<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PostController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request)
    {
        // Cache key based on request parameters
        $cacheKey = 'posts_index_' . md5(serialize($request->all()));
        
        $posts = Cache::remember($cacheKey, 300, function () use ($request) {
            $query = Post::with(['user', 'categories', 'tags'])
                ->withCount('likes')
                ->where('status', 'published')
                ->latest('published_at');

            // Filter by category
            if ($request->has('category')) {
                $query->whereHas('categories', function($q) use ($request) {
                    $q->where('slug', $request->category);
                });
            }

            // Filter by tag
            if ($request->has('tag')) {
                $query->whereHas('tags', function($q) use ($request) {
                    $q->where('slug', $request->tag);
                });
            }

            // Search functionality
            if ($request->has('search')) {
                $searchTerm = $request->search;
                $query->where(function($q) use ($searchTerm) {
                    $q->where('title', 'like', "%{$searchTerm}%")
                      ->orWhere('excerpt', 'like', "%{$searchTerm}%")
                      ->orWhere('content', 'like', "%{$searchTerm}%");
                });
            }

            // Sort functionality
            if ($request->has('sort')) {
                switch ($request->sort) {
                    case 'popular':
                        $query->withCount('comments')
                              ->orderBy('likes_count', 'desc')
                              ->orderBy('comments_count', 'desc')
                              ->orderBy('published_at', 'desc');
                        break;
                    case 'trending':
                        // Trending: posts from last 7 days with high engagement
                        $query->where('published_at', '>=', now()->subDays(7))
                              ->withCount('comments')
                              ->orderBy('likes_count', 'desc')
                              ->orderBy('comments_count', 'desc')
                              ->orderBy('published_at', 'desc');
                        break;
                    default:
                        $query->latest('published_at');
                        break;
                }
            } else {
                $query->latest('published_at');
            }

            return $query->paginate(10);
        });

        // Add counts to posts (optimized to prevent N+1 queries)
        $posts->getCollection()->transform(function ($post) {
            $post->likes_count = $post->likes_count ?? 0;
            $post->comments_count = $post->comments_count ?? 0;
            $post->is_liked = auth()->check() ? $post->likes()->where('user_id', auth()->id())->exists() : false;
            return $post;
        });

        $categories = \App\Models\Category::orderBy('name')->get();
        $tags = \App\Models\Tag::orderBy('name')->take(20)->get();

        return view('posts.index', compact('posts', 'categories', 'tags'));
    }

    public function show($username, $slug)
    {
        $post = Post::with(['user', 'categories', 'tags', 'comments.user', 'comments.replies.user'])
            ->whereHas('user', function($query) use ($username) {
                $query->where('username', $username);
            })
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Increment view count (prevent counting author's views and multiple counts from same IP)
        if (!auth()->check() || auth()->id() !== $post->user_id) {
            // Use cache to prevent multiple counts in same session (24 hour window)
            $cacheKey = 'post_view_' . $post->id . '_' . request()->ip();
            if (!Cache::has($cacheKey)) {
                $post->increment('view_count');
                Cache::put($cacheKey, true, now()->addHours(24));
            }
        }

        // Add counts and like status
        $post->likes_count = $post->likes()->count();
        $post->comments_count = $post->comments()->count();
        $post->is_liked = auth()->check() ? $post->likes()->where('user_id', auth()->id())->exists() : false;

        return view('posts.show', compact('post'));
    }
    public function create(Request $request, string $username)
    {
        // Find user by username
        $user = \App\Models\User::where('username', $username)->firstOrFail();
        
        // Ensure the authenticated user can only create posts for themselves
        if ($request->user()->id !== $user->id) {
            abort(403, 'Unauthorized access');
        }
        
        $categories = Category::orderBy('name')->get();
        return view('posts.create', compact('categories', 'user'));
    }

    public function store(StorePostRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        
        Log::info('Creating new post', [
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'status' => $validated['status'] ?? 'draft'
        ]);

        try {
            // Handle featured image upload
            $featuredImagePath = null;
            if ($request->hasFile('featured_image')) {
                $featuredImagePath = $request->file('featured_image')->store('posts', 'public');
            }

            $post = Post::create([
                'user_id' => Auth::id(),
                'title' => $validated['title'],
                'slug' => $this->generateUniqueSlug($validated['title']),
                'content' => $validated['content'],
                'excerpt' => $validated['excerpt'] ?? null,
                'featured_image' => $featuredImagePath,
                'status' => $validated['status'] ?? 'draft',
                'is_featured' => $request->has('is_featured'),
                'published_at' => ($validated['status'] ?? 'draft') === 'published' ? now() : null,
            ]);
            
            Log::info('Post created successfully', ['post_id' => $post->id]);
        } catch (\Exception $e) {
            Log::error('Failed to create post', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);
            throw $e;
        }

        if (!empty($validated['categories'])) {
            $post->categories()->sync($validated['categories']);
        }

        if (!empty($validated['tags'])) {
            $tagNames = collect(explode(',', $validated['tags']))
                ->map(fn ($t) => trim($t))
                ->filter()
                ->unique();

            $tagIds = [];
            foreach ($tagNames as $name) {
                $slug = Str::slug($name);
                $tag = Tag::firstOrCreate(['slug' => $slug], ['name' => $name]);
                $tagIds[] = $tag->id;
            }
            if ($tagIds) {
                $post->tags()->sync($tagIds);
            }
        }

        return redirect()->route('dashboard', ['username' => auth()->user()->username])->with('status', 'Post created');
    }

    public function edit(Request $request, string $username, Post $post)
    {
        // Find user by username
        $user = \App\Models\User::where('username', $username)->firstOrFail();
        
        // Ensure the authenticated user can only edit their own posts
        if ($request->user()->id !== $user->id || $post->user_id !== $user->id) {
            abort(403, 'Unauthorized access');
        }
        
        $this->authorize('update', $post);
        $categories = Category::orderBy('name')->get();
        $selectedCategoryIds = $post->categories()->pluck('categories.id')->all();
        $tagsCsv = $post->tags()->pluck('name')->implode(', ');
        return view('posts.edit', compact('post', 'categories', 'selectedCategoryIds', 'tagsCsv', 'user'));
    }

    public function update(UpdatePostRequest $request, Post $post): RedirectResponse
    {
        $this->authorize('update', $post);

        $validated = $request->validated();

        // Handle featured image update
        $featuredImagePath = $post->featured_image; // Keep current image by default
        
        if ($request->hasFile('featured_image')) {
            // New image uploaded
            $featuredImagePath = $request->file('featured_image')->store('posts', 'public');
            
            // Delete old image if it exists
            if ($post->featured_image && Storage::disk('public')->exists($post->featured_image)) {
                Storage::disk('public')->delete($post->featured_image);
            }
        } elseif ($request->has('remove_featured_image')) {
            // Remove featured image
            if ($post->featured_image && Storage::disk('public')->exists($post->featured_image)) {
                Storage::disk('public')->delete($post->featured_image);
            }
            $featuredImagePath = null;
        }

        $post->update([
            'title' => $validated['title'],
            'slug' => $this->generateUniqueSlug($validated['title']),
            'content' => $validated['content'],
            'excerpt' => $validated['excerpt'] ?? null,
            'featured_image' => $featuredImagePath,
            'status' => $validated['status'] ?? $post->status,
            'is_featured' => $request->has('is_featured'),
            'published_at' => ($validated['status'] ?? $post->status) === 'published' && !$post->published_at ? now() : $post->published_at,
        ]);

        $post->categories()->sync($validated['categories'] ?? []);

        $tagIds = [];
        if (!empty($validated['tags'])) {
            $tagNames = collect(explode(',', $validated['tags']))
                ->map(fn ($t) => trim($t))
                ->filter()
                ->unique();

            foreach ($tagNames as $name) {
                $slug = Str::slug($name);
                $tag = Tag::firstOrCreate(['slug' => $slug], ['name' => $name]);
                $tagIds[] = $tag->id;
            }
        }
        $post->tags()->sync($tagIds);

        return redirect()->route('dashboard', ['username' => auth()->user()->username])->with('status', 'Post updated');
    }

    /**
     * Handle image uploads from TinyMCE editor
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB max
        ]);

        try {
            $file = $request->file('image');
            
            // Generate unique filename with original extension
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '_' . Str::random(10) . '.' . $extension;
            
            // Store the image
            $path = $file->storeAs('post-images', $filename, 'public');
            
            // Get image info for optimization
            $imageInfo = getimagesize($file->getPathname());
            $width = $imageInfo[0] ?? null;
            $height = $imageInfo[1] ?? null;
            
            // Get the full URL
            $url = asset('storage/' . $path);
            
            // Log successful upload
            Log::info('Image uploaded successfully', [
                'user_id' => Auth::id(),
                'filename' => $filename,
                'path' => $path,
                'size' => $file->getSize(),
                'dimensions' => "{$width}x{$height}"
            ]);
            
            return response()->json([
                'success' => true,
                'url' => $url,
                'path' => $path,
                'filename' => $filename,
                'size' => $file->getSize(),
                'dimensions' => [
                    'width' => $width,
                    'height' => $height
                ]
            ]);
            
        } catch (\Exception $e) {
            Log::error('Image upload failed', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'file' => $request->file('image')?->getClientOriginalName()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload image. Please try again.'
            ], 500);
        }
    }

    private function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        while (Post::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}


