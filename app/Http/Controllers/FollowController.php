<?php

namespace App\Http\Controllers;

use App\Models\Follower;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function store(Request $request, User $user): RedirectResponse|JsonResponse
    {
        if ($user->id === $request->user()->id) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Cannot follow yourself'], 400);
            }
            return back();
        }

        Follower::firstOrCreate([
            'follower_id' => $request->user()->id,
            'following_id' => $user->id,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Followed successfully',
                'is_following' => true,
                'followers_count' => $user->followers()->count()
            ]);
        }

        return back()->with('status', 'Followed');
    }

    public function destroy(Request $request, User $user): RedirectResponse|JsonResponse
    {
        Follower::where('follower_id', $request->user()->id)
            ->where('following_id', $user->id)
            ->delete();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Unfollowed successfully',
                'is_following' => false,
                'followers_count' => $user->followers()->count()
            ]);
        }

        return back()->with('status', 'Unfollowed');
    }
}


