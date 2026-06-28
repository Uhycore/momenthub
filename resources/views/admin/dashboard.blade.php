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

        .stat-badge.red {
            background: #fee2e2;
            color: #b91c1c;
        }

        .stat-badge.amber {
            color: #c89a00;
            font-size: 11px;
            font-weight: 600;
            background: none;
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
            font-size: 20px;
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
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
        }

        .client-name {
            font-size: 13px;
            font-weight: 600;
            color: #111;
            line-height: 1.2;
        }

        .client-sub {
            font-size: 11px;
            color: #aaa;
            margin-top: 2px;
        }

        .sesi-name {
            font-size: 13px;
            font-weight: 500;
            color: #222;
        }

        .sesi-date {
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
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
        }

        .badge-completed {
            background: #111;
            color: #fff;
        }

        .badge-editing {
            background: #e0e7ff;
            color: #3730a3;
            border: 1px solid #a5b4fc;
        }

        .badge-done {
            background: #d1fae5;
            color: #166534;
            border: 1px solid #6ee7b7;
        }

        .badge-rejected {
            background: #fee2e2;
            color: #b91c1c;
            border: 1px solid #fca5a5;
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
            text-decoration: none;
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

        .action-btn:hover.confirm {
            border-color: #f5c518;
            background: #fffbe6;
        }

        .action-btn:hover.reject {
            border-color: #ff5555;
            background: #fff0f0;
        }

        /* Empty */
        .table-empty {
            text-align: center;
            padding: 40px 20px;
            color: #ccc;
            font-size: 12.5px;
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
            object-fit: cover;
            flex-shrink: 0;
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

        .posts-empty {
            text-align: center;
            padding: 40px 20px;
            color: #ccc;
            font-size: 12px;
        }
    </style>

    {{-- ═══ STAT CARDS ══════════════════════════════════════════ --}}
    <div class="stat-grid">

        {{-- Total Pendapatan --}}
        <div class="stat-card">
            <div class="stat-card-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>

            @if (!is_null($pendapatanPct))
                <span class="stat-badge {{ $pendapatanPct >= 0 ? 'green' : 'red' }}">
                    {{ $pendapatanPct >= 0 ? '+' : '' }}{{ $pendapatanPct }}%
                </span>
            @endif

            <div class="stat-label" style="margin-bottom:6px">Total Pendapatan</div>
            <div class="stat-value sm">Rp {{ number_format($pendapatan, 0, ',', '.') }}</div>
        </div>

        {{-- Pemesanan Aktif --}}
        <div class="stat-card">
            <div class="stat-card-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            @if ($pemesananBaru > 0)
                <span class="stat-badge amber">{{ $pemesananBaru }} Baru</span>
            @endif
            <div class="stat-label" style="margin-bottom:6px">Pemesanan Aktif</div>
            <div class="stat-value">{{ $pemesananAktif }}</div>
        </div>

        {{-- Postingan Gallery --}}
        <div class="stat-card dark">
            <div class="stat-card-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M14 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <span class="stat-badge dark-badge" style="position:absolute;top:22px;right:22px;">Semua Postingan</span>
            <div class="stat-label" style="margin-bottom:6px">Postingan Gallery</div>
            <div class="stat-value">{{ $totalPostingan }} Post</div>
        </div>

    </div>

    {{-- ═══ BOTTOM GRID ═════════════════════════════════════════ --}}
    <div class="bottom-grid">

        {{-- TABLE: Pemesanan Terbaru --}}
        <div class="table-card">
            <div class="card-header">
                <h2>Pemesanan Terbaru</h2>
                <a href="{{ route('admin.bookings.index') }}">Lihat Semua →</a>
            </div>

            @php
                $avatarPalette = ['#d4a8a0', '#a8b8d4', '#b4d4a8', '#d4c8a8', '#c4a8d4'];
            @endphp

            <table class="data-table">
                <thead>
                    <tr>
                        <th>Klien</th>
                        <th>Paket &amp; Tanggal</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pemesananTerbaru as $i => $bk)
                        @php
                            $initials = collect(explode(' ', $bk->user->name ?? 'U'))
                                ->map(fn($w) => strtoupper(substr($w, 0, 1)))
                                ->take(2)
                                ->join('');
                            $bgColor = $avatarPalette[$i % count($avatarPalette)];
                            $badgeClass = match ($bk->status) {
                                'confirmed' => 'badge-confirmed',
                                'completed' => 'badge-completed',
                                'editing' => 'badge-editing',
                                'done' => 'badge-done',
                                'rejected' => 'badge-rejected',
                                default => 'badge-pending',
                            };
                            $badgeLabel = match ($bk->status) {
                                'confirmed' => 'Confirmed',
                                'completed' => 'Completed',
                                'editing' => 'Editing',
                                'done' => 'Done',
                                'rejected' => 'Rejected',
                                default => 'Pending',
                            };

                            $sameDay = $bk->start_date->toDateString() === $bk->end_date->toDateString();
                        @endphp
                        <tr>
                            <td>
                                <div style="display:flex;align-items:center;gap:10px">
                                    <div class="client-avatar" style="background:{{ $bgColor }}">{{ $initials }}
                                    </div>
                                    <div>
                                        <div class="client-name">{{ $bk->user->name ?? '-' }}</div>
                                        <div class="client-sub">{{ $bk->user->email ?? '' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="sesi-name">{{ $bk->package->name ?? '-' }}</div>
                                <div class="sesi-date">
                                    {{ $bk->start_date->format('d M Y, H:i') }}
                                    @if (!$sameDay)
                                        – {{ $bk->end_date->format('d M Y, H:i') }}
                                    @else
                                        – {{ $bk->end_date->format('H:i') }}
                                    @endif
                                </div>
                            </td>
                            <td style="font-size:13px;font-weight:700;color:#111;white-space:nowrap;">
                                {{ $bk->formatted_total }}
                            </td>
                            <td>
                                <span class="badge {{ $badgeClass }}">{{ $badgeLabel }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="table-empty">Belum ada pemesanan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- POSTINGAN TERBARU --}}
        <div class="posts-card">
            <div class="posts-header">
                <h2>Postingan Terbaru</h2>
                <span class="posts-tab">Blog &amp; Gallery</span>
            </div>

            @forelse ($postinganTerbaru as $post)
                <div class="post-item">
                    {{-- Thumbnail --}}
                    @if ($post->image ?? null)
                        <img src="{{ asset('storage/' . $post->image) }}" class="post-thumb" alt="{{ $post->title }}">
                    @else
                        <div class="post-thumb-placeholder">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M14 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif

                    <div class="post-info">
                        <div class="post-title">{{ $post->title }}</div>
                        <div class="post-meta">
                            {{ $post->created_at->diffForHumans() }}
                            @if ($post->category ?? null)
                                &bull; {{ $post->category }}
                            @endif
                        </div>
                        <span class="post-badge {{ $post->is_published ?? false ? 'published' : 'draft' }}">
                            {{ $post->is_published ?? false ? 'Published' : 'Draft' }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="posts-empty">Belum ada postingan.</div>
            @endforelse
        </div>

    </div>

@endsection
