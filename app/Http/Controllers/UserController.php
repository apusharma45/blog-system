<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a public user profile (view-only)
     */
    public function show($username)
    {
        $user = User::where('username', $username)->firstOrFail();
        
        // If viewing own profile, redirect to edit page
        if (Auth::check() && Auth::id() === $user->id) {
            return redirect()->route('user.profile', ['username' => $user->username]);
        }
        
        // Load user's posts with relationships
        $posts = $user->posts()
            ->with(['user', 'categories', 'tags'])
            ->latest()
            ->paginate(10);
        
        return view('users.profile-public', compact('user', 'posts'));
    }

    public function edit($username)
    {
        // Ensure user can only edit their own profile
        if (Auth::user()->username !== $username) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('users.edit-profile');
    }

    public function update(Request $request, $username)
    {
        $user = Auth::user();
        
        // Ensure user can only update their own profile
        if ($user->username !== $username) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => [
                'required',
                'string',
                'alpha_dash',
                'max:50',
                Rule::unique('users')->ignore($user->id)
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id)
            ],
            'bio' => ['nullable', 'string', 'max:500'],
            'location' => ['nullable', 'string', 'max:100'],
            'avatar' => ['nullable', 'image', 'max:2048'], // 2MB max
        ]);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Store new avatar
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        // Update user
        $user->update($validated);

        return redirect()->route('user.profile', ['username' => $user->username])
            ->with('success', 'Profile updated successfully!');
    }

    public function updatePassword(Request $request, $username)
    {
        $user = Auth::user();
        
        // Ensure user can only update their own password
        if ($user->username !== $username) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Verify current password
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        // Update password
        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('user.profile', ['username' => $user->username])
            ->with('success', 'Password updated successfully!');
    }

    public function destroy(Request $request, $username)
    {
        $user = Auth::user();
        
        // Ensure user can only delete their own account
        if ($user->username !== $username) {
            abort(403, 'Unauthorized action.');
        }

        // Validate password
        $request->validate([
            'password' => ['required', 'string'],
        ]);

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'The provided password is incorrect.']);
        }

        // Delete user's avatar
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Delete user's post images
        foreach ($user->posts as $post) {
            if ($post->featured_image && Storage::disk('public')->exists($post->featured_image)) {
                Storage::disk('public')->delete($post->featured_image);
            }
        }

        // Logout user
        Auth::logout();

        // Delete user (cascade deletes will handle related data)
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Your account has been deleted successfully.');
    }
}