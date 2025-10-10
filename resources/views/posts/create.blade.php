<x-layouts.homepage :title="__('Create Post')">
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/30 to-indigo-50/20 dark:from-slate-950 dark:via-blue-950/30 dark:to-indigo-950/20">
    <!-- Header -->
    <div class="bg-gradient-to-r from-white via-blue-50/50 to-indigo-50/30 dark:from-slate-900 dark:via-blue-900/20 dark:to-indigo-900/20 border-b border-zinc-200 dark:border-zinc-800">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 py-4 sm:py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('dashboard', ['username' => auth()->user()->username]) }}" class="p-2 rounded-lg text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-3xl sm:text-4xl font-semibold bg-gradient-to-r from-blue-900 via-indigo-800 to-purple-800 dark:from-blue-200 dark:via-indigo-200 dark:to-purple-200 bg-clip-text text-transparent">Create New Post</h1>
                        <p class="text-lg sm:text-xl text-zinc-600 dark:text-zinc-400 mt-1">Share your thoughts with the community</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="text-sm text-zinc-500 dark:text-zinc-400">
                        <span id="word-count">0</span> words
                    </div>
                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                    <span class="text-sm text-zinc-500 dark:text-zinc-400">Auto-saving...</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="mx-auto max-w-4xl px-4 sm:px-6 py-6 sm:py-8">
        <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data" class="space-y-8" id="post-form">
            @csrf
            
            <!-- Title Section -->
            <div class="bg-gradient-to-br from-white via-blue-50/30 to-indigo-50/20 rounded-2xl dark:from-slate-900 dark:via-blue-900/20 dark:to-indigo-900/20 border border-zinc-200 dark:border-zinc-800 p-4 sm:p-6 lg:p-8 transition-all duration-300 shadow-xl hover:shadow-2xl">
                <div class="relative">
                    <label for="title" class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-3">
                        <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                        Post Title
                    </label>
                    <input 
                        type="text" 
                        id="title" 
                        name="title" 
                        value="{{ old('title') }}"
                        class="w-full text-xl sm:text-2xl lg:text-3xl font-bold bg-transparent border-none focus:outline-none text-zinc-900 dark:text-white placeholder-zinc-400 dark:placeholder-zinc-500" 
                        placeholder="What's your post about?"
                        required
                    >
                    @error('title')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <!-- Excerpt Section -->
            <div class="bg-gradient-to-br from-white via-blue-50/30 to-indigo-50/20 rounded-2xl dark:from-slate-900 dark:via-blue-900/20 dark:to-indigo-900/20 border border-zinc-200 dark:border-zinc-800 p-8 transition-all duration-300 shadow-xl hover:shadow-2xl">
                <div class="relative">
                    <label for="excerpt" class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-3">
                        <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Excerpt (Optional)
                    </label>
                    <textarea 
                        id="excerpt" 
                        name="excerpt" 
                        rows="3"
                        class="w-full bg-transparent border-none focus:outline-none text-zinc-700 dark:text-zinc-300 placeholder-zinc-400 dark:placeholder-zinc-500 resize-none" 
                        placeholder="Brief description of your post that will appear in the feed..."
                    >{{ old('excerpt') }}</textarea>
                    <div class="flex items-center justify-between mt-2">
                        <p class="text-xs text-zinc-500 dark:text-zinc-400">A compelling excerpt helps readers decide to read your full post</p>
                        <span class="text-xs text-zinc-400" id="excerpt-count">0/500</span>
                    </div>
                    @error('excerpt')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <!-- Featured Image Section -->
            <div class="bg-gradient-to-br from-white via-blue-50/30 to-indigo-50/20 rounded-2xl dark:from-slate-900 dark:via-blue-900/20 dark:to-indigo-900/20 border border-zinc-200 dark:border-zinc-800 p-8 transition-all duration-300 shadow-xl hover:shadow-2xl">
                <div class="relative">
                    <label for="featured_image" class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-4">
                        <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Featured Image (Optional)
                    </label>
                    
                    <div class="space-y-4">
                        <!-- Image Upload Area -->
                        <div class="relative">
                            <input 
                                type="file" 
                                id="featured_image" 
                                name="featured_image" 
                                accept="image/*"
                                class="hidden"
                                onchange="previewImage(this)"
                            >
                            <label for="featured_image" class="flex flex-col items-center justify-center w-full h-48 border-2 border-dashed border-zinc-300 dark:border-zinc-600 rounded-lg cursor-pointer bg-zinc-50 dark:bg-zinc-800 hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors duration-200">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                    </svg>
                                    <p class="mb-2 text-sm text-zinc-500 dark:text-zinc-400">
                                        <span class="font-semibold">Click to upload</span> or drag and drop
                                    </p>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">PNG, JPG, GIF, WEBP (MAX. 2MB)</p>
                                </div>
                            </label>
                        </div>
                        
                        <!-- Image Preview -->
                        <div id="image-preview" class="hidden">
                            <div class="relative inline-block">
                                <img id="preview-img" src="" alt="Preview" class="max-w-full h-48 object-cover rounded-lg border border-zinc-200 dark:border-zinc-700">
                                <button type="button" onclick="removeImage()" class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        
                        <div class="text-xs text-zinc-500 dark:text-zinc-400">
                            💡 <strong>Tip:</strong> A featured image helps your post stand out in the feed and improves engagement
                        </div>
                    </div>
                    
                    @error('featured_image')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <!-- Content Section -->
            <div class="bg-gradient-to-br from-white via-blue-50/30 to-indigo-50/20 rounded-2xl dark:from-slate-900 dark:via-blue-900/20 dark:to-indigo-900/20 border border-zinc-200 dark:border-zinc-800 p-8 transition-all duration-300 shadow-xl hover:shadow-2xl">
                <div class="relative">
                    <div class="flex items-center justify-between mb-4">
                        <label for="content" class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300">
                            <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Content
                        </label>
                        <div class="flex items-center space-x-2">
                            <button type="button" class="p-2 rounded-lg text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors" title="Bold">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 4h8a4 4 0 014 4 4 4 0 01-4 4H6z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 12h9a4 4 0 014 4 4 4 0 01-4 4H6z"></path>
                                </svg>
                            </button>
                            <button type="button" class="p-2 rounded-lg text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors" title="Italic">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 4h4M8 20h4M12 4l-2 16"></path>
                                </svg>
                            </button>
                            <button type="button" class="p-2 rounded-lg text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors" title="Link">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <textarea 
                        id="content" 
                        name="content" 
                        rows="20"
                        class="w-full bg-transparent border-none focus:outline-none text-zinc-700 dark:text-zinc-300 placeholder-zinc-400 dark:placeholder-zinc-500 resize-none leading-relaxed" 
                        placeholder="Start writing your post content here..."
                        required
                    >{{ old('content') }}</textarea>
                    @error('content')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <!-- Categories & Tags Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Categories -->
                <div class="bg-gradient-to-br from-white via-blue-50/30 to-indigo-50/20 rounded-2xl dark:from-slate-900 dark:via-blue-900/20 dark:to-indigo-900/20 border border-zinc-200 dark:border-zinc-800 p-8 transition-all duration-300 shadow-xl hover:shadow-2xl">
                    <div class="relative">
                        <label class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-4">
                            <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            Categories
                        </label>
                        <div class="grid grid-cols-2 gap-2">
                            @foreach($categories as $category)
                                <label class="flex items-center p-2 rounded-md bg-zinc-50 dark:bg-zinc-800 hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-all duration-200 cursor-pointer">
                                    <input 
                                        type="checkbox" 
                                        name="categories[]" 
                                        value="{{ $category->id }}"
                                        {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}
                                        class="rounded border-zinc-300 text-zinc-600 focus:ring-zinc-500 dark:border-zinc-600 dark:bg-zinc-700"
                                    >
                                    <span class="ml-3 text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ $category->name }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('categories')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Tags -->
                <div class="bg-gradient-to-br from-white via-blue-50/30 to-indigo-50/20 rounded-2xl dark:from-slate-900 dark:via-blue-900/20 dark:to-indigo-900/20 border border-zinc-200 dark:border-zinc-800 p-8 transition-all duration-300 shadow-xl hover:shadow-2xl">
                    <div class="relative">
                        <label for="tags" class="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-4">
                            <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            Tags
                        </label>
                        <input 
                            type="text" 
                            id="tags" 
                            name="tags" 
                            value="{{ old('tags') }}"
                            class="w-full bg-transparent border-none focus:outline-none text-zinc-700 dark:text-zinc-300 placeholder-zinc-400 dark:placeholder-zinc-500 text-lg" 
                            placeholder="laravel, php, web-development"
                        >
                        <div class="mt-3 p-3 rounded-xl bg-zinc-50 dark:bg-zinc-800">
                            <p class="text-xs text-zinc-600 dark:text-zinc-400 mb-2">💡 <strong>Tip:</strong> Use relevant tags to help readers find your post</p>
                            <div class="flex flex-wrap gap-2" id="tag-preview">
                                <!-- Tags will be dynamically added here -->
                            </div>
                        </div>
                        @error('tags')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Status & Actions -->
            <div class="bg-gradient-to-br from-white via-blue-50/30 to-indigo-50/20 rounded-2xl dark:from-slate-900 dark:via-blue-900/20 dark:to-indigo-900/20 border border-zinc-200 dark:border-zinc-800 p-8 transition-all duration-300 shadow-xl hover:shadow-2xl">
                <div class="relative space-y-6">
                    <!-- Featured Toggle -->
                    <div class="flex items-start space-x-3">
                        <input 
                            type="checkbox" 
                            id="is_featured"
                            name="is_featured" 
                            value="1"
                            {{ old('is_featured') ? 'checked' : '' }}
                            class="mt-1 rounded border-zinc-300 text-zinc-600 focus:ring-zinc-500 dark:border-zinc-600 dark:bg-zinc-700"
                        >
                        <label for="is_featured" class="flex-1">
                            <div class="text-sm font-semibold text-zinc-700 dark:text-zinc-300 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                                Featured Post
                            </div>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">Mark this post as featured to highlight it on the homepage</p>
                        </label>
                    </div>

                    <!-- Status & Buttons -->
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
                        <div class="flex items-center space-x-4">
                            <label for="status" class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">
                                <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Publication Status
                            </label>
                            <select 
                                id="status" 
                                name="status"
                                class="rounded-lg border border-zinc-300 px-4 py-2 text-sm focus:border-zinc-500 focus:outline-none dark:border-zinc-600 dark:bg-zinc-700 dark:text-white"
                            >
                                <option value="draft" {{ old('status', 'draft') === 'draft' ? 'selected' : '' }}>📝 Draft</option>
                                <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>🚀 Published</option>
                            </select>
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('dashboard', ['username' => auth()->user()->username]) }}" class="px-6 py-3 border border-blue-300 text-base font-medium rounded-md text-blue-700 bg-white hover:bg-blue-50 dark:border-blue-600 dark:text-blue-300 dark:bg-slate-800 dark:hover:bg-blue-900/20 transition-all duration-200 shadow-lg hover:shadow-xl">
                                Cancel
                            </a>
                            <button 
                                type="submit" 
                                name="status" 
                                value="draft"
                                class="px-6 py-3 border border-blue-300 text-base font-medium rounded-md text-blue-700 bg-white hover:bg-blue-50 dark:border-blue-600 dark:text-blue-300 dark:bg-slate-800 dark:hover:bg-blue-900/20 transition-all duration-200 shadow-lg hover:shadow-xl"
                            >
                                💾 Save as Draft
                            </button>
                            <button 
                                type="submit" 
                                name="status" 
                                value="published"
                                class="px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition-all duration-200 shadow-lg hover:shadow-xl"
                            >
                                🚀 Publish Post
                            </button>
                        </div>
                    </div>
                    @error('status')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
        </form>
    </div>
</div>

<!-- TinyMCE CDN -->
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const titleInput = document.getElementById('title');
    const contentInput = document.getElementById('content');
    const excerptInput = document.getElementById('excerpt');
    const tagsInput = document.getElementById('tags');
    const wordCountElement = document.getElementById('word-count');
    const excerptCountElement = document.getElementById('excerpt-count');
    const tagPreviewElement = document.getElementById('tag-preview');

    // Word count functionality
    function updateWordCount() {
        const content = contentInput.value;
        const words = content.trim().split(/\s+/).filter(word => word.length > 0);
        wordCountElement.textContent = words.length;
    }

    // Excerpt count functionality
    function updateExcerptCount() {
        const excerpt = excerptInput.value;
        const count = excerpt.length;
        excerptCountElement.textContent = `${count}/500`;
        
        if (count > 500) {
            excerptCountElement.classList.add('text-red-500');
        } else {
            excerptCountElement.classList.remove('text-red-500');
        }
    }

    // Tag preview functionality
    function updateTagPreview() {
        const tags = tagsInput.value.split(',').map(tag => tag.trim()).filter(tag => tag.length > 0);
        tagPreviewElement.innerHTML = '';
        
        tags.forEach(tag => {
            const tagElement = document.createElement('span');
            tagElement.className = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-zinc-100 text-zinc-800 dark:bg-zinc-800 dark:text-zinc-300';
            tagElement.textContent = `#${tag}`;
            tagPreviewElement.appendChild(tagElement);
        });
    }

    // Auto-save functionality (simulated)
    function autoSave() {
        const formData = new FormData(document.getElementById('post-form'));
        // In a real implementation, you would send this to a save endpoint
        console.log('Auto-saving...', Object.fromEntries(formData));
    }

    // Event listeners
    titleInput.addEventListener('input', updateWordCount);
    contentInput.addEventListener('input', updateWordCount);
    excerptInput.addEventListener('input', updateExcerptCount);
    tagsInput.addEventListener('input', updateTagPreview);

    // Auto-save every 30 seconds
    setInterval(autoSave, 30000);

    // Initial updates
    updateWordCount();
    updateExcerptCount();
    updateTagPreview();

    // Initialize TinyMCE
    tinymce.init({
        selector: '#content',
        height: 500,
        menubar: false,
        plugins: [
            'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
            'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
            'insertdatetime', 'media', 'table', 'help', 'wordcount', 'emoticons',
            'paste', 'textpattern', 'nonbreaking', 'pagebreak', 'save', 'template'
        ],
        toolbar: 'undo redo | blocks | ' +
            'bold italic underline strikethrough | forecolor backcolor | ' +
            'alignleft aligncenter alignright alignjustify | ' +
            'bullist numlist outdent indent | removeformat | ' +
            'image link table | code preview | help',
        content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif; font-size: 14px; line-height: 1.6; }',
        paste_data_images: true,
        image_advtab: true,
        image_description: true,
        image_title: true,
        image_caption: true,
        image_uploadtab: true,
        automatic_uploads: true,
        file_picker_types: 'image',
        images_upload_base_path: '{{ asset("storage/post-images") }}',
        convert_urls: false,
        relative_urls: false,
        branding: false,
        promotion: false,
        statusbar: true,
        resize: true,
        elementpath: true,
        setup: function (editor) {
            editor.on('change', function () {
                editor.save();
                updateWordCount();
            });
            
            editor.on('init', function () {
                updateWordCount();
            });
        },
        images_upload_handler: function (blobInfo, success, failure) {
            const formData = new FormData();
            formData.append('image', blobInfo.blob(), blobInfo.filename());
            
            fetch('{{ route("posts.upload-image") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    success(result.url);
                } else {
                    failure('Upload failed: ' + result.message);
                }
            })
            .catch(error => {
                failure('Upload failed: ' + error.message);
            });
        },
        automatic_uploads: true,
        file_picker_types: 'image',
        file_picker_callback: function (callback, value, meta) {
            if (meta.filetype === 'image') {
                const input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');
                
                input.onchange = function () {
                    const file = this.files[0];
                    const formData = new FormData();
                    formData.append('image', file);
                    
                    fetch('{{ route("posts.upload-image") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(result => {
                        if (result.success) {
                            callback(result.url, { alt: file.name });
                        }
                    });
                };
                
                input.click();
            }
        }
    });
});

// Image preview functionality
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            const previewImg = document.getElementById('preview-img');
            const imagePreview = document.getElementById('image-preview');
            const uploadArea = input.parentElement;
            
            previewImg.src = e.target.result;
            imagePreview.classList.remove('hidden');
            uploadArea.classList.add('hidden');
        };
        
        reader.readAsDataURL(input.files[0]);
    }
}

function removeImage() {
    const input = document.getElementById('featured_image');
    const previewImg = document.getElementById('preview-img');
    const imagePreview = document.getElementById('image-preview');
    const uploadArea = input.parentElement;
    
    input.value = '';
    previewImg.src = '';
    imagePreview.classList.add('hidden');
    uploadArea.classList.remove('hidden');
}
</script>
</x-layouts.homepage>
