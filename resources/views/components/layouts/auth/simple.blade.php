<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white antialiased dark:bg-zinc-950">
        <div class="flex min-h-screen">
            <!-- Left Panel - Form -->
            <div class="flex w-full flex-col justify-center px-6 py-12 lg:w-1/2 lg:px-16 xl:px-24 2xl:px-32 relative">
                <!-- Professional Background -->
                <div class="absolute inset-0 bg-gray-50 dark:bg-zinc-950"></div>
                
                <div class="relative mx-auto w-full max-w-md">
                    <!-- Logo -->
                    <div class="mb-12">
                        <a href="{{ route('home') }}" class="inline-flex items-center gap-3 group" wire:navigate>
                            <img src="{{ asset('logos/logo.png') }}" alt="{{ config('app.name') }}" class="h-12 w-12 rounded-lg object-contain shadow-lg group-hover:shadow-xl transition-all duration-200" />
                            <div class="flex flex-col">
                                <span class="text-xl font-semibold bg-clip-text text-transparent bg-gradient-to-r from-blue-900 via-indigo-800 to-purple-800 dark:from-blue-200 dark:via-indigo-200 dark:to-purple-200">{{ config('app.name') }}</span>
                                <span class="text-xs text-zinc-600 dark:text-zinc-400">Professional Publishing Platform</span>
                            </div>
                        </a>
                    </div>

                    <!-- Main Content -->
                    <div class="flex flex-col">
                        {{ $slot }}
                    </div>

                    <!-- Footer -->
                    <div class="mt-10 text-center">
                        <p class="text-xs text-zinc-500 dark:text-zinc-400">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
                        <div class="flex items-center justify-center gap-4 mt-3">
                            <a href="#" class="text-xs text-zinc-500 dark:text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-300 transition-colors">Privacy Policy</a>
                            <span class="text-zinc-300 dark:text-zinc-700">•</span>
                            <a href="#" class="text-xs text-zinc-500 dark:text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-300 transition-colors">Terms of Service</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Panel - Professional Hero -->
            <div class="hidden lg:flex lg:w-1/2 bg-zinc-900 dark:bg-zinc-800 relative overflow-hidden">
                <!-- Subtle Grid Pattern -->
                <div class="absolute inset-0 opacity-5">
                    <div class="absolute inset-0" style="background-image: radial-gradient(circle at 25px 25px, white 2px, transparent 0), radial-gradient(circle at 75px 75px, white 2px, transparent 0); background-size: 50px 50px; background-position: 0 0, 25px 25px;"></div>
                </div>

                <!-- Content -->
                <div class="relative flex flex-col justify-center text-white p-16 xl:p-20 w-full">
                    <div class="max-w-md space-y-8">
                        <!-- Professional Header -->
                        <div class="space-y-4">
                            <div class="inline-flex items-center px-3 py-1 bg-zinc-800 rounded-full text-sm text-zinc-300 border border-zinc-700">
                                Best Blogging Platform
                            </div>
                            
                            <h1 class="text-3xl font-medium leading-tight text-white">
                                Professional Blog Management for Writers
                            </h1>
                            <p class="text-lg text-zinc-400 leading-relaxed">
                                Streamline your editorial workflow with enterprise-grade tools designed for professional content creators and publishing teams.
                            </p>
                        </div>

                        <!-- Professional Features -->
                        <div class="space-y-6 pt-4">
                            <div class="flex items-start gap-4">
                                <div class="flex h-10 w-10 items-center justify-center rounded-md bg-zinc-800 border border-zinc-700 flex-shrink-0">
                                    <svg class="w-5 h-5 text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-medium text-white">Editorial Workflow</h3>
                                    <p class="text-sm text-zinc-400 mt-1">Advanced content management with version control and collaboration tools</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div class="flex h-10 w-10 items-center justify-center rounded-md bg-zinc-800 border border-zinc-700 flex-shrink-0">
                                    <svg class="w-5 h-5 text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-medium text-white">Analytics & Insights</h3>
                                    <p class="text-sm text-zinc-400 mt-1">Comprehensive performance metrics and audience engagement data</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div class="flex h-10 w-10 items-center justify-center rounded-md bg-zinc-800 border border-zinc-700 flex-shrink-0">
                                    <svg class="w-5 h-5 text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-medium text-white">Enterprise Security</h3>
                                    <p class="text-sm text-zinc-400 mt-1">Bank-level security with advanced access controls and data protection</p>
                                </div>
                            </div>
                        </div>

                        <!-- Professional Quote -->
                        <div class="mt-12 p-5 bg-zinc-800/50 backdrop-blur rounded-lg border border-zinc-700">
                            <div class="flex items-start gap-3 mb-3">
                                <div class="h-10 w-10 rounded bg-zinc-700 flex items-center justify-center text-white font-medium text-sm">
                                    DK
                                </div>
                                <div>
                                    <div class="font-medium text-white text-sm">Sheldon Cooper</div>
                                    <div class="text-xs text-zinc-400">Content Director, Digital Publishing Co.</div>
                                </div>
                            </div>
                            <p class="text-sm text-zinc-300 leading-relaxed">
                                "BlogSuite transformed our editorial workflow. The advanced publishing tools and team collaboration features saved us countless hours."
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @fluxScripts
    </body>
</html>
