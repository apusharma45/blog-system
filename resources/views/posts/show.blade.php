<x-layouts.homepage :title="$post->title">

    <!-- Reading Progress Bar -->
<div id="reading-progress" class="fixed top-0 left-0 h-1 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 z-50 transition-all duration-150" style="width: 0%"></div>

<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/30 to-indigo-50/20 dark:from-slate-950 dark:via-blue-950/30 dark:to-indigo-950/20">
    <div class="max-w-4xl mx-auto px-4 py-8">
        <!-- Breadcrumb Navigation -->
        <nav class="mb-6" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2 text-sm text-zinc-600 dark:text-zinc-400">
                <li>
                    <a href="{{ route('home') }}" class="hover:text-zinc-900 dark:hover:text-white transition-colors">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                    </svg>
                    </a>
                </li>
                <li>
                    <span class="text-zinc-400 dark:text-zinc-600">/</span>
                </li>
                <li>
                    <a href="{{ route('posts.index') }}" class="hover:text-zinc-900 dark:hover:text-white transition-colors">
                        Posts
                    </a>
                </li>
                <li>
                    <span class="text-zinc-400 dark:text-zinc-600">/</span>
                </li>
                <li>
                    <a href="{{ route('users.profile', $post->user->username) }}" class="hover:text-zinc-900 dark:hover:text-white transition-colors">
                        {{ $post->user->name }}
                    </a>
                </li>
                <li>
                    <span class="text-zinc-400 dark:text-zinc-600">/</span>
                </li>
                <li class="text-zinc-900 dark:text-white font-medium truncate max-w-xs">
                    {{ $post->title }}
                </li>
            </ol>
        </nav>

        <article class="bg-gradient-to-br from-white via-blue-50/30 to-indigo-50/20 dark:from-slate-900 dark:via-blue-900/20 dark:to-indigo-900/20 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-xl overflow-hidden">

            <div class="p-6 sm:p-8">
            <!-- Post Header -->
            <header class="mb-6">
                    <h1 class="font-bold text-zinc-900 dark:text-white mb-4 leading-tight" style="font-size:42px;">
                        {{ $post->title }}
                    </h1>
                    
                    @if($post->excerpt)
                <div class="text-lg text-zinc-600 dark:text-zinc-400 mb-6 leading-relaxed">
                            {{ $post->excerpt }}
                        </div>
                    @endif
                
                
                    
                        
            </header>

            <!-- Post Content -->
            <div class="prose dark:prose-invert max-w-none rich-content" style="font-size:18px; line-height:1.8; text-align: justify; text-justify: inter-word;">
                @if($post->featured_image)
                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="featured-image">
                @endif
                {!! $post->content !!}
            </div>

            <!-- Author row moved below content -->
            <div class="flex items-center space-x-2 mt-6 text-sm text-zinc-600 dark:text-zinc-400">
                <a href="{{ route('users.profile', $post->user->username) }}" class="hover:opacity-80 transition-opacity">
                    @if($post->user->avatar)
                    <img src="{{ asset('storage/' . $post->user->avatar) }}" 
                         alt="{{ $post->user->name }}"
                         class="w-7 h-7 rounded-full object-cover border border-zinc-200 dark:border-zinc-700">
                    @else
                    <div class="w-7 h-7 rounded-full bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-600 flex items-center justify-center text-white text-xs font-semibold border border-zinc-200 dark:border-zinc-700">
                        {{ substr($post->user->name, 0, 1) }}
                    </div>
                    @endif
                </a>
                <div>
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('users.profile', $post->user->username) }}" class="font-medium text-zinc-800 dark:text-zinc-100 text-sm hover:text-blue-600 dark:hover:text-blue-400 transition-colors">{{ $post->user->name }}</a>
                        <span class="text-zinc-400">•</span>
                        <span class="text-xs">{{ $post->published_at ? $post->published_at->format('M d, Y') : $post->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Categories and Tags after content -->
            <div class="mt-6">
                @if($post->categories->count() > 0)
                <div class="flex flex-wrap gap-1.5 mt-2">
                    @foreach($post->categories as $category)
                    <a href="{{ route('posts.index') }}?category={{ $category->slug }}" 
                       class="px-2 py-1 bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 rounded-md text-xs font-medium hover:bg-zinc-200 dark:hover:bg-zinc-700 transition-colors border border-zinc-200 dark:border-zinc-700">
                        {{ $category->name }}
                    </a>
                    @endforeach
                </div>
                @endif

                @if($post->tags->count() > 0)
                <div class="flex flex-wrap gap-1.5 mt-2">
                    @foreach($post->tags as $tag)
                    <a href="{{ route('posts.index') }}?tag={{ $tag->slug }}" 
                       class="px-2 py-0.5 bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 rounded-full text-xs hover:bg-zinc-200 dark:hover:bg-zinc-700 transition-colors border border-zinc-200 dark:border-zinc-700">
                        #{{ $tag->name }}
                    </a>
                    @endforeach
                </div>
                @endif
            </div>

            <!-- Post Actions -->
            <div class="mt-8 pt-6 border-t border-zinc-200 dark:border-zinc-800">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-6">
                        <!-- Like Button -->
                        @auth
                        <button onclick="toggleLike()" id="like-button" class="flex items-center space-x-2 transition-colors" data-liked="{{ $post->is_liked ? 'true' : 'false' }}">
                            <svg id="like-icon" class="w-6 h-6 {{ $post->is_liked ? 'fill-current text-red-600 dark:text-red-400' : 'text-zinc-600 dark:text-zinc-400' }}" viewBox="0 0 24 24" fill="{{ $post->is_liked ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                            <span id="like-count" class="font-medium text-zinc-900 dark:text-white">{{ $post->likes_count ?? 0 }}</span>
                            </button>
                        @else
                        <div class="flex items-center space-x-2 text-zinc-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                        </svg>
                                            <span class="font-medium">{{ $post->likes_count ?? 0 }}</span>
                                            </div>
                        @endauth

                        <!-- Views -->
                        <div class="flex items-center space-x-2 text-zinc-600 dark:text-zinc-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                <span class="font-medium">{{ $post->view_count ?? 0 }} views</span>
                            </div>
                    </div>
                    
                        <div class="flex items-center space-x-3">
                            <!-- Favorite Button -->
                            @auth
                        <button onclick="toggleFavorite()" id="favorite-button" class="p-2 text-yellow-500 hover:text-yellow-600 dark:text-yellow-400 dark:hover:text-yellow-300 rounded-lg hover:bg-yellow-50 dark:hover:bg-yellow-900/20 transition-colors" title="Add to favorites" data-favorited="{{ auth()->user()->hasFavorited($post) ? 'true' : 'false' }}">
                            <svg id="favorite-icon" class="w-6 h-6 {{ auth()->user()->hasFavorited($post) ? 'fill-current text-yellow-500 dark:text-yellow-400' : 'text-zinc-400 dark:text-zinc-500' }}" viewBox="0 0 24 24" fill="{{ auth()->user()->hasFavorited($post) ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"/>
                                            </svg>
                                        </button>
                            @endauth

                        <!-- Share Button -->
                        <button onclick="sharePost()" class="p-2 text-zinc-500 hover:text-zinc-600 dark:text-zinc-400 dark:hover:text-zinc-300 rounded-lg hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors" title="Share">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"/>
                            </svg>
                        </button>
                        </div>
                    </div>
                </div>
            </div>
        </article>

        <!-- Comments Section -->
        <div class="bg-gradient-to-br from-white via-blue-50/30 to-indigo-50/20 dark:from-slate-900 dark:via-blue-900/20 dark:to-indigo-900/20 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-xl p-6 sm:p-8 mt-8">
            <h2 class="text-xl sm:text-2xl font-semibold bg-gradient-to-r from-blue-900 via-indigo-800 to-purple-800 dark:from-blue-200 dark:via-indigo-200 dark:to-purple-200 bg-clip-text text-transparent mb-6">
                Comments ({{ $post->comments_count ?? 0 }})
            </h2>

            <!-- Comment Form -->
            @auth
            <div class="mb-8">
                <form id="comment-form" onsubmit="submitComment(event)" class="space-y-4">
                    <div>
                            <textarea 
                            id="comment-content"
                                name="content" 
                                    rows="4" 
                            class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-lg focus:ring-2 focus:ring-zinc-500 focus:border-transparent dark:bg-zinc-800 dark:text-white resize-none" 
                            placeholder="Write your comment..."
                                required
                            ></textarea>
                        <p id="comment-error" class="mt-2 text-sm text-red-600 dark:text-red-400 hidden"></p>
                    </div>
                    <div class="flex justify-end">
                        <button 
                            type="submit" 
                            id="comment-submit-btn"
                            class="px-6 py-2 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 hover:from-blue-700 hover:via-indigo-700 hover:to-purple-700 text-white font-medium rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                                        Post Comment
                                    </button>
                                </div>
                </form>
                        </div>
                @else
            <div class="mb-8 p-4 bg-gradient-to-r from-blue-50 via-indigo-50 to-purple-50 dark:from-blue-900/20 dark:via-indigo-900/20 dark:to-purple-900/20 rounded-lg text-center border border-zinc-200 dark:border-zinc-700">
                <p class="text-zinc-600 dark:text-zinc-400">
                    <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 font-medium">Log in</a> to leave a comment
                </p>
                </div>
            @endauth

            <!-- Comments List -->
            <div class="space-y-6">
                @forelse($post->comments->whereNull('parent_id')->sortByDesc('created_at') as $comment)
                <div id="comment-{{ $comment->id }}" class="border-b border-zinc-200 dark:border-zinc-800 pb-6 last:border-b-0">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            @if($comment->user->avatar)
                            <img src="{{ asset('storage/' . $comment->user->avatar) }}" 
                                 alt="{{ $comment->user->name }}"
                                 class="w-10 h-10 rounded-full object-cover border border-zinc-200 dark:border-zinc-700">
                            @else
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-600 flex items-center justify-center text-white text-sm font-semibold border border-zinc-200 dark:border-zinc-700">
                                {{ substr($comment->user->name, 0, 1) }}
                            </div>
                            @endif
                            </div>
                            <div class="flex-1">
                            <div class="flex items-center space-x-2 mb-2">
                                <span class="font-medium text-zinc-900 dark:text-white">
                                    {{ $comment->user->name }}
                                </span>
                                <span class="text-sm text-zinc-600 dark:text-zinc-400">
                                    {{ $comment->created_at->diffForHumans() }}
                                </span>
                                </div>
                            <p id="comment-content-{{ $comment->id }}" class="text-zinc-700 dark:text-zinc-300 mb-3">
                                {{ $comment->content }}
                            </p>
                            <div id="comment-edit-{{ $comment->id }}" class="hidden mb-3"></div>
                            <div class="flex items-center space-x-4">
                                @auth
                                <button 
                                    onclick="toggleReplyForm({{ $comment->id }})" 
                                    class="text-sm text-zinc-600 hover:text-zinc-700 dark:text-zinc-400 font-medium"
                                >
                                        Reply
                                    </button>
                                @endauth
                                
                                @can('update', $comment)
                                <button 
                                    onclick="editComment({{ $comment->id }}, false)"
                                    class="text-sm text-zinc-600 hover:text-zinc-700 dark:text-zinc-400 font-medium"
                                >
                                    Edit
                                </button>
                                @endcan
                                
                                @can('delete', $comment)
                                <button 
                                    onclick="deleteComment({{ $comment->id }}, false)"
                                    class="text-sm text-red-600 hover:text-red-700 dark:text-red-400 font-medium"
                                >
                                    Delete
                                </button>
                                @endcan
                        </div>

                            <!-- Reply Form -->
                        @auth
                            <div id="reply-form-{{ $comment->id }}" class="hidden mt-4">
                                <form onsubmit="submitReply(event, {{ $comment->id }})" class="space-y-3">
                                            <textarea 
                                        id="reply-content-{{ $comment->id }}"
                                                name="content" 
                                                    rows="3" 
                                        class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg focus:ring-2 focus:ring-zinc-500 focus:border-transparent dark:bg-zinc-800 dark:text-white resize-none" 
                                        placeholder="Write your reply..."
                                                required
                                            ></textarea>
                                    <p id="reply-error-{{ $comment->id }}" class="text-sm text-red-600 dark:text-red-400 hidden"></p>
                                    <div class="flex justify-end space-x-2">
                                        <button 
                                            type="button" 
                                            onclick="toggleReplyForm({{ $comment->id }})" 
                                            class="px-4 py-2 text-zinc-600 hover:text-zinc-700 dark:text-zinc-400 font-medium"
                                        >
                                            Cancel
                                        </button>
                                        <button 
                                            type="submit" 
                                            id="reply-submit-{{ $comment->id }}"
                                            class="px-4 py-2 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 hover:from-blue-700 hover:via-indigo-700 hover:to-purple-700 text-white font-medium rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed"
                                        >
                                                        Reply
                                                    </button>
                                    </div>
                                </form>
                            </div>
                        @endauth

                        <!-- Replies -->
                        <div id="replies-{{ $comment->id }}" class="mt-4 ml-6 space-y-4">
                        @if($comment->replies->count() > 0)
                                @foreach($comment->replies as $reply)
                                <div id="comment-{{ $reply->id }}" class="flex items-start space-x-3">
                                    <div class="flex-shrink-0">
                                        @if($reply->user->avatar)
                                        <img src="{{ asset('storage/' . $reply->user->avatar) }}" 
                                             alt="{{ $reply->user->name }}"
                                             class="w-8 h-8 rounded-full object-cover border border-zinc-200 dark:border-zinc-700">
                                        @else
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-600 flex items-center justify-center text-white text-sm font-semibold border border-zinc-200 dark:border-zinc-700">
                                            {{ substr($reply->user->name, 0, 1) }}
                                        </div>
                                        @endif
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center space-x-2 mb-1">
                                            <span class="font-medium text-zinc-900 dark:text-white text-sm">
                                                {{ $reply->user->name }}
                                            </span>
                                            <span class="text-xs text-zinc-600 dark:text-zinc-400">
                                                {{ $reply->created_at->diffForHumans() }}
                                            </span>
                                                </div>
                                        <p id="comment-content-{{ $reply->id }}" class="text-zinc-700 dark:text-zinc-300 text-sm mb-2">
                                            {{ $reply->content }}
                                        </p>
                                        <div id="comment-edit-{{ $reply->id }}" class="hidden mb-2"></div>
                                        <div class="flex items-center space-x-3">
                                            @can('update', $reply)
                                            <button 
                                                onclick="editComment({{ $reply->id }}, true)"
                                                class="text-xs text-zinc-600 hover:text-zinc-700 dark:text-zinc-400 font-medium"
                                            >
                                                Edit
                                            </button>
                                            @endcan
                                            @can('delete', $reply)
                                            <button 
                                                onclick="deleteComment({{ $reply->id }}, true)"
                                                class="text-xs text-red-600 hover:text-red-700 dark:text-red-400 font-medium"
                                            >
                                                Delete
                                            </button>
                                            @endcan
                                                </div>
                                        </div>
                                    </div>
                                @endforeach
                        @endif
                        </div>
                        </div>
                    </div>
                    </div>
                @empty
                <div class="text-center py-8">
                    <p class="text-gray-500 dark:text-gray-400">No comments yet. Be the first to comment!</p>
                        </div>
                @endforelse
            </div>
        </div>

        <!-- Related Posts -->
        @if(isset($relatedPosts) && $relatedPosts->count() > 0)
        <div class="bg-gradient-to-br from-white via-blue-50/30 to-indigo-50/20 dark:from-slate-900 dark:via-blue-900/20 dark:to-indigo-900/20 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-xl p-6 sm:p-8 mt-8">
            <h2 class="text-xl sm:text-2xl font-semibold bg-gradient-to-r from-blue-900 via-indigo-800 to-purple-800 dark:from-blue-200 dark:via-indigo-200 dark:to-purple-200 bg-clip-text text-transparent mb-6">
                Related Posts
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($relatedPosts as $relatedPost)
                <a href="{{ route('posts.show', ['username' => $relatedPost->user->username, 'slug' => $relatedPost->slug]) }}" 
                   class="group block bg-zinc-50 dark:bg-zinc-800/50 rounded-lg border border-zinc-200 dark:border-zinc-700 overflow-hidden hover:shadow-md transition-shadow">
                    @if($relatedPost->featured_image)
                    <div class="aspect-video bg-zinc-200 dark:bg-zinc-600 overflow-hidden">
                        <img src="{{ asset('storage/' . $relatedPost->featured_image) }}" 
                             alt="{{ $relatedPost->title }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    </div>
                    @else
                    <div class="aspect-video bg-gradient-to-br from-zinc-500 to-zinc-600 flex items-center justify-center">
                        <svg class="w-16 h-16 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    @endif
                    <div class="p-4">
                        <h3 class="font-semibold text-zinc-900 dark:text-white group-hover:text-zinc-600 dark:group-hover:text-zinc-400 line-clamp-2 mb-2">
                            {{ $relatedPost->title }}
                        </h3>
                        @if($relatedPost->excerpt)
                        <p class="text-sm text-zinc-600 dark:text-zinc-400 line-clamp-2 mb-3">
                            {{ $relatedPost->excerpt }}
                        </p>
                        @endif
                        <div class="flex items-center justify-between text-xs text-zinc-600 dark:text-zinc-400">
                            <span>{{ $relatedPost->user->name }}</span>
                            <span>{{ $relatedPost->published_at ? $relatedPost->published_at->format('M d, Y') : $relatedPost->created_at->format('M d, Y') }}</span>
                            </div>
                        @if($relatedPost->tags->count() > 0)
                        <div class="flex flex-wrap gap-1 mt-3">
                            @foreach($relatedPost->tags->take(3) as $tag)
                            <span class="px-2 py-1 bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 rounded text-xs border border-zinc-200 dark:border-zinc-700">
                                #{{ $tag->name }}
                            </span>
                            @endforeach
                        </div>
                        @endif
                </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

        <script>
function sharePost() {
    const url = window.location.href;
    copyToClipboard(url);
}

function copyToClipboard(text) {
    // Try modern clipboard API first
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(text).then(() => {
            showNotification('Copied!', 'success');
        }).catch((error) => {
            console.error('Clipboard API failed:', error);
            // Fallback to legacy method
            fallbackCopyToClipboard(text);
        });
    } else {
        // Fallback for older browsers or non-secure contexts
        fallbackCopyToClipboard(text);
    }
}

function fallbackCopyToClipboard(text) {
    const textArea = document.createElement('textarea');
    textArea.value = text;
    textArea.style.position = 'fixed';
    textArea.style.left = '-999999px';
    textArea.style.top = '-999999px';
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();
    
    try {
        const successful = document.execCommand('copy');
        if (successful) {
            showNotification('Copied!', 'success');
    } else {
            showNotification('Failed to copy link', 'error');
        }
    } catch (error) {
        console.error('Fallback copy failed:', error);
        showNotification('Failed to copy link', 'error');
    } finally {
        document.body.removeChild(textArea);
    }
}

function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg transition-all duration-300 transform translate-x-full ${
        type === 'success' ? 'bg-green-500 text-white' : 
        type === 'error' ? 'bg-red-500 text-white' : 
        'bg-blue-500 text-white'
    }`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);
    
    // Remove after 3 seconds
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            if (document.body.contains(notification)) {
                document.body.removeChild(notification);
            }
        }, 300);
    }, 3000);
}

            function toggleReplyForm(commentId) {
                const form = document.getElementById('reply-form-' + commentId);
                if (form.classList.contains('hidden')) {
                    form.classList.remove('hidden');
                } else {
                    form.classList.add('hidden');
                }
            }

// Reading Progress Bar
window.addEventListener('scroll', function() {
    const progressBar = document.getElementById('reading-progress');
    const windowHeight = window.innerHeight;
    const documentHeight = document.documentElement.scrollHeight - windowHeight;
    const scrolled = window.scrollY;
    const progress = (scrolled / documentHeight) * 100;
    
    progressBar.style.width = Math.min(progress, 100) + '%';
});

// AJAX Like Toggle
function toggleLike() {
    const button = document.getElementById('like-button');
    const icon = document.getElementById('like-icon');
    const countSpan = document.getElementById('like-count');
    const isLiked = button.dataset.liked === 'true';
    const postId = {{ $post->id }};
    
    // Optimistic UI update
    const currentCount = parseInt(countSpan.textContent);
    
    if (isLiked) {
        // Unlike
        icon.classList.remove('fill-current', 'text-red-600', 'dark:text-red-400');
        icon.classList.add('text-zinc-600', 'dark:text-zinc-400');
        icon.setAttribute('fill', 'none');
        countSpan.textContent = currentCount - 1;
        button.dataset.liked = 'false';
    } else {
        // Like
        icon.classList.remove('text-zinc-600', 'dark:text-zinc-400');
        icon.classList.add('fill-current', 'text-red-600', 'dark:text-red-400');
        icon.setAttribute('fill', 'currentColor');
        countSpan.textContent = currentCount + 1;
        button.dataset.liked = 'true';
    }
    
    // Send AJAX request
    const url = isLiked ? `/posts/${postId}/like` : `/posts/${postId}/like`;
    const method = isLiked ? 'DELETE' : 'POST';
    
    fetch(url, {
        method: method,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        // Update with actual count from server
        if (data.success && data.likes_count !== undefined) {
            countSpan.textContent = data.likes_count;
            // Ensure button state matches the action taken
            button.dataset.liked = isLiked ? 'false' : 'true';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        // Revert UI on error
        if (!isLiked) {
            icon.classList.remove('fill-current', 'text-red-600', 'dark:text-red-400');
            icon.classList.add('text-zinc-600', 'dark:text-zinc-400');
            icon.setAttribute('fill', 'none');
            countSpan.textContent = currentCount;
            button.dataset.liked = 'false';
        } else {
            icon.classList.remove('text-zinc-600', 'dark:text-zinc-400');
            icon.classList.add('fill-current', 'text-red-600', 'dark:text-red-400');
            icon.setAttribute('fill', 'currentColor');
            countSpan.textContent = currentCount;
            button.dataset.liked = 'true';
        }
    });
}

// AJAX Favorite Toggle
function toggleFavorite() {
    const button = document.getElementById('favorite-button');
    const icon = document.getElementById('favorite-icon');
    const isFavorited = button.dataset.favorited === 'true';
    const postId = {{ $post->id }};
    
    // Optimistic UI update
    if (isFavorited) {
        // Unfavorite
        icon.classList.remove('fill-current', 'text-yellow-500', 'dark:text-yellow-400');
        icon.classList.add('text-zinc-400', 'dark:text-zinc-500');
        icon.setAttribute('fill', 'none');
        button.dataset.favorited = 'false';
        button.title = 'Add to favorites';
    } else {
        // Favorite
        icon.classList.remove('text-zinc-400', 'dark:text-zinc-500');
        icon.classList.add('fill-current', 'text-yellow-500', 'dark:text-yellow-400');
        icon.setAttribute('fill', 'currentColor');
        button.dataset.favorited = 'true';
        button.title = 'Remove from favorites';
    }
    
    // Send AJAX request
    const url = `/posts/${postId}/favorite`;
    const method = isFavorited ? 'DELETE' : 'POST';
    
    fetch(url, {
        method: method,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        // Confirm state with server response
        if (data.success) {
            button.dataset.favorited = data.is_favorited ? 'true' : 'false';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        // Revert UI on error
        if (!isFavorited) {
            icon.classList.remove('fill-current', 'text-yellow-500', 'dark:text-yellow-400');
            icon.classList.add('text-zinc-400', 'dark:text-zinc-500');
            icon.setAttribute('fill', 'none');
            button.dataset.favorited = 'false';
            button.title = 'Add to favorites';
        } else {
            icon.classList.remove('text-zinc-400', 'dark:text-zinc-500');
            icon.classList.add('fill-current', 'text-yellow-500', 'dark:text-yellow-400');
            icon.setAttribute('fill', 'currentColor');
            button.dataset.favorited = 'true';
            button.title = 'Remove from favorites';
        }
    });
}

// AJAX Comment Submission
function submitComment(event) {
    event.preventDefault();
    
    const form = document.getElementById('comment-form');
    const content = document.getElementById('comment-content');
    const submitBtn = document.getElementById('comment-submit-btn');
    const errorEl = document.getElementById('comment-error');
    const postId = {{ $post->id }};
    
    // Disable button and hide errors
    submitBtn.disabled = true;
    submitBtn.textContent = 'Posting...';
    errorEl.classList.add('hidden');
    
    fetch('{{ route("comments.store") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
            post_id: postId,
            content: content.value
        })
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => Promise.reject(err));
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Create new comment element
            const commentsList = document.querySelector('.space-y-6');
            const emptyState = commentsList.querySelector('.text-center.py-8');
            
            if (emptyState) {
                emptyState.remove();
            }
            
            const commentHTML = createCommentHTML(data.comment);
            commentsList.insertAdjacentHTML('afterbegin', commentHTML);
            
            // Clear form
            content.value = '';
            
            // Update comment count
            const countEl = document.querySelector('h2');
            const currentCount = parseInt(countEl.textContent.match(/\d+/)[0]);
            countEl.textContent = `Comments (${currentCount + 1})`;
        }
        
        // Re-enable button
        submitBtn.disabled = false;
        submitBtn.textContent = 'Post Comment';
    })
    .catch(error => {
        console.error('Error:', error);
        errorEl.textContent = error.errors?.content?.[0] || 'Failed to post comment. Please try again.';
        errorEl.classList.remove('hidden');
        
        // Re-enable button
        submitBtn.disabled = false;
        submitBtn.textContent = 'Post Comment';
    });
}

function createCommentHTML(comment) {
    const avatarHTML = comment.user.avatar 
        ? `<img src="${comment.user.avatar}" alt="${comment.user.name}" class="w-10 h-10 rounded-full object-cover">`
        : `<div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold">${comment.user.name.charAt(0)}</div>`;
    
    return `
        <div id="comment-${comment.id}" class="border-b border-gray-200 dark:border-gray-700 pb-6">
            <div class="flex items-start space-x-4">
                <div class="flex-shrink-0">
                    ${avatarHTML}
                </div>
                <div class="flex-1">
                    <div class="flex items-center space-x-2 mb-2">
                        <span class="font-semibold text-gray-900 dark:text-white">
                            ${comment.user.name}
                        </span>
                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            ${comment.created_at}
                        </span>
                    </div>
                    <p class="text-gray-700 dark:text-gray-300 mb-3">
                        ${comment.content}
                    </p>
                    <div class="flex items-center space-x-4">
                        <button 
                            onclick="toggleReplyForm(${comment.id})" 
                            class="text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400 font-medium"
                        >
                            Reply
                        </button>
                        <button 
                            onclick="deleteComment(${comment.id}, false)"
                            class="text-sm text-red-600 hover:text-red-700 dark:text-red-400 font-medium"
                        >
                            Delete
                        </button>
                    </div>
                    <div id="reply-form-${comment.id}" class="hidden mt-4">
                        <form onsubmit="submitReply(event, ${comment.id})" class="space-y-3">
                            <textarea 
                                id="reply-content-${comment.id}"
                                name="content" 
                                rows="3" 
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white resize-none" 
                                placeholder="Write your reply..."
                                required
                            ></textarea>
                            <p id="reply-error-${comment.id}" class="text-sm text-red-600 dark:text-red-400 hidden"></p>
                            <div class="flex justify-end space-x-2">
                                <button 
                                    type="button" 
                                    onclick="toggleReplyForm(${comment.id})" 
                                    class="px-4 py-2 text-gray-600 hover:text-gray-700 dark:text-gray-400 font-medium"
                                >
                                    Cancel
                                </button>
                                <button 
                                    type="submit" 
                                    id="reply-submit-${comment.id}"
                                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                                >
                                    Reply
                                </button>
                            </div>
                        </form>
                    </div>
                    <div id="replies-${comment.id}" class="mt-4 ml-6 space-y-4"></div>
                </div>
            </div>
        </div>
    `;
}

// AJAX Reply Submission
function submitReply(event, commentId) {
    event.preventDefault();
    
    const content = document.getElementById(`reply-content-${commentId}`);
    const submitBtn = document.getElementById(`reply-submit-${commentId}`);
    const errorEl = document.getElementById(`reply-error-${commentId}`);
    const postId = {{ $post->id }};
    
    // Disable button and hide errors
    submitBtn.disabled = true;
    submitBtn.textContent = 'Replying...';
    errorEl.classList.add('hidden');
    
    fetch('{{ route("comments.store") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
            post_id: postId,
            parent_id: commentId,
            content: content.value
        })
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => Promise.reject(err));
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Create new reply element
            const repliesContainer = document.getElementById(`replies-${commentId}`);
            const replyHTML = createReplyHTML(data.comment);
            repliesContainer.insertAdjacentHTML('beforeend', replyHTML);
            
            // Clear form and hide it
            content.value = '';
            toggleReplyForm(commentId);
            
            // Update comment count
            const countEl = document.querySelector('h2');
            const currentCount = parseInt(countEl.textContent.match(/\d+/)[0]);
            countEl.textContent = `Comments (${currentCount + 1})`;
        }
        
        // Re-enable button
        submitBtn.disabled = false;
        submitBtn.textContent = 'Reply';
    })
    .catch(error => {
        console.error('Error:', error);
        errorEl.textContent = error.errors?.content?.[0] || 'Failed to post reply. Please try again.';
        errorEl.classList.remove('hidden');
        
        // Re-enable button
        submitBtn.disabled = false;
        submitBtn.textContent = 'Reply';
    });
}

function createReplyHTML(reply) {
    const avatarHTML = reply.user.avatar 
        ? `<img src="${reply.user.avatar}" alt="${reply.user.name}" class="w-8 h-8 rounded-full object-cover">`
        : `<div class="w-8 h-8 rounded-full bg-gray-500 flex items-center justify-center text-white text-sm font-semibold">${reply.user.name.charAt(0)}</div>`;
    
    return `
        <div id="comment-${reply.id}" class="flex items-start space-x-3">
            <div class="flex-shrink-0">
                ${avatarHTML}
            </div>
            <div class="flex-1">
                <div class="flex items-center space-x-2 mb-1">
                    <span class="font-semibold text-gray-900 dark:text-white text-sm">
                        ${reply.user.name}
                    </span>
                    <span class="text-xs text-gray-500 dark:text-gray-400">
                        ${reply.created_at}
                    </span>
                </div>
                <p class="text-gray-700 dark:text-gray-300 text-sm mb-2">
                    ${reply.content}
                </p>
                <button 
                    onclick="deleteComment(${reply.id}, true)"
                    class="text-xs text-red-600 hover:text-red-700 dark:text-red-400 font-medium"
                >
                    Delete
                </button>
            </div>
        </div>
    `;
}

// AJAX Delete Comment/Reply
function deleteComment(commentId, isReply) {
    if (!confirm(isReply ? 'Are you sure you want to delete this reply?' : 'Are you sure you want to delete this comment?')) {
        return;
    }
    
    const url = `{{ url('/') }}/comments/${commentId}`;
    
    fetch(url, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        if (!response.ok) {
            return response.text().then(text => {
                console.error('Server response:', text);
                throw new Error(`Failed to delete comment: ${response.status} ${response.statusText}`);
            });
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Remove the comment element from DOM
            const commentElement = document.getElementById(`comment-${commentId}`);
            let deletedCount = 1; // At least the comment itself
            
            if (commentElement) {
                // If it's a top-level comment, count its replies too
                if (!isReply) {
                    const repliesContainer = commentElement.querySelector(`#replies-${commentId}`);
                    if (repliesContainer) {
                        const replyElements = repliesContainer.querySelectorAll('[id^="comment-"]');
                        deletedCount += replyElements.length;
                    }
                }
                commentElement.remove();
            }
            
            // Update comment count (subtract comment + all its replies)
            const countEl = document.querySelector('h2');
            const currentCount = parseInt(countEl.textContent.match(/\d+/)[0]);
            countEl.textContent = `Comments (${Math.max(0, currentCount - deletedCount)})`;
            
            // Check if comments list is empty
            const commentsList = document.querySelector('.space-y-6');
            const hasComments = commentsList.querySelector('.border-b, .flex');
            if (!hasComments) {
                commentsList.innerHTML = `
                    <div class="text-center py-8">
                        <p class="text-gray-500 dark:text-gray-400">No comments yet. Be the first to comment!</p>
                    </div>
                `;
            }
        }
    })
    .catch(error => {
        console.error('Full error:', error);
        alert('Failed to delete comment: ' + error.message + '. Check console for details.');
    });
}

// Edit Comment/Reply
function editComment(commentId, isReply) {
    const contentEl = document.getElementById(`comment-content-${commentId}`);
    const editEl = document.getElementById(`comment-edit-${commentId}`);
    const currentContent = contentEl.textContent.trim();
    
    // Hide content, show edit form
    contentEl.classList.add('hidden');
    editEl.classList.remove('hidden');
    
    const textareaClass = isReply 
        ? 'w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white resize-none text-sm'
        : 'w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white resize-none';
    
    editEl.innerHTML = `
        <form onsubmit="saveEdit(event, ${commentId}, ${isReply})" class="space-y-2">
            <textarea 
                id="edit-textarea-${commentId}"
                rows="3" 
                class="${textareaClass}"
                required
            >${currentContent}</textarea>
            <p id="edit-error-${commentId}" class="text-sm text-red-600 dark:text-red-400 hidden"></p>
            <div class="flex justify-end space-x-2">
                <button 
                    type="button" 
                    onclick="cancelEdit(${commentId})"
                    class="px-3 py-1 text-sm text-gray-600 hover:text-gray-700 dark:text-gray-400 font-medium"
                >
                    Cancel
                </button>
                <button 
                    type="submit" 
                    id="edit-submit-${commentId}"
                    class="px-3 py-1 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 hover:from-blue-700 hover:via-indigo-700 hover:to-purple-700 text-white text-sm font-medium rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl disabled:opacity-50"
                >
                    Save
                </button>
            </div>
        </form>
    `;
    
    // Focus the textarea
    document.getElementById(`edit-textarea-${commentId}`).focus();
}

function cancelEdit(commentId) {
    const contentEl = document.getElementById(`comment-content-${commentId}`);
    const editEl = document.getElementById(`comment-edit-${commentId}`);
    
    contentEl.classList.remove('hidden');
    editEl.classList.add('hidden');
    editEl.innerHTML = '';
}

function saveEdit(event, commentId, isReply) {
    event.preventDefault();
    
    const textarea = document.getElementById(`edit-textarea-${commentId}`);
    const submitBtn = document.getElementById(`edit-submit-${commentId}`);
    const errorEl = document.getElementById(`edit-error-${commentId}`);
    const newContent = textarea.value.trim();
    
    if (!newContent) {
        errorEl.textContent = 'Comment cannot be empty';
        errorEl.classList.remove('hidden');
        return;
    }
    
    // Disable button
    submitBtn.disabled = true;
    submitBtn.textContent = 'Saving...';
    errorEl.classList.add('hidden');
    
    const url = `{{ url('/') }}/comments/${commentId}`;
    
    fetch(url, {
        method: 'PUT',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
            content: newContent
        })
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => Promise.reject(err));
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Update the content
            const contentEl = document.getElementById(`comment-content-${commentId}`);
            contentEl.textContent = data.comment.content;
            
            // Cancel edit mode
            cancelEdit(commentId);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        errorEl.textContent = error.errors?.content?.[0] || 'Failed to update comment. Please try again.';
        errorEl.classList.remove('hidden');
        
        submitBtn.disabled = false;
        submitBtn.textContent = 'Save';
    });
}
</script>

<style>
/* Rich content styling */
.rich-content img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 1rem 0;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

.rich-content img.featured-image {
    max-height: 300px;
    height: auto;
    width: auto;
    max-width: 100%;
    display: block;
    margin-left: auto;
    margin-right: auto;
}

.rich-content img.align-left {
    float: left;
    margin-right: 1rem;
    margin-bottom: 0.5rem;
}

.rich-content img.align-right {
    float: right;
    margin-left: 1rem;
    margin-bottom: 0.5rem;
}

.rich-content img.align-center {
    display: block;
    margin-left: auto;
    margin-right: auto;
}

.rich-content figure {
    margin: 1.5rem 0;
    text-align: center;
}

.rich-content figcaption {
    font-size: 0.875rem;
    color: #6b7280;
    margin-top: 0.5rem;
    font-style: italic;
}

.dark .rich-content figcaption {
    color: #9ca3af;
}

.rich-content blockquote {
    border-left: 4px solid #3b82f6;
    padding-left: 1rem;
    margin: 1.5rem 0;
    font-style: italic;
    background-color: #f8fafc;
    padding: 1rem;
    border-radius: 0 8px 8px 0;
}

.dark .rich-content blockquote {
    background-color: #1e293b;
    border-left-color: #60a5fa;
}

.rich-content pre {
    background-color: #f1f5f9;
    padding: 1rem;
    border-radius: 8px;
    overflow-x: auto;
    margin: 1rem 0;
}

.dark .rich-content pre {
    background-color: #0f172a;
}

.rich-content code {
    background-color: #f1f5f9;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-size: 0.875rem;
}

.dark .rich-content code {
    background-color: #0f172a;
}

.rich-content table {
    width: 100%;
    border-collapse: collapse;
    margin: 1rem 0;
}

.rich-content th,
.rich-content td {
    border: 1px solid #e5e7eb;
    padding: 0.75rem;
    text-align: left;
}

.dark .rich-content th,
.dark .rich-content td {
    border-color: #374151;
}

.rich-content th {
    background-color: #f9fafb;
    font-weight: 600;
}

.dark .rich-content th {
    background-color: #1f2937;
}
</style>

</x-layouts.homepage>

