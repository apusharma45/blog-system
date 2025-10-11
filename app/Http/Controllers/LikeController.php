<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->user();

        Like::firstOrCreate([
            'post_id' => $post->id,
            'user_id' => $request->user()->id,
        ]);

        $likesCount = $post->likes()->count();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'likes_count' => $likesCount,
                'message' => 'Post liked'
            ]);
        }

        return back()->with('status', 'Post liked');
    }

    public function destroy(Request $request, Post $post)
    {
        Like::where('post_id', $post->id)
            ->where('user_id', $request->user()->id)
            ->delete();

        $likesCount = $post->likes()->count();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'likes_count' => $likesCount,
                'message' => 'Like removed'
            ]);
        }

        return back()->with('status', 'Like removed');
    }
}


