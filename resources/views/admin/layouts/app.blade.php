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
            width: 180px;
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
            padding: 22px 18px 18px;
            border-bottom: 1px solid #eeeeec;
        }

        .sb-brand-name {
            font-size: 13.5px;
            font-weight: 700;
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
            padding: 16px 18px;
            border-bottom: 1px solid #eeeeec;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sb-avatar {
            width: 36px;
            height: 36px;
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
            font-size: 12px;
            font-weight: 600;
            color: #111;
            line-height: 1.2;
        }

        .sb-user-role {
            font-size: 10px;
            color: #aaa;
            margin-top: 1px;
        }

        /* Nav */
        .sb-nav {
            padding: 12px 0;
            flex: 1;
            overflow-y: auto;
        }

        .sb-nav a {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 9px 18px;
            font-size: 11.5px;
            font-weight: 500;
            color: #888;
            text-decoration: none;
            border-left: 2.5px solid transparent;
            transition: all 0.15s;
            white-space: nowrap;
        }

        .sb-nav a:hover {
            color: #222;
            background: #f7f7f5;
        }

        .sb-nav a.active {
            color: #111;
            font-weight: 600;
            border-left-color: #e8a000;
            background: #fdf8ee;
        }

        .sb-nav a svg {
            width: 15px;
            height: 15px;
            flex-shrink: 0;
            opacity: 0.55;
        }

        .sb-nav a.active svg {
            opacity: 1;
        }

        /* Sesi Baru button */
        .sb-bottom {
            padding: 16px 14px;
            border-top: 1px solid #eeeeec;
        }

        .sb-new-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            width: 100%;
            padding: 10px 0;
            background: #111;
            color: #fff;
            font-size: 11.5px;
            font-weight: 600;
            border-radius: 8px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: background 0.15s;
        }

        .sb-new-btn:hover {
            background: #333;
        }

        /* ─── TOPBAR ──────────────────────────────── */
        #topbar {
            position: fixed;
            top: 0;
            left: 180px;
            right: 0;
            height: 64px;
            background: #F2F2F0;
            border-bottom: 1px solid #e4e4e2;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 36px;
            z-index: 40;
        }

        .topbar-title h1 {
            font-size: 20px;
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
            gap: 14px;
        }

        .topbar-bell {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: #fff;
            border: 1px solid #e4e4e2;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: border-color 0.15s;
        }

        .topbar-bell:hover {
            border-color: #ccc;
        }

        .topbar-bell svg {
            width: 16px;
            height: 16px;
            color: #555;
        }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .topbar-user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #e4e4e2;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .topbar-user-name {
            font-size: 13px;
            font-weight: 600;
            color: #111;
        }

        /* ─── MAIN ────────────────────────────────── */
        #main {
            margin-left: 180px;
            margin-top: 64px;
            flex: 1;
            padding: 32px 36px 48px;
            width: calc(100% - 180px);
            min-height: calc(100vh - 64px);
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
            <div class="sb-brand-name">{{ config('app.name', 'MomentHub') }}</div>
            <div class="sb-brand-sub">Admin Panel</div>
        </div>

        {{-- User --}}
        <div class="sb-user">
            <div class="sb-avatar">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.8">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                    <circle cx="12" cy="7" r="4" />
                </svg>
            </div>
            <div>
                <div class="sb-user-name">{{ Auth::user()->name ?? 'Admin' }}</div>
                <div class="sb-user-role">MomentHub Admin</div>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="sb-nav">

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
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Pengguna
            </a>

            <a href="{{ route('admin.posts.index') }}"
                class="{{ request()->routeIs('admin.posts*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M14 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Manajemen Postingan
            </a>

            <a href="{{ route('admin.price.index') }}"
                class="{{ request()->routeIs('admin.price*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Manajemen Harga
            </a>

            <a href="{{ route('admin.bookings.index') }}"
                class="{{ request()->routeIs('admin.bookings*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Manajemen Pemesanan
            </a>

        </nav>

        {{-- CTA Button --}}
        <div class="sb-bottom">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sb-new-btn" style="width:100%; border:none; cursor:pointer;">
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
            <div class="topbar-bell">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                    <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                </svg>
            </div>
            <div class="topbar-user" onclick="document.getElementById('logout-form').submit()">
                <div class="topbar-user-avatar">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#888"
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
