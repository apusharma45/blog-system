<x-layouts.admin title="Dashboard">
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Users -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Users</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ number_format($stats['total_users']) }}</p>
                    <p class="text-sm text-green-600 dark:text-green-400 mt-2">
                        +{{ $growthStats['new_users'] }} this month
                    </p>
                </div>
                <div class="bg-blue-100 dark:bg-blue-900/30 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Posts -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Posts</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ number_format($stats['total_posts']) }}</p>
                    <p class="text-sm text-green-600 dark:text-green-400 mt-2">
                        +{{ $growthStats['new_posts'] }} this month
                    </p>
                </div>
                <div class="bg-purple-100 dark:bg-purple-900/30 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Comments -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Comments</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ number_format($stats['total_comments']) }}</p>
                    <p class="text-sm text-green-600 dark:text-green-400 mt-2">
                        +{{ $growthStats['new_comments'] }} this month
                    </p>
                </div>
                <div class="bg-green-100 dark:bg-green-900/30 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Active Users -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Active Users</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ number_format($stats['active_users']) }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                        Last 7 days
                    </p>
                </div>
                <div class="bg-indigo-100 dark:bg-indigo-900/30 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Two Column Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Published vs Draft Posts -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Post Status</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-4 bg-green-50 dark:bg-green-900/20 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                        <span class="font-medium text-gray-900 dark:text-white">Published</span>
                    </div>
                    <span class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['published_posts']) }}</span>
                </div>
                <div class="flex items-center justify-between p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                        <span class="font-medium text-gray-900 dark:text-white">Drafts</span>
                    </div>
                    <span class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['draft_posts']) }}</span>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Content Overview</h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between py-2 border-b border-gray-100 dark:border-gray-700">
                    <span class="text-gray-600 dark:text-gray-400">Total Likes</span>
                    <span class="font-semibold text-gray-900 dark:text-white">{{ number_format($stats['total_likes']) }}</span>
                </div>
                <div class="flex items-center justify-between py-2 border-b border-gray-100 dark:border-gray-700">
                    <span class="text-gray-600 dark:text-gray-400">Total Followers</span>
                    <span class="font-semibold text-gray-900 dark:text-white">{{ number_format($stats['total_followers']) }}</span>
                </div>
                <div class="flex items-center justify-between py-2">
                    <span class="text-gray-600 dark:text-gray-400">Categories</span>
                    <span class="font-semibold text-gray-900 dark:text-white">{{ number_format($stats['total_categories']) }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Recent Posts -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Posts</h3>
                    <a href="{{ route('admin.posts') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">View All</a>
                </div>
            </div>
            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($recentPosts as $post)
                    <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <h4 class="font-medium text-gray-900 dark:text-white text-sm">{{ Str::limit($post->title, 50) }}</h4>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    by {{ $post->user->name }} &bull; {{ $post->created_at->diffForHumans() }}
                                </p>
                            </div>
                            <span class="px-2 py-1 text-xs rounded-full {{ $post->status === 'published' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' }}">
                                {{ ucfirst($post->status) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center text-gray-500 dark:text-gray-400">No recent posts</div>
                @endforelse
            </div>
        </div>

        <!-- Recent Users -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Users</h3>
                    <a href="{{ route('admin.users') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">View All</a>
                </div>
            </div>
            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($recentUsers as $user)
                    <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                        <div class="flex items-center space-x-3">
                            <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-10 h-10 rounded-full">
                            <div class="flex-1">
                                <h4 class="font-medium text-gray-900 dark:text-white text-sm">{{ $user->name }}</h4>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                            </div>
                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ $user->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center text-gray-500 dark:text-gray-400">No recent users</div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Top Content -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Top Posts by Views -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Top Posts by Views</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($topPosts->take(5) as $index => $post)
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                {{ $index + 1 }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $post->title }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ number_format($post->view_count) }} views &bull; {{ $post->likes_count }} likes
                                </p>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 dark:text-gray-400">No data available</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Top Users by Posts -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Top Contributors</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($topUsers->take(5) as $index => $user)
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-r from-green-600 to-teal-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                {{ $index + 1 }}
                            </div>
                            <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-10 h-10 rounded-full">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $user->name }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ number_format($user->posts_count) }} posts &bull; {{ number_format($user->followers_count) }} followers
                                </p>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 dark:text-gray-400">No data available</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
