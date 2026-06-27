@php
    $siteTitle = \App\Models\Setting::getVal('site_title', 'Be Rooted in Christ');
    $siteSubtitle = \App\Models\Setting::getVal('site_subtitle', 'Planted to Prevail & Produce');
    $siteLogoSetting = \App\Models\Setting::getVal('site_logo');
    $siteLogo = $siteLogoSetting ? asset($siteLogoSetting) : asset('images/logo.png');

    $useLogoAsFavicon = (bool) \App\Models\Setting::getVal('use_logo_as_favicon', '0');
    $siteFaviconSetting = \App\Models\Setting::getVal('site_favicon');
    
    if ($useLogoAsFavicon && $siteLogoSetting) {
        $faviconUrl = asset($siteLogoSetting);
    } elseif ($siteFaviconSetting) {
        $faviconUrl = asset($siteFaviconSetting);
    } else {
        $faviconUrl = asset('favicon.png');
    }
@endphp
@props([
    'title'                => null,
    'description'          => null,
    'keywords'             => null,
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
@php
    $resolvedTitle = $title ?? $siteTitle;
    $resolvedDescription = $description ?? ($siteTitle . ' — a devotional blog anchored in Scripture. Explore faith-building articles on spiritual growth, prayer, and living rooted in Jesus Christ.');
    $resolvedKeywords = $keywords ?? ('Christian blog, devotional, Bible study, faith, spiritual growth, Jesus Christ, rooted in Christ, prayer, scripture');
@endphp
<!DOCTYPE html>
<html lang="en" prefix="og: https://ogp.me/ns#">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- ============================================================ --}}
    {{-- SEO: Core Meta Tags --}}
    {{-- ============================================================ --}}
    <title>{{ $resolvedTitle }}</title>
    <meta name="description" content="{{ $resolvedDescription }}">
    <meta name="keywords" content="{{ $resolvedKeywords }}">
    <meta name="author" content="{{ $siteTitle }}">
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
    <meta property="og:site_name" content="{{ $siteTitle }}">
    <meta property="og:title" content="{{ $ogTitle ?? $resolvedTitle }}">
    <meta property="og:description" content="{{ $ogDescription ?? $resolvedDescription }}">
    <meta property="og:url" content="{{ $canonical ?? url()->current() }}">
    <meta property="og:image" content="{{ $ogImage ?? asset('images/og-default.jpg') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="{{ $ogTitle ?? $resolvedTitle }}">
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
    <meta name="twitter:title" content="{{ $ogTitle ?? $resolvedTitle }}">
    <meta name="twitter:description" content="{{ $ogDescription ?? $resolvedDescription }}">
    <meta name="twitter:image" content="{{ $ogImage ?? asset('images/og-default.jpg') }}">
    <meta name="twitter:image:alt" content="{{ $ogTitle ?? $resolvedTitle }}">

    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "WebSite",
        "@@id": "{{ url('/') }}/#website",
        "name": "{{ $siteTitle }}",
        "alternateName": "{{ $siteTitle }} Blog",
        "url": "{{ url('/') }}",
        "description": "{{ $resolvedDescription }}",
        "inLanguage": "en-IN",
        "potentialAction": {
            "@@type": "SearchAction",
            "target": { "@@type": "EntryPoint", "urlTemplate": "{{ url('/') }}/?search={search_term_string}" },
            "query-input": "required name=search_term_string"
        },
        "publisher": {
            "@@type": "Organization",
            "@@id": "{{ url('/') }}/#organization",
            "name": "{{ $siteTitle }}",
            "url": "{{ url('/') }}",
            "logo": { 
                "@@type": "ImageObject", 
                "url": "{{ $siteLogo }}", 
                "width": 150, 
                "height": 50 
            }
        }
    }
    </script>

    {{-- Per-page JSON-LD (BlogPosting, Blog, AboutPage, ContactPage, etc.) --}}
    @isset($jsonLd)
    {!! $jsonLd !!}
    @endisset

    {{-- ============================================================ --}}
    {{-- Favicons --}}
    {{-- ============================================================ --}}
    <link rel="icon" type="image/png" href="{{ $faviconUrl }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ $faviconUrl }}">

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
                <img src="{{ $siteLogo }}" alt="Logo" class="site-logo">
                <div class="site-title-group">
                    <span class="site-title">{{ $siteTitle }}</span>
                    <span class="site-subtitle">{{ $siteSubtitle }}</span>
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
            <p>&copy; {{ date('Y') }} {{ $siteTitle }}. {{ $siteSubtitle }}.</p>
            <p style="font-size: 0.8rem; margin-top: 6px; opacity: 0.8;">
                Designed and maintained by <a href="https://leenaitsolutions.in" target="_blank" rel="noopener" style="text-decoration: underline; color: var(--accent-color);">LITS</a>
            </p>
            <p style="font-size: 0.8rem; margin-top: 8px; color: var(--accent-color); font-family: var(--font-heading); font-style: italic;">
                "As ye have therefore received Christ Jesus the Lord, so walk ye in him: Rooted and built up in him, and stablished in the faith..." — Colossians 2:6-7
            </p>

            @php
                $fb = \App\Models\Setting::getVal('facebook_link');
                $ig = \App\Models\Setting::getVal('instagram_link');
                $tw = \App\Models\Setting::getVal('twitter_link');
                $yt = \App\Models\Setting::getVal('youtube_link');
                $pin = \App\Models\Setting::getVal('pinterest_link');
            @endphp
            @if ($fb || $ig || $tw || $yt || $pin)
                <div class="footer-social-links" style="margin-top: 16px; margin-bottom: 8px; display: flex; justify-content: center; gap: 18px; align-items: center;">
                    @if ($fb)
                        <a href="{{ $fb }}" target="_blank" rel="noopener" aria-label="Facebook" style="color: var(--text-muted); transition: var(--transition); display: flex; align-items: center;" onmouseover="this.style.color='var(--accent-color)'" onmouseout="this.style.color='var(--text-muted)'">
                            <svg style="width: 20px; height: 20px;" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3v3h-3v6.95c4.56-.93 8-4.96 8-9.75z"/></svg>
                        </a>
                    @endif
                    @if ($ig)
                        <a href="{{ $ig }}" target="_blank" rel="noopener" aria-label="Instagram" style="color: var(--text-muted); transition: var(--transition); display: flex; align-items: center;" onmouseover="this.style.color='var(--accent-color)'" onmouseout="this.style.color='var(--text-muted)'">
                            <svg style="width: 20px; height: 20px;" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.051C.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                        </a>
                    @endif
                    @if ($tw)
                        <a href="{{ $tw }}" target="_blank" rel="noopener" aria-label="Twitter / X" style="color: var(--text-muted); transition: var(--transition); display: flex; align-items: center;" onmouseover="this.style.color='var(--accent-color)'" onmouseout="this.style.color='var(--text-muted)'">
                            <svg style="width: 20px; height: 20px;" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        </a>
                    @endif
                    @if ($yt)
                        <a href="{{ $yt }}" target="_blank" rel="noopener" aria-label="YouTube" style="color: var(--text-muted); transition: var(--transition); display: flex; align-items: center;" onmouseover="this.style.color='var(--accent-color)'" onmouseout="this.style.color='var(--text-muted)'">
                            <svg style="width: 20px; height: 20px;" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.163a3.003 3.003 0 00-2.11-2.11C19.518 3.545 12 3.545 12 3.545s-7.518 0-9.388.508a3.003 3.003 0 00-2.11 2.11C0 8.033 0 12 0 12s0 3.967.502 5.837a3.003 3.003 0 002.11 2.11c1.87.508 9.388.508 9.388.508s7.518 0 9.388-.508a3.003 3.003 0 002.11-2.11C24 15.967 24 12 24 12s0-3.967-.502-5.837zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        </a>
                    @endif
                    @if ($pin)
                        <a href="{{ $pin }}" target="_blank" rel="noopener" aria-label="Pinterest" style="color: var(--text-muted); transition: var(--transition); display: flex; align-items: center;" onmouseover="this.style.color='var(--accent-color)'" onmouseout="this.style.color='var(--text-muted)'">
                            <svg style="width: 20px; height: 20px;" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.373 0 0 5.372 0 12c0 5.084 3.163 9.426 7.627 11.174-.105-.949-.2-2.405.042-3.441.218-.937 1.407-5.965 1.407-5.965s-.359-.719-.359-1.782c0-1.668.967-2.914 2.171-2.914 1.023 0 1.518.769 1.518 1.69 0 1.029-.655 2.568-.994 3.995-.283 1.194.599 2.169 1.777 2.169 2.133 0 3.772-2.249 3.772-5.495 0-2.873-2.064-4.882-5.012-4.882-3.414 0-5.418 2.561-5.418 5.207 0 1.031.397 2.138.893 2.738.098.119.112.224.083.345l-.333 1.36c-.053.22-.174.267-.402.161-1.499-.698-2.436-2.889-2.436-4.649 0-3.785 2.75-7.262 7.929-7.262 4.163 0 7.398 2.967 7.398 6.931 0 4.136-2.607 7.464-6.227 7.464-1.216 0-2.359-.631-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24 12 24c6.627 0 12-5.373 12-12 0-6.628-5.373-12-12-12z"/></svg>
                        </a>
                    @endif
                </div>
            @endif

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
