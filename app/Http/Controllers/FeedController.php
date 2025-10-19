<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Facades\Cache;

class FeedController extends Controller
{
    public function index()
    {
        // Cache featured posts for 10 minutes
        $featuredPosts = Cache::remember('feed_featured_posts', 600, function () {
            return Post::featured()
                ->with(['user', 'categories', 'tags'])
                ->take(3)
                ->get();
        });

        // Cache posts for 5 minutes
        $posts = Cache::remember('feed_posts', 300, function () {
            return Post::with(['user', 'categories', 'tags'])
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

        // Transform featured posts too
        $featuredPosts->transform(function ($post) {
            $post->likes_count = $post->likes_count ?? 0;
            $post->comments_count = $post->comments_count ?? 0;
            $post->is_liked = auth()->check() ? $post->likes()->where('user_id', auth()->id())->exists() : false;
            return $post;
        });

        return view('home', compact('posts', 'categories', 'tags', 'featuredPosts'));
    }
}


