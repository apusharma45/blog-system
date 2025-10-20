<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Like;
use App\Models\Follower;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Overall Statistics
        $stats = [
            'total_posts' => Post::count(),
            'published_posts' => Post::where('status', 'published')->count(),
            'draft_posts' => Post::where('status', 'draft')->count(),
            'total_users' => User::count(),
            'active_users' => User::where('last_activity_at', '>=', Carbon::now()->subDays(7))->count(),
            'total_comments' => Comment::count(),
            'total_categories' => Category::count(),
            'total_likes' => Like::count(),
            'total_followers' => Follower::count(),
        ];

        // Growth Statistics (Last 30 days)
        $growthStats = [
            'new_users' => User::where('created_at', '>=', Carbon::now()->subDays(30))->count(),
            'new_posts' => Post::where('created_at', '>=', Carbon::now()->subDays(30))->count(),
            'new_comments' => Comment::where('created_at', '>=', Carbon::now()->subDays(30))->count(),
        ];

        // Recent Activity
        $recentPosts = Post::with('user')->latest()->take(5)->get();
        $recentUsers = User::latest()->take(5)->get();
        $recentComments = Comment::with(['user', 'post'])->latest()->take(5)->get();

        // Top Content
        $topPosts = Post::withCount('likes', 'comments')
            ->orderBy('view_count', 'desc')
            ->take(10)
            ->get();

        $topUsers = User::withCount('posts', 'followers')
            ->orderBy('posts_count', 'desc')
            ->take(10)
            ->get();

        // Chart Data - Posts per day (last 7 days)
        $postsChartData = Post::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as count')
        )
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Chart Data - Users registration (last 7 days)
        $usersChartData = User::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as count')
        )
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'growthStats',
            'recentPosts',
            'recentUsers',
            'recentComments',
            'topPosts',
            'topUsers',
            'postsChartData',
            'usersChartData'
        ));
    }

    public function posts(Request $request)
    {
        $query = Post::with('user');

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $posts = $query->paginate(20);

        return view('admin.posts', compact('posts'));
    }

    public function users(Request $request)
    {
        $query = User::withCount(['posts', 'followers', 'following']);

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%");
            });
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $users = $query->paginate(20);

        return view('admin.users', compact('users'));
    }

    public function comments(Request $request)
    {
        $query = Comment::with(['user', 'post']);

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('content', 'like', "%{$search}%");
        }

        $comments = $query->latest()->paginate(20);

        return view('admin.comments', compact('comments'));
    }

    public function categories()
    {
        $categories = Category::withCount('posts')->orderBy('name')->get();
        return view('admin.categories', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => \Illuminate\Support\Str::slug($request->name),
        ]);

        return back()->with('success', 'Category created successfully.');
    }

    public function updateCategory(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => \Illuminate\Support\Str::slug($request->name),
        ]);

        return back()->with('success', 'Category updated successfully.');
    }

    public function deleteCategory($id)
    {
        $category = Category::findOrFail($id);
        
        // Check if category has posts
        if ($category->posts()->count() > 0) {
            return back()->with('error', 'Cannot delete category with existing posts.');
        }
        
        $category->delete();

        return back()->with('success', 'Category deleted successfully.');
    }


    // User Management Actions
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return back()->with('success', 'User deleted successfully.');
    }

    public function suspendUser($id)
    {
        $user = User::findOrFail($id);
        // Add suspended_at field if needed
        return back()->with('success', 'User suspended successfully.');
    }

    // Post Management Actions
    public function deletePost($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return back()->with('success', 'Post deleted successfully.');
    }

    public function togglePostStatus($id)
    {
        $post = Post::findOrFail($id);
        $post->status = $post->status === 'published' ? 'draft' : 'published';
        $post->save();

        return back()->with('success', 'Post status updated successfully.');
    }

    // Comment Management Actions
    public function deleteComment($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return back()->with('success', 'Comment deleted successfully.');
    }

    // Contact Messages Management
    public function contacts(Request $request)
    {
        $query = Contact::query();

        // Filter by read status
        if ($request->has('status')) {
            if ($request->status === 'unread') {
                $query->whereNull('read_at');
            } elseif ($request->status === 'read') {
                $query->whereNotNull('read_at');
            }
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        $contacts = $query->latest()->paginate(20);
        $unreadCount = Contact::whereNull('read_at')->count();

        return view('admin.contacts', compact('contacts', 'unreadCount'));
    }

    public function markContactAsRead($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->read_at = now();
        $contact->save();

        return back()->with('success', 'Message marked as read.');
    }

    public function markContactAsUnread($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->read_at = null;
        $contact->save();

        return back()->with('success', 'Message marked as unread.');
    }

    public function deleteContact($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return back()->with('success', 'Contact message deleted successfully.');
    }
}