<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <header class="sticky top-0 z-40 flex h-16 w-full items-center gap-3 border-b border-zinc-200 bg-white/95 px-4 backdrop-blur supports-[backdrop-filter]:bg-white/80 dark:border-zinc-800 dark:bg-zinc-900/95 dark:supports-[backdrop-filter]:bg-zinc-900/80">
            <div class="flex w-full items-center justify-between">
                <a href="{{ route('home') }}" class="flex items-center space-x-3" wire:navigate>
                    <div class="h-8 w-8 rounded-lg bg-zinc-900 dark:bg-white flex items-center justify-center border border-zinc-200 dark:border-zinc-800">
                        <x-app-logo-icon class="size-5 fill-current text-white dark:text-zinc-900" />
                    </div>
                    <span class="text-xl font-semibold text-zinc-900 dark:text-white">{{ config('app.name') }}</span>
                </a>

                <!-- Desktop Navigation -->
                <nav class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('home') }}" class="text-sm font-medium text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white {{ request()->routeIs('home') ? 'text-zinc-900 dark:text-white' : '' }}">Home</a>
                    <a href="{{ route('posts.index') }}" class="text-sm font-medium text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white {{ request()->routeIs('posts.*') ? 'text-zinc-900 dark:text-white' : '' }}">Posts</a>
                    @auth
                        @if(auth()->user() && auth()->user()->username)
                            <a href="{{ route('dashboard', ['username' => auth()->user()->username]) }}" class="text-sm font-medium text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white {{ request()->routeIs('dashboard') ? 'text-zinc-900 dark:text-white' : '' }}">Dashboard</a>
                        @endif
                    @endauth
                </nav>

                <div class="flex items-center gap-3">
                    @auth
                        <!-- User Menu -->
                        <div class="relative">
                            <button class="flex items-center space-x-2 text-sm font-medium text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white">
                                <div class="h-8 w-8 rounded-full bg-zinc-900 dark:bg-white flex items-center justify-center text-xs font-medium text-white dark:text-zinc-900 border border-zinc-200 dark:border-zinc-800">
                                    {{ auth()->user()->initials() }}
                                </div>
                                <span>{{ auth()->user()->name }}</span>
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                        </div>
                        
                        <!-- Logout Form -->
                        <form method="POST" action="{{ route('logout') }}" class="inline" id="app-logout-form">
                            @csrf
                            <button type="submit" class="text-sm text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-200">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white">Sign In</a>
                        <a href="{{ route('register') }}" class="rounded-md bg-zinc-900 px-3 py-1.5 text-sm font-medium text-white hover:bg-zinc-800 dark:bg-white dark:text-zinc-900 dark:hover:bg-zinc-100">Join</a>
                    @endauth
                    
                    <flux:theme.toggle />
                </div>
            </div>
        </header>

        <!-- Mobile Menu -->
        <flux:sidebar stashable sticky class="lg:hidden border-e border-zinc-200 bg-zinc-50 dark:border-zinc-800 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('home') }}" class="ms-1 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                <div class="h-8 w-8 rounded-lg bg-zinc-900 dark:bg-white flex items-center justify-center border border-zinc-200 dark:border-zinc-800">
                    <x-app-logo-icon class="size-5 fill-current text-white dark:text-zinc-900" />
                </div>
                <span class="text-lg font-semibold text-zinc-900 dark:text-white">{{ config('app.name') }}</span>
            </a>

            <flux:navlist variant="outline">
                <flux:navlist.group :heading="__('Navigation')">
                    <flux:navlist.item icon="home" :href="route('home')" :current="request()->routeIs('home')" wire:navigate>
                        {{ __('Home') }}
                    </flux:navlist.item>
                    <flux:navlist.item icon="newspaper" :href="route('posts.index')" :current="request()->routeIs('posts.*')" wire:navigate>
                        {{ __('Posts') }}
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
                            <flux:navlist.item icon="user" :href="route('user.profile', ['username' => auth()->user()->username])" wire:navigate>
                                {{ __('Profile') }}
                            </flux:navlist.item>
                            <flux:navlist.item icon="settings" :href="route('user.profile', ['username' => auth()->user()->username])" wire:navigate>
                                {{ __('Settings') }}
                            </flux:navlist.item>
                        @endif
                    </flux:navlist.group>
                </flux:navlist>
            @else
                <flux:navlist variant="outline">
                    <flux:navlist.group :heading="__('Account')">
                        <flux:navlist.item icon="log-in" :href="route('login')" wire:navigate>
                            {{ __('Sign In') }}
                        </flux:navlist.item>
                        <flux:navlist.item icon="user-plus" :href="route('register')" wire:navigate>
                            {{ __('Join') }}
                        </flux:navlist.item>
                    </flux:navlist.group>
                </flux:navlist>
            @endauth
        </flux:sidebar>

        {{ $slot }}

        <script>
            // Handle logout form submission and clear cache
            document.addEventListener('DOMContentLoaded', function() {
                const logoutForms = document.querySelectorAll('#app-logout-form');
                logoutForms.forEach(form => {
                    if (form) {
                        form.addEventListener('submit', function(e) {
                            // Clear any cached authentication state
                            sessionStorage.clear();
                        });
                    }
                });
            });

            // Prevent browser back/forward cache
            @auth
            window.addEventListener('pageshow', function(event) {
                if (event.persisted) {
                    window.location.reload();
                }
            });
            @endauth
        </script>

        @fluxScripts
    </body>
</html>
