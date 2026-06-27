@props([
    'title'                => 'Be Rooted in Christ',
    'description'          => 'Be Rooted in Christ — a devotional blog anchored in Scripture. Explore faith-building articles on spiritual growth, prayer, and living rooted in Jesus Christ.',
    'keywords'             => 'Christian blog, devotional, Bible study, faith, spiritual growth, Jesus Christ, rooted in Christ, prayer, scripture',
    'robots'               => 'index, follow',
    'canonical'            => null,
    'ogType'               => 'website',
    'ogTitle'              => null,
    'ogDescription'        => null,
    'ogImage'              => null,
    'articlePublishedTime' => null,
    'articleModifiedTime'  => null,
    'articleSection'       => null,
    'articleTags'          => null,
    'twitterCard'          => 'summary_large_image',
    'jsonLd'               => null,
])
<!DOCTYPE html>
<html lang="en" prefix="og: https://ogp.me/ns#">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- ============================================================ --}}
    {{-- SEO: Core Meta Tags --}}
    {{-- ============================================================ --}}
    <title>{{ $title ?? 'Be Rooted in Christ' }}</title>
    <meta name="description" content="{{ $description ?? 'Be Rooted in Christ — a devotional blog anchored in Scripture. Explore faith-building articles on spiritual growth, prayer, and living rooted in Jesus Christ.' }}">
    <meta name="keywords" content="{{ $keywords ?? 'Christian blog, devotional, Bible study, faith, spiritual growth, Jesus Christ, rooted in Christ, prayer, scripture' }}">
    <meta name="author" content="Be Rooted in Christ">
    <meta name="robots" content="{{ $robots ?? 'index, follow' }}">
    <meta name="theme-color" content="#8B5E3C">

    {{-- ============================================================ --}}
    {{-- SEO: Canonical URL --}}
    {{-- ============================================================ --}}
    <link rel="canonical" href="{{ $canonical ?? url()->current() }}">

    {{-- ============================================================ --}}
    {{-- SEO: Open Graph --}}
    {{-- ============================================================ --}}
    <meta property="og:type" content="{{ $ogType ?? 'website' }}">
    <meta property="og:site_name" content="Be Rooted in Christ">
    <meta property="og:title" content="{{ $ogTitle ?? ($title ?? 'Be Rooted in Christ') }}">
    <meta property="og:description" content="{{ $ogDescription ?? ($description ?? 'Be Rooted in Christ — a devotional blog anchored in Scripture.') }}">
    <meta property="og:url" content="{{ $canonical ?? url()->current() }}">
    <meta property="og:image" content="{{ $ogImage ?? asset('images/og-default.jpg') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="{{ $ogTitle ?? ($title ?? 'Be Rooted in Christ') }}">
    <meta property="og:locale" content="en_IN">

    {{-- Article-specific OG tags (only for posts) --}}
    @isset($articlePublishedTime)
    <meta property="article:published_time" content="{{ $articlePublishedTime }}">
    @endisset
    @isset($articleModifiedTime)
    <meta property="article:modified_time" content="{{ $articleModifiedTime }}">
    @endisset
    @isset($articleSection)
    <meta property="article:section" content="{{ $articleSection }}">
    @endisset
    @isset($articleTags)
        @foreach($articleTags as $tag)
        <meta property="article:tag" content="{{ $tag }}">
        @endforeach
    @endisset

    {{-- ============================================================ --}}
    {{-- SEO: Twitter / X Cards --}}
    {{-- ============================================================ --}}
    <meta name="twitter:card" content="{{ $twitterCard ?? 'summary_large_image' }}">
    <meta name="twitter:title" content="{{ $ogTitle ?? ($title ?? 'Be Rooted in Christ') }}">
    <meta name="twitter:description" content="{{ $ogDescription ?? ($description ?? 'Be Rooted in Christ — a devotional blog anchored in Scripture.') }}">
    <meta name="twitter:image" content="{{ $ogImage ?? asset('images/og-default.jpg') }}">
    <meta name="twitter:image:alt" content="{{ $ogTitle ?? ($title ?? 'Be Rooted in Christ') }}">

    @verbatim
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebSite",
        "@id": "https://berootedinchrist.com/#website",
        "name": "Be Rooted in Christ",
        "alternateName": "Be Rooted in Christ Blog",
        "url": "https://berootedinchrist.com",
        "description": "A devotional blog anchored in Scripture. Explore faith-building articles on spiritual growth, prayer, and living rooted in Jesus Christ.",
        "inLanguage": "en-IN",
        "potentialAction": {
            "@type": "SearchAction",
            "target": { "@type": "EntryPoint", "urlTemplate": "https://berootedinchrist.com/?search={search_term_string}" },
            "query-input": "required name=search_term_string"
        },
        "publisher": {
            "@type": "Organization",
            "@id": "https://berootedinchrist.com/#organization",
            "name": "Be Rooted in Christ",
            "url": "https://berootedinchrist.com",
            "logo": { "@type": "ImageObject", "url": "https://berootedinchrist.com/images/og-default.jpg", "width": 1200, "height": 630 }
        }
    }
    </script>
    @endverbatim

    {{-- Per-page JSON-LD (BlogPosting, Blog, AboutPage, ContactPage, etc.) --}}
    @isset($jsonLd)
    {!! $jsonLd !!}
    @endisset

    {{-- ============================================================ --}}
    {{-- Favicons --}}
    {{-- ============================================================ --}}
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">

    {{-- ============================================================ --}}
    {{-- Performance: Google Fonts --}}
    {{-- ============================================================ --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

    {{-- Custom stylesheet --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @livewireStyles

    {{-- Dark Mode Init (prevents flash) --}}
    <script>
        const savedTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-theme', savedTheme);
    </script>
</head>
<body>

    <!-- Header Branding & Navigation -->
    <header>
        <div class="container header-inner">
            <a href="/" class="brand-wrapper">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="site-logo">
                <div class="site-title-group">
                    <span class="site-title">Be Rooted in Christ</span>
                    <span class="site-subtitle">Planted to Prevail &amp; Produce</span>
                </div>
            </a>

            <div class="nav-wrapper">
                <nav aria-label="Main navigation">
                    <a href="/" class="{{ request()->is('/') ? 'active' : '' }}" aria-current="{{ request()->is('/') ? 'page' : 'false' }}">Home</a>
                    <a href="/about" class="{{ request()->is('about') ? 'active' : '' }}" aria-current="{{ request()->is('about') ? 'page' : 'false' }}">About</a>
                    <a href="/contact" class="{{ request()->is('contact') ? 'active' : '' }}" aria-current="{{ request()->is('contact') ? 'page' : 'false' }}">Contact</a>
                </nav>

                <button id="themeToggle" class="theme-toggle-btn" aria-label="Toggle dark mode" onclick="toggleTheme()">
                    <svg class="sun-icon" style="display: none; width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-12.728l.707.707m12.728 12.728l.707.707M12 8a4 4 0 100 8 4 4 0 000-8z" />
                    </svg>
                    <svg class="moon-icon" style="display: none; width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main id="main-content">
        {{ $slot }}
    </main>

    <!-- Site Footer -->
    <footer>
        <div class="container">
            <p>&copy; {{ date('Y') }} Be Rooted in Christ. Planted to Prevail &amp; Produce.</p>
            <p style="font-size: 0.8rem; margin-top: 6px; opacity: 0.8;">
                Designed and maintained by <a href="https://leenaitsolutions.in" target="_blank" rel="noopener" style="text-decoration: underline; color: var(--accent-color);">LITS</a>
            </p>
            <p style="font-size: 0.8rem; margin-top: 8px; color: var(--accent-color); font-family: var(--font-heading); font-style: italic;">
                "As ye have therefore received Christ Jesus the Lord, so walk ye in him: Rooted and built up in him, and stablished in the faith..." — Colossians 2:6-7
            </p>
            <nav aria-label="Footer navigation" style="margin-top: 12px; font-size: 0.85rem;">
                <a href="/" style="margin: 0 10px;">Home</a>
                <a href="/about" style="margin: 0 10px;">About</a>
                <a href="/contact" style="margin: 0 10px;">Contact</a>
                @auth
                    <a href="/admin/dashboard" style="margin: 0 10px; font-weight: 600; color: var(--accent-color);">Dashboard</a>
                @else
                    <a href="/login" style="margin: 0 10px; opacity: 0.8;">Login</a>
                @endauth
            </nav>
        </div>
    </footer>

    @livewireScripts

    <script>
        function updateThemeIcons(theme) {
            const sunIcon = document.querySelector('.sun-icon');
            const moonIcon = document.querySelector('.moon-icon');
            if (theme === 'dark') {
                sunIcon.style.display = 'block';
                moonIcon.style.display = 'none';
            } else {
                sunIcon.style.display = 'none';
                moonIcon.style.display = 'block';
            }
        }
        function toggleTheme() {
            const currentTheme = document.documentElement.getAttribute('data-theme') || 'light';
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateThemeIcons(newTheme);
        }
        updateThemeIcons(document.documentElement.getAttribute('data-theme'));
    </script>
</body>
</html>
