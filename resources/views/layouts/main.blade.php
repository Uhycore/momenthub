<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'MomentHub')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Tambahan warna kustom yang tidak ada di Tailwind default */
        .bg-gold {
            background-color: #D4A017;
        }

        .text-gold {
            color: #D4A017;
        }

        .border-gold {
            border-color: #D4A017;
        }

        .bg-cream {
            background-color: #F5F3EE;
        }

        /* Smooth scroll */
        html {
            scroll-behavior: smooth;
        }

        /* Font override */
        body {
            font-family: 'DM Sans', sans-serif;
        }

        .font-serif {
            font-family: 'Georgia', 'Times New Roman', serif;
        }
    </style>
    {{--
    Tambahkan CSS ini di dalam @section('content'), setelah opening tag <div class="pt-14">
    atau di dalam tag <style> yang sudah ada.
    Semua ini adalah mobile/responsive overrides untuk dashboard.blade.php
--}}

    <style>
        /* ═══════════════════════════════════════════════════
   MOBILE RESPONSIVE — dashboard.blade.php
   max-width: 768px (md breakpoint Tailwind)
   ═══════════════════════════════════════════════════ */

        @media (max-width: 767px) {

            /* ── Hero ── */
            .hero-text-xl {
                font-size: 48px !important;
                line-height: 1.05 !important;
            }

            /* ── Mengapa MomentHub: features grid 1 col ── */
            .max-w-5xl .grid.grid-cols-2 {
                grid-template-columns: 1fr !important;
            }

            /* ── Karya Pilihan: masonry 1 col ── */
            div[style*="columns:2"] {
                columns: 1 !important;
                column-gap: 0 !important;
            }

            /* ── Investasi Momen packages grid ── */
            div[style*="grid-template-columns: repeat"] {
                grid-template-columns: 1fr !important;
            }

            /* ── Calendar section (gc-*) ── */
            .gc-hero h2 {
                font-size: 28px !important;
            }

            .gc-stats {
                flex-direction: column !important;
                width: 100% !important;
            }

            .gc-stat-item {
                border-right: none !important;
                border-bottom: 1px solid #f0f0ee;
                width: 100%;
            }

            .gc-stat-item:last-child {
                border-bottom: none;
            }

            #gc-cal .fc-toolbar {
                flex-wrap: wrap !important;
                gap: 8px !important;
            }

            .gc-card-head {
                flex-direction: column !important;
                align-items: flex-start !important;
                gap: 10px;
            }

            /* ── Contact section (cs-*) ── */
            .cs-grid {
                grid-template-columns: 1fr !important;
            }

            .cs-head h2 {
                font-size: 26px !important;
            }

            .cs-map-iframe {
                height: 220px !important;
            }

            /* ── Stats section kalau ada di halaman lain ── */
            .bk-stat-grid {
                grid-template-columns: 1fr 1fr !important;
            }

            /* ── General: reduce section padding ── */
            section.bg-white,
            section.bg-gray-50,
            section.bg-gray-900 {
                padding-top: 48px !important;
                padding-bottom: 48px !important;
            }

            /* ── Hero min-height ── */
            section.min-h-screen {
                min-height: auto !important;
                padding: 60px 0 40px !important;
            }

            /* ── Hero image stack ── */
            .relative.h-\[520px\] {
                display: none !important;
            }

            /* Hero grid 1 col */
            .grid.grid-cols-1.lg\:grid-cols-2 {
                grid-template-columns: 1fr !important;
            }

            /* ── Mengapa: hide right camera image ── */
            .hidden.md\:block {
                display: none !important;
            }

            /* ── CTA banner text ── */
            .font-sans.text-4xl {
                font-size: 28px !important;
            }

            .font-sans.text-5xl {
                font-size: 32px !important;
            }

            /* ── Footer grid ── */
            .grid.grid-cols-2.md\:grid-cols-4 {
                grid-template-columns: 1fr 1fr !important;
                gap: 28px !important;
            }

            /* ── Pricing CTA buttons ── */
            .flex.items-center.gap-4.flex-wrap a {
                width: 100%;
                text-align: center;
                justify-content: center;
                display: block;
            }
        }

        @media (max-width: 480px) {

            /* Extra small screens */
            .gc-hero h2 {
                font-size: 24px !important;
            }

            .cs-head h2 {
                font-size: 22px !important;
            }

            .gc-stats {
                gap: 0;
            }

            .font-sans.text-4xl,
            .font-sans.text-5xl {
                font-size: 26px !important;
            }

            /* Package pairing stats */
            .bk-stat-grid {
                grid-template-columns: 1fr !important;
            }

            /* Footer col-span */
            .col-span-2.md\:col-span-1 {
                grid-column: span 2 !important;
            }
        }
    </style>
</head>

<body class="bg-white text-gray-900 antialiased">

    @yield('content')

</body>

</html>
