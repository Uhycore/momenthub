<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'MomentHub') }} – Admin</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: #F2F2F0;
            color: #1a1a1a;
            display: flex;
            min-height: 100vh;
        }

        /* ─── SIDEBAR ─────────────────────────────── */
        #sidebar {
            width: 220px;
            min-height: 100vh;
            background: #ffffff;
            border-right: 1px solid #e8e8e6;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            z-index: 50;
        }

        /* Brand */
        .sb-brand {
            padding: 22px 20px 18px;
            border-bottom: 1px solid #eeeeec;
        }

        .sb-brand-name {
            font-size: 14px;
            font-weight: 800;
            letter-spacing: -0.01em;
            color: #111;
        }

        .sb-brand-sub {
            font-size: 9px;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: #aaa;
            margin-top: 2px;
        }

        /* User section */
        .sb-user {
            padding: 14px 20px;
            border-bottom: 1px solid #eeeeec;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sb-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: #e8e8e6;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            overflow: hidden;
        }

        .sb-avatar svg {
            color: #888;
        }

        .sb-user-name {
            font-size: 12.5px;
            font-weight: 600;
            color: #111;
            line-height: 1.2;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sb-user-role {
            font-size: 10px;
            color: #aaa;
            margin-top: 1px;
        }

        /* Nav */
        .sb-nav {
            padding: 10px 0;
            flex: 1;
            overflow-y: auto;
        }

        .sb-nav-section {
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: #ccc;
            padding: 14px 20px 6px;
        }

        .sb-nav a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 20px;
            font-size: 12.5px;
            font-weight: 500;
            color: #777;
            text-decoration: none;
            border-left: 2.5px solid transparent;
            transition: all 0.15s;
        }

        .sb-nav a:hover {
            color: #222;
            background: #f7f7f5;
            border-left-color: #ddd;
        }

        .sb-nav a.active {
            color: #111;
            font-weight: 700;
            border-left-color: #f5c518;
            background: #fffbe6;
        }

        .sb-nav a svg {
            width: 15px;
            height: 15px;
            flex-shrink: 0;
            opacity: 0.5;
        }

        .sb-nav a:hover svg {
            opacity: 0.75;
        }

        .sb-nav a.active svg {
            opacity: 1;
        }

        /* Bottom */
        .sb-bottom {
            padding: 14px 16px;
            border-top: 1px solid #eeeeec;
        }

        .sb-new-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            width: 100%;
            padding: 10px 0;
            background: #111;
            color: #fff;
            font-size: 12px;
            font-weight: 600;
            border-radius: 9px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: background 0.15s;
            font-family: inherit;
        }

        .sb-new-btn:hover {
            background: #333;
        }

        /* ─── TOPBAR ──────────────────────────────── */
        #topbar {
            position: fixed;
            top: 0;
            left: 220px;
            right: 0;
            height: 60px;
            background: #F2F2F0;
            border-bottom: 1px solid #e4e4e2;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
            z-index: 40;
        }

        .topbar-title h1 {
            font-size: 18px;
            font-weight: 700;
            color: #111;
            letter-spacing: -0.02em;
            line-height: 1.2;
        }

        .topbar-title p {
            font-size: 11px;
            color: #aaa;
            margin-top: 1px;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        

        .topbar-user {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            padding: 5px 10px;
            border-radius: 8px;
            transition: background 0.13s;
        }

        .topbar-user:hover {
            background: #e8e8e6;
        }

        .topbar-user-avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: #e4e4e2;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .topbar-user-name {
            font-size: 12.5px;
            font-weight: 600;
            color: #111;
        }

        /* ─── MAIN ────────────────────────────────── */
        #main {
            margin-left: 220px;
            margin-top: 60px;
            flex: 1;
            padding: 32px 36px 48px;
            width: calc(100% - 220px);
            min-height: calc(100vh - 60px);
        }

        /* Alerts */
        .alert-success {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 11px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 13px;
        }

        .alert-error {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 11px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 13px;
        }
    </style>
</head>

<body>

    {{-- ═══ SIDEBAR ═══════════════════════════════════════════ --}}
    <aside id="sidebar">

        {{-- Brand --}}
        <div class="sb-brand">
            <div class="sb-brand-name">MomentHub</div>
            <div class="sb-brand-sub">Admin Panel</div>
        </div>

        {{-- User --}}
        <div class="sb-user">
            <div class="sb-avatar">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.8">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                    <circle cx="12" cy="7" r="4" />
                </svg>
            </div>
            <div style="min-width:0;">
                <div class="sb-user-name">{{ Auth::user()->name ?? 'Admin' }}</div>
                <div class="sb-user-role">MomentHub Admin</div>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="sb-nav">

            <div class="sb-nav-section">Menu</div>

            <a href="{{ route('admin.dashboard') }}"
                class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <rect x="3" y="3" width="7" height="7" rx="1" stroke-width="2" />
                    <rect x="14" y="3" width="7" height="7" rx="1" stroke-width="2" />
                    <rect x="3" y="14" width="7" height="7" rx="1" stroke-width="2" />
                    <rect x="14" y="14" width="7" height="7" rx="1" stroke-width="2" />
                </svg>
                Ringkasan
            </a>

            <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" stroke-linecap="round" stroke-linejoin="round" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M23 21v-2a4 4 0 0 0-3-3.87" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 3.13a4 4 0 0 1 0 7.75" />
                </svg>
                Pengguna
            </a>

            <a href="{{ route('admin.posts.index') }}" class="{{ request()->routeIs('admin.posts*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M14 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Manajemen Postingan
            </a>

            <a href="{{ route('admin.price.index') }}"
                class="{{ request()->routeIs('admin.price*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Manajemen Harga
            </a>

            <a href="{{ route('admin.bookings.index') }}"
                class="{{ request()->routeIs('admin.bookings*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Manajemen Pemesanan
            </a>

        </nav>

        {{-- Logout --}}
        <div class="sb-bottom">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sb-new-btn">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Log Out
                </button>
            </form>
        </div>
    </aside>

    {{-- ═══ TOPBAR ══════════════════════════════════════════════ --}}
    <header id="topbar">
        <div class="topbar-title">
            <h1>@yield('page-title', 'Dashboard Ringkasan')</h1>
            <p>@yield('page-subtitle', now()->translatedFormat('l, d F Y'))</p>
        </div>
        <div class="topbar-right">
            
            <div class="topbar-user" onclick="document.querySelector('.sb-bottom form').submit()">
                <div class="topbar-user-avatar">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#888"
                        stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                </div>
                <span class="topbar-user-name">{{ Auth::user()->name ?? 'Admin' }}</span>
            </div>
        </div>
    </header>

    {{-- ═══ MAIN CONTENT ════════════════════════════════════════ --}}
    <main id="main">

        @if (session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        @yield('content')

    </main>

</body>

</html>
