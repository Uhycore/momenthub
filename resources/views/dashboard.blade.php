@extends('layouts.main')
@section('title', 'MomentHub - Abadikan Momen Terbaik Anda')

@section('content')

    {{-- ===================== NAVBAR ===================== --}}
    @include('partials.navbar', ['activeNav' => 'home'])

    <script>
        let _navOpen = false;

        function toggleMobileNav() {
            _navOpen = !_navOpen;
            const nav = document.getElementById('mobile-nav');
            nav.style.display = _navOpen ? 'block' : 'none';

            // Animate hamburger → X
            const b1 = document.getElementById('bar1');
            const b2 = document.getElementById('bar2');
            const b3 = document.getElementById('bar3');
            if (_navOpen) {
                b1.style.transform = 'translateY(8px) rotate(45deg)';
                b2.style.opacity = '0';
                b3.style.transform = 'translateY(-8px) rotate(-45deg)';
            } else {
                b1.style.transform = '';
                b2.style.opacity = '1';
                b3.style.transform = '';
            }
        }
    </script>

    @include('partials.booking-modal')

    <div class="pt-14">

        {{-- ===================== HERO ===================== --}}
        <section class="bg-white min-h-screen flex items-center relative overflow-hidden">
            <div class="max-w-7xl mx-auto px-6 lg:px-10 py-20 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center w-full">

                {{-- Left --}}
                <div>
                    <div class="inline-flex items-center gap-2 bg-yellow-400 px-3 py-1 mb-8">
                        <span class="w-1.5 h-1.5 rounded-full bg-gray-900"></span>
                        <span class="text-[9px] uppercase tracking-widest font-bold text-gray-900">Kurator Excellence</span>
                    </div>
                    <h1 class="font-sans text-6xl lg:text-7xl font-black text-gray-900 leading-[1.0] mb-2">
                        Abadikan
                    </h1>
                    <h1 class="font-sans text-6xl lg:text-7xl font-black text-yellow-400 leading-[1.0] mb-2">
                        Momen
                    </h1>
                    <h1 class="font-sans text-6xl lg:text-7xl font-black text-gray-900 leading-[1.0] mb-8">
                        Terbaik Anda.
                    </h1>
                    <p class="text-sm text-gray-500 leading-relaxed max-w-sm mb-10">
                        MomentHub menghubungkan Anda dengan fotografer terkurasi untuk menghadirkan visual yang bercerita.
                        Kualitas editorial dalam setiap bidikan.
                    </p>
                    <div class="flex items-center gap-4 flex-wrap">
                        <a href="{{ route('price') }}"
                            class="bg-gray-900 text-white text-[11px] uppercase tracking-widest font-bold px-7 py-3.5 hover:bg-gray-800 transition-colors">
                            Pesan Sekarang
                        </a>
                        <a href="#portofolio"
                            class="border border-gray-300 text-gray-700 text-[11px] uppercase tracking-widest font-bold px-7 py-3.5 hover:border-gray-900 hover:text-gray-900 transition-colors">
                            Lihat Portofolio
                        </a>
                    </div>
                </div>

                {{-- Right: stacked images --}}
                <div class="relative h-[520px] hidden lg:block">
                    {{-- Main large image --}}
                    <div class="absolute top-0 right-0 w-72 h-96 overflow-hidden shadow-2xl">
                        <img src="https://images.unsplash.com/photo-1537633552985-df8429e8048b?w=600&q=80"
                            class="w-full h-full object-cover" alt="Wedding photography">
                    </div>
                    {{-- Second image overlapping --}}
                    <div class="absolute bottom-8 right-52 w-52 h-64 overflow-hidden shadow-xl border-4 border-white">
                        <img src="https://images.unsplash.com/photo-1531746020798-e6953c6e8e04?w=400&q=80"
                            class="w-full h-full object-cover" alt="Portrait photography">
                    </div>
                </div>

            </div>
        </section>

        {{-- ===================== MENGAPA MOMENTHUB ===================== --}}
        <section class="bg-gray-50 py-24">
            <div class="max-w-5xl mx-auto px-6 text-center mb-14">
                <h2 class="font-sans text-3xl font-bold text-gray-900 mb-3">Mengapa MomentHub?</h2>
                <p class="text-sm text-gray-500 max-w-md mx-auto leading-relaxed">
                    Kami menerapkan standar fotografi bosa dengan pendekatan kurasi yang teran dan layanan concierge
                    personal.
                </p>
            </div>

            <div class="max-w-5xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-6 items-center">

                {{-- Features grid --}}
                <div class="grid grid-cols-2 gap-5">
                    {{-- F1 --}}
                    <div class="bg-white border border-gray-200 p-5">
                        <div class="w-8 h-8 flex items-center justify-center mb-4">
                            <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="text-sm font-bold text-gray-900 mb-1.5">Fotografer Terkurasi</div>
                        <p class="text-[11px] text-gray-400 leading-relaxed">Hanya 5% pendaftar yang berhasil lolos proses
                            kurasi kualitas editorial kami.</p>
                    </div>
                    {{-- F2 --}}
                    <div class="bg-white border border-gray-200 p-5">
                        <div class="w-8 h-8 flex items-center justify-center mb-4">
                            <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="text-sm font-bold text-gray-900 mb-1.5">Booking Instan</div>
                        <p class="text-[11px] text-gray-400 leading-relaxed">Sistem pemesanan real-time tanpa perlu chat
                            berlama-lama dengan fotografer.</p>
                    </div>
                    {{-- F3 --}}
                    <div class="bg-white border border-gray-200 p-5">
                        <div class="w-8 h-8 flex items-center justify-center mb-4">
                            <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                            </svg>
                        </div>
                        <div class="text-sm font-bold text-gray-900 mb-1.5">Harga Transparan</div>
                        <p class="text-[11px] text-gray-400 leading-relaxed">Tidak ada biaya tersembunyi. Semua paket sudah
                            termasuk editing dan narasi digital.</p>
                    </div>
                    {{-- F4 --}}
                    <div class="bg-white border border-gray-200 p-5">
                        <div class="w-8 h-8 flex items-center justify-center mb-4">
                            <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M15.75 10.5l4.72-4.72a.75.75 0 011.28.53v11.38a.75.75 0 01-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25h-9A2.25 2.25 0 002.25 7.5v9a2.25 2.25 0 002.25 2.25z" />
                            </svg>
                        </div>
                        <div class="text-sm font-bold text-gray-900 mb-1.5">Hasil Cinematic</div>
                        <p class="text-[11px] text-gray-400 leading-relaxed">Setiap foto diproses menggunakan color grading
                            premium eksklusif MomentHub.</p>
                    </div>
                </div>

                {{-- Right: camera image --}}
                <div class="hidden md:block">
                    <div class="aspect-square overflow-hidden bg-gray-200">
                        <img src="https://images.unsplash.com/photo-1606983340126-99ab4feaa64a?w=600&q=80"
                            class="w-full h-full object-cover" alt="Camera">
                    </div>
                </div>

            </div>
        </section>

        {{-- ===================== KARYA PILIHAN ===================== --}}
        <section class="bg-white py-24" id="portofolio">
            <div class="max-w-6xl mx-auto px-6">
                <div class="flex justify-between items-end mb-10">
                    <div>
                        <h2 class="font-sans text-4xl font-bold text-gray-900 leading-tight">Karya Pilihan</h2>
                        <p class="text-sm text-gray-400 mt-2 max-w-sm">Jelajahi berbagai gaya fotografi dari komunitas
                            profesional kami di seluruh Indonesia.</p>
                    </div>
                    <a href="{{ route('gallery') }}"
                        class="text-[10px] uppercase tracking-widest font-bold text-yellow-600 flex items-center gap-1.5 hover:text-yellow-700 transition-colors">
                        Lihat Semua Galeri
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>

                @if ($featuredPosts->isNotEmpty())
                    <div style="columns:2; column-gap:14px;">
                        @foreach ($featuredPosts->take(4) as $post)
                            <div class="karya-item"
                                style="break-inside:avoid; position:relative;
                                border-radius:10px; overflow:hidden; margin-bottom:14px;
                                cursor:pointer; background:#1a1a18;">

                                @if ($post->image_url)
                                    <img src="{{ $post->image_url }}" alt="{{ $post->title }}"
                                        style="width:100%; display:block; object-fit:cover;
                                        transition:transform 0.4s ease;">
                                @else
                                    <div
                                        style="width:100%; height:240px; display:flex;
                                        align-items:center; justify-content:center;">
                                        <svg class="w-10 h-10 text-white/20" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586
                                                                                                             a2 2 0 012.828 0L20 14M14 8h.01M6 20h12a2 2 0 002-2V6
                                                                                                             a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif

                                <div class="karya-overlay"
                                    style="position:absolute; inset:0;
                                    background:linear-gradient(to top,rgba(0,0,0,0.78) 0%,transparent 55%);
                                    opacity:0; transition:opacity .3s;
                                    display:flex; flex-direction:column;
                                    justify-content:flex-end; padding:18px 16px;">
                                    <span
                                        style="font-size:9px; font-weight:700; letter-spacing:0.13em;
                                         text-transform:uppercase; color:#f5c518; margin-bottom:4px;">
                                        {{ $post->type_label }}
                                    </span>
                                    <span
                                        style="font-size:14px; font-weight:700; color:#fff;
                                         line-height:1.3; margin-bottom:4px;">
                                        {{ $post->title }}
                                    </span>
                                    <span style="font-size:11px; color:rgba(255,255,255,0.5);">
                                        {{ $post->published_at?->format('d M Y') }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-20 text-gray-400">
                        <p class="text-sm">Belum ada karya yang dipublikasikan.</p>
                    </div>
                @endif
            </div>
        </section>

        <style>
            .karya-item:hover .karya-overlay {
                opacity: 1 !important;
            }

            .karya-item:hover img {
                transform: scale(1.04);
            }
        </style>

        {{-- ===================== INVESTASI MOMEN ===================== --}}
        <section class="bg-gray-50 py-24">
            <div class="max-w-5xl mx-auto px-6">
                <div class="text-center mb-14">
                    <h2 class="font-sans text-3xl font-bold text-gray-900 mb-3">Investasi Momen</h2>
                    <p class="text-sm text-gray-400 max-w-sm mx-auto">Pilih paket yang sesuai dengan kebutuhan Anda.
                        Setiap sesi dijamin dengan tim kurator kami.</p>
                </div>

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
                                class="{{ $isDark ? 'bg-gray-900 border-gray-900' : 'bg-white border-gray-200' }}
                                border p-7 flex flex-col">

                                <div
                                    class="text-[9px] uppercase tracking-widest font-bold mb-4
                                    {{ $isDark ? 'text-yellow-400' : 'text-gray-400' }}">
                                    {{ $pkg->name }}
                                </div>

                                <div class="mb-1">
                                    <span class="text-3xl font-black {{ $isDark ? 'text-white' : 'text-gray-900' }}">
                                        {{ $pkg->formatted_price }}
                                    </span>
                                    <span class="text-xs text-gray-400 ml-1">/sesi</span>
                                </div>

                                <div class="border-t {{ $isDark ? 'border-gray-700' : 'border-gray-100' }} my-5"></div>

                                <ul class="space-y-2.5 flex-1 mb-8">
                                    <li
                                        class="flex items-center gap-2 text-xs {{ $isDark ? 'text-gray-300' : 'text-gray-600' }}">
                                        @if ($isDark)
                                            <svg class="w-3.5 h-3.5 text-yellow-400 flex-shrink-0" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                        @else
                                            <span class="w-1 h-1 rounded-full bg-gray-400 flex-shrink-0"></span>
                                        @endif
                                        {{ $pkg->duration_label }} Sesi Foto
                                    </li>
                                    <li
                                        class="flex items-center gap-2 text-xs {{ $isDark ? 'text-gray-300' : 'text-gray-600' }}">
                                        @if ($isDark)
                                            <svg class="w-3.5 h-3.5 text-yellow-400 flex-shrink-0" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                        @else
                                            <span class="w-1 h-1 rounded-full bg-gray-400 flex-shrink-0"></span>
                                        @endif
                                        {{ $pkg->photo_count }} Foto Editing Premium
                                    </li>
                                    @if ($pkg->description)
                                        <li class="text-xs italic mt-1 {{ $isDark ? 'text-gray-400' : 'text-gray-400' }}">
                                            {{ $pkg->description }}
                                        </li>
                                    @endif
                                </ul>

                                <a href="{{ route('price') }}"
                                    class="w-full text-center text-[10px] uppercase tracking-widest font-bold py-3
                                  transition-colors block
                                  {{ $isDark
                                      ? 'bg-yellow-400 text-gray-900 hover:bg-yellow-500'
                                      : 'border border-gray-900 text-gray-900 hover:bg-gray-900 hover:text-white' }}">
                                    Pilih Paket
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-center text-sm text-gray-400 py-12">Belum ada paket tersedia.</p>
                @endif
            </div>
        </section>

        {{-- ===================== CEK KETERSEDIAAN JADWAL (KALENDER STATIS) ===================== --}}
        {{-- <section class="bg-white py-24">
            <div class="max-w-5xl mx-auto px-6">

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">

                   
                    <div>
                        <h2 class="font-sans text-3xl font-bold text-gray-900 mb-3">Cek Ketersediaan Jadwal</h2>
                        <p class="text-sm text-gray-400 leading-relaxed mb-8 max-w-xs">
                            Pilih tanggal untuk memastikan slot waktu yang tersedia bagi sesi foto Anda.
                        </p>
                        <div class="space-y-3">
                            <div class="flex items-center gap-3">
                                <span class="w-3 h-3 rounded-full bg-white border border-gray-300 flex-shrink-0"></span>
                                <span class="text-[11px] text-gray-500">Tersedia</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="w-3 h-3 rounded-full bg-yellow-400 flex-shrink-0"></span>
                                <span class="text-[11px] text-gray-500">Pilihan Anda</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="w-3 h-3 rounded-full bg-gray-900 flex-shrink-0"></span>
                                <span class="text-[11px] text-gray-500">Penuh / Sudah Dibooking</span>
                            </div>
                        </div>
                    </div>

                    
                    <div>
                        <div class="flex items-center justify-between mb-6">
                            <span class="font-bold text-gray-900 text-sm">Oktober 2024</span>
                            <div class="flex items-center gap-2">
                                <button
                                    class="w-7 h-7 flex items-center justify-center border border-gray-200 hover:bg-gray-100 transition-colors">
                                    <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 19l-7-7 7-7" />
                                    </svg>
                                </button>
                                <button
                                    class="w-7 h-7 flex items-center justify-center border border-gray-200 hover:bg-gray-100 transition-colors">
                                    <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        
                        <div class="grid grid-cols-7 mb-2">
                            @foreach (['MIN', 'SEN', 'SEL', 'RAB', 'KAM', 'JUM', 'SAB'] as $day)
                                <div
                                    class="text-center text-[9px] uppercase tracking-widest font-bold text-gray-400 py-1.5">
                                    {{ $day }}</div>
                            @endforeach
                        </div>

                        
                        @php
                            $booked = [5, 12, 19, 20, 26];
                            $selected = [10];
                            $startOffset = 2; // Oktober 2024 mulai Selasa
                            $totalDays = 31;
                        @endphp

                        <div class="grid grid-cols-7 gap-1">
                           
                            @for ($i = 0; $i < $startOffset; $i++)
                                <div></div>
                            @endfor

                            @for ($day = 1; $day <= $totalDays; $day++)
                                @if (in_array($day, $booked))
                                    <div
                                        class="aspect-square flex items-center justify-center bg-gray-900 text-white text-xs font-bold rounded-sm cursor-not-allowed">
                                        {{ $day }}
                                    </div>
                                @elseif(in_array($day, $selected))
                                    <div
                                        class="aspect-square flex items-center justify-center bg-yellow-400 text-gray-900 text-xs font-bold rounded-sm">
                                        {{ $day }}
                                    </div>
                                @else
                                    <div
                                        class="aspect-square flex items-center justify-center text-xs text-gray-700 hover:bg-gray-100 rounded-sm cursor-pointer transition-colors">
                                        {{ $day }}
                                    </div>
                                @endif
                            @endfor
                        </div>

                    </div>
                </div>
            </div>
        </section> --}}
        @include('partials.calendar')
        @include('partials.contact')

        {{-- ===================== CTA BANNER ===================== --}}
        <section class="bg-gray-900 py-24">
            <div class="max-w-3xl mx-auto px-6 text-center">
                <h2 class="font-sans text-4xl lg:text-5xl font-black text-white leading-tight mb-5">
                    Siap Untuk Membuat<br>Kenangan Abadi?
                </h2>
                <p class="text-sm text-gray-400 leading-relaxed mb-10 max-w-md mx-auto">
                    Konsultasikan konsep foto Anda dan dapatkan rekomendasi dengan tim kurator terbaik kami.
                </p>
                <div class="flex items-center justify-center gap-4 flex-wrap">
                    <a href="{{ route('register') }}"
                        class="bg-yellow-400 text-gray-900 text-[11px] uppercase tracking-widest font-bold px-8 py-3.5 hover:bg-yellow-500 transition-colors">
                        Mulai Konsultasi
                    </a>
                    <a href="#"
                        class="border border-gray-600 text-white text-[11px] uppercase tracking-widest font-bold px-8 py-3.5 hover:border-white transition-colors">
                        Hubungi Kami
                    </a>
                </div>
            </div>
        </section>


        {{-- ===================== FOOTER ===================== --}}
        <footer class="bg-gray-900 border-t border-gray-800 pt-16 pb-10">
            <div class="max-w-6xl mx-auto px-6">

                <div class="grid grid-cols-2 md:grid-cols-4 gap-10 mb-14">

                    {{-- Brand --}}
                    <div class="col-span-2 md:col-span-1">
                        <div class="font-bold text-white text-sm mb-4">MomentHub</div>
                        <p class="text-xs text-gray-500 leading-relaxed max-w-xs mb-6">
                            Platform kurasi fotografi editorial terpercaya untuk mengabadikan momen terbaik Anda.
                        </p>
                        <div class="flex items-center gap-3">
                            @foreach (['M', 'I', 'T', 'L'] as $icon)
                                <div
                                    class="w-7 h-7 border border-gray-700 flex items-center justify-center text-gray-500 hover:border-gray-400 hover:text-white transition-colors cursor-pointer">
                                    <span class="text-[10px] font-bold">{{ $icon }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Layanan --}}
                    <div>
                        <div class="text-[9px] uppercase tracking-widest font-bold text-gray-500 mb-5">Layanan</div>
                        <ul class="space-y-3">
                            @foreach (['Wedding Photography', 'Portofolio Editorial', 'Event & Komersial', 'Konsultasi Kreatif', 'Galeri & Arsip'] as $item)
                                <li><a href="#"
                                        class="text-xs text-gray-400 hover:text-white transition-colors">{{ $item }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Perusahaan --}}
                    <div>
                        <div class="text-[9px] uppercase tracking-widest font-bold text-gray-500 mb-5">Perusahaan</div>
                        <ul class="space-y-3">
                            @foreach (['Tentang Kami', 'Tim Fotografer', 'Cara Kerja', 'Syarat & Ketentuan', 'Kebijakan Privasi'] as $item)
                                <li><a href="#"
                                        class="text-xs text-gray-400 hover:text-white transition-colors">{{ $item }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Newsletter --}}
                    <div>
                        <div class="text-[9px] uppercase tracking-widest font-bold text-gray-500 mb-5">Newsletter</div>
                        <p class="text-xs text-gray-500 leading-relaxed mb-4">Dapatkan inspirasi fotografi dan penawaran
                            eksklusif langsung di inbox Anda.</p>
                        <div class="flex">
                            <input type="email" placeholder="Email Anda"
                                class="flex-1 bg-gray-800 border border-gray-700 text-xs text-white placeholder-gray-600 px-3 py-2.5 outline-none focus:border-gray-500">
                            <button class="bg-yellow-400 text-gray-900 px-3 py-2.5 hover:bg-yellow-500 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </button>
                        </div>
                    </div>

                </div>

                <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                    <span class="text-[10px] text-gray-600 uppercase tracking-widest">© 2024 MomentHub. Editorial
                        Photography Curator.</span>
                    <div class="flex items-center gap-6">
                        <a href="#"
                            class="text-[10px] uppercase tracking-widest text-gray-600 hover:text-white transition-colors">Indonesia</a>
                        <a href="#"
                            class="text-[10px] uppercase tracking-widest text-gray-600 hover:text-white transition-colors">English</a>
                    </div>
                </div>

            </div>
        </footer>


    </div>{{-- end pt-14 --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection
