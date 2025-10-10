<x-layouts.homepage :title="__('All Posts')">
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/30 to-indigo-50/20 dark:from-slate-950 dark:via-blue-950/30 dark:to-indigo-950/20">
    <!-- Hero Search Section -->
    <div class="bg-gradient-to-r from-white via-blue-50/50 to-indigo-50/30 dark:from-slate-900 dark:via-blue-900/20 dark:to-indigo-900/20 border-b border-zinc-200 dark:border-zinc-800">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 py-4 sm:py-6">
            <div class="text-center mb-4">
                <h1 class="text-lg sm:text-xl lg:text-2xl font-bold bg-gradient-to-r from-blue-900 via-indigo-800 to-purple-800 dark:from-blue-200 dark:via-indigo-200 dark:to-purple-200 bg-clip-text text-transparent mb-2">Discover Amazing Content</h1>
                <p class="text-sm sm:text-base text-slate-600 dark:text-slate-400 max-w-xl mx-auto">Search through posts, filter by categories and tags</p>
            </div>

            <!-- Advanced Search Bar -->
            <div class="max-w-3xl mx-auto">
                <form method="GET" action="{{ route('posts.index') }}" class="relative">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input 
                            type="text" 
                            name="search" 
                            value="{{ request('search') }}"
                            placeholder="Search posts, authors, or topics..."
                            class="w-full pl-10 pr-20 py-2.5 text-sm border border-zinc-200 rounded-lg focus:border-zinc-400 focus:outline-none focus:ring-2 focus:ring-zinc-400/20 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white dark:focus:border-zinc-400 transition-all duration-200 shadow-sm hover:shadow-md"
                        >
                        <div class="absolute inset-y-0 right-0 flex items-center pr-2">
                            <button type="submit" class="inline-flex items-center px-4 py-1.5 border border-transparent text-sm font-medium rounded-md text-white bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 hover:from-blue-700 hover:via-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-lg hover:shadow-xl">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                Search
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Quick Search Suggestions -->
                <div class="mt-3 flex flex-wrap justify-center items-center gap-2">
                    <span class="text-xs text-slate-500 dark:text-slate-400 whitespace-nowrap">Popular:</span>
                    <div class="flex flex-wrap gap-1.5">
                        <a href="{{ route('posts.index', ['search' => 'laravel']) }}" class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-slate-100 text-slate-700 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700 transition-colors whitespace-nowrap">Laravel</a>
                        <a href="{{ route('posts.index', ['search' => 'php']) }}" class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-slate-100 text-slate-700 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700 transition-colors whitespace-nowrap">PHP</a>
                        <a href="{{ route('posts.index', ['search' => 'javascript']) }}" class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-slate-100 text-slate-700 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700 transition-colors whitespace-nowrap">JavaScript</a>
                        <a href="{{ route('posts.index', ['search' => 'web development']) }}" class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-slate-100 text-slate-700 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700 transition-colors whitespace-nowrap">Web Development</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="mx-auto max-w-7xl px-6 py-8">
        <div class="grid gap-8 lg:grid-cols-4">
            <!-- Advanced Filters Sidebar -->
            <aside class="lg:col-span-1 space-y-6 order-2 lg:order-2 lg:col-start-4">
                <!-- Filter Toggle for Mobile -->
                <div class="lg:hidden">
                    <button onclick="toggleFilters()" class="w-full flex items-center justify-between p-4 rounded-xl bg-white shadow-lg border border-zinc-200 dark:bg-zinc-900 dark:border-zinc-800 text-zinc-900 dark:text-white">
                        <span class="font-semibold">Filters & Categories</span>
                        <svg class="w-5 h-5 transform transition-transform" id="filter-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                </div>

                <!-- Filters Container -->
                <div id="filters-container" class="hidden lg:block space-y-6">
                    <!-- Active Filters -->
                    @if(request()->hasAny(['search', 'category', 'tag', 'author', 'date_range']))
                        <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-white via-red-50/30 to-orange-50/20 p-6 shadow-xl hover:shadow-2xl transition-all duration-300 dark:from-slate-900 dark:via-red-900/20 dark:to-orange-900/20 border border-zinc-200 dark:border-zinc-800">
                            <div class="absolute inset-0 bg-gradient-to-br from-red-500/5 to-orange-600/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <div class="relative">
                                <div class="flex items-center mb-4">
                                    <div class="w-8 h-8 bg-blue-500 dark:bg-blue-600 rounded-lg flex items-center justify-center mr-3 border border-zinc-200 dark:border-zinc-700 shadow-lg">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-semibold bg-gradient-to-r from-red-900 to-orange-800 dark:from-red-200 dark:to-orange-200 bg-clip-text text-transparent">Active Filters</h3>
                                </div>
                                <div class="space-y-2">
                                    @if(request('search'))
                                        <div class="flex items-center justify-between p-2 rounded-lg bg-zinc-50 dark:bg-zinc-800">
                                            <span class="text-sm text-zinc-700 dark:text-zinc-300">Search: "{{ request('search') }}"</span>
                                            <a href="{{ route('posts.index', request()->except('search')) }}" class="text-zinc-600 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-zinc-200">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    @endif
                                    @if(request('category'))
                                        <div class="flex items-center justify-between p-2 rounded-lg bg-zinc-50 dark:bg-zinc-800">
                                            <span class="text-sm text-zinc-700 dark:text-zinc-300">Category: {{ $categories->where('slug', request('category'))->first()->name ?? request('category') }}</span>
                                            <a href="{{ route('posts.index', request()->except('category')) }}" class="text-zinc-600 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-zinc-200">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    @endif
                                    @if(request('tag'))
                                        <div class="flex items-center justify-between p-2 rounded-lg bg-zinc-50 dark:bg-zinc-800">
                                            <span class="text-sm text-zinc-700 dark:text-zinc-300">Tag: #{{ $tags->where('slug', request('tag'))->first()->name ?? request('tag') }}</span>
                                            <a href="{{ route('posts.index', request()->except('tag')) }}" class="text-zinc-600 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-zinc-200">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    @endif
                                </div>
                                <div class="mt-4">
                                    <a href="{{ route('posts.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-gradient-to-r from-red-500 via-orange-500 to-yellow-500 hover:from-red-600 hover:via-orange-600 hover:to-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200 shadow-lg hover:shadow-xl">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Clear All Filters
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Categories Filter -->
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
                            <a href="{{ route('posts.index') }}" class="py-1.5 px-2 text-sm text-slate-600 hover:text-slate-800 dark:text-slate-400 dark:hover:text-slate-100 transition-colors duration-200 hover:bg-gradient-to-r hover:from-purple-100 hover:to-pink-100 dark:hover:from-purple-800/30 dark:hover:to-pink-800/30 rounded-md text-center border border-transparent hover:border-zinc-200 dark:hover:border-zinc-700 {{ !request('category') ? 'bg-gradient-to-r from-purple-100 to-pink-100 dark:from-purple-800/30 dark:to-pink-800/30 font-medium border-zinc-200 dark:border-zinc-700' : '' }}">
                                All Categories
                            </a>
                            @foreach($categories as $category)
                                <a href="{{ route('posts.index', ['category' => $category->slug] + request()->except('category')) }}" class="py-1.5 px-2 text-sm text-slate-600 hover:text-slate-800 dark:text-slate-400 dark:hover:text-slate-100 transition-colors duration-200 hover:bg-gradient-to-r hover:from-purple-100 hover:to-pink-100 dark:hover:from-purple-800/30 dark:hover:to-pink-800/30 rounded-md text-center border border-transparent hover:border-zinc-200 dark:hover:border-zinc-700 {{ request('category') === $category->slug ? 'bg-gradient-to-r from-purple-100 to-pink-100 dark:from-purple-800/30 dark:to-pink-800/30 font-medium border-zinc-200 dark:border-zinc-700' : '' }}">
                                    {{ $category->name }}
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
                            <a href="{{ route('posts.index', ['tag' => $tag->slug] + request()->except('tag')) }}" class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium bg-gradient-to-r from-emerald-100 via-teal-100 to-cyan-100 text-emerald-800 hover:from-emerald-200 hover:via-teal-200 hover:to-cyan-200 hover:text-emerald-900 dark:from-emerald-900/20 dark:via-teal-900/20 dark:to-cyan-900/20 dark:text-emerald-300 dark:hover:from-emerald-800/30 dark:hover:via-teal-800/30 dark:hover:to-cyan-800/30 dark:hover:text-emerald-200 transition-all duration-200 border border-zinc-200 dark:border-zinc-700 shadow-sm hover:shadow-md">
                                <span class="mr-1">#</span>{{ $tag->name }}
                            </a>
                        @endforeach
                    </div>
                </div>

                    <!-- Sort Options -->
                    <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-white via-blue-50/30 to-indigo-50/20 p-6 shadow-xl hover:shadow-2xl transition-all duration-300 dark:from-slate-900 dark:via-blue-900/20 dark:to-indigo-900/20 border border-zinc-200 dark:border-zinc-800">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-indigo-600/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <div class="relative">
                            <div class="flex items-center mb-4">
                                <div class="w-8 h-8 bg-blue-500 dark:bg-blue-600 rounded-lg flex items-center justify-center mr-3 border border-zinc-200 dark:border-zinc-700 shadow-lg">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"></path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold bg-gradient-to-r from-blue-900 to-indigo-800 dark:from-blue-200 dark:to-indigo-200 bg-clip-text text-transparent">Sort By</h3>
                            </div>
                            <div class="space-y-2">
                                <a href="{{ route('posts.index', request()->except('sort')) }}" class="block p-3 rounded-xl {{ !request('sort') ? 'bg-gradient-to-r from-blue-100 to-indigo-100 dark:from-blue-800/30 dark:to-indigo-800/30 text-blue-600 dark:text-blue-400 font-medium border border-zinc-200 dark:border-zinc-700' : 'bg-gradient-to-r from-slate-50 to-slate-100 dark:from-slate-800/50 dark:to-slate-700/50 hover:from-blue-50 hover:to-indigo-50 dark:hover:from-blue-900/20 dark:hover:to-indigo-900/20 text-slate-700 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400' }} transition-all duration-200 border border-transparent hover:border-zinc-200 dark:hover:border-zinc-700">
                                    Latest Posts
                                </a>
                                <a href="{{ route('posts.index', ['sort' => 'popular'] + request()->except('sort')) }}" class="block p-3 rounded-xl {{ request('sort') === 'popular' ? 'bg-gradient-to-r from-blue-100 to-indigo-100 dark:from-blue-800/30 dark:to-indigo-800/30 text-blue-600 dark:text-blue-400 font-medium border border-zinc-200 dark:border-zinc-700' : 'bg-gradient-to-r from-slate-50 to-slate-100 dark:from-slate-800/50 dark:to-slate-700/50 hover:from-blue-50 hover:to-indigo-50 dark:hover:from-blue-900/20 dark:hover:to-indigo-900/20 text-slate-700 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400' }} transition-all duration-200 border border-transparent hover:border-zinc-200 dark:hover:border-zinc-700">
                                    Most Popular
                                </a>
                                <a href="{{ route('posts.index', ['sort' => 'trending'] + request()->except('sort')) }}" class="block p-3 rounded-xl {{ request('sort') === 'trending' ? 'bg-gradient-to-r from-blue-100 to-indigo-100 dark:from-blue-800/30 dark:to-indigo-800/30 text-blue-600 dark:text-blue-400 font-medium border border-zinc-200 dark:border-zinc-700' : 'bg-gradient-to-r from-slate-50 to-slate-100 dark:from-slate-800/50 dark:to-slate-700/50 hover:from-blue-50 hover:to-indigo-50 dark:hover:from-blue-900/20 dark:hover:to-indigo-900/20 text-slate-700 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400' }} transition-all duration-200 border border-transparent hover:border-zinc-200 dark:hover:border-zinc-700">
                                    Trending
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Main Content Area -->
            <main class="lg:col-span-3 order-1 lg:order-1 lg:col-start-1">
                <!-- Results Header -->
                <div class="mb-8">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-2xl font-bold text-zinc-900 dark:text-white">
                                @if(request()->hasAny(['search', 'category', 'tag']))
                                    Search Results
                                @else
                                    All Posts
                                @endif
                            </h2>
                            <p class="text-zinc-600 dark:text-zinc-400 mt-1">
                @if(request()->hasAny(['search', 'category', 'tag']))
                                    Found {{ $posts->total() }} {{ Str::plural('result', $posts->total()) }}
                            @if(request('search'))
                                        for "{{ request('search') }}"
                            @endif
                                @else
                                    Discover the latest posts from our community
                            @endif
                            </p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="text-sm text-zinc-500 dark:text-zinc-400">
                                Showing {{ $posts->firstItem() ?? 0 }}-{{ $posts->lastItem() ?? 0 }} of {{ $posts->total() }} results
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Posts Feed -->
                <div class="space-y-6">
                    @forelse($posts as $post)
                        <article class="group bg-white rounded-2xl dark:bg-slate-900 hover:border-blue-300 dark:hover:border-blue-700 transition-all duration-300 shadow-lg hover:shadow-xl overflow-hidden border border-zinc-200 dark:border-zinc-800">
                            <div class="p-4 sm:p-6 lg:p-8">
                                    <!-- Post Title -->
                                    <div class="mb-4">
                                        <h2 class="font-bold text-slate-900 dark:text-white leading-tight mb-3" style="font-size:36px;">
                                            <a href="{{ route('posts.show', ['username' => $post->user->username, 'slug' => $post->slug]) }}" class="hover:text-blue-700 dark:hover:text-blue-300 transition-colors">{{ $post->title }}</a>
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
                                            <button disabled class="flex items-center space-x-2 text-zinc-400 cursor-not-allowed">
                                                <div class="p-2 rounded-full bg-zinc-100 dark:bg-zinc-700">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                            </svg>
                                                </div>
                                                <span class="font-medium">{{ $post->likes_count ?? 0 }}</span>
                                        </button>
                                    @else
                                        <button onclick="toggleLike({{ $post->id }}, this)" 
                                                data-liked="{{ $post->is_liked ? 'true' : 'false' }}"
                                                class="flex items-center space-x-2 {{ $post->is_liked ? 'text-red-500 hover:text-red-600 dark:text-red-400 dark:hover:text-red-300' : 'text-zinc-600 hover:text-red-500 dark:text-zinc-300 dark:hover:text-red-400' }} transition-colors group">
                                            <div class="p-2 rounded-full {{ $post->is_liked ? 'bg-red-50 dark:bg-red-900/20 group-hover:bg-red-100 dark:group-hover:bg-red-900/30' : 'bg-zinc-50 dark:bg-zinc-700 group-hover:bg-red-50 dark:group-hover:bg-red-900/20' }} transition-colors">
                                                <svg class="h-4 w-4" fill="{{ $post->is_liked ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                                </svg>
                                            </div>
                                            <span class="like-count font-medium">{{ $post->likes_count ?? 0 }}</span>
                                        </button>
                                    @endguest
                                    
                                        <a href="{{ route('posts.show', ['username' => $post->user->username, 'slug' => $post->slug]) }}#comments" class="flex items-center space-x-2 text-zinc-600 hover:text-zinc-700 dark:text-zinc-300 dark:hover:text-zinc-200 transition-colors group">
                                            <div class="p-2 rounded-full bg-zinc-50 dark:bg-zinc-700 group-hover:bg-zinc-100 dark:group-hover:bg-zinc-600 transition-colors">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                        </svg>
                                            </div>
                                            <span class="font-medium">{{ $post->comments_count ?? 0 }}</span>
                                        </a>
                                        
                                        <div class="flex items-center space-x-2 text-zinc-600 dark:text-zinc-300">
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
                                        <a href="{{ route('posts.index', ['category' => $cat->slug] + request()->except('category')) }}" class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-medium bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-800 dark:from-blue-900/20 dark:to-indigo-900/20 dark:text-blue-300 hover:from-blue-200 hover:to-indigo-200 hover:text-blue-900 dark:hover:from-blue-800/30 dark:hover:to-indigo-800/30 dark:hover:text-blue-200 transition-all duration-200">{{ $cat->name }}</a>
                                    @endforeach
                                    @foreach($post->tags as $tag)
                                        <a href="{{ route('posts.index', ['tag' => $tag->slug] + request()->except('tag')) }}" class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-medium bg-gradient-to-r from-purple-100 to-pink-100 text-purple-800 dark:from-purple-900/20 dark:to-pink-900/20 dark:text-purple-300 hover:from-purple-200 hover:to-pink-200 hover:text-purple-900 dark:hover:from-purple-800/30 dark:hover:to-pink-800/30 dark:hover:text-purple-200 transition-all duration-200">#{{ $tag->name }}</a>
                                    @endforeach
                                    </div>
                            </div>
                        </article>
                    @empty
                        <div class="text-center py-16">
                            <div class="mx-auto max-w-md">
                                <svg class="mx-auto h-16 w-16 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                                <h3 class="mt-4 text-xl font-semibold text-slate-800 dark:text-white">
                                    @if(request()->hasAny(['search', 'category', 'tag']))
                                        No results found
                                    @else
                                        No posts yet
                                    @endif
                                </h3>
                                <p class="mt-2 text-slate-500 dark:text-slate-400">
                                    @if(request()->hasAny(['search', 'category', 'tag']))
                                        Try adjusting your search terms or filters to find what you're looking for.
                                    @else
                                        Be the first to share your thoughts and start the conversation!
                                    @endif
                                </p>
                                @if(request()->hasAny(['search', 'category', 'tag']))
                                    <div class="mt-6">
                                        <a href="{{ route('posts.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-full text-white bg-zinc-900 hover:bg-zinc-800 dark:bg-zinc-800 dark:hover:bg-zinc-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-zinc-500 transition-all duration-200 shadow-lg hover:shadow-xl">
                                            Clear Filters
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="mt-12">
                    <div class="bg-white rounded-2xl dark:bg-slate-900 p-4 shadow-lg border border-zinc-200 dark:border-zinc-800">
                    {{ $posts->appends(request()->query())->links() }}
                    </div>
                </div>
            </main>
        </div>
    </div>
</div>

<script>
function toggleFilters() {
    const container = document.getElementById('filters-container');
    const arrow = document.getElementById('filter-arrow');
    
    if (container.classList.contains('hidden')) {
        container.classList.remove('hidden');
        arrow.classList.add('rotate-180');
    } else {
        container.classList.add('hidden');
        arrow.classList.remove('rotate-180');
    }
}

// Auto-submit search on Enter key
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                this.closest('form').submit();
            }
        });
    }
});

// Highlight search terms in results
document.addEventListener('DOMContentLoaded', function() {
    const searchTerm = '{{ request('search') }}';
    if (searchTerm) {
        const postTitles = document.querySelectorAll('article h2 a');
        const postExcerpts = document.querySelectorAll('article p');
        
        postTitles.forEach(title => {
            title.innerHTML = title.innerHTML.replace(new RegExp(`(${searchTerm})`, 'gi'), '<mark class="bg-yellow-200 dark:bg-yellow-800/50 px-1 rounded">$1</mark>');
        });
        
        postExcerpts.forEach(excerpt => {
            excerpt.innerHTML = excerpt.innerHTML.replace(new RegExp(`(${searchTerm})`, 'gi'), '<mark class="bg-yellow-200 dark:bg-yellow-800/50 px-1 rounded">$1</mark>');
        });
    }
});
</script>

<style>
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
        button.classList.add('text-zinc-600', 'hover:text-red-500', 'dark:text-zinc-300', 'dark:hover:text-red-400');
        iconBg.classList.remove('bg-red-50', 'dark:bg-red-900/20', 'group-hover:bg-red-100', 'dark:group-hover:bg-red-900/30');
        iconBg.classList.add('bg-zinc-50', 'dark:bg-zinc-700', 'group-hover:bg-red-50', 'dark:group-hover:bg-red-900/20');
        icon.setAttribute('fill', 'none');
        countSpan.textContent = currentCount - 1;
        button.dataset.liked = 'false';
    } else {
        // Like
        button.classList.remove('text-zinc-600', 'hover:text-red-500', 'dark:text-zinc-300', 'dark:hover:text-red-400');
        button.classList.add('text-red-500', 'hover:text-red-600', 'dark:text-red-400', 'dark:hover:text-red-300');
        iconBg.classList.remove('bg-zinc-50', 'dark:bg-zinc-700', 'group-hover:bg-red-50', 'dark:group-hover:bg-red-900/20');
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
            button.classList.add('text-zinc-600', 'hover:text-red-500', 'dark:text-zinc-300', 'dark:hover:text-red-400');
            iconBg.classList.remove('bg-red-50', 'dark:bg-red-900/20', 'group-hover:bg-red-100', 'dark:group-hover:bg-red-900/30');
            iconBg.classList.add('bg-zinc-50', 'dark:bg-zinc-700', 'group-hover:bg-red-50', 'dark:group-hover:bg-red-900/20');
            icon.setAttribute('fill', 'none');
            countSpan.textContent = currentCount;
            button.dataset.liked = 'false';
        } else {
            button.classList.remove('text-zinc-600', 'hover:text-red-500', 'dark:text-zinc-300', 'dark:hover:text-red-400');
            button.classList.add('text-red-500', 'hover:text-red-600', 'dark:text-red-400', 'dark:hover:text-red-300');
            iconBg.classList.remove('bg-zinc-50', 'dark:bg-zinc-700', 'group-hover:bg-red-50', 'dark:group-hover:bg-red-900/20');
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
