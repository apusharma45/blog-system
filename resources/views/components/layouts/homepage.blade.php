<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <header class="sticky top-0 z-50 w-full border-b border-zinc-200 bg-white/80 backdrop-blur supports-[backdrop-filter]:bg-white/60 dark:border-zinc-800 dark:bg-slate-900/70 dark:supports-[backdrop-filter]:bg-slate-900/60">
            <div class="mx-auto max-w-7xl px-3 sm:px-4">
                <div class="flex h-14 sm:h-16 items-center justify-between">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2" wire:navigate>
                        <img src="{{ asset('logos/logo.png') }}" alt="{{ config('app.name') }}" class="h-8 w-8 rounded-lg object-contain shadow-lg" />
                        <span class="text-lg sm:text-xl font-extrabold tracking-tight bg-clip-text text-transparent bg-gradient-to-r from-blue-900 via-indigo-800 to-purple-800 dark:from-blue-200 dark:via-indigo-200 dark:to-purple-200">{{ config('app.name') }}</span>
                    </a>

                    <!-- Desktop Navigation -->
                    <nav class="hidden md:flex items-center gap-2">
                        <a href="{{ route('home') }}" class="group relative inline-flex items-center px-3 py-1.5 rounded-md text-sm font-medium transition-colors hover:bg-zinc-100 dark:hover:bg-zinc-800 {{ request()->routeIs('home') ? 'text-blue-600 bg-zinc-100 dark:text-blue-400 dark:bg-zinc-800' : 'text-gray-700 dark:text-gray-300' }}">
                            Home
                        </a>
                        <a href="{{ route('posts.index') }}" class="group relative inline-flex items-center px-3 py-1.5 rounded-md text-sm font-medium transition-colors hover:bg-zinc-100 dark:hover:bg-zinc-800 {{ request()->routeIs('posts.*') ? 'text-blue-600 bg-zinc-100 dark:text-blue-400 dark:bg-zinc-800' : 'text-gray-700 dark:text-gray-300' }}">
                            Posts
                        </a>
                        <a href="{{ route('about') }}" class="group relative inline-flex items-center px-3 py-1.5 rounded-md text-sm font-medium transition-colors hover:bg-zinc-100 dark:hover:bg-zinc-800 {{ request()->routeIs('about') ? 'text-blue-600 bg-zinc-100 dark:text-blue-400 dark:bg-zinc-800' : 'text-gray-700 dark:text-gray-300' }}">
                            About
                        </a>
                        <a href="{{ route('contact') }}" class="group relative inline-flex items-center px-3 py-1.5 rounded-md text-sm font-medium transition-colors hover:bg-zinc-100 dark:hover:bg-zinc-800 {{ request()->routeIs('contact') ? 'text-blue-600 bg-zinc-100 dark:text-blue-400 dark:bg-zinc-800' : 'text-gray-700 dark:text-gray-300' }}">
                            Contact
                        </a>
                        @auth
                            @if(auth()->user() && auth()->user()->username)
                                <a href="{{ route('dashboard', ['username' => auth()->user()->username]) }}" class="group relative inline-flex items-center px-3 py-1.5 rounded-md text-sm font-medium transition-colors hover:bg-zinc-100 dark:hover:bg-zinc-800 {{ request()->routeIs('dashboard') ? 'text-blue-600 bg-zinc-100 dark:text-blue-400 dark:bg-zinc-800' : 'text-gray-700 dark:text-gray-300' }}">
                                    Dashboard
                                </a>
                            @endif
                        @endauth
                    </nav>

                    <div class="flex items-center gap-2 sm:gap-3">
                    @auth
                        <!-- User Menu -->
                        <div class="relative">
                            <a href="{{ route('user.profile', ['username' => auth()->user()->username]) }}" class="flex items-center space-x-1 sm:space-x-2 text-sm font-medium text-gray-700 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white transition-colors" wire:navigate>
                                <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" class="h-7 w-7 sm:h-8 sm:w-8 rounded-full object-cover">
                                <span class="hidden sm:inline">{{ auth()->user()->name }}</span>
                            </a>
                        </div>
                        
                        <!-- Logout Button -->
                        <form method="POST" action="{{ route('logout') }}" class="inline" id="logout-form">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-2 sm:px-3 py-1 sm:py-1.5 text-xs sm:text-sm font-medium text-gray-600 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-400 transition-colors duration-200 rounded-md hover:bg-red-50 dark:hover:bg-red-900/20">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-xs sm:text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400">Sign In</a>
                        <a href="{{ route('register') }}" class="rounded-md bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 px-2 sm:px-3 py-1 sm:py-1.5 text-xs sm:text-sm font-medium text-white hover:from-blue-700 hover:via-indigo-700 hover:to-purple-700 shadow-lg hover:shadow-xl">Join</a>
                    @endauth
                    
                    <!-- Simple Theme Toggle -->
                    <button onclick="toggleTheme()" class="p-2 rounded-md text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                        <svg class="h-5 w-5 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <svg class="h-5 w-5 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                        </svg>
                    </button>
                    </div>
                </div>
            </div>
        </header>

        <!-- Mobile Menu -->
        <flux:sidebar stashable sticky class="lg:hidden border-e border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-gray-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('home') }}" class="ms-1 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                <div class="h-8 w-8 rounded-lg bg-zinc-900 dark:bg-white flex items-center justify-center">
                    <x-app-logo-icon class="h-5 w-5 text-white dark:text-zinc-900" />
                </div>
                <span class="text-lg font-bold text-gray-900 dark:text-white">{{ config('app.name') }}</span>
            </a>

            <flux:navlist variant="outline">
                <flux:navlist.group :heading="__('Navigation')">
                    <flux:navlist.item icon="home" :href="route('home')" :current="request()->routeIs('home')" wire:navigate>
                        {{ __('Home') }}
                    </flux:navlist.item>
                    <flux:navlist.item icon="newspaper" :href="route('posts.index')" :current="request()->routeIs('posts.*')" wire:navigate>
                        {{ __('Posts') }}
                    </flux:navlist.item>
                    <flux:navlist.item icon="information-circle" :href="route('about')" :current="request()->routeIs('about')" wire:navigate>
                        {{ __('About') }}
                    </flux:navlist.item>
                    <flux:navlist.item icon="envelope" :href="route('contact')" :current="request()->routeIs('contact')" wire:navigate>
                        {{ __('Contact') }}
                    </flux:navlist.item>
                    @auth
                        @if(auth()->user() && auth()->user()->username)
                            <flux:navlist.item icon="layout-grid" :href="route('dashboard', ['username' => auth()->user()->username])" :current="request()->routeIs('dashboard')" wire:navigate>
                                {{ __('Dashboard') }}
                            </flux:navlist.item>
                        @endif
                    @endauth
                </flux:navlist.group>
            </flux:navlist>

            <flux:spacer />

            @auth
                <flux:navlist variant="outline">
                    <flux:navlist.group :heading="__('Account')">
                        @if(auth()->user() && auth()->user()->username)
                            <flux:navlist.item :href="route('user.profile', ['username' => auth()->user()->username])" wire:navigate>
                                Profile
                            </flux:navlist.item>
                            <flux:navlist.item :href="route('user.profile', ['username' => auth()->user()->username])" wire:navigate>
                                Settings
                            </flux:navlist.item>
                        @endif
                    </flux:navlist.group>
                </flux:navlist>
                
                <form method="POST" action="{{ route('logout') }}" class="mt-4 px-4" id="mobile-logout-form">
                    @csrf
                    <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 bg-red-50 dark:bg-red-900/20 rounded-lg hover:bg-red-100 dark:hover:bg-red-900/30 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Logout
                    </button>
                </form>
            @else
                <flux:navlist variant="outline">
                    <flux:navlist.group :heading="__('Account')">
                        <flux:navlist.item :href="route('login')" wire:navigate>
                            {{ __('Sign In') }}
                        </flux:navlist.item>
                        <flux:navlist.item :href="route('register')" wire:navigate>
                            {{ __('Join') }}
                        </flux:navlist.item>
                    </flux:navlist.group>
                </flux:navlist>
            @endauth
        </flux:sidebar>

        {{ $slot }}

        <!-- Footer -->
        <x-footer />

        <!-- Notifications -->
        <x-notifications />

        <script>
            function toggleTheme() {
                const html = document.documentElement;
                const isDark = html.classList.contains('dark');
                
                if (isDark) {
                    html.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                } else {
                    html.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                }
            }

            // Initialize theme from localStorage
            document.addEventListener('DOMContentLoaded', function() {
                const savedTheme = localStorage.getItem('theme');
                if (savedTheme === 'dark') {
                    document.documentElement.classList.add('dark');
                } else if (savedTheme === 'light') {
                    document.documentElement.classList.remove('dark');
                }

                // Handle logout form submission
                const logoutForms = document.querySelectorAll('#logout-form, #mobile-logout-form');
                logoutForms.forEach(form => {
                    if (form) {
                        form.addEventListener('submit', function(e) {
                            // Ensure the form submits normally (not via Livewire)
                            // Clear any cached authentication state
                            sessionStorage.clear();
                            if ('caches' in window) {
                                caches.keys().then(names => {
                                    names.forEach(name => {
                                        caches.delete(name);
                                    });
                                });
                            }
                        });
                    }
                });
            });

            // Prevent browser back/forward cache for authenticated pages
            @auth
            window.addEventListener('pageshow', function(event) {
                if (event.persisted) {
                    // Page was loaded from cache, reload to get fresh auth state
                    window.location.reload();
                }
            });
            
            // Additional cache busting for authenticated users
            if (window.performance && window.performance.navigation.type === 1) {
                // Page was refreshed, ensure fresh content
                const url = new URL(window.location);
                if (!url.searchParams.has('_t')) {
                    url.searchParams.set('_t', Date.now());
                    window.history.replaceState({}, '', url);
                }
            }
            @endauth
        </script>

        @fluxScripts
    </body>
</html>
