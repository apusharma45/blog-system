<x-layouts.admin title="Comment Management">
    <!-- Search -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 mb-6 border border-gray-200 dark:border-gray-700">
        <form method="GET" action="{{ route('admin.comments') }}" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}"
                    placeholder="Search comments..." 
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                >
            </div>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                Search
            </button>
            <a href="{{ route('admin.comments') }}" class="px-6 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors text-center">
                Clear
            </a>
        </form>
    </div>

    <!-- Comments List -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($comments as $comment)
                <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-3 mb-3">
                                <img src="{{ $comment->user->avatar_url }}" alt="{{ $comment->user->name }}" class="w-10 h-10 rounded-full">
                                <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $comment->user->name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $comment->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <p class="text-sm text-gray-700 dark:text-gray-300 mb-3">{{ $comment->content }}</p>
                            <div class="flex items-center space-x-4 text-xs text-gray-500 dark:text-gray-400">
                                <span>On post: <a href="{{ route('posts.show', ['username' => $comment->post->user->username, 'slug' => $comment->post->slug]) }}" target="_blank" class="text-blue-600 dark:text-blue-400 hover:underline">{{ Str::limit($comment->post->title, 40) }}</a></span>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('admin.comments.delete', $comment->id) }}" onsubmit="return confirm('Are you sure you want to delete this comment?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 text-sm font-medium">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center text-gray-500 dark:text-gray-400">
                    No comments found
                </div>
            @endforelse
        </div>
    </div>

    <!-- Pagination -->
    @if($comments->hasPages())
        <div class="mt-6">
            {{ $comments->links() }}
        </div>
    @endif
</x-layouts.admin>
