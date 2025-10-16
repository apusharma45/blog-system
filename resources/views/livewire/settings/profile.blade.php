<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;

new #[Layout('components.layouts.homepage')] class extends Component {
    use WithFileUploads;

    public string $name = '';
    public string $email = '';
    public string $username = '';
    public string $bio = '';
    public string $location = '';
    public $avatar;

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
        $this->username = Auth::user()->username;
        $this->bio = Auth::user()->bio ?? '';
        $this->location = Auth::user()->location ?? '';
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user->id)
            ],
            'username' => [
                'required',
                'string',
                'alpha_dash',
                'max:50',
                Rule::unique(User::class)->ignore($user->id)
            ],
            'bio' => ['nullable', 'string', 'max:500'],
            'location' => ['nullable', 'string', 'max:100'],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Update the user's avatar.
     */
    public function updateAvatar(): void
    {
        $this->validate([
            'avatar' => ['required', 'image', 'max:2048'], // 2MB max
        ]);

        $user = Auth::user();

        // Delete old avatar if exists
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Store new avatar
        $path = $this->avatar->store('avatars', 'public');

        $user->update(['avatar' => $path]);

        $this->reset('avatar');
        $this->dispatch('avatar-updated');
    }

    /**
     * Delete the user's avatar.
     */
    public function deleteAvatar(): void
    {
        $user = Auth::user();

        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->update(['avatar' => null]);

        $this->dispatch('avatar-deleted');
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', ['username' => auth()->user()->username], absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section class="w-full">
    <!-- Avatar Upload Section -->
    <div class="mb-8">
        <div class="flex items-center mb-6">
            <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 dark:from-blue-600 dark:to-blue-700 rounded-lg flex items-center justify-center mr-3 shadow-lg">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"></path>
                </svg>
            </div>
            <h2 class="text-xl font-semibold bg-gradient-to-r from-blue-900 to-indigo-800 dark:from-blue-200 dark:to-indigo-200 bg-clip-text text-transparent">Profile Picture</h2>
        </div>
        
        <div class="bg-gradient-to-br from-white via-blue-50/30 to-indigo-50/20 rounded-xl dark:from-slate-800 dark:via-blue-900/20 dark:to-indigo-900/20 border border-zinc-200 dark:border-zinc-700 p-6">
            <div class="flex flex-col md:flex-row items-start gap-6">
                <!-- Current Avatar Display -->
                <div class="flex-shrink-0">
                    @if ($avatar)
                        <!-- Preview new avatar -->
                        <img src="{{ $avatar->temporaryUrl() }}" alt="Avatar preview" class="w-32 h-32 rounded-full object-cover border-4 border-blue-500 shadow-lg">
                    @else
                        <!-- Current avatar or default -->
                        <img src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->name }}" class="w-32 h-32 rounded-full object-cover border-4 border-zinc-200 dark:border-zinc-700 shadow-lg">
                    @endif
                </div>

                <!-- Avatar Upload Controls -->
                <div class="flex-1 space-y-4">
                    <div>
                        <flux:input 
                            type="file" 
                            wire:model="avatar" 
                            accept="image/*"
                            :label="__('Upload new picture')"
                        />
                        <flux:text class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">
                            {{ __('JPG, PNG or GIF. Max size 2MB.') }}
                        </flux:text>
                        @error('avatar') 
                            <flux:text class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</flux:text>
                        @enderror
                    </div>

                    <div class="flex gap-3">
                        @if ($avatar)
                            <flux:button wire:click="updateAvatar" variant="primary" class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800">
                                <flux:icon.arrow-up-tray class="size-5" />
                                {{ __('Upload Picture') }}
                            </flux:button>
                            <flux:button wire:click="$set('avatar', null)" variant="ghost">
                                {{ __('Cancel') }}
                            </flux:button>
                        @elseif (Auth::user()->avatar)
                            <flux:button wire:click="deleteAvatar" wire:confirm="Are you sure you want to delete your profile picture?" variant="danger">
                                <flux:icon.trash class="size-5" />
                                {{ __('Remove Picture') }}
                            </flux:button>
                        @endif
                    </div>

                    <div wire:loading wire:target="avatar" class="text-sm text-blue-600 dark:text-blue-400">
                        {{ __('Processing...') }}
                    </div>
                </div>
            </div>

            <x-action-message class="mt-4" on="avatar-updated">
                {{ __('Profile picture updated successfully!') }}
            </x-action-message>
            <x-action-message class="mt-4" on="avatar-deleted">
                {{ __('Profile picture removed.') }}
            </x-action-message>
        </div>
    </div>

    <!-- Profile Information Form -->
    <div class="mb-8">
        <div class="flex items-center mb-6">
            <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 dark:from-blue-600 dark:to-blue-700 rounded-lg flex items-center justify-center mr-3 shadow-lg">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"></path>
                </svg>
            </div>
            <h2 class="text-xl font-semibold bg-gradient-to-r from-blue-900 to-indigo-800 dark:from-blue-200 dark:to-indigo-200 bg-clip-text text-transparent">Profile Information</h2>
        </div>

        <div class="bg-gradient-to-br from-white via-blue-50/30 to-indigo-50/20 rounded-xl dark:from-slate-800 dark:via-blue-900/20 dark:to-indigo-900/20 border border-zinc-200 dark:border-zinc-700 p-6">
            <form wire:submit="updateProfileInformation" class="space-y-6">
                <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus autocomplete="name" />

                <flux:input wire:model="username" :label="__('Username')" type="text" required autocomplete="username" />

                <div>
                    <flux:input wire:model="email" :label="__('Email')" type="email" required autocomplete="email" />

                    @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail &&! auth()->user()->hasVerifiedEmail())
                        <div>
                            <flux:text class="mt-4">
                                {{ __('Your email address is unverified.') }}

                                <flux:link class="text-sm cursor-pointer" wire:click.prevent="resendVerificationNotification">
                                    {{ __('Click here to re-send the verification email.') }}
                                </flux:link>
                            </flux:text>

                            @if (session('status') === 'verification-link-sent')
                                <flux:text class="mt-2 font-medium !dark:text-green-400 !text-green-600">
                                    {{ __('A new verification link has been sent to your email address.') }}
                                </flux:text>
                            @endif
                        </div>
                    @endif
                </div>

                <div>
                    <flux:textarea 
                        wire:model="bio" 
                        :label="__('Bio')" 
                        :placeholder="__('Tell us about yourself...')"
                        rows="4"
                    />
                    <flux:text class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">
                        {{ __('Brief description for your profile. Max 500 characters.') }}
                    </flux:text>
                </div>

                <flux:input wire:model="location" :label="__('Location')" type="text" :placeholder="__('City, Country')" />

                <div class="flex items-center gap-4">
                    <div class="flex items-center justify-end">
                        <flux:button variant="primary" type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800">{{ __('Save Changes') }}</flux:button>
                    </div>

                    <x-action-message class="me-3" on="profile-updated">
                        {{ __('Profile updated successfully!') }}
                    </x-action-message>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Account Section -->
    <div class="mb-8">
        <div class="bg-gradient-to-br from-red-50 via-red-50/30 to-red-50/20 rounded-xl dark:from-red-900/20 dark:via-red-900/20 dark:to-red-900/20 border border-red-200 dark:border-red-800 p-6">
            <livewire:settings.delete-user-form />
        </div>
    </div>
</section>
