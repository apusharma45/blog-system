<footer class="bg-white dark:bg-slate-900 border-t border-zinc-200 dark:border-zinc-800">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <!-- Main Footer Content -->
        <div class="py-12 lg:py-16">
            <div class="grid grid-cols-1 gap-8 lg:grid-cols-4 md:grid-cols-2">
                <!-- Brand Section -->
                <div class="space-y-4 lg:col-span-1">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2" wire:navigate>
                        <img src="{{ asset('logos/logo.png') }}" alt="{{ config('app.name') }}" class="h-10 w-10 rounded-lg object-contain shadow-lg" />
                        <span class="text-xl font-extrabold tracking-tight bg-clip-text text-transparent bg-gradient-to-r from-blue-900 via-indigo-800 to-purple-800 dark:from-blue-200 dark:via-indigo-200 dark:to-purple-200">
                            {{ config('app.name') }}
                        </span>
                    </a>
                    <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                        Share your stories, connect with readers, and discover amazing content from writers around the world.
                    </p>
                    <!-- Social Links -->
                    <div class="flex space-x-3">
                        <a href="https://x.com/as_tt45" class="group p-2 rounded-lg bg-zinc-100 dark:bg-zinc-800 hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors" aria-label="Twitter">
                            <svg class="w-5 h-5 text-gray-600 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                            </svg>
                        </a>
                        <a href="https://github.com/apusharma45" class="group p-2 rounded-lg bg-zinc-100 dark:bg-zinc-800 hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors" aria-label="GitHub">
                            <svg class="w-5 h-5 text-gray-600 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"/>
                            </svg>
                        </a>
                        <a href="https://www.linkedin.com/in/apusharma/" class="group p-2 rounded-lg bg-zinc-100 dark:bg-zinc-800 hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors" aria-label="LinkedIn">
                            <svg class="w-5 h-5 text-gray-600 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </a>
                        <a href="https://www.facebook.com/apusharma45" class="group p-2 rounded-lg bg-zinc-100 dark:bg-zinc-800 hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors" aria-label="Facebook">
                            <svg class="w-5 h-5 text-gray-600 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="space-y-4">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider">Quick Links</h3>
                    <ul class="space-y-3">
                        <li>
                            <a href="{{ route('home') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors" wire:navigate>
                                Home
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('posts.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors" wire:navigate>
                                All Posts
                            </a>
                        </li>
                        @auth
                            @if(auth()->user() && auth()->user()->username)
                                <li>
                                    <a href="{{ route('dashboard', ['username' => auth()->user()->username]) }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors" wire:navigate>
                                        Dashboard
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('posts.create', ['username' => auth()->user()->username]) }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors" wire:navigate>
                                        Write a Post
                                    </a>
                                </li>
                            @endif
                        @else
                            <li>
                                <a href="{{ route('login') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors" wire:navigate>
                                    Sign In
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('register') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors" wire:navigate>
                                    Join Us
                                </a>
                            </li>
                        @endauth
                    </ul>
                </div>

                <!-- Resources -->
                <div class="space-y-4">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider">Resources</h3>
                    <ul class="space-y-3">
                        <li>
                            <a href="#" class="text-sm text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                Contact
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-sm text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                Help Center
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-sm text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                Guidelines
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Legal -->
                <div class="space-y-4">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider">Legal</h3>
                    <ul class="space-y-3">
                        <li>
                            <a href="#" class="text-sm text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                Privacy Policy
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-sm text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                Terms of Service
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-sm text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                Cookie Policy
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-sm text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                DMCA
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="border-t border-zinc-200 dark:border-zinc-800 py-6">
            <div class="flex flex-col items-center justify-between gap-4 sm:flex-row">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                </p>
                <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                    <span>Made with</span>
                    <svg class="w-4 h-4 text-red-500 animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                    </svg>
                    <span>by passionate writers</span>
                </div>
            </div>
        </div>
    </div>
</footer>
