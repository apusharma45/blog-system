@php
    use Illuminate\Support\Facades\DB;
@endphp

<x-layouts.homepage :title="__('Home')">
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/30 to-indigo-50/20 dark:from-slate-950 dark:via-blue-950/30 dark:to-indigo-950/20">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-white via-blue-50/50 to-indigo-50/30 dark:from-slate-900 dark:via-blue-900/20 dark:to-indigo-900/20 border-b border-zinc-200 dark:border-zinc-800">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-xl font-semibold bg-gradient-to-r from-blue-900 via-indigo-800 to-purple-800 dark:from-blue-200 dark:via-indigo-200 dark:to-purple-200 bg-clip-text text-transparent sm:text-2xl">
                    {{ config('app.name') }}
                </h1>
                <p class="mt-2 text-sm text-slate-600 dark:text-slate-400 max-w-xl mx-auto">
                    Discover amazing stories, share your thoughts, and connect with a vibrant community
                </p>
                @guest
                <div class="mt-4 flex flex-col sm:flex-row justify-center gap-3">
                    <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 hover:from-blue-700 hover:via-indigo-700 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Start Writing
                    </a>
                    <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 border border-blue-300 text-sm font-medium rounded-md text-blue-700 bg-white hover:bg-blue-50 dark:border-blue-600 dark:text-blue-300 dark:bg-slate-800 dark:hover:bg-blue-900/20 transition-all duration-200 shadow-lg hover:shadow-xl">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                        Sign In
                    </a>
                </div>
                @endguest
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="mx-auto max-w-7xl px-4 py-4 sm:py-6 lg:py-8 sm:px-6 lg:px-8">
        <div class="grid gap-4 sm:gap-6 lg:gap-8 lg:grid-cols-4">
            <!-- Left Sidebar -->
            <aside class="lg:col-span-1 space-y-4 sm:space-y-6 order-2 lg:order-1">
                <!-- Online Users Widget -->
                <div class="bg-gradient-to-br from-white via-blue-50/30 to-indigo-50/20 rounded-2xl dark:from-slate-900 dark:via-blue-900/20 dark:to-indigo-900/20 p-6 transition-all duration-300 shadow-xl hover:shadow-2xl border border-zinc-200 dark:border-zinc-800">
                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-500 dark:bg-blue-600 rounded-lg flex items-center justify-center shadow-lg">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="ml-3 text-xl font-semibold bg-gradient-to-r from-blue-900 to-indigo-800 dark:from-blue-200 dark:to-indigo-200 bg-clip-text text-transparent">Live Activity</h3>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between p-3 bg-gradient-to-r from-emerald-50 via-teal-50 to-cyan-50 dark:from-emerald-900/20 dark:via-teal-900/20 dark:to-cyan-900/20 rounded-lg border border-zinc-200 dark:border-zinc-800">
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-full animate-pulse mr-3 shadow-sm"></div>
                                <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Active Bloggers</span>
                            </div>
                            <span class="text-lg font-bold text-emerald-600 dark:text-emerald-400">{{ \App\Models\User::where('last_activity_at', '>', now()->subMinutes(15))->count() }}</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gradient-to-r from-blue-50 via-indigo-50 to-purple-50 dark:from-blue-900/20 dark:via-indigo-900/20 dark:to-purple-900/20 rounded-lg border border-zinc-200 dark:border-zinc-800">
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full animate-pulse mr-3 shadow-sm"></div>
                                <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Visitors</span>
                            </div>
                            <span class="text-lg font-bold text-blue-600 dark:text-blue-400">{{ DB::table('sessions')->where('last_activity', '>', now()->subMinutes(15)->timestamp)->count() }}</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gradient-to-r from-purple-50 via-pink-50 to-rose-50 dark:from-purple-900/20 dark:via-pink-900/20 dark:to-rose-900/20 rounded-lg border border-zinc-200 dark:border-zinc-800">
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full animate-pulse mr-3 shadow-sm"></div>
                                <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Mobile Users</span>
                            </div>
                            <span class="text-lg font-bold text-purple-600 dark:text-purple-400">{{ DB::table('sessions')->where('last_activity', '>', now()->subMinutes(15)->timestamp)->where('user_agent', 'LIKE', '%Mobile%')->count() }}</span>
                        </div>
                    </div>
                </div>

                <!-- Categories -->
                <div class="bg-gradient-to-br from-white via-purple-50/30 to-pink-50/20 rounded-2xl dark:from-slate-900 dark:via-purple-900/20 dark:to-pink-900/20 p-6 transition-all duration-300 shadow-xl hover:shadow-2xl border border-zinc-200 dark:border-zinc-800">
                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-500 dark:bg-blue-600 rounded-lg flex items-center justify-center shadow-lg">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="ml-3 text-xl font-semibold bg-gradient-to-r from-purple-900 to-pink-800 dark:from-purple-200 dark:to-pink-200 bg-clip-text text-transparent">Categories</h3>
                    </div>
                    <div class="grid grid-cols-2 gap-1">
                        @foreach($categories as $cat)
                            <a href="{{ route('posts.index') }}?category={{ $cat->slug }}" class="py-1.5 px-2 text-sm text-slate-600 hover:text-slate-800 dark:text-slate-400 dark:hover:text-slate-100 transition-colors duration-200 hover:bg-gradient-to-r hover:from-purple-100 hover:to-pink-100 dark:hover:from-purple-800/30 dark:hover:to-pink-800/30 rounded-md text-center border border-transparent hover:border-zinc-200 dark:hover:border-zinc-700">
                                {{ $cat->name }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Popular Tags -->
                <div class="bg-gradient-to-br from-white via-emerald-50/30 to-teal-50/20 rounded-2xl dark:from-slate-900 dark:via-emerald-900/20 dark:to-teal-900/20 p-6 transition-all duration-300 shadow-xl hover:shadow-2xl border border-zinc-200 dark:border-zinc-800">
                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-500 dark:bg-blue-600 rounded-lg flex items-center justify-center shadow-lg">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="ml-3 text-xl font-semibold bg-gradient-to-r from-emerald-900 to-teal-800 dark:from-emerald-200 dark:to-teal-200 bg-clip-text text-transparent">Trending Tags</h3>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        @foreach($tags as $tag)
                            <a href="{{ route('posts.index') }}?tag={{ $tag->slug }}" class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium bg-gradient-to-r from-emerald-100 via-teal-100 to-cyan-100 text-emerald-800 hover:from-emerald-200 hover:via-teal-200 hover:to-cyan-200 hover:text-emerald-900 dark:from-emerald-900/20 dark:via-teal-900/20 dark:to-cyan-900/20 dark:text-emerald-300 dark:hover:from-emerald-800/30 dark:hover:via-teal-800/30 dark:hover:to-cyan-800/30 dark:hover:text-emerald-200 transition-all duration-200 border border-zinc-200 dark:border-zinc-700 shadow-sm hover:shadow-md">
                                <span class="mr-1">#</span>{{ $tag->name }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Recent Comments -->
                <div class="bg-gradient-to-br from-white via-orange-50/30 to-amber-50/20 rounded-2xl dark:from-slate-900 dark:via-orange-900/20 dark:to-amber-900/20 p-6 transition-all duration-300 shadow-xl hover:shadow-2xl border border-zinc-200 dark:border-zinc-800">
                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-500 dark:bg-blue-600 rounded-lg flex items-center justify-center shadow-lg">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="ml-3 text-xl font-semibold bg-gradient-to-r from-orange-900 to-amber-800 dark:from-orange-200 dark:to-amber-200 bg-clip-text text-transparent">Recent Activity</h3>
                    </div>
                    <div class="space-y-3">
                        @php
                            $recentComments = \App\Models\Comment::with(['user', 'post'])->latest()->limit(3)->get();
                        @endphp
                        @forelse($recentComments as $comment)
                            <div class="p-3 rounded-lg bg-gradient-to-r from-orange-50 via-amber-50 to-yellow-50 dark:from-orange-900/20 dark:via-amber-900/20 dark:to-yellow-900/20 border border-zinc-200 dark:border-zinc-800">
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-indigo-500 dark:from-blue-500 dark:to-indigo-600 rounded-full flex items-center justify-center text-xs font-bold text-white shadow-sm">
                                            {{ substr($comment->user->name, 0, 1) }}
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-medium text-slate-600 dark:text-slate-400">{{ $comment->user->name }}</p>
                                        <a href="{{ route('posts.show', ['username' => $comment->post->user->username, 'slug' => $comment->post->slug]) }}#comments" class="text-sm text-slate-800 dark:text-white hover:text-slate-600 dark:hover:text-slate-300 transition-colors line-clamp-2">{{ Str::limit($comment->post->title, 40) }}</a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <svg class="mx-auto h-8 w-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                                <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">No recent activity</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </aside>

            <!-- Main Content Area -->
            <main class="lg:col-span-3">
                <!-- Navigation Tabs removed - simplified feed -->

                <!-- Posts Feed -->
                <div class="space-y-6">
                    @forelse($posts as $post)
                        <article class="group bg-white rounded-2xl dark:bg-slate-900 hover:border-blue-300 dark:hover:border-blue-700 transition-all duration-300 shadow-lg hover:shadow-xl overflow-hidden border border-zinc-200 dark:border-zinc-800">
                            <div class="p-4 sm:p-6 lg:p-8">
                                    <!-- Post Title -->
                                    <div class="mb-4">
                                        <h2 class="font-bold text-slate-900 dark:text-white leading-tight mb-3" style="font-size:36px;">
                                            <a href="{{ route('posts.show', ['username' => $post->user->username, 'slug' => $post->slug]) }}" class="hover:text-slate-700 dark:hover:text-slate-200 transition-colors">{{ $post->title }}</a>
                                        </h2>
                                    </div>

                                    <!-- Content Preview -->
                                    <div class="mb-4">
                                        @if($post->featured_image)
                                            <div class="mb-4 flex justify-center">
                                                <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="rounded-lg shadow-md" style="max-height: 250px; width: auto; object-fit: contain;">
                                            </div>
                                        @endif
                                        <div class="text-slate-600 dark:text-slate-300 mb-3 line-clamp-4" style="font-size:18px; line-height:1.8; text-align: justify; text-justify: inter-word;">
                                            {{ Str::limit(strip_tags($post->content), 400) }}
                                        </div>
                                        <a href="{{ route('posts.show', ['username' => $post->user->username, 'slug' => $post->slug]) }}" class="inline-flex items-center text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 font-medium transition-colors text-sm">
                                            Read more
                                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </a>
                                    </div>

                                        <!-- Author and Date moved below content -->
                                        <div class="flex items-center justify-between mb-4">
                                            <div class="flex items-center space-x-2 opacity-70">
                                                <div class="relative">
                                                    <img src="{{ $post->user->avatar_url }}" alt="{{ $post->user->name }}" class="h-6 w-6 rounded-full object-cover border border-slate-200 dark:border-slate-700">
                                                    <div class="absolute -bottom-0.5 -right-0.5 w-1.5 h-1.5 bg-emerald-500 border border-white dark:border-slate-900 rounded-full"></div>
                                                </div>
                                                <a href="{{ route('users.profile', $post->user->username) }}" class="text-sm font-medium text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 transition-colors">{{ $post->user->name }}</a>
                                                <span class="text-xs text-slate-500 dark:text-slate-500">•</span>
                                                <div class="flex items-center space-x-1 text-xs text-slate-500 dark:text-slate-500">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    <span>{{ optional($post->published_at ?? $post->created_at)->format('M d, Y') }}</span>
                                                </div>
                                            </div>
                                            
                                            @auth
                                                @if(auth()->id() !== $post->user_id)
                                                    <button onclick="toggleFollow({{ $post->user_id }}, this)" 
                                                            data-following="{{ $post->user->isFollowedBy(auth()->user()) ? 'true' : 'false' }}"
                                                            class="inline-flex items-center px-2 py-1 text-xs font-medium rounded text-gray-600 hover:text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:bg-gray-800 transition-colors duration-200">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                                        </svg>
                                                        <span>{{ $post->user->isFollowedBy(auth()->user()) ? 'Following' : 'Follow' }}</span>
                                                    </button>
                                                @endif
                                            @endauth
                                        </div>

                                    <!-- Post Meta -->
                                    <div class="flex items-center justify-between pt-4 border-t border-zinc-200 dark:border-zinc-800">
                                    <div class="flex items-center space-x-6">
                                        @guest
                                            <button disabled class="flex items-center space-x-2 text-slate-400 cursor-not-allowed">
                                                <div class="p-2 rounded-lg bg-slate-100 dark:bg-slate-700">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                                    </svg>
                                                </div>
                                                <span class="font-medium">{{ $post->likes_count ?? 0 }}</span>
                                            </button>
                                        @else
                                            <button onclick="toggleLike({{ $post->id }}, this)" 
                                                    data-liked="{{ $post->is_liked ? 'true' : 'false' }}"
                                                    class="flex items-center space-x-2 {{ $post->is_liked ? 'text-red-500 hover:text-red-600 dark:text-red-400 dark:hover:text-red-300' : 'text-slate-600 hover:text-red-500 dark:text-slate-300 dark:hover:text-red-400' }} transition-colors group">
                                                <div class="p-2 rounded-lg {{ $post->is_liked ? 'bg-red-50 dark:bg-red-900/20 group-hover:bg-red-100 dark:group-hover:bg-red-900/30' : 'bg-slate-50 dark:bg-slate-700 group-hover:bg-red-50 dark:group-hover:bg-red-900/20' }} transition-colors">
                                                    <svg class="h-4 w-4" fill="{{ $post->is_liked ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                                    </svg>
                                                </div>
                                                <span class="like-count font-medium">{{ $post->likes_count ?? 0 }}</span>
                                            </button>
                                        @endguest
                                        
                                        <a href="{{ route('posts.show', ['username' => $post->user->username, 'slug' => $post->slug]) }}#comments" class="flex items-center space-x-2 text-slate-600 hover:text-slate-700 dark:text-slate-300 dark:hover:text-slate-200 transition-colors group">
                                            <div class="p-2 rounded-lg bg-slate-50 dark:bg-slate-700 group-hover:bg-slate-100 dark:group-hover:bg-slate-600 transition-colors">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                                </svg>
                                            </div>
                                            <span class="font-medium">{{ $post->comments_count ?? 0 }}</span>
                                        </a>
                                        
                                        <div class="flex items-center space-x-2 text-slate-600 dark:text-slate-300">
                                            <div class="p-2 rounded-lg bg-slate-50 dark:bg-slate-700">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </div>
                                            <span class="font-medium">{{ $post->view_count ?? 0 }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($post->categories as $cat)
                                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-medium bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-800 dark:from-blue-900/20 dark:to-indigo-900/20 dark:text-blue-300">{{ $cat->name }}</span>
                                        @endforeach
                                        @foreach($post->tags as $tag)
                                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-medium bg-gradient-to-r from-purple-100 to-pink-100 text-purple-800 dark:from-purple-900/20 dark:to-pink-900/20 dark:text-purple-300">#{{ $tag->name }}</span>
                                        @endforeach
                                    </div>
                                    </div>
                            </div>
                        </article>
                    @empty
                        <div class="text-center py-16">
                            <div class="mx-auto max-w-md">
                                <svg class="mx-auto h-16 w-16 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <h3 class="mt-4 text-xl font-semibold text-slate-800 dark:text-white">No posts yet</h3>
                                <p class="mt-2 text-slate-500 dark:text-slate-400">Be the first to share your thoughts and start the conversation!</p>
                                @auth
                                    <div class="mt-6">
                                        <a href="{{ route('posts.create') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-lg hover:shadow-xl">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                            </svg>
                                            Write your first post
                                        </a>
                                    </div>
                                @endauth
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="mt-12">
                    <div class="bg-white rounded-2xl dark:bg-slate-900 p-4 shadow-lg border border-zinc-200 dark:border-zinc-800">
                        {{ $posts->links() }}
                    </div>
                </div>
            </main>
        </div>
    </div>
</div>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.line-clamp-4 {
    display: -webkit-box;
    -webkit-line-clamp: 4;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Enhanced post card styling */
.group:hover .group-hover\:scale-105 {
    transform: scale(1.05);
}

/* Smooth transitions for better UX */
article {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

article:hover {
    transform: translateY(-2px);
}
</style>

<script>
function toggleLike(postId, button) {
    const isLiked = button.dataset.liked === 'true';
    const icon = button.querySelector('svg');
    const iconBg = button.querySelector('div');
    const countSpan = button.querySelector('.like-count');
    const currentCount = parseInt(countSpan.textContent);
    
    // Optimistic UI update
    if (isLiked) {
        // Unlike
        button.classList.remove('text-red-500', 'hover:text-red-600', 'dark:text-red-400', 'dark:hover:text-red-300');
        button.classList.add('text-slate-600', 'hover:text-red-500', 'dark:text-slate-300', 'dark:hover:text-red-400');
        iconBg.classList.remove('bg-red-50', 'dark:bg-red-900/20', 'group-hover:bg-red-100', 'dark:group-hover:bg-red-900/30');
        iconBg.classList.add('bg-slate-50', 'dark:bg-slate-700', 'group-hover:bg-red-50', 'dark:group-hover:bg-red-900/20');
        icon.setAttribute('fill', 'none');
        countSpan.textContent = currentCount - 1;
        button.dataset.liked = 'false';
    } else {
        // Like
        button.classList.remove('text-slate-600', 'hover:text-red-500', 'dark:text-slate-300', 'dark:hover:text-red-400');
        button.classList.add('text-red-500', 'hover:text-red-600', 'dark:text-red-400', 'dark:hover:text-red-300');
        iconBg.classList.remove('bg-slate-50', 'dark:bg-slate-700', 'group-hover:bg-red-50', 'dark:group-hover:bg-red-900/20');
        iconBg.classList.add('bg-red-50', 'dark:bg-red-900/20', 'group-hover:bg-red-100', 'dark:group-hover:bg-red-900/30');
        icon.setAttribute('fill', 'currentColor');
        countSpan.textContent = currentCount + 1;
        button.dataset.liked = 'true';
    }
    
    // Send AJAX request
    const method = isLiked ? 'DELETE' : 'POST';
    const url = `/posts/${postId}/like`;
    
    fetch(url, {
        method: method,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.likes_count !== undefined) {
            countSpan.textContent = data.likes_count;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        // Revert on error
        if (!isLiked) {
            button.classList.remove('text-red-500', 'hover:text-red-600', 'dark:text-red-400', 'dark:hover:text-red-300');
            button.classList.add('text-slate-600', 'hover:text-red-500', 'dark:text-slate-300', 'dark:hover:text-red-400');
            iconBg.classList.remove('bg-red-50', 'dark:bg-red-900/20', 'group-hover:bg-red-100', 'dark:group-hover:bg-red-900/30');
            iconBg.classList.add('bg-slate-50', 'dark:bg-slate-700', 'group-hover:bg-red-50', 'dark:group-hover:bg-red-900/20');
            icon.setAttribute('fill', 'none');
            countSpan.textContent = currentCount;
            button.dataset.liked = 'false';
        } else {
            button.classList.remove('text-slate-600', 'hover:text-red-500', 'dark:text-slate-300', 'dark:hover:text-red-400');
            button.classList.add('text-red-500', 'hover:text-red-600', 'dark:text-red-400', 'dark:hover:text-red-300');
            iconBg.classList.remove('bg-slate-50', 'dark:bg-slate-700', 'group-hover:bg-red-50', 'dark:group-hover:bg-red-900/20');
            iconBg.classList.add('bg-red-50', 'dark:bg-red-900/20', 'group-hover:bg-red-100', 'dark:group-hover:bg-red-900/30');
            icon.setAttribute('fill', 'currentColor');
            countSpan.textContent = currentCount;
            button.dataset.liked = 'true';
        }
    });
}

function toggleFollow(userId, button) {
    const isFollowing = button.dataset.following === 'true';
    const textSpan = button.querySelector('span');
    
    // Optimistic UI update
    if (isFollowing) {
        textSpan.textContent = 'Follow';
        button.dataset.following = 'false';
    } else {
        textSpan.textContent = 'Following';
        button.dataset.following = 'true';
    }
    
    // Send AJAX request
    const method = isFollowing ? 'DELETE' : 'POST';
    const url = `/users/${userId}/follow`;
    
    fetch(url, {
        method: method,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update confirmed by server
            button.dataset.following = data.is_following ? 'true' : 'false';
            textSpan.textContent = data.is_following ? 'Following' : 'Follow';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        // Revert on error
        if (!isFollowing) {
            textSpan.textContent = 'Follow';
            button.dataset.following = 'false';
        } else {
            textSpan.textContent = 'Following';
            button.dataset.following = 'true';
        }
    });
}
</script>
</x-layouts.homepage>
