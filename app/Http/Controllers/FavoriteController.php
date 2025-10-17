<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the user's favorite posts.
     */
    public function index(Request $request, string $username)
    {
        // Find user by username
        $user = \App\Models\User::where('username', $username)->firstOrFail();
        
        // Ensure the authenticated user can only view their own favorites
        if ($request->user()->id !== $user->id) {
            abort(403, 'Unauthorized access to favorites');
        }
        
        $favorites = $user->favorites()
            ->with(['user', 'categories', 'tags'])
            ->paginate(12);

        // Add counts to posts
        $favorites->getCollection()->transform(function ($post) use ($user) {
            $post->likes_count = $post->likes()->count();
            $post->comments_count = $post->comments()->count();
            $post->views_count = $post->view_count ?? 0;
            $post->is_liked = $post->likes()->where('user_id', $user->id)->exists();
            $post->is_favorited = true; // They're all favorited in this view
            return $post;
        });

        return view('favorites.index', compact('favorites', 'user'));
    }

    /**
     * Add a post to favorites.
     */
    public function store(Request $request, Post $post)
    {
        $isFavorited = auth()->user()->hasFavorited($post);
        
        if (!$isFavorited) {
            auth()->user()->favorites()->attach($post->id);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'is_favorited' => true,
                'message' => $isFavorited ? 'Post already in favorites.' : 'Post added to favorites!'
            ]);
        }

        return back()->with('status', $isFavorited ? 'Post already in favorites.' : 'Post added to favorites!');
    }

    /**
     * Remove a post from favorites.
     */
    public function destroy(Request $request, Post $post)
    {
        auth()->user()->favorites()->detach($post->id);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'is_favorited' => false,
                'message' => 'Post removed from favorites.'
            ]);
        }

        return back()->with('status', 'Post removed from favorites.');
    }
}
