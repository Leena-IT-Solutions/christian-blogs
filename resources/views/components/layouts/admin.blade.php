@php
    $siteTitle = \App\Models\Setting::getVal('site_title', 'Be Rooted in Christ');
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Dashboard - ' . $siteTitle }}</title>
    
    <!-- Favicons -->
    <link rel="icon" type="image/png" href="{{ $faviconUrl }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ $faviconUrl }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    
    <!-- Admin stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    
    @livewireStyles
</head>
<body>

    <div class="admin-layout">
        <!-- Mobile Top Bar Header -->
        <div class="admin-mobile-header">
            <button id="adminMenuOpen" class="admin-hamburger-btn" aria-label="Open navigation menu">
                <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            
            <div class="admin-mobile-logo" style="display: flex; align-items: center; gap: 8px;">
                <img src="{{ $siteLogo }}" alt="Logo" style="height: 32px; width: auto; object-fit: contain;">
                <span style="font-family: var(--font-heading); font-weight: 700; color: #ffffff; font-size: 1.1rem; letter-spacing: 0.5px;">Rooted Admin</span>
            </div>
            
            <div class="admin-mobile-logout">
                <form action="{{ route('admin.logout') }}" method="POST" onsubmit="return confirm('Are you sure you want to log out?');">
                    @csrf
                    <button type="submit" class="admin-logout-icon-btn" aria-label="Log Out">
                        <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>

        <!-- Sidebar Drawer Backdrop -->
        <div id="adminSidebarBackdrop" class="admin-sidebar-backdrop"></div>

        <!-- Sidebar Navigation Drawer -->
        <aside id="adminSidebar" class="admin-sidebar">
            <button id="adminMenuClose" class="admin-drawer-close-btn" aria-label="Close navigation menu">
                &times;
            </button>

            <div class="admin-logo" style="display: flex; flex-direction: column; align-items: center; gap: 8px;">
                <img src="{{ $siteLogo }}" alt="Logo" style="max-height: 50px; max-width: 100%; width: auto; object-fit: contain;">
                <div style="font-size: 1.2rem; font-weight: 700; margin-top: 4px;">Rooted<span>Admin</span></div>
            </div>
            
            <ul class="admin-nav">
                <li class="admin-nav-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                    <a href="/admin/dashboard">
                        <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z" />
                        </svg>
                        Dashboard
                    </a>
                </li>
                <li class="admin-nav-item {{ request()->is('admin/categories') ? 'active' : '' }}">
                    <a href="/admin/categories">
                        <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                        </svg>
                        Categories
                    </a>
                </li>
                <li class="admin-nav-item {{ request()->is('admin/posts*') ? 'active' : '' }}">
                    <a href="/admin/posts">
                        <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2 2 0 00-.586-1.414l-4.5-4.5A2 2 0 0014.586 3H13" />
                        </svg>
                        Posts
                    </a>
                </li>
                <li class="admin-nav-item {{ request()->is('admin/comments') ? 'active' : '' }}">
                    <a href="/admin/comments">
                        <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        Comments
                    </a>
                </li>
                <li class="admin-nav-item {{ request()->is('admin/messages') ? 'active' : '' }}">
                    <a href="/admin/messages">
                        <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Messages
                    </a>
                </li>
                <li class="admin-nav-item {{ request()->is('admin/settings') ? 'active' : '' }}">
                    <a href="/admin/settings">
                        <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Settings
                    </a>
                </li>
                <li class="admin-nav-item" style="margin-top: 12px; border-top: 1px dashed var(--admin-border); padding-top: 12px;">
                    <a href="/" target="_blank">
                        <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                        Go to Website
                    </a>
                </li>
            </ul>
            
            <div class="admin-logout">
                <form action="{{ route('admin.logout') }}" method="POST" onsubmit="return confirm('Are you sure you want to log out?');">
                    @csrf
                    <button type="submit">
                        <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span>Log Out</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Dashboard View Area -->
        <main class="admin-main">
            {{ $slot }}
        </main>
    </div>

    @livewireScripts

    <script>
        const adminSidebar = document.getElementById('adminSidebar');
        const adminSidebarBackdrop = document.getElementById('adminSidebarBackdrop');
        const adminMenuOpen = document.getElementById('adminMenuOpen');
        const adminMenuClose = document.getElementById('adminMenuClose');

        function openDrawer() {
            adminSidebar.classList.add('open');
            adminSidebarBackdrop.classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        function closeDrawer() {
            adminSidebar.classList.remove('open');
            adminSidebarBackdrop.classList.remove('open');
            document.body.style.overflow = '';
        }

        if (adminMenuOpen) adminMenuOpen.addEventListener('click', openDrawer);
        if (adminMenuClose) adminMenuClose.addEventListener('click', closeDrawer);
        if (adminSidebarBackdrop) adminSidebarBackdrop.addEventListener('click', closeDrawer);
        
        // Auto-close drawer on Livewire page transitions (if any navigations trigger updates)
        document.addEventListener('livewire:navigating', closeDrawer);
    </script>
</body>
</html>
