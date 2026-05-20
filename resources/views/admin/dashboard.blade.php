@extends('admin.layouts.app')

@section('page-title', 'Dashboard Ringkasan')
@section('page-subtitle', now()->translatedFormat('l, d F Y'))

@section('content')

    <style>
        /* ─── STAT CARDS ──────────────────────────── */
        .stat-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 14px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: #fff;
            border-radius: 14px;
            padding: 22px 24px;
            position: relative;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
        }

        .stat-card.dark {
            background: #111;
            color: #fff;
        }

        .stat-card-icon {
            width: 36px;
            height: 36px;
            background: #f5f5f3;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .stat-card.dark .stat-card-icon {
            background: rgba(255, 255, 255, 0.1);
        }

        .stat-card-icon svg {
            width: 18px;
            height: 18px;
            color: #555;
        }

        .stat-card.dark .stat-card-icon svg {
            color: #fff;
        }

        .stat-badge {
            position: absolute;
            top: 22px;
            right: 22px;
            font-size: 10px;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 20px;
            letter-spacing: 0.02em;
        }

        .stat-badge.green {
            background: #e8f7ee;
            color: #1d8a45;
        }

        .stat-badge.green-text {
            color: #1d8a45;
            font-size: 11px;
            font-weight: 600;
        }

        .stat-badge.dark-badge {
            background: rgba(255, 255, 255, 0.12);
            color: #ddd;
            font-size: 9.5px;
        }

        .stat-value {
            font-size: 28px;
            font-weight: 700;
            color: #111;
            letter-spacing: -0.03em;
            line-height: 1;
            margin-bottom: 6px;
        }

        .stat-value.sm {
            font-size: 22px;
        }

        .stat-card.dark .stat-value {
            color: #fff;
        }

        .stat-label {
            font-size: 11px;
            color: #aaa;
            font-weight: 500;
        }

        .stat-card.dark .stat-label {
            color: rgba(255, 255, 255, 0.5);
        }

        .stat-sub {
            font-size: 11px;
            color: #aaa;
            margin-top: 4px;
        }

        /* ─── BOTTOM GRID ─────────────────────────── */
        .bottom-grid {
            display: grid;
            grid-template-columns: 1fr 320px;
            gap: 16px;
        }

        /* ─── TABLE CARD ──────────────────────────── */
        .table-card {
            background: #fff;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 22px;
            border-bottom: 1px solid #f0f0ee;
        }

        .card-header h2 {
            font-size: 14px;
            font-weight: 700;
            color: #111;
        }

        .card-header a {
            font-size: 11.5px;
            font-weight: 600;
            color: #c89a00;
            text-decoration: none;
        }

        .card-header a:hover {
            text-decoration: underline;
        }

        table.data-table {
            width: 100%;
            border-collapse: collapse;
        }

        table.data-table thead th {
            text-align: left;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #bbb;
            padding: 10px 22px;
            border-bottom: 1px solid #f0f0ee;
        }

        table.data-table tbody tr {
            border-bottom: 1px solid #f6f6f4;
            transition: background 0.12s;
        }

        table.data-table tbody tr:last-child {
            border-bottom: none;
        }

        table.data-table tbody tr:hover {
            background: #fafaf8;
        }

        table.data-table td {
            padding: 13px 22px;
            vertical-align: middle;
        }

        .client-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: #e8e8e6;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            color: #555;
            flex-shrink: 0;
        }

        .client-name {
            font-size: 13px;
            font-weight: 600;
            color: #111;
            line-height: 1.2;
        }

        .client-loc {
            font-size: 11px;
            color: #aaa;
            margin-top: 2px;
        }

        .sesi-name {
            font-size: 13px;
            font-weight: 500;
            color: #222;
        }

        .fotografer-name {
            font-size: 11px;
            color: #aaa;
            margin-top: 2px;
        }

        /* Status badges */
        .badge {
            display: inline-block;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            padding: 4px 10px;
            border-radius: 6px;
        }

        .badge-pending {
            background: #f0f0ee;
            color: #666;
        }

        .badge-confirmed {
            background: #e8f5e2;
            color: #2a7a1e;
            border: 1px solid #c3e6b5;
        }

        .badge-review {
            background: #fff7e0;
            color: #8a6200;
            border: 1px solid #fce38a;
        }

        /* Action buttons */
        .action-btn {
            width: 28px;
            height: 28px;
            border-radius: 7px;
            border: 1px solid #e4e4e2;
            background: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.12s;
        }

        .action-btn:hover.confirm {
            border-color: #f5c518;
            background: #fffbe6;
        }

        .action-btn:hover.reject {
            border-color: #ff5555;
            background: #fff0f0;
        }

        .action-btn svg {
            width: 13px;
            height: 13px;
        }

        .action-btn.confirm svg {
            color: #c89a00;
        }

        .action-btn.reject svg {
            color: #e53e3e;
        }

        .action-btn.menu svg {
            color: #999;
        }

        /* ─── POSTINGAN CARD ──────────────────────── */
        .posts-card {
            background: #fff;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
        }

        .posts-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 20px;
            border-bottom: 1px solid #f0f0ee;
        }

        .posts-header h2 {
            font-size: 14px;
            font-weight: 700;
            color: #111;
        }

        .posts-tab {
            font-size: 10.5px;
            font-weight: 600;
            color: #aaa;
            padding: 4px 10px;
            border-radius: 6px;
            background: #f5f5f3;
        }

        .post-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 13px 20px;
            border-bottom: 1px solid #f6f6f4;
            transition: background 0.12s;
        }

        .post-item:last-child {
            border-bottom: none;
        }

        .post-item:hover {
            background: #fafaf8;
        }

        .post-thumb {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            background: #e8e8e6;
            overflow: hidden;
            flex-shrink: 0;
            object-fit: cover;
        }

        .post-thumb-placeholder {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            background: #e0e0de;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .post-thumb-placeholder svg {
            width: 20px;
            height: 20px;
            color: #bbb;
        }

        .post-info {
            flex: 1;
            min-width: 0;
        }

        .post-title {
            font-size: 12.5px;
            font-weight: 600;
            color: #111;
            line-height: 1.3;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .post-meta {
            font-size: 10.5px;
            color: #aaa;
            margin-top: 3px;
        }

        .post-badge {
            display: inline-block;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            padding: 2px 7px;
            border-radius: 4px;
            margin-top: 5px;
        }

        .post-badge.published {
            background: #e8f5e2;
            color: #2a7a1e;
        }

        .post-badge.draft {
            background: #f0f0ee;
            color: #888;
        }

        /* ─── FOOTER ──────────────────────────────── */
        .dash-footer {
            margin-top: 40px;
            padding-top: 28px;
            border-top: 1px solid #e8e8e6;
            display: grid;
            grid-template-columns: 1.4fr 1fr 1fr 1fr;
            gap: 28px;
        }

        .footer-col-title {
            font-size: 12.5px;
            font-weight: 700;
            color: #111;
            margin-bottom: 10px;
        }

        .footer-col p {
            font-size: 11.5px;
            color: #999;
            line-height: 1.6;
        }

        .footer-col a {
            display: block;
            font-size: 12px;
            color: #666;
            text-decoration: none;
            margin-bottom: 6px;
            transition: color 0.12s;
        }

        .footer-col a:hover {
            color: #111;
        }
    </style>

    {{-- ═══ STAT CARDS ══════════════════════════════════════════ --}}
    <div class="stat-grid">

        {{-- Total Pendapatan --}}
        <div class="stat-card">
            <div class="stat-card-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                </svg>
            </div>
            <span class="stat-badge green">+12.5%</span>
            <div class="stat-label" style="margin-bottom:6px">Total Pendapatan</div>
            <div class="stat-value sm">Rp {{ number_format($pendapatan ?? 84250000, 0, ',', '.') }}</div>
        </div>

        {{-- Pemesanan Aktif --}}
        <div class="stat-card">
            <div class="stat-card-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <span class="stat-badge"
                style="top:22px;right:22px;font-size:11px;font-weight:600;color:#1d8a45;position:absolute">
                {{ $pemesananBaru ?? 8 }} Baru
            </span>
            <div class="stat-label" style="margin-bottom:6px">Pemesanan Aktif</div>
            <div class="stat-value">{{ $pemesananAktif ?? 142 }}</div>
        </div>

        {{-- Postingan Gallery (dark) --}}
        <div class="stat-card dark">
            <div class="stat-card-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M14 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <span class="stat-badge dark-badge" style="position:absolute;top:22px;right:22px;">Update Terakhir</span>
            <div class="stat-label" style="margin-bottom:6px">Postingan Gallery</div>
            <div class="stat-value">{{ $totalPostingan ?? 24 }} Post</div>
        </div>

    </div>

    {{-- ═══ BOTTOM GRID ═════════════════════════════════════════ --}}
    <div class="bottom-grid">

        {{-- TABLE: Manajemen Pemesanan --}}
        <div class="table-card">
            <div class="card-header">
                <h2>Manajemen Pemesanan</h2>
                <a href="#">Lihat Semua →</a>
            </div>

            @php
                $pemesanan = $pemesananTerbaru ?? [
                    [
                        'nama' => 'Andini Sekar',
                        'lokasi' => 'Jakarta Selatan',
                        'sesi' => 'Pre-Wedding Gold',
                        'fotografer' => 'Bramantya Putra',
                        'status' => 'pending',
                    ],
                    [
                        'nama' => 'Raka Fauzi',
                        'lokasi' => 'Bandung',
                        'sesi' => 'Potret Bisnis',
                        'fotografer' => 'Citra Maharani',
                        'status' => 'confirmed',
                    ],
                    [
                        'nama' => 'Maya Lestari',
                        'lokasi' => 'Yogyakarta',
                        'sesi' => 'Family Studio',
                        'fotografer' => 'Dimas Anggara',
                        'status' => 'pending',
                    ],
                ];

                $avatarPalette = ['#d4a8a0', '#a8b8d4', '#b4d4a8', '#d4c8a8', '#c4a8d4'];
            @endphp

            <table class="data-table">
                <thead>
                    <tr>
                        <th>Klien</th>
                        <th>Sesi &amp; Fotografer</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pemesanan as $i => $p)
                        @php
                            $initials = collect(explode(' ', $p['nama']))
                                ->map(fn($w) => strtoupper(substr($w, 0, 1)))
                                ->take(2)
                                ->join('');

                            $badgeClass = match ($p['status']) {
                                'confirmed' => 'badge-confirmed',
                                'review' => 'badge-review',
                                default => 'badge-pending',
                            };
                            $badgeLabel = match ($p['status']) {
                                'confirmed' => 'Confirmed',
                                'review' => 'In Review',
                                default => 'Pending',
                            };
                            $bgColor = $avatarPalette[$i % count($avatarPalette)];
                        @endphp
                        <tr>
                            {{-- Klien --}}
                            <td>
                                <div style="display:flex;align-items:center;gap:10px">
                                    <div class="client-avatar" style="background:{{ $bgColor }};color:#fff;">
                                        {{ $initials }}
                                    </div>
                                    <div>
                                        <div class="client-name">{{ $p['nama'] }}</div>
                                        <div class="client-loc">{{ $p['lokasi'] }}</div>
                                    </div>
                                </div>
                            </td>

                            {{-- Sesi --}}
                            <td>
                                <div class="sesi-name">{{ $p['sesi'] }}</div>
                                <div class="fotografer-name">{{ $p['fotografer'] }}</div>
                            </td>

                            {{-- Status --}}
                            <td>
                                <span class="badge {{ $badgeClass }}">{{ $badgeLabel }}</span>
                            </td>

                            {{-- Aksi --}}
                            <td>
                                @if ($p['status'] === 'confirmed')
                                    <button class="action-btn menu">
                                        <svg viewBox="0 0 24 24" fill="currentColor">
                                            <circle cx="5" cy="12" r="2" />
                                            <circle cx="12" cy="12" r="2" />
                                            <circle cx="19" cy="12" r="2" />
                                        </svg>
                                    </button>
                                @else
                                    <div style="display:flex;gap:5px">
                                        <button class="action-btn confirm">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </button>
                                        <button class="action-btn reject">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- POSTINGAN TERBARU --}}
        <div class="posts-card">
            <div class="posts-header">
                <h2>Postingan Terbaru</h2>
                <span class="posts-tab">Blog &amp; Gallery</span>
            </div>

            @php
                $posts = $postinganTerbaru ?? [
                    [
                        'judul' => 'Esensi Pernikahan Modern',
                        'kategori' => 'Gallery',
                        'waktu' => '2 Jam Lalu',
                        'status' => 'published',
                        'img' => null,
                    ],
                    [
                        'judul' => 'Tips Fotografi Outdoor',
                        'kategori' => 'Blog',
                        'waktu' => 'Kemarin',
                        'status' => 'published',
                        'img' => null,
                    ],
                    [
                        'judul' => 'Potret Studio Minimalis',
                        'kategori' => 'Gallery',
                        'waktu' => '3 Hari Lalu',
                        'status' => 'draft',
                        'img' => null,
                    ],
                ];
            @endphp

            @foreach ($posts as $post)
                <div class="post-item">
                    {{-- Thumbnail --}}
                    @if (!empty($post['img']))
                        <img src="{{ $post['img'] }}" class="post-thumb" alt="{{ $post['judul'] }}">
                    @else
                        <div class="post-thumb-placeholder">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M14 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif

                    {{-- Info --}}
                    <div class="post-info">
                        <div class="post-title">{{ $post['judul'] }}</div>
                        <div class="post-meta">{{ $post['waktu'] }} • {{ $post['kategori'] }}</div>
                        <span class="post-badge {{ $post['status'] === 'published' ? 'published' : 'draft' }}">
                            {{ $post['status'] === 'published' ? 'Published' : 'Draft' }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>

    </div>

    {{-- ═══ FOOTER ══════════════════════════════════════════════ --}}
    <div class="dash-footer">
        <div class="footer-col">
            <div class="footer-col-title">MomentHub</div>
            <p>Platform kurasi fotografer profesional terpercaya untuk setiap momen berharga Anda.</p>
        </div>
        <div class="footer-col">
            <div class="footer-col-title">Pintasan</div>
            <a href="{{ route('admin.dashboard') }}">Dashboard Admin</a>
            <a href="#">Kelola Postingan</a>
            <a href="#">Laporan Pendapatan</a>
        </div>
        <div class="footer-col">
            <div class="footer-col-title">Bantuan</div>
            <a href="#">Pusat Bantuan</a>
            <a href="#">Kontak Support</a>
            <a href="#">Kebijakan Privasi</a>
        </div>
        <div class="footer-col">
            <div class="footer-col-title">Copyright</div>
            <p>© {{ date('Y') }} MomentHub. Hak Cipta Dilindungi.</p>
        </div>
    </div>

@endsection
