<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        // Cache posts for 5 minutes
        $posts = Cache::remember('feed_posts', 300, function () {
            return Post::with(['user', 'categories', 'tags'])
                ->withCount('likes')
                ->where('status', 'published')
                ->latest('published_at')
                ->paginate(10);
        });

        // Cache categories and tags for 1 hour
        $categories = Cache::remember('feed_categories', 3600, function () {
            return Category::orderBy('name')->get();
        });
        
        $tags = Cache::remember('feed_tags', 3600, function () {
            return Tag::orderBy('name')->take(20)->get();
        });

        // Add counts to posts for display (optimized to prevent N+1 queries)
        $posts->getCollection()->transform(function ($post) {
            $post->likes_count = $post->likes_count ?? 0;
            $post->comments_count = $post->comments_count ?? 0;
            $post->is_liked = auth()->check() ? $post->likes()->where('user_id', auth()->id())->exists() : false;
            return $post;
        });

        return view('home', compact('posts', 'categories', 'tags'));
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }

    public function submitContact(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10|max:2000',
        ]);

        try {
            // Store contact submission in database
            $contact = \App\Models\Contact::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'subject' => $validated['subject'],
                'message' => $validated['message'],
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            // Send email notification to admin
            \Illuminate\Support\Facades\Mail::to('sheldoncoop455@gmail.com')
                ->send(new \App\Mail\ContactFormSubmitted($contact));

            return back()->with('success', 'Thank you for contacting us! We\'ll get back to you soon.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Contact form submission failed: ' . $e->getMessage());
            return back()
                ->withInput()
                ->with('error', 'Sorry, there was an error sending your message. Please try again later.');
        }
    }
}


