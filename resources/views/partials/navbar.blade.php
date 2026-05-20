@php
    /*
    resources/views/partials/navbar.blade.php
    @include('partials.navbar')

    Ganti seluruh blok <nav ...>...</nav> di SEMUA halaman guest:
    - dashboard.blade.php
    - price.blade.php
    - gallery.blade.php

    Parameter opsional: $activeNav = 'home' | 'gallery' | 'price'
    Contoh: @include('partials.navbar', ['activeNav' => 'price'])
*/
@endphp

@php $activeNav = $activeNav ?? ''; @endphp

<nav class="fixed top-0 left-0 right-0 z-50 bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-5 flex items-center justify-between h-14">

        {{-- Brand --}}
        <a href="{{ route('home') }}" class="font-bold text-gray-900 text-sm tracking-tight flex-shrink-0">
            MomentHub
        </a>

        {{-- Desktop links --}}
        <div class="hidden md:flex items-center gap-8">
            @php
                $links = [
                    ['route' => 'home', 'label' => 'Beranda'],
                    ['route' => 'gallery', 'label' => 'Galeri'],
                    ['route' => 'price', 'label' => 'Pemesanan'],
                ];
            @endphp
            @foreach ($links as $link)
                <a href="{{ route($link['route']) }}"
                    class="text-[11px] uppercase tracking-widest font-medium transition-colors
                          {{ request()->routeIs($link['route'])
                              ? 'font-semibold text-gray-900 border-b-2 border-gray-900 pb-0.5'
                              : 'text-gray-400 hover:text-gray-900' }}">
                    {{ $link['label'] }}
                </a>
            @endforeach

            @auth
                @if (auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}"
                        class="text-[11px] uppercase tracking-widest font-medium text-gray-400 hover:text-gray-900 transition-colors">
                        Dashboard</a>
                @else
                    <a href="{{ route('user.dashboard') }}"
                        class="text-[11px] uppercase tracking-widest font-medium text-gray-400 hover:text-gray-900 transition-colors">
                        Dashboard</a>
                @endif
            @else
                <a href="{{ route('login') }}"
                    class="text-[11px] uppercase tracking-widest font-medium text-gray-400 hover:text-gray-900 transition-colors">
                    Dashboard</a>
            @endauth
        </div>

        {{-- Desktop right --}}
        <div class="hidden md:flex items-center gap-3">
            @auth
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center gap-2 hover:opacity-80 transition-opacity">
                        <div
                            class="w-8 h-8 rounded-full bg-gray-900 flex items-center justify-center text-white text-[11px] font-bold flex-shrink-0">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <span class="text-[11px] uppercase tracking-widest font-semibold text-gray-700">
                            {{ auth()->user()->name }}
                        </span>
                        <svg class="w-3.5 h-3.5 text-gray-400 transition-transform duration-200"
                            :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95" @click.outside="open = false"
                        class="absolute right-0 mt-2 w-44 bg-white rounded-xl shadow-lg border border-gray-100 py-1 z-50"
                        style="display:none;">
                        <a href="{{ route('profile.edit') }}"
                            class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                            Profile</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}"
                    class="text-[11px] uppercase tracking-widest font-semibold text-gray-600 hover:text-gray-900 transition-colors">
                    Masuk</a>
                <a href="{{ route('register') }}"
                    class="text-[11px] uppercase tracking-widest font-bold bg-yellow-400 text-gray-900 px-4 py-2 hover:bg-yellow-500 transition-colors">
                    Daftar</a>
            @endauth
        </div>

        {{-- Mobile: avatar + hamburger --}}
        <div class="flex md:hidden items-center gap-3">
            @auth
                <div
                    class="w-8 h-8 rounded-full bg-gray-900 flex items-center justify-center text-white text-[11px] font-bold flex-shrink-0">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            @else
                <a href="{{ route('register') }}"
                    class="text-[10px] uppercase tracking-widest font-bold bg-yellow-400 text-gray-900 px-3 py-1.5">
                    Daftar</a>
            @endauth

            <button id="mh-nav-toggle" onclick="mhToggleNav()" aria-label="Menu"
                class="flex flex-col gap-1.5 items-center justify-center w-9 h-9 flex-shrink-0">
                <span id="mh-b1"
                    style="display:block;width:20px;height:2px;background:#1a1a1a;border-radius:2px;transition:all 0.22s ease;"></span>
                <span id="mh-b2"
                    style="display:block;width:20px;height:2px;background:#1a1a1a;border-radius:2px;transition:all 0.22s ease;"></span>
                <span id="mh-b3"
                    style="display:block;width:20px;height:2px;background:#1a1a1a;border-radius:2px;transition:all 0.22s ease;"></span>
            </button>
        </div>

    </div>

    {{-- Mobile drawer --}}
    <div id="mh-nav-drawer" style="display:none; border-top:1px solid #f0f0ee;" class="md:hidden bg-white">
        <div class="px-5 py-4 flex flex-col gap-0.5">

            <a href="{{ route('home') }}"
                class="flex items-center px-3 py-3 rounded-lg text-[12px] font-semibold uppercase tracking-widest transition-colors
                      {{ request()->routeIs('home') ? 'bg-gray-50 text-gray-900' : 'text-gray-500 hover:bg-gray-50' }}">
                Beranda</a>
            <a href="{{ route('gallery') }}"
                class="flex items-center px-3 py-3 rounded-lg text-[12px] font-semibold uppercase tracking-widest transition-colors
                      {{ request()->routeIs('gallery') ? 'bg-gray-50 text-gray-900' : 'text-gray-500 hover:bg-gray-50' }}">
                Galeri</a>
            <a href="{{ route('price') }}"
                class="flex items-center px-3 py-3 rounded-lg text-[12px] font-semibold uppercase tracking-widest transition-colors
                      {{ request()->routeIs('price') ? 'bg-gray-50 text-gray-900' : 'text-gray-500 hover:bg-gray-50' }}">
                Pemesanan</a>

            @auth
                @if (auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center px-3 py-3 rounded-lg text-[12px] font-semibold uppercase tracking-widest text-gray-500 hover:bg-gray-50 transition-colors">
                        Dashboard</a>
                @else
                    <a href="{{ route('user.dashboard') }}"
                        class="flex items-center px-3 py-3 rounded-lg text-[12px] font-semibold uppercase tracking-widest text-gray-500 hover:bg-gray-50 transition-colors">
                        Dashboard</a>
                @endif

                <div class="border-t border-gray-100 my-2"></div>

                <a href="{{ route('profile.edit') }}"
                    class="flex items-center px-3 py-3 rounded-lg text-[12px] font-semibold uppercase tracking-widest text-gray-500 hover:bg-gray-50 transition-colors">
                    Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full text-left flex items-center px-3 py-3 rounded-lg text-[12px] font-semibold uppercase tracking-widest text-red-400 hover:bg-red-50 transition-colors">
                        Log Out
                    </button>
                </form>
            @else
                <div class="border-t border-gray-100 my-2"></div>
                <a href="{{ route('login') }}"
                    class="flex items-center justify-center px-3 py-3 rounded-lg border border-gray-200 text-[12px] font-bold uppercase tracking-widest text-gray-700 hover:bg-gray-50 transition-colors">
                    Masuk</a>
            @endauth
        </div>
    </div>
</nav>

{{-- Script: inline supaya tersedia di semua halaman --}}
<script>
    (function() {
        var _mhNavOpen = false;

        window.mhToggleNav = function() {
            _mhNavOpen = !_mhNavOpen;
            var drawer = document.getElementById('mh-nav-drawer');
            var b1 = document.getElementById('mh-b1');
            var b2 = document.getElementById('mh-b2');
            var b3 = document.getElementById('mh-b3');

            drawer.style.display = _mhNavOpen ? 'block' : 'none';

            if (_mhNavOpen) {
                b1.style.transform = 'translateY(7px) rotate(45deg)';
                b2.style.opacity = '0';
                b3.style.transform = 'translateY(-7px) rotate(-45deg)';
            } else {
                b1.style.transform = '';
                b2.style.opacity = '1';
                b3.style.transform = '';
            }
        };

        // Tutup saat resize ke desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768 && _mhNavOpen) {
                _mhNavOpen = false;
                var drawer = document.getElementById('mh-nav-drawer');
                if (drawer) drawer.style.display = 'none';
            }
        });
    })();
</script>
