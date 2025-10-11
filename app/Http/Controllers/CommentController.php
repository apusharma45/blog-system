<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    use AuthorizesRequests;
    public function store(Request $request)
    {
        $validated = $request->validate([
            'post_id' => ['required', 'exists:posts,id'],
            'parent_id' => ['nullable', 'exists:comments,id'],
            'content' => ['required', 'string', 'max:5000'],
        ]);

        $comment = Comment::create([
            'post_id' => $validated['post_id'],
            'user_id' => $request->user()->id,
            'parent_id' => $validated['parent_id'] ?? null,
            'content' => $validated['content'],
        ]);

        // Load the user relationship
        $comment->load('user');

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Comment added',
                'comment' => [
                    'id' => $comment->id,
                    'content' => $comment->content,
                    'created_at' => $comment->created_at->diffForHumans(),
                    'user' => [
                        'name' => $comment->user->name,
                        'avatar' => $comment->user->avatar ? asset('storage/' . $comment->user->avatar) : null,
                    ],
                    'parent_id' => $comment->parent_id,
                ]
            ]);
        }

        return back()->with('status', 'Comment added');
    }

    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $validated = $request->validate([
            'content' => ['required', 'string', 'max:5000'],
        ]);

        $comment->update([
            'content' => $validated['content'],
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Comment updated',
                'comment' => [
                    'id' => $comment->id,
                    'content' => $comment->content,
                ]
            ]);
        }

        return back()->with('status', 'Comment updated');
    }

    public function destroy(Request $request, Comment $comment)
    {
        $this->authorize('delete', $comment);

        $commentId = $comment->id;
        $isReply = $comment->parent_id !== null;
        
        $comment->delete();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Comment deleted',
                'comment_id' => $commentId,
                'is_reply' => $isReply
            ]);
        }

        return back()->with('status', 'Comment deleted');
    }
}


