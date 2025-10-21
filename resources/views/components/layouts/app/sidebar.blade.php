<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            @auth
                @if(auth()->user() && auth()->user()->username)
                    <a href="{{ route('dashboard', ['username' => auth()->user()->username]) }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                        <x-app-logo />
                    </a>
                @else
                    <a href="{{ route('home') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                        <x-app-logo />
                    </a>
                @endif
            @else
                <a href="{{ route('home') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                    <x-app-logo />
                </a>
            @endauth

            <flux:navlist variant="outline">
                <flux:navlist.group :heading="__('Browse')" class="grid">
                    <flux:navlist.item icon="home" :href="route('home')" :current="request()->routeIs('home')" wire:navigate>{{ __('Home') }}</flux:navlist.item>
                    <flux:navlist.item icon="newspaper" :href="route('posts.index')" :current="request()->routeIs('posts.*')" wire:navigate>{{ __('Posts') }}</flux:navlist.item>
                    @auth
                        @if(auth()->user() && auth()->user()->username)
                            <flux:navlist.item icon="heart" :href="route('favorites.index', ['username' => auth()->user()->username])" :current="request()->routeIs('favorites.*')" wire:navigate>{{ __('Favourites') }}</flux:navlist.item>
                        @endif
                    @endauth
                </flux:navlist.group>
            </flux:navlist>

            @auth
                @if(auth()->user() && auth()->user()->username)
                    <flux:navlist variant="outline">
                        <flux:navlist.group :heading="__('Manage')" class="grid">
                            <flux:navlist.item icon="layout-grid" :href="route('dashboard', ['username' => auth()->user()->username])" :current="request()->routeIs('dashboard')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
                            <flux:navlist.item icon="plus-circle" :href="route('posts.create', ['username' => auth()->user()->username])" :current="request()->routeIs('posts.create')" wire:navigate>{{ __('Write Post') }}</flux:navlist.item>
                            <flux:navlist.item icon="user-circle" :href="route('user.profile', ['username' => auth()->user()->username])" :current="request()->routeIs('user.profile')" wire:navigate>{{ __('Profile') }}</flux:navlist.item>
                        </flux:navlist.group>
                    </flux:navlist>
                @endif
            @endauth

            <flux:spacer />

            <flux:navlist variant="outline">
                <flux:navlist.group :heading="__('Support')" class="grid">
                    <flux:navlist.item icon="question-mark-circle" href="#" wire:navigate>{{ __('Help Center') }}</flux:navlist.item>
                    <flux:navlist.item icon="chat-bubble-left-right" href="#" wire:navigate>{{ __('Feedback') }}</flux:navlist.item>
                </flux:navlist.group>
            </flux:navlist>

            <!-- Desktop User Menu -->
            @auth
            <flux:dropdown class="hidden lg:block" position="bottom" align="start">
                <button class="flex items-center space-x-2 text-left w-full p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                    @if(auth()->user()->avatar)
                        <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" class="w-8 h-8 rounded-full object-cover">
                    @else
                        <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white text-sm font-medium">
                            {{ auth()->user()->initials() }}
                        </div>
                    @endif
                    <div class="flex-1 min-w-0">
                        <div class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ auth()->user()->name }}</div>
                    </div>
                    <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                    </svg>
                </button>

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                @if(auth()->user()->avatar)
                                    <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" class="w-8 h-8 rounded-full object-cover">
                                @else
                                    <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                        <span class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                            {{ auth()->user()->initials() }}
                                        </span>
                                    </span>
                                @endif

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        @if(auth()->user() && auth()->user()->username)
                            <flux:menu.item :href="route('user.profile', ['username' => auth()->user()->username])" icon="user" wire:navigate>{{ __('Profile') }}</flux:menu.item>
                        @endif
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full" id="sidebar-logout-form">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
            @else
            <div class="hidden lg:flex items-center gap-2">
                <flux:link :href="route('login')" wire:navigate>Login</flux:link>
                <flux:link :href="route('register')" wire:navigate>Register</flux:link>
            </div>
            @endauth
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            @auth
            <flux:dropdown position="top" align="end">
                <button class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                    @if(auth()->user()->avatar)
                        <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" class="w-8 h-8 rounded-full object-cover">
                    @else
                        <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white text-sm font-medium">
                            {{ auth()->user()->initials() }}
                        </div>
                    @endif
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                @if(auth()->user()->avatar)
                                    <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" class="w-8 h-8 rounded-full object-cover">
                                @else
                                    <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                        <span class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                            {{ auth()->user()->initials() }}
                                        </span>
                                    </span>
                                @endif

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        @if(auth()->user() && auth()->user()->username)
                            <flux:menu.item :href="route('user.profile', ['username' => auth()->user()->username])" icon="user" wire:navigate>{{ __('Profile') }}</flux:menu.item>
                        @endif
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full" id="mobile-sidebar-logout-form">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
            @else
            <div class="flex items-center gap-3">
                <flux:link :href="route('login')" wire:navigate>Login</flux:link>
                <flux:link :href="route('register')" wire:navigate>Register</flux:link>
            </div>
            @endauth
        </flux:header>

        {{ $slot }}

        <script>
            // Handle logout form submission and clear cache
            document.addEventListener('DOMContentLoaded', function() {
                const logoutForms = document.querySelectorAll('#sidebar-logout-form, #mobile-sidebar-logout-form, #app-logout-form');
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
