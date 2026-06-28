<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'MomentHub') }} — @yield('title', 'Dashboard')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
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
            font-family: 'Figtree', sans-serif;
            background: #F2F2F0;
            color: #111;
            display: flex;
            min-height: 100vh;
        }

        /* ════ SIDEBAR ════════════════════════════════════ */
        #u-sidebar {
            width: 195px;
            min-height: 100vh;
            background: #fff;
            border-right: 1px solid #eeeeec;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            z-index: 60;
            transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .u-sb-brand {
            padding: 20px 18px 16px;
            border-bottom: 1px solid #eeeeec;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .u-sb-brand-icon {
            width: 32px;
            height: 32px;
            background: #111;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .u-sb-brand-icon svg {
            width: 16px;
            height: 16px;
            color: #f5c518;
        }

        .u-sb-brand-name {
            font-size: 13px;
            font-weight: 800;
            color: #111;
            line-height: 1.1;
        }

        .u-sb-brand-sub {
            font-size: 8.5px;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #bbb;
        }

        .u-sb-nav {
            padding: 16px 0;
            flex: 1;
            overflow-y: auto;
        }

        .u-sb-nav a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 18px;
            font-size: 12px;
            font-weight: 600;
            color: #999;
            text-decoration: none;
            border-left: 2.5px solid transparent;
            transition: all 0.13s;
        }

        .u-sb-nav a:hover {
            color: #111;
            background: #f7f7f5;
        }

        .u-sb-nav a.active {
            color: #111;
            border-left-color: #111;
            background: #f5f5f3;
        }

        .u-sb-nav a svg {
            width: 15px;
            height: 15px;
            flex-shrink: 0;
            opacity: 0.5;
        }

        .u-sb-nav a.active svg {
            opacity: 1;
        }

        .u-sb-bottom {
            padding: 14px 14px 12px;
            border-top: 1px solid #eeeeec;
        }

        .u-sb-new-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            width: 100%;
            padding: 10px;
            background: #111;
            color: #fff;
            font-size: 12px;
            font-weight: 700;
            border-radius: 10px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: background 0.13s;
        }

        .u-sb-new-btn:hover {
            background: #333;
        }

        .u-sb-new-btn svg {
            width: 13px;
            height: 13px;
        }

        .u-sb-member {
            margin: 12px 14px 14px;
            background: #fffbe6;
            border: 1px solid #f5e08a;
            border-radius: 10px;
            padding: 10px 12px;
        }

        .u-sb-member-label {
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #aaa;
            margin-bottom: 2px;
        }

        .u-sb-member-value {
            font-size: 13px;
            font-weight: 800;
            color: #111;
        }

        /* ════ OVERLAY (mobile) ═══════════════════════════ */
        #u-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.45);
            z-index: 55;
            backdrop-filter: blur(2px);
        }

        /* ════ TOPNAV ══════════════════════════════════════ */
        #u-topnav {
            position: fixed;
            top: 0;
            left: 195px;
            right: 0;
            height: 60px;
            background: #fff;
            border-bottom: 1px solid #eeeeec;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 36px;
            z-index: 40;
            transition: left 0.25s;
        }

        .u-topnav-links {
            display: flex;
            gap: 32px;
        }

        .u-topnav-links a {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #aaa;
            text-decoration: none;
            padding-bottom: 2px;
            transition: color 0.13s;
        }

        .u-topnav-links a:hover {
            color: #111;
        }

        .u-topnav-links a.active {
            color: #111;
            border-bottom: 2px solid #111;
        }

        .u-topnav-right {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .u-topnav-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: #e8e8e6;
            border: 1px solid #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 800;
            color: #555;
        }

        .u-topnav-user-name {
            font-size: 12px;
            font-weight: 700;
            color: #111;
        }

        .u-topnav-user-role {
            font-size: 10px;
            color: #aaa;
        }

        /* Hamburger (hidden desktop) */
        #u-hamburger {
            display: none;
            flex-direction: column;
            gap: 5px;
            width: 36px;
            height: 36px;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            background: none;
            border: none;
            padding: 0;
        }

        #u-hamburger span {
            display: block;
            width: 20px;
            height: 2px;
            background: #111;
            border-radius: 2px;
            transition: all 0.22s ease;
        }

        /* ════ MAIN ════════════════════════════════════════ */
        #u-main {
            margin-left: 195px;
            margin-top: 60px;
            flex: 1;
            min-height: calc(100vh - 60px);
            width: calc(100% - 195px);
            transition: margin-left 0.25s, width 0.25s;
        }

        .u-content {
            padding: 36px 40px;
        }

        /* ════ ALERTS ══════════════════════════════════════ */
        .u-alert-success {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 11px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 13px;
        }

        .u-alert-error {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 11px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 13px;
        }

        /* ════ MOBILE ══════════════════════════════════════ */
        @media (max-width: 768px) {

            /* Sidebar hidden by default on mobile */
            #u-sidebar {
                transform: translateX(-100%);
                box-shadow: none;
            }

            #u-sidebar.open {
                transform: translateX(0);
                box-shadow: 4px 0 24px rgba(0, 0, 0, 0.12);
            }

            /* Topnav full width */
            #u-topnav {
                left: 0 !important;
                padding: 0 16px;
            }

            /* Hide desktop nav links in topnav */
            .u-topnav-links {
                display: none;
            }

            /* Show hamburger */
            #u-hamburger {
                display: flex;
            }

            /* Main full width */
            #u-main {
                margin-left: 0 !important;
                width: 100% !important;
            }

            .u-content {
                padding: 20px 16px;
            }

            /* User info text hide on very small */
            .u-topnav-user-info {
                display: none;
            }

            /* ── Dashboard content responsive ── */
            .ud-stats {
                grid-template-columns: 1fr 1fr !important;
            }

            .ud-info {
                grid-template-columns: 1fr !important;
            }

            .ud-grid {
                grid-template-columns: 1fr !important;
            }

            .ud-footer-grid {
                grid-template-columns: 1fr 1fr !important;
            }

            .ud-cal-card {
                margin-bottom: 0;
            }

            /* ── Booking page responsive ── */
            .ub-topbar {
                flex-direction: column;
                align-items: stretch !important;
            }

            .ub-search-wrap {
                max-width: 100% !important;
            }

            .ub-filter-tabs {
                overflow-x: auto;
                flex-wrap: nowrap;
                padding-bottom: 4px;
            }

            .ub-card {
                flex-wrap: wrap;
                padding: 16px !important;
                gap: 12px !important;
            }

            .ub-total-col {
                width: 100%;
                text-align: left !important;
                padding-top: 10px;
                border-top: 1px solid #f5f5f3;
            }

            .ub-pkg-name {
                font-size: 16px !important;
            }

            .ub-cta {
                flex-direction: column;
                align-items: flex-start !important;
            }

            .ub-cta-btn {
                width: 100%;
                text-align: center;
            }

            .ub-footer {
                flex-direction: column;
                gap: 8px;
            }
        }

        @media (max-width: 480px) {
            .ud-stats {
                grid-template-columns: 1fr !important;
            }

            .ud-footer-grid {
                grid-template-columns: 1fr !important;
            }

            .ub-actions {
                flex-direction: column;
                align-items: flex-start !important;
            }

            .ub-btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>

<body>

    {{-- ══ SIDEBAR ══════════════════════════════════════════════ --}}
    <aside id="u-sidebar">
        <div class="u-sb-brand">
            <div class="u-sb-brand-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69
                         h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118
                         l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176
                         0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363
                         -1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69
                         l1.519-4.674z" />
                </svg>
            </div>
            <div>
                <div class="u-sb-brand-name">MomentHub</div>
                <div class="u-sb-brand-sub">Digital Curator</div>
            </div>
        </div>

        <nav class="u-sb-nav">
            <a href="{{ route('user.dashboard') }}" class="{{ request()->routeIs('user.dashboard') ? 'active' : '' }}"
                onclick="closeSidebar()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <rect x="3" y="3" width="7" height="7" rx="1" stroke-width="2" />
                    <rect x="14" y="3" width="7" height="7" rx="1" stroke-width="2" />
                    <rect x="3" y="14" width="7" height="7" rx="1" stroke-width="2" />
                    <rect x="14" y="14" width="7" height="7" rx="1" stroke-width="2" />
                </svg>
                Ringkasan
            </a>
            <a href="{{ route('user.bookings') }}" class="{{ request()->routeIs('user.bookings') ? 'active' : '' }}"
                onclick="closeSidebar()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2
                         M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Pesanan Saya
            </a>
        </nav>

        <div class="u-sb-bottom">
            <a href="{{ route('price') }}" class="u-sb-new-btn">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <line x1="12" y1="5" x2="12" y2="19" />
                    <line x1="5" y1="12" x2="19" y2="12" />
                </svg>
                Sesi Baru
            </a>
        </div>
    </aside>

    {{-- Mobile overlay --}}
    <div id="u-overlay" onclick="closeSidebar()"></div>

    {{-- ══ TOPNAV ════════════════════════════════════════════════ --}}
    <header id="u-topnav">
        <div style="display:flex;align-items:center;gap:12px;">
            {{-- Hamburger (mobile only) --}}
            <button id="u-hamburger" onclick="toggleSidebar()" aria-label="Menu">
                <span id="uhb1"></span>
                <span id="uhb2"></span>
                <span id="uhb3"></span>
            </button>

            {{-- Desktop nav links --}}
            <nav class="u-topnav-links">
                <a href="{{ route('home') }}">Beranda</a>
                <a href="{{ route('gallery') }}">Galeri</a>
                <a href="{{ route('price') }}">Pemesanan</a>
                <a href="{{ route('user.dashboard') }}"
                    class="{{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                    Dashboard</a>
            </nav>
        </div>

        <div class="u-topnav-right">
            <div x-data="{ open: false }" @click.outside="open = false" style="position:relative;">
                <div @click="open = !open" style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                    <div style="text-align:right;" class="u-topnav-user-info">
                        <div class="u-topnav-user-name">{{ Auth::user()->name }}</div>
                        <div class="u-topnav-user-role">User</div>
                    </div>
                    <div class="u-topnav-avatar">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                </div>
                <div x-show="open" x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    style="display:none; position:fixed; top:56px; right:16px; width:160px;
                        background:#fff; border-radius:12px; box-shadow:0 8px 24px rgba(0,0,0,0.12);
                        border:1px solid #eee; z-index:999; overflow:hidden;">
                    <a href="{{ route('profile.edit') }}"
                        style="display:block;padding:12px 16px;font-size:13px;color:#333;text-decoration:none;">
                        Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            style="width:100%;text-align:left;padding:12px 16px;font-size:13px;
                                   color:#333;background:none;border:none;cursor:pointer;
                                   border-top:1px solid #f0f0ee;font-family:inherit;">
                            Log Out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    {{-- ══ MAIN ══════════════════════════════════════════════════ --}}
    <main id="u-main">
        <div class="u-content">
            @if (session('success'))
                <div class="u-alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="u-alert-error">{{ session('error') }}</div>
            @endif

            @yield('content')
        </div>
    </main>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        (function() {
            var _open = false;

            window.toggleSidebar = function() {
                _open = !_open;
                var sb = document.getElementById('u-sidebar');
                var ov = document.getElementById('u-overlay');
                var b1 = document.getElementById('uhb1');
                var b2 = document.getElementById('uhb2');
                var b3 = document.getElementById('uhb3');

                sb.classList.toggle('open', _open);
                ov.style.display = _open ? 'block' : 'none';
                document.body.style.overflow = _open ? 'hidden' : '';

                if (_open) {
                    b1.style.transform = 'translateY(7px) rotate(45deg)';
                    b2.style.opacity = '0';
                    b3.style.transform = 'translateY(-7px) rotate(-45deg)';
                } else {
                    b1.style.transform = '';
                    b2.style.opacity = '1';
                    b3.style.transform = '';
                }
            };

            window.closeSidebar = function() {
                if (!_open) return;
                _open = false;
                document.getElementById('u-sidebar').classList.remove('open');
                document.getElementById('u-overlay').style.display = 'none';
                document.body.style.overflow = '';
                document.getElementById('uhb1').style.transform = '';
                document.getElementById('uhb2').style.opacity = '1';
                document.getElementById('uhb3').style.transform = '';
            };

            window.addEventListener('resize', function() {
                if (window.innerWidth > 768) closeSidebar();
            });
        })();
    </script>
</body>

</html>
