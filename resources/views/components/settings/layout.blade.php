<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/30 to-indigo-50/20 dark:from-slate-950 dark:via-blue-950/30 dark:to-indigo-950/20">
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <!-- Settings Header -->
        <div class="bg-gradient-to-r from-white via-blue-50/50 to-indigo-50/30 dark:from-slate-900 dark:via-blue-900/20 dark:to-indigo-900/20 rounded-2xl border border-zinc-200 dark:border-zinc-800 mb-8 transition-all duration-300 shadow-xl">
            <div class="p-6 sm:p-8">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 dark:from-blue-600 dark:to-blue-700 rounded-lg flex items-center justify-center mr-4 shadow-lg">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl sm:text-4xl font-semibold bg-gradient-to-r from-blue-900 via-indigo-800 to-purple-800 dark:from-blue-200 dark:via-indigo-200 dark:to-purple-200 bg-clip-text text-transparent">{{ $heading ?? 'Settings' }}</h1>
                        <p class="text-lg text-zinc-600 dark:text-zinc-400 mt-1">{{ $subheading ?? 'Manage your account settings' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Settings Navigation -->
            <div class="lg:w-64 flex-shrink-0">
                <div class="bg-gradient-to-br from-white via-blue-50/30 to-indigo-50/20 rounded-2xl dark:from-slate-900 dark:via-blue-900/20 dark:to-indigo-900/20 border border-zinc-200 dark:border-zinc-800 transition-all duration-300 shadow-xl">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold bg-gradient-to-r from-blue-900 to-indigo-800 dark:from-blue-200 dark:to-indigo-200 bg-clip-text text-transparent mb-4">Settings</h3>
                        <nav class="space-y-2">
                            @if(auth()->user() && auth()->user()->username)
                                <a href="{{ route('user.profile', ['username' => auth()->user()->username]) }}" 
                                   class="flex items-center px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('user.profile') ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-lg' : 'text-zinc-700 hover:bg-blue-50 dark:text-zinc-300 dark:hover:bg-blue-900/20' }}">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"></path>
                                    </svg>
                                    Profile
                                </a>
                                <a href="{{ route('profile.password', ['username' => auth()->user()->username]) }}" 
                                   class="flex items-center px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('profile.password') ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-lg' : 'text-zinc-700 hover:bg-blue-50 dark:text-zinc-300 dark:hover:bg-blue-900/20' }}">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"></path>
                                    </svg>
                                    Password
                                </a>
                                <a href="{{ route('profile.appearance', ['username' => auth()->user()->username]) }}" 
                                   class="flex items-center px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('profile.appearance') ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-lg' : 'text-zinc-700 hover:bg-blue-50 dark:text-zinc-300 dark:hover:bg-blue-900/20' }}">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.994 15.994 0 011.622-3.395m3.42 3.42a15.995 15.995 0 004.764-4.648l3.876-3.876a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 00-1.5 3.364l-.876 3.876a4.5 4.5 0 004.648 4.764z"></path>
                                    </svg>
                                    Appearance
                                </a>
                            @endif
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Settings Content -->
            <div class="flex-1">
                <div class="bg-gradient-to-br from-white via-blue-50/30 to-indigo-50/20 rounded-2xl dark:from-slate-900 dark:via-blue-900/20 dark:to-indigo-900/20 border border-zinc-200 dark:border-zinc-800 transition-all duration-300 shadow-xl">
                    <div class="p-6 sm:p-8">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
