@extends('layouts.main')

@section('title', 'Galeri Karya — MomentHub')

@section('content')

    <style>
        /* ─── Gallery layout ────────────────── */
        .gal-wrap {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 40px;
        }

        /* Filter tabs */
        .gal-tabs {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-bottom: 36px;
        }

        .gal-tab {
            padding: 7px 18px;
            border-radius: 20px;
            font-size: 12.5px;
            font-weight: 600;
            text-decoration: none;
            border: 1.5px solid #e0e0de;
            color: #666;
            background: #fff;
            transition: all 0.15s;
            cursor: pointer;
        }

        .gal-tab:hover {
            border-color: #999;
            color: #111;
        }

        .gal-tab.active {
            background: #111;
            border-color: #111;
            color: #fff;
        }

        /* Masonry 2-col */
        .gal-grid {
            columns: 2;
            column-gap: 14px;
        }

        @media (max-width: 640px) {
            .gal-grid {
                columns: 1;
            }
        }

        /* Each item */
        .gal-item {
            break-inside: avoid;
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 14px;
            cursor: pointer;
            background: #1a1a18;
        }

        .gal-item img {
            width: 100%;
            display: block;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        /* Hover overlay */
        .gal-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.8) 0%, rgba(0, 0, 0, 0.1) 55%, transparent 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 22px 20px;
        }

        .gal-item:hover .gal-overlay {
            opacity: 1;
        }

        .gal-item:hover img {
            transform: scale(1.04);
        }

        .gal-overlay-type {
            font-size: 9.5px;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: #f5c518;
            margin-bottom: 5px;
        }

        .gal-overlay-title {
            font-size: 16px;
            font-weight: 700;
            color: #fff;
            line-height: 1.3;
            margin-bottom: 5px;
        }

        .gal-overlay-date {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.55);
        }

        /* Placeholder when no image */
        .gal-placeholder {
            width: 100%;
            height: 220px;
            background: linear-gradient(135deg, #2a2a28, #111);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .gal-placeholder svg {
            width: 32px;
            height: 32px;
            color: rgba(255, 255, 255, 0.15);
        }

        /* Empty state */
        .gal-empty {
            text-align: center;
            padding: 80px 20px;
            color: #bbb;
            grid-column: 1/-1;
        }

        .gal-empty svg {
            width: 40px;
            height: 40px;
            margin: 0 auto 12px;
            display: block;
        }

        .gal-empty p {
            font-size: 14px;
        }

        /* CTA section */
        .gal-cta {
            background: #111;
            padding: 80px 40px;
            text-align: center;
            margin-top: 80px;
        }

        .gal-cta h2 {
            font-size: 36px;
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.03em;
            margin: 0 0 12px;
        }

        .gal-cta p {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.5);
            margin: 0 0 32px;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.6;
        }

        .gal-cta-btns {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .gal-btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #f5c518;
            color: #111;
            font-size: 13px;
            font-weight: 700;
            padding: 13px 24px;
            border-radius: 10px;
            text-decoration: none;
            transition: background 0.15s;
        }

        .gal-btn-primary:hover {
            background: #e6b800;
        }

        .gal-btn-secondary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: transparent;
            color: #fff;
            font-size: 13px;
            font-weight: 600;
            padding: 13px 24px;
            border-radius: 10px;
            border: 1.5px solid rgba(255, 255, 255, 0.25);
            text-decoration: none;
            transition: border-color 0.15s;
        }

        .gal-btn-secondary:hover {
            border-color: rgba(255, 255, 255, 0.6);
        }
    </style>

    {{-- ===================== NAVBAR ===================== --}}
    @include('partials.navbar', ['activeNav' => 'gallery'])
    <div class="pt-14">


        {{-- ── Page Header ─────────────────────────────────────────── --}}
        <div style="padding: 56px 0 40px; background:#fafaf8;">
            <div class="gal-wrap">
                <h1 style="font-size:42px; font-weight:800; color:#111; letter-spacing:-0.03em; margin:0 0 10px;">
                    Galeri Karya
                </h1>
                <p style="font-size:13.5px; color:#888; margin:0; max-width:420px; line-height:1.6;">
                    A curated selection of visual excellence. Where every shutter click
                    captures a permanent narrative of elegance and raw emotion.
                </p>
            </div>
        </div>

        {{-- ── Filter Tabs ──────────────────────────────────────────── --}}
        <div style="background:#fafaf8; padding:0 0 32px;">
            <div class="gal-wrap">
                <div class="gal-tabs">
                    <a href="{{ route('gallery') }}" class="gal-tab {{ $filter === 'all' ? 'active' : '' }}">
                        Semua
                        <span style="margin-left:4px;font-size:10px;opacity:0.6">({{ $posts->count() }})</span>
                    </a>
                    <a href="{{ route('gallery', ['filter' => 'gallery']) }}"
                        class="gal-tab {{ $filter === 'gallery' ? 'active' : '' }}">
                        Gallery
                    </a>
                    <a href="{{ route('gallery', ['filter' => 'editorial']) }}"
                        class="gal-tab {{ $filter === 'editorial' ? 'active' : '' }}">
                        Editorial
                    </a>
                </div>
            </div>
        </div>

        {{-- ── Masonry Grid ─────────────────────────────────────────── --}}
        <div style="padding: 0 0 80px; background:#fafaf8;">
            <div class="gal-wrap">

                @if ($posts->isNotEmpty())
                    <div class="gal-grid">
                        @foreach ($posts as $post)
                            <div class="gal-item">

                                {{-- Image --}}
                                @if ($post->image_url)
                                    <img src="{{ $post->image_url }}" alt="{{ $post->title }}">
                                @else
                                    <div class="gal-placeholder">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2
                                                                                             l1.586-1.586a2 2 0 012.828 0L20 14M14 8h.01
                                                                                             M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6
                                                                                             a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif

                                {{-- Overlay on hover --}}
                                <div class="gal-overlay">
                                    <div class="gal-overlay-type">
                                        {{ $post->type_label }}
                                    </div>
                                    <div class="gal-overlay-title">
                                        {{ $post->title }}
                                    </div>
                                    <div class="gal-overlay-date">
                                        {{ $post->published_at?->translatedFormat('d F Y') ?? '-' }}
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="gal-empty">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586
                                                                             a2 2 0 012.828 0L20 14M14 8h.01M6 20h12a2 2 0 002-2V6
                                                                             a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p>Belum ada karya yang dipublikasikan.</p>
                    </div>
                @endif

            </div>
        </div>

        {{-- ── CTA Section ──────────────────────────────────────────── --}}
        <div class="gal-cta">
            <div style="max-width:500px; margin:0 auto;">
                <h2>Visi Anda, Lensa Kami.</h2>
                <p>
                    Ready to transform your moments into a permanent legacy?
                    Join our exclusive roster of clients and work with the industry's finest.
                </p>
                <div class="gal-cta-btns">
                    <a href="{{ route('price') }}" class="gal-btn-primary">
                        Book a Session →
                    </a>
                    <a href="{{ route('price') }}" class="gal-btn-secondary">
                        View Pricing
                    </a>
                </div>
            </div>
        </div>

    </div>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection
