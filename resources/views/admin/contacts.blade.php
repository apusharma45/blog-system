<x-layouts.admin title="Contact Messages">
    <!-- Header with Search -->
    <div class="mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Contact Messages</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    {{ $unreadCount }} unread message{{ $unreadCount != 1 ? 's' : '' }}
                </p>
            </div>
        </div>

        <!-- Search and Filters -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
            <form method="GET" action="{{ route('admin.contacts') }}" class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Search by name, email, or message..." 
                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                </div>
                <div>
                    <select name="status" 
                            class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                            onchange="this.form.submit()">
                        <option value="">All Messages</option>
                        <option value="unread" {{ request('status') === 'unread' ? 'selected' : '' }}>Unread</option>
                        <option value="read" {{ request('status') === 'read' ? 'selected' : '' }}>Read</option>
                    </select>
                </div>
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                    Search
                </button>
                @if(request('search') || request('status'))
                    <a href="{{ route('admin.contacts') }}" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg transition-colors">
                        Clear
                    </a>
                @endif
            </form>
        </div>
    </div>

    <!-- Messages List -->
    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
        @if($contacts->count() > 0)
            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($contacts as $contact)
                    <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors {{ !$contact->read_at ? 'bg-blue-50/50 dark:bg-blue-900/10' : '' }}">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <!-- Header -->
                                <div class="flex items-center space-x-3 mb-3">
                                    <h3 class="font-semibold text-gray-900 dark:text-white">{{ $contact->name }}</h3>
                                    @if(!$contact->read_at)
                                        <span class="px-2 py-0.5 text-xs rounded-full bg-blue-600 text-white">
                                            New
                                        </span>
                                    @endif
                                </div>

                                <!-- Email and Date -->
                                <div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-sm text-gray-600 dark:text-gray-400 mb-3">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                        <a href="mailto:{{ $contact->email }}" class="hover:text-blue-600 dark:hover:text-blue-400">
                                            {{ $contact->email }}
                                        </a>
                                    </span>
                                    <span>•</span>
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        {{ $contact->created_at->format('M d, Y \a\t h:i A') }}
                                    </span>
                                </div>

                                <!-- Message -->
                                <div class="bg-gray-50 dark:bg-gray-900/50 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                                    <p class="text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $contact->message }}</p>
                                </div>

                                @if($contact->read_at)
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                                        Read {{ $contact->read_at->diffForHumans() }}
                                    </p>
                                @endif
                            </div>

                            <!-- Actions -->
                            <div class="flex flex-col space-y-2 ml-6">
                                <form method="POST" 
                                      action="{{ route('admin.contacts.delete', $contact->id) }}"
                                      onsubmit="return confirm('Are you sure you want to delete this message?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="inline-flex items-center px-3 py-1.5 text-sm border border-red-300 dark:border-red-600 rounded-lg text-red-700 dark:text-red-300 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors"
                                            title="Delete">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                {{ $contacts->links() }}
            </div>
        @else
            <div class="p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No messages found</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    @if(request('search') || request('status'))
                        Try adjusting your search or filter criteria.
                    @else
                        No contact messages have been received yet.
                    @endif
                </p>
            </div>
        @endif
    </div>
</x-layouts.admin>
