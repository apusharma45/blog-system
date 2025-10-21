<?php

use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.homepage')] class extends Component {
    //
}; ?>

<section class="w-full">
    <div class="mb-8">
        <div class="flex items-center mb-6">
            <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 dark:from-blue-600 dark:to-blue-700 rounded-lg flex items-center justify-center mr-3 shadow-lg">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.994 15.994 0 011.622-3.395m3.42 3.42a15.995 15.995 0 004.764-4.648l3.876-3.876a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 00-1.5 3.364l-.876 3.876a4.5 4.5 0 004.648 4.764z"></path>
                </svg>
            </div>
            <h2 class="text-xl font-semibold bg-gradient-to-r from-blue-900 to-indigo-800 dark:from-blue-200 dark:to-indigo-200 bg-clip-text text-transparent">Appearance Settings</h2>
        </div>

        <div class="bg-gradient-to-br from-white via-blue-50/30 to-indigo-50/20 rounded-xl dark:from-slate-800 dark:via-blue-900/20 dark:to-indigo-900/20 border border-zinc-200 dark:border-zinc-700 p-6">
            <div class="space-y-4">
                <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-4">Choose your preferred theme</h3>
                <flux:radio.group x-data variant="segmented" x-model="$flux.appearance" class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <flux:radio value="light" icon="sun" class="flex items-center justify-center p-4 rounded-lg border-2 border-zinc-200 dark:border-zinc-700 hover:border-blue-300 dark:hover:border-blue-600 transition-all duration-200">
                        <div class="text-center">
                            <svg class="w-6 h-6 mx-auto mb-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            <span class="text-sm font-medium">Light</span>
                        </div>
                    </flux:radio>
                    <flux:radio value="dark" icon="moon" class="flex items-center justify-center p-4 rounded-lg border-2 border-zinc-200 dark:border-zinc-700 hover:border-blue-300 dark:hover:border-blue-600 transition-all duration-200">
                        <div class="text-center">
                            <svg class="w-6 h-6 mx-auto mb-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                            </svg>
                            <span class="text-sm font-medium">Dark</span>
                        </div>
                    </flux:radio>
                    <flux:radio value="system" icon="computer-desktop" class="flex items-center justify-center p-4 rounded-lg border-2 border-zinc-200 dark:border-zinc-700 hover:border-blue-300 dark:hover:border-blue-600 transition-all duration-200">
                        <div class="text-center">
                            <svg class="w-6 h-6 mx-auto mb-2 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25"></path>
                            </svg>
                            <span class="text-sm font-medium">System</span>
                        </div>
                    </flux:radio>
                </flux:radio.group>
                
                <div class="mt-6 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"></path>
                        </svg>
                        <div>
                            <h4 class="text-sm font-medium text-blue-900 dark:text-blue-100">Theme Information</h4>
                            <p class="text-sm text-blue-700 dark:text-blue-300 mt-1">
                                Choose between light mode, dark mode, or let the system automatically switch based on your device preferences.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
