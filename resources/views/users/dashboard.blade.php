<x-layouts.homepage :title="__('Dashboard')">
    <?php
        $user = auth()->user();
        $totalPosts = \App\Models\Post::where('user_id', $user->id)->count();
        $publishedPosts = \App\Models\Post::where('user_id', $user->id)->where('status', 'published')->count();
        $draftPosts = \App\Models\Post::where('user_id', $user->id)->where('status', 'draft')->count();
        $totalComments = \App\Models\Comment::where('user_id', $user->id)->count();
        $likesReceived = \App\Models\Like::whereIn('post_id', \App\Models\Post::where('user_id', $user->id)->pluck('id'))->count();
        $followersCount = \App\Models\Follower::where('following_id', $user->id)->count();
        $followingCount = \App\Models\Follower::where('follower_id', $user->id)->count();
        $recentPosts = \App\Models\Post::where('user_id', $user->id)->latest()->take(5)->get();
        $recentComments = \App\Models\Comment::where('user_id', $user->id)->latest()->take(3)->get();
        // Get monthly stats using Laravel's database-agnostic approach
        $monthlyStats = \App\Models\Post::where('user_id', $user->id)
            ->where('created_at', '>=', now()->subMonths(6))
            ->get()
            ->groupBy(function($post) {
                return $post->created_at->format('Y-m');
            })
            ->map(function($posts, $month) {
                return (object) [
                    'month' => $month,
                    'count' => $posts->count()
                ];
            })
            ->values();
    ?>

    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/30 to-indigo-50/20 dark:from-slate-950 dark:via-blue-950/30 dark:to-indigo-950/20">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-white via-blue-50/50 to-indigo-50/30 dark:from-slate-900 dark:via-blue-900/20 dark:to-indigo-900/20 border-b border-zinc-200 dark:border-zinc-800">
        <div class="max-w-7xl mx-auto px-3 sm:px-4 py-6 sm:py-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            @if($user->avatar)
                                <img src="{{ Storage::url($user->avatar) }}" alt="{{ $user->name }}" class="h-16 w-16 rounded-lg object-cover border border-zinc-200 dark:border-zinc-800">
                            @else
                                <div class="h-16 w-16 rounded-lg bg-zinc-900 dark:bg-white flex items-center justify-center text-xl font-medium text-white dark:text-zinc-900 border border-zinc-200 dark:border-zinc-800">
                                    {{ $user->initials() }}
                                </div>
                            @endif
                            <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-emerald-500 border-2 border-white dark:border-zinc-900 rounded-full flex items-center justify-center">
                                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h1 class="text-2xl sm:text-3xl font-semibold bg-gradient-to-r from-blue-900 via-indigo-800 to-purple-800 dark:from-blue-200 dark:via-indigo-200 dark:to-purple-200 bg-clip-text text-transparent">Welcome back, {{ $user->name }}</h1>
                            <p class="text-sm sm:text-base text-zinc-600 dark:text-zinc-400 mt-1">Dashboard Overview</p>
        </div>
            </div>
                    <div class="mt-6 lg:mt-0 flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('posts.create', ['username' => auth()->user()->username]) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Create New Post
                        </a>
                        <a href="{{ route('posts.index') }}" class="inline-flex items-center px-4 py-2 border border-blue-300 text-base font-medium rounded-md text-blue-700 bg-white hover:bg-blue-50 dark:border-blue-600 dark:text-blue-300 dark:bg-slate-800 dark:hover:bg-blue-900/20 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            View All Posts
                        </a>
                        <a href="{{ route('favorites.index', ['username' => auth()->user()->username]) }}" class="inline-flex items-center px-4 py-2 border border-yellow-300 text-base font-medium rounded-md text-yellow-700 bg-white hover:bg-yellow-50 dark:border-yellow-600 dark:text-yellow-300 dark:bg-slate-800 dark:hover:bg-yellow-900/20 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                            </svg>
                            My Favorites
                        </a>
            </div>
            </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-3 sm:px-4 py-6 sm:py-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-6 sm:mb-8">
                <!-- Total Posts -->
                <div class="bg-gradient-to-br from-white via-blue-50/30 to-indigo-50/20 rounded-2xl dark:from-slate-900 dark:via-blue-900/20 dark:to-indigo-900/20 border border-zinc-200 dark:border-zinc-800 p-3 transition-all duration-300 shadow-xl hover:shadow-2xl">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-6 h-6 bg-blue-500 dark:bg-blue-600 rounded-md flex items-center justify-center shadow-lg">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-2">
                            <p class="text-base font-medium text-zinc-600 dark:text-zinc-400">Total Posts</p>
                            <p class="text-2xl font-semibold text-zinc-900 dark:text-white">{{ $totalPosts }}</p>
                            <p class="text-sm text-zinc-500 dark:text-zinc-500">{{ $publishedPosts }} published, {{ $draftPosts }} drafts</p>
                        </div>
                    </div>
                </div>

                <!-- Followers -->
                <div class="bg-gradient-to-br from-white via-blue-50/30 to-indigo-50/20 rounded-2xl dark:from-slate-900 dark:via-blue-900/20 dark:to-indigo-900/20 border border-zinc-200 dark:border-zinc-800 p-3 transition-all duration-300 shadow-xl hover:shadow-2xl">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-6 h-6 bg-blue-500 dark:bg-blue-600 rounded-md flex items-center justify-center shadow-lg">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-2">
                            <p class="text-base font-medium text-zinc-600 dark:text-zinc-400">Followers</p>
                            <p class="text-2xl font-semibold text-zinc-900 dark:text-white">{{ $followersCount }}</p>
                            <p class="text-sm text-zinc-500 dark:text-zinc-500">Following {{ $followingCount }}</p>
                        </div>
                    </div>
                </div>

                <!-- Comments -->
                <div class="bg-gradient-to-br from-white via-blue-50/30 to-indigo-50/20 rounded-2xl dark:from-slate-900 dark:via-blue-900/20 dark:to-indigo-900/20 border border-zinc-200 dark:border-zinc-800 p-3 transition-all duration-300 shadow-xl hover:shadow-2xl">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-6 h-6 bg-blue-500 dark:bg-blue-600 rounded-md flex items-center justify-center shadow-lg">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-2">
                            <p class="text-base font-medium text-zinc-600 dark:text-zinc-400">Your Comments</p>
                            <p class="text-2xl font-semibold text-zinc-900 dark:text-white">{{ $totalComments }}</p>
                            <p class="text-sm text-zinc-500 dark:text-zinc-500">Comments you've made</p>
                        </div>
                    </div>
                </div>

                <!-- Likes Received -->
                <div class="bg-gradient-to-br from-white via-blue-50/30 to-indigo-50/20 rounded-2xl dark:from-slate-900 dark:via-blue-900/20 dark:to-indigo-900/20 border border-zinc-200 dark:border-zinc-800 p-3 transition-all duration-300 shadow-xl hover:shadow-2xl">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-6 h-6 bg-blue-500 dark:bg-blue-600 rounded-md flex items-center justify-center shadow-lg">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-2">
                                <p class="text-base font-medium text-zinc-600 dark:text-zinc-400">Likes Received</p>
                                <p class="text-2xl font-semibold text-zinc-900 dark:text-white">{{ $likesReceived }}</p>
                                <p class="text-sm text-zinc-500 dark:text-zinc-500">Across all your posts</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="max-w-7xl mx-auto px-3 sm:px-4 py-6 sm:py-8">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-3 sm:gap-4 lg:gap-6">
                <!-- Recent Posts -->
                <div class="lg:col-span-2">
                    <div class="bg-gradient-to-br from-white via-blue-50/30 to-indigo-50/20 rounded-2xl dark:from-slate-900 dark:via-blue-900/20 dark:to-indigo-900/20 border border-zinc-200 dark:border-zinc-800 transition-all duration-300 shadow-xl hover:shadow-2xl">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-6">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-blue-500 dark:bg-blue-600 rounded-md flex items-center justify-center mr-3 shadow-lg">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <h2 class="text-2xl font-semibold bg-gradient-to-r from-blue-900 to-indigo-800 dark:from-blue-200 dark:to-indigo-200 bg-clip-text text-transparent">Recent Posts</h2>
                                </div>
                                <a href="{{ route('posts.index') }}" class="text-sm font-medium text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-zinc-100 transition-colors">
                                    View all →
                                </a>
                            </div>
                            <div class="space-y-3">
                                @forelse($recentPosts as $post)
                                    <div class="p-4 rounded-md bg-zinc-50 dark:bg-zinc-800/50 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors duration-200 border border-zinc-200 dark:border-zinc-700">
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1 min-w-0">
                                                <a href="{{ route('posts.show', ['username' => $post->user->username, 'slug' => $post->slug]) }}" class="text-xl font-medium text-zinc-900 dark:text-white hover:text-zinc-700 dark:hover:text-zinc-300 transition-colors line-clamp-2">
                                                    {{ $post->title }}
                                                </a>
                                                <div class="flex items-center mt-2 space-x-4 text-xs text-zinc-500 dark:text-zinc-400">
                                                    <span class="flex items-center">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                        {{ $post->created_at->format('M d, Y') }}
                                                    </span>
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $post->status === 'published' ? 'bg-zinc-100 text-zinc-800 dark:bg-zinc-800 dark:text-zinc-300' : 'bg-zinc-200 text-zinc-700 dark:bg-zinc-700 dark:text-zinc-400' }}">
                                                        {{ ucfirst($post->status) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="ml-4 flex items-center space-x-2">
                                                <a href="{{ route('posts.edit', ['username' => auth()->user()->username, 'post' => $post]) }}" class="p-1 text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300 transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"></path>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-8">
                                        <svg class="mx-auto h-12 w-12 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <h3 class="mt-2 text-sm font-medium text-zinc-900 dark:text-white">No posts yet</h3>
                                        <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Get started by creating your first post.</p>
                                        <div class="mt-6">
                                            <a href="{{ route('posts.create', ['username' => auth()->user()->username]) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-zinc-900 hover:bg-zinc-800 dark:bg-white dark:text-zinc-900 dark:hover:bg-zinc-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-zinc-500">
                                                Create Post
                                            </a>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Quick Actions -->
                    <div class="bg-gradient-to-br from-white via-blue-50/30 to-indigo-50/20 rounded-2xl dark:from-slate-900 dark:via-blue-900/20 dark:to-indigo-900/20 border border-zinc-200 dark:border-zinc-800 transition-all duration-300 shadow-xl hover:shadow-2xl">
                        <div class="p-6">
                            <div class="flex items-center mb-4">
                                <div class="w-8 h-8 bg-blue-500 dark:bg-blue-600 rounded-md flex items-center justify-center mr-3 shadow-lg">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-semibold bg-gradient-to-r from-blue-900 to-indigo-800 dark:from-blue-200 dark:to-indigo-200 bg-clip-text text-transparent">Quick Actions</h3>
                            </div>
                            <div class="space-y-3">
                                <a href="{{ route('posts.create', ['username' => auth()->user()->username]) }}" class="flex items-center p-3 rounded-md bg-zinc-50 dark:bg-zinc-800/50 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors border border-zinc-200 dark:border-zinc-700">
                                    <div class="w-6 h-6 bg-zinc-200 dark:bg-zinc-700 rounded flex items-center justify-center mr-3">
                                        <svg class="w-3 h-3 text-zinc-600 dark:text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"></path>
                                        </svg>
                                    </div>
                                    <span class="text-base font-medium text-zinc-900 dark:text-white">New Post</span>
                                </a>
                                <a href="{{ route('user.profile', ['username' => auth()->user()->username]) }}" class="flex items-center p-3 rounded-md bg-zinc-50 dark:bg-zinc-800/50 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors border border-zinc-200 dark:border-zinc-700">
                                    <div class="w-6 h-6 bg-zinc-200 dark:bg-zinc-700 rounded flex items-center justify-center mr-3">
                                        <svg class="w-3 h-3 text-zinc-600 dark:text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"></path>
                                        </svg>
                                    </div>
                                    <span class="text-base font-medium text-zinc-900 dark:text-white">Edit Profile</span>
                                </a>
                                @if(auth()->user()->hasRole('admin'))
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center p-3 rounded-md bg-zinc-50 dark:bg-zinc-800/50 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors border border-zinc-200 dark:border-zinc-700">
                                    <div class="w-6 h-6 bg-zinc-200 dark:bg-zinc-700 rounded flex items-center justify-center mr-3">
                                        <svg class="w-3 h-3 text-zinc-600 dark:text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"></path>
                                        </svg>
                                    </div>
                                    <span class="text-sm font-medium text-zinc-900 dark:text-white">Admin Panel</span>
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="bg-white rounded-lg border border-zinc-200 dark:bg-zinc-900 dark:border-zinc-800">
                        <div class="p-6">
                            <div class="flex items-center mb-4">
                                <div class="w-8 h-8 bg-blue-500 dark:bg-blue-600 rounded-md flex items-center justify-center mr-3 border border-zinc-200 dark:border-zinc-700">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941"></path>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-semibold text-zinc-900 dark:text-white">Recent Activity</h3>
                            </div>
                            <div class="space-y-3">
                                @forelse($recentComments as $comment)
                                    <div class="p-3 rounded-md bg-zinc-50 dark:bg-zinc-800/50 border border-zinc-200 dark:border-zinc-700">
                                        <div class="flex items-start space-x-3">
                                            <div class="w-6 h-6 bg-zinc-200 dark:bg-zinc-700 rounded-full flex items-center justify-center text-xs font-medium text-zinc-700 dark:text-zinc-300">
                                                {{ substr($comment->user->name, 0, 1) }}
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Commented on</p>
                                                <a href="{{ route('posts.show', ['username' => $comment->post->user->username, 'slug' => $comment->post->slug]) }}#comments" class="text-base text-zinc-900 dark:text-white hover:text-zinc-700 dark:hover:text-zinc-300 transition-colors line-clamp-1">
                                                    {{ Str::limit($comment->post->title, 30) }}
                                                </a>
                                                <p class="text-sm text-zinc-500 dark:text-zinc-500 mt-1">{{ $comment->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-4">
                                        <svg class="mx-auto h-8 w-8 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z"></path>
                                        </svg>
                                        <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">No recent activity</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>

    <style>
    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    </style>
</x-layouts.homepage>
