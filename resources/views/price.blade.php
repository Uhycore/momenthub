@extends('layouts.main')
@section('title', 'Paket Harga — MomentHub')

@section('content')

    {{-- ===================== NAVBAR ===================== --}}
    @include('partials.navbar', ['activeNav' => 'price'])
    @include('partials.booking-modal')

    <div class="pt-14">

        {{-- ===================== HERO ===================== --}}
        <section class="bg-white pt-20 pb-6">
            <div class="max-w-4xl mx-auto px-6 text-center">
                <h1 class="font-sans text-5xl lg:text-6xl font-black text-gray-900 leading-tight mb-5">
                    Abadikan <span class="text-yellow-400">Momentum</span> Anda.
                </h1>
                <p class="text-sm text-gray-500 leading-relaxed max-w-lg mx-auto">
                    Pilih paket kurasi kami yang dirancang khusus untuk menangkap esensi
                    cerita Anda melalui lensa fotografer profesional bersertifikat.
                </p>
            </div>
        </section>

        {{-- ===================== PACKAGE CARDS ===================== --}}

        <section class="bg-white py-14">
            <div class="max-w-5xl mx-auto px-6">

                @if ($packages->isNotEmpty())
                    @php
                        $count = $packages->count();
                        $gridCols = $count === 4 ? 2 : min($count, 3);
                    @endphp

                    {{-- JADI INI --}}
                    <div
                        style="display:grid; grid-template-columns: repeat({{ $gridCols }}, minmax(0,1fr)); gap:20px; align-items:stretch;">
                        @foreach ($packages as $i => $pkg)
                            @php $isDark = $i % 2 === 1; @endphp

                            <div
                                class="relative flex flex-col p-8 rounded-sm
                                {{ $isDark ? 'bg-gray-900 border border-gray-900' : 'bg-white border border-gray-200' }}">

                                {{-- Name --}}
                                <div
                                    class="text-[9px] uppercase tracking-widest font-bold mb-3
                                    {{ $isDark ? 'text-yellow-400' : 'text-gray-400' }}">
                                    {{ $pkg->name }}
                                </div>

                                {{-- Price --}}
                                <div class="mb-5">
                                    <span
                                        class="font-black leading-none text-4xl
                                         {{ $isDark ? 'text-white' : 'text-gray-900' }}">
                                        {{ $pkg->formatted_price }}
                                    </span>
                                    <span class="text-xs text-gray-400 ml-1">/sesi</span>
                                </div>

                                {{-- Description --}}
                                @if ($pkg->description)
                                    <p
                                        class="text-xs leading-relaxed mb-5
                                      {{ $isDark ? 'text-gray-400' : 'text-gray-400' }}">
                                        {{ $pkg->description }}
                                    </p>
                                @endif

                                {{-- Divider --}}
                                <div class="border-t {{ $isDark ? 'border-gray-700' : 'border-gray-100' }} mb-5"></div>

                                {{-- Features --}}
                                <ul class="space-y-3 flex-1 mb-8">
                                    <li
                                        class="flex items-center gap-2.5 text-xs
                                       {{ $isDark ? 'text-gray-300' : 'text-gray-600' }}">
                                        <svg class="w-4 h-4 flex-shrink-0 {{ $isDark ? 'text-yellow-400' : 'text-gray-300' }}"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            stroke-width="{{ $isDark ? '2.5' : '2' }}">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                        {{ $pkg->duration_label }} Sesi Foto
                                    </li>
                                    <li
                                        class="flex items-center gap-2.5 text-xs
                                       {{ $isDark ? 'text-gray-300' : 'text-gray-600' }}">
                                        <svg class="w-4 h-4 flex-shrink-0 {{ $isDark ? 'text-yellow-400' : 'text-gray-300' }}"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            stroke-width="{{ $isDark ? '2.5' : '2' }}">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                        {{ $pkg->photo_count }} Foto Editing Premium
                                    </li>
                                    <li
                                        class="flex items-center gap-2.5 text-xs
                                       {{ $isDark ? 'text-gray-300' : 'text-gray-600' }}">
                                        <svg class="w-4 h-4 flex-shrink-0 {{ $isDark ? 'text-yellow-400' : 'text-gray-300' }}"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            stroke-width="{{ $isDark ? '2.5' : '2' }}">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Link Galeri Digital
                                    </li>
                                </ul>

                                @auth
                                    <button type="button"
                                        onclick="openBkModal({{ $pkg->id }}, '{{ $pkg->name }}', '{{ $pkg->formatted_price }}')"
                                        class="w-full text-center text-[10px] uppercase tracking-widest font-bold py-4
                   transition-colors cursor-pointer border-none font-sans
                   {{ $isDark
                       ? 'bg-yellow-400 text-gray-900 hover:bg-yellow-500'
                       : 'border border-gray-900 text-gray-900 hover:bg-gray-900 hover:text-white' }}">
                                        Pilih Paket
                                    </button>
                                @else
                                    <a href="{{ route('login') }}"
                                        class="w-full text-center text-[10px] uppercase tracking-widest font-bold py-4
              transition-colors block
              {{ $isDark
                  ? 'bg-yellow-400 text-gray-900 hover:bg-yellow-500'
                  : 'border border-gray-900 text-gray-900 hover:bg-gray-900 hover:text-white' }}">
                                        Masuk untuk Memesan
                                    </a>
                                @endauth
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-24 text-gray-400">
                        <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10" />
                        </svg>
                        <p class="text-sm">Belum ada paket tersedia.</p>
                    </div>
                @endif

            </div>
        </section>

        {{-- ===================== LAYANAN EKSKLUSIF ===================== --}}
        <section class="bg-white py-20 border-t border-gray-100">
            <div class="max-w-5xl mx-auto px-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

                    {{-- Left: text --}}
                    <div>
                        <h2 class="font-sans text-4xl font-black text-gray-900 leading-tight mb-6">
                            Layanan Kurasi <span class="text-yellow-400">Eksklusif</span>
                        </h2>
                        <p class="text-sm text-gray-500 leading-relaxed mb-10 max-w-md">
                            Setiap pemesanan di MomentHub mendapatkan penanganan khusus dari tim kurasi kami.
                            Kami memastikan setiap detail konsep Anda diterjemahkan dengan sempurna oleh mitra fotografer
                            kami yang memiliki spesialisasi di berbagai bidang mulai dari Portrait hingga Cinematic
                            Documentary.
                        </p>
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <div class="font-bold text-gray-900 text-sm mb-1.5">Kualitas 4K</div>
                                <p class="text-[11px] text-gray-400 leading-relaxed">
                                    Standard pengiriman file resolusi tinggi untuk kebutuhan cetak.
                                </p>
                            </div>
                            <div>
                                <div class="font-bold text-gray-900 text-sm mb-1.5">Revisi Cepat</div>
                                <p class="text-[11px] text-gray-400 leading-relaxed">
                                    Editing diselesaikan dalam waktu 7 hari kerja.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Right: image --}}
                    <div class="overflow-hidden rounded-sm aspect-[4/3] bg-gray-100">
                        <img src="https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=800&q=80"
                            class="w-full h-full object-cover" alt="Photography equipment">
                    </div>

                </div>
            </div>
        </section>

        {{-- ===================== FOOTER ===================== --}}
        <footer class="bg-white border-t border-gray-100 py-16">
            <div class="max-w-6xl mx-auto px-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-10 mb-12">

                    {{-- Brand --}}
                    <div class="col-span-2 md:col-span-1">
                        <div class="font-bold text-gray-900 text-sm mb-3">MomentHub</div>
                        <p class="text-xs text-gray-400 leading-relaxed max-w-xs mb-5">
                            Digital Curator untuk momen tak ternilai Anda. Menghubungkan visi dengan lensa profesional
                            terbaik.
                        </p>
                    </div>

                    {{-- Navigasi --}}
                    <div>
                        <div class="text-[9px] uppercase tracking-widest font-bold text-gray-400 mb-5">Navigasi</div>
                        <ul class="space-y-3">
                            <li><a href="{{ route('home') }}"
                                    class="text-xs text-gray-500 hover:text-gray-900 transition-colors">Tentang Kami</a>
                            </li>
                            <li><a href="{{ route('price') }}"
                                    class="text-xs text-gray-500 hover:text-gray-900 transition-colors">Pemesanan</a></li>
                            <li><a href="{{ route('gallery') }}"
                                    class="text-xs text-gray-500 hover:text-gray-900 transition-colors">Galeri</a></li>
                            <li><a href="#"
                                    class="text-xs text-gray-500 hover:text-gray-900 transition-colors">Kontak</a></li>
                        </ul>
                    </div>

                    {{-- Legal --}}
                    <div>
                        <div class="text-[9px] uppercase tracking-widest font-bold text-gray-400 mb-5">Legal</div>
                        <ul class="space-y-3">
                            <li><a href="#"
                                    class="text-xs text-gray-500 hover:text-gray-900 transition-colors">Syarat &amp;
                                    Ketentuan</a></li>
                            <li><a href="#"
                                    class="text-xs text-gray-500 hover:text-gray-900 transition-colors">Kebijakan
                                    Privasi</a></li>
                            <li><a href="#"
                                    class="text-xs text-gray-500 hover:text-gray-900 transition-colors">FAQ</a></li>
                        </ul>
                    </div>

                    {{-- Ikuti Kami --}}
                    <div>
                        <div class="text-[9px] uppercase tracking-widest font-bold text-gray-400 mb-5">Ikuti Kami</div>
                        <div class="flex gap-2.5">
                            @foreach (['IG', 'BE', 'LI'] as $s)
                                <a href="#"
                                    class="w-8 h-8 border border-gray-200 rounded-full flex items-center justify-center
                                          text-[9px] font-bold text-gray-400 hover:border-gray-900 hover:text-gray-900 transition-colors">
                                    {{ $s }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-100 pt-8 flex flex-col md:flex-row justify-between items-center gap-3">
                    <span class="text-[10px] text-gray-400">© 2024 MomentHub. Hak Cipta Dilindungi.</span>
                    <a href="{{ route('price') }}"
                        class="text-[10px] text-gray-400 underline underline-offset-2 hover:text-gray-900 transition-colors">Pemesanan</a>
                </div>
            </div>
        </footer>

    </div>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

@endsection
