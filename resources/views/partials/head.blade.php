<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>{{ $title ?? config('app.name') }}</title>

<!-- SEO Meta Tags -->
<meta name="description" content="{{ $description ?? 'A modern, professional blog platform where you can share your thoughts, connect with readers, and build your community.' }}" />
<meta name="keywords" content="{{ $keywords ?? 'blog, writing, community, articles, posts, modern blog platform' }}" />
<meta name="author" content="{{ $author ?? config('app.name') }}" />
<meta name="robots" content="{{ $robots ?? 'index, follow' }}" />

<!-- Open Graph Meta Tags -->
<meta property="og:title" content="{{ $title ?? config('app.name') }}" />
<meta property="og:description" content="{{ $description ?? 'A modern, professional blog platform where you can share your thoughts, connect with readers, and build your community.' }}" />
<meta property="og:type" content="{{ $ogType ?? 'website' }}" />
<meta property="og:url" content="{{ $ogUrl ?? request()->url() }}" />
<meta property="og:image" content="{{ $ogImage ?? asset('favicon.svg') }}" />
<meta property="og:site_name" content="{{ config('app.name') }}" />

<!-- Twitter Card Meta Tags -->
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="{{ $title ?? config('app.name') }}" />
<meta name="twitter:description" content="{{ $description ?? 'A modern, professional blog platform where you can share your thoughts, connect with readers, and build your community.' }}" />
<meta name="twitter:image" content="{{ $ogImage ?? asset('favicon.svg') }}" />

<!-- Additional SEO -->
<meta name="theme-color" content="#3b82f6" />
<meta name="msapplication-TileColor" content="#3b82f6" />
<link rel="canonical" href="{{ request()->url() }}" />
<meta name="csrf-token" content="{{ csrf_token() }}" />

<!-- Favicons -->
<link rel="icon" href="/favicon.ico" sizes="any">
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">

<!-- Fonts -->
<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

<!-- Assets -->
@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance
