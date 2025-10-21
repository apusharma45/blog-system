<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the user's dashboard.
     */
    public function show(Request $request, string $username)
    {
        // Find user by username
        $user = User::where('username', $username)->firstOrFail();
        
        // Ensure the authenticated user can only access their own dashboard
        if ($request->user()->id !== $user->id) {
            abort(403, 'Unauthorized access to dashboard');
        }
        
        return view('users.dashboard', compact('user'));
    }
}
