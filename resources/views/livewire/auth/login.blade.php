<?php

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    #[Validate('required|string')]
    public string $identifier = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->ensureIsNotRateLimited();

        $field = filter_var($this->identifier, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (! Auth::attempt([$field => $this->identifier, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'identifier' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        // Force a hard page reload using JavaScript to bypass all caches
        $this->dispatch('login-success');
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'login' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->identifier).'|'.request()->ip());
    }
}; ?>

<div class="flex flex-col gap-6">
    <!-- Header -->
    <div class="space-y-2">
        <h1 class="text-2xl font-semibold text-zinc-900 dark:text-white">
            Sign In
        </h1>
        <p class="text-sm text-zinc-600 dark:text-zinc-400">
            Access your account to continue
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form method="POST" wire:submit="login" class="flex flex-col gap-5">
        <!-- Email or Username -->
        <div>
            <flux:input
                wire:model="identifier"
                :label="__('Email or Username')"
                type="text"
                required
                autofocus
                autocomplete="username"
                placeholder="Enter your email or username"
                class="w-full"
            />
        </div>

        <!-- Password -->
        <div class="space-y-2">
            <flux:input
                wire:model="password"
                :label="__('Password')"
                type="password"
                required
                autocomplete="current-password"
                :placeholder="__('Enter your password')"
                viewable
                class="w-full"
            />
            
            @if (Route::has('password.request'))
                <div class="flex justify-end">
                    <flux:link 
                        class="text-sm text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white transition-colors" 
                        :href="route('password.request')" 
                        wire:navigate
                    >
                        {{ __('Forgot password?') }}
                    </flux:link>
                </div>
            @endif
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <flux:checkbox 
                wire:model="remember" 
                :label="__('Remember me')"
                class="text-sm"
            />
        </div>

        <!-- Submit Button -->
        <div class="space-y-4 pt-2">
            <flux:button 
                variant="primary" 
                type="submit" 
                class="w-full py-3 text-sm font-medium bg-zinc-900 hover:bg-zinc-800 text-white dark:bg-white dark:hover:bg-zinc-100 dark:text-zinc-900 transition-colors"
            >
                {{ __('Sign In') }}
            </flux:button>

            <!-- Divider -->
            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-zinc-200 dark:border-zinc-700"></div>
                </div>
                <div class="relative flex justify-center text-xs">
                    <span class="bg-gray-50 dark:bg-zinc-950 px-3 text-zinc-500 dark:text-zinc-400">
                        OR
                    </span>
                </div>
            </div>

            <!-- Social Login Buttons -->
            <div class="grid grid-cols-2 gap-3">
                <button
                    type="button"
                    disabled
                    class="flex items-center justify-center gap-2 px-3 py-2.5 border border-zinc-200 dark:border-zinc-700 rounded-md text-sm text-zinc-600 dark:text-zinc-400 bg-white dark:bg-zinc-900 opacity-40 cursor-not-allowed"
                    title="Coming soon"
                >
                    <svg class="w-4 h-4" viewBox="0 0 24 24">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                    </svg>
                    Google
                </button>
                <button
                    type="button"
                    disabled
                    class="flex items-center justify-center gap-2 px-3 py-2.5 border border-zinc-200 dark:border-zinc-700 rounded-md text-sm text-zinc-600 dark:text-zinc-400 bg-white dark:bg-zinc-900 opacity-40 cursor-not-allowed"
                    title="Coming soon"
                >
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                        <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                    </svg>
                    GitHub
                </button>
            </div>
        </div>
    </form>

    <!-- Sign Up Link -->
    @if (Route::has('register'))
        <div class="text-center pt-3 border-t border-zinc-200 dark:border-zinc-800">
            <span class="text-sm text-zinc-600 dark:text-zinc-400">{{ __("Don't have an account?") }}</span>
            <flux:link 
                :href="route('register')" 
                wire:navigate
                class="text-sm font-medium text-zinc-900 hover:text-zinc-700 dark:text-white dark:hover:text-zinc-300 ml-1 transition-colors"
            >
                {{ __('Create one') }}
            </flux:link>
        </div>
    @endif

    <!-- Explore Link -->
    <div class="text-center pt-2">
        <a 
            href="{{ route('home') }}" 
            wire:navigate
            class="inline-flex items-center gap-2 text-sm text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white transition-colors group"
        >
            <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            {{ __('Explore blogs') }}
        </a>
    </div>
</div>

<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('login-success', () => {
            // Clear all caches and storage
            if ('caches' in window) {
                caches.keys().then(names => {
                    names.forEach(name => {
                        caches.delete(name);
                    });
                });
            }
            
            // Clear session storage and local storage
            sessionStorage.clear();
            localStorage.removeItem('theme'); // Keep theme preference
            
            // Force a hard page reload to bypass all caches
            window.location.href = "{{ route('home') }}?_t=" + Date.now();
        });
    });
</script>
