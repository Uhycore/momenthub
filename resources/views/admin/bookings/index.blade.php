@extends('admin.layouts.app')

@section('page-title', 'Manajemen Pesanan')
@section('page-subtitle', now()->translatedFormat('l, d F Y'))

@section('content')

    <style>
        /* ── Stat cards ── */
        .bk-stat-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            margin-bottom: 24px;
        }

        .bk-stat {
            background: #fff;
            border-radius: 14px;
            padding: 20px 22px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
        }

        .bk-stat-label {
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: #bbb;
            margin-bottom: 8px;
        }

        .bk-stat-value {
            font-size: 28px;
            font-weight: 800;
            color: #111;
            letter-spacing: -0.03em;
            line-height: 1;
            margin-bottom: 6px;
        }

        .bk-stat-sub {
            font-size: 11px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .bk-stat-sub.green {
            color: #1d8a45;
        }

        .bk-stat-sub.amber {
            color: #c89a00;
        }

        .bk-stat-sub.gray {
            color: #aaa;
        }

        /* ── Toolbar ── */
        .bk-toolbar {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 16px;
            flex-wrap: wrap;
        }

        .bk-toolbar-label {
            font-size: 9.5px;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #bbb;
            margin-right: 2px;
        }

        .bk-select {
            padding: 7px 28px 7px 12px;
            border: 1.5px solid #e8e8e6;
            border-radius: 8px;
            font-size: 12.5px;
            color: #333;
            background: #fff;
            font-family: inherit;
            cursor: pointer;
            transition: border-color 0.13s;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6' fill='none' stroke='%23999' stroke-width='2'%3E%3Cpath d='M1 1l4 4 4-4'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 10px center;
        }

        .bk-select:focus {
            outline: none;
            border-color: #f5c518;
        }

        /* ── Card wrapper: overflow visible supaya dropdown tidak terpotong ── */
        .bk-card {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
            border: 1px solid #f0f0ee;
            overflow: visible;
            /* PENTING: jangan hidden */
        }

        /* ── Table ── */
        .bk-table-wrap {
            overflow-x: auto;
            border-radius: 14px 14px 0 0;
        }

        .bk-table {
            width: 100%;
            border-collapse: collapse;
        }

        .bk-table thead th {
            text-align: left;
            font-size: 9.5px;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #bbb;
            padding: 11px 18px;
            border-bottom: 1px solid #f0f0ee;
            background: #fafaf8;
            white-space: nowrap;
        }

        .bk-table thead tr th:first-child {
            border-radius: 13px 0 0 0;
        }

        .bk-table thead tr th:last-child {
            border-radius: 0 13px 0 0;
        }

        .bk-table tbody tr {
            border-bottom: 1px solid #f5f5f3;
            transition: background 0.12s;
        }

        .bk-table tbody tr:last-child {
            border-bottom: none;
        }

        .bk-table tbody tr:hover {
            background: #fafaf8;
        }

        .bk-table td {
            padding: 13px 18px;
            vertical-align: middle;
        }

        /* ── Cell styles ── */
        .bk-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
        }

        .bk-client-name {
            font-size: 13px;
            font-weight: 600;
            color: #111;
        }

        .bk-client-email {
            font-size: 10.5px;
            color: #aaa;
            margin-top: 1px;
        }

        .bk-order-id {
            font-size: 11.5px;
            font-weight: 700;
            color: #555;
            font-family: monospace;
        }

        .bk-date {
            font-size: 12px;
            color: #555;
            white-space: nowrap;
        }

        .bk-date-sub {
            font-size: 10.5px;
            color: #aaa;
            margin-top: 1px;
            white-space: nowrap;
        }

        .bk-total {
            font-size: 13px;
            font-weight: 700;
            color: #111;
            white-space: nowrap;
        }

        .bk-pkg-tag {
            display: inline-block;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 3px 7px;
            border-radius: 4px;
            background: #f0f0ee;
            color: #666;
            white-space: nowrap;
        }

        /* ── Status badges ── */
        .bk-badge {
            display: inline-block;
            font-size: 9.5px;
            font-weight: 800;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            padding: 4px 10px;
            border-radius: 6px;
            white-space: nowrap;
        }

        .bk-badge-pending {
            background: #f0f0ee;
            color: #777;
        }

        .bk-badge-confirmed {
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
        }

        .bk-badge-rejected {
            background: #fee2e2;
            color: #b91c1c;
            border: 1px solid #fca5a5;
        }

        .bk-badge-completed {
            background: #111;
            color: #fff;
        }

        .bk-badge-editing {
            background: #e0e7ff;
            color: #3730a3;
            border: 1px solid #a5b4fc;
        }

        .bk-badge-done {
            background: #d1fae5;
            color: #166534;
            border: 1px solid #6ee7b7;
        }

        /* ── Action buttons ── */
        .bk-act-btn {
            width: 28px;
            height: 28px;
            border-radius: 7px;
            border: 1px solid #e8e8e6;
            background: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.12s;
            text-decoration: none;
        }

        .bk-act-btn svg {
            width: 13px;
            height: 13px;
        }

        .bk-act-btn.edit svg {
            color: #888;
        }

        .bk-act-btn.edit:hover {
            border-color: #f5c518;
            background: #fffbe6;
        }

        .bk-act-btn.edit:hover svg {
            color: #c89a00;
        }

        .bk-act-btn.del svg {
            color: #888;
        }

        .bk-act-btn.del:hover {
            border-color: #fca5a5;
            background: #fff0f0;
        }

        .bk-act-btn.del:hover svg {
            color: #e53e3e;
        }

        /* ── Proof link ── */
        .bk-proof-link {
            font-size: 11px;
            font-weight: 600;
            color: #c89a00;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .bk-proof-link:hover {
            text-decoration: underline;
        }

        .bk-proof-link svg {
            width: 11px;
            height: 11px;
        }

        /* ── Pagination ── */
        .bk-pagination {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 13px 18px;
            border-top: 1px solid #f0f0ee;
            border-radius: 0 0 14px 14px;
            background: #fff;
            font-size: 11.5px;
            color: #aaa;
        }

        .bk-page-btns {
            display: flex;
            gap: 4px;
        }

        .bk-page-btn {
            min-width: 30px;
            height: 30px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #e8e8e6;
            border-radius: 7px;
            font-size: 12px;
            font-weight: 600;
            color: #555;
            text-decoration: none;
            background: #fff;
            transition: all 0.12s;
            padding: 0 8px;
        }

        .bk-page-btn:hover {
            border-color: #f5c518;
            color: #c89a00;
        }

        .bk-page-btn.active {
            background: #111;
            color: #fff;
            border-color: #111;
        }

        .bk-page-btn.disabled {
            opacity: 0.35;
            pointer-events: none;
            cursor: default;
        }

        /* ── Empty ── */
        .bk-empty {
            text-align: center;
            padding: 60px 20px;
            color: #bbb;
        }

        .bk-empty svg {
            width: 36px;
            height: 36px;
            margin: 0 auto 10px;
            display: block;
        }

        .bk-empty p {
            font-size: 13px;
        }
    </style>

    {{-- ── STAT CARDS ── --}}
    <div class="bk-stat-grid">
        <div class="bk-stat">
            <div class="bk-stat-label">Total Pesanan</div>
            <div class="bk-stat-value">{{ number_format($stats['total']) }}</div>
            <div class="bk-stat-sub green">
                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                </svg>
                12.5%
            </div>
        </div>
        <div class="bk-stat">
            <div class="bk-stat-label">Menunggu</div>
            <div class="bk-stat-value">{{ $stats['pending'] }}</div>
            <div class="bk-stat-sub amber">
                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    stroke-width="2">
                    <circle cx="12" cy="12" r="10" />
                    <path stroke-linecap="round" d="M12 8v4l2 2" />
                </svg>
                Butuh Tindakan
            </div>
        </div>
        <div class="bk-stat">
            <div class="bk-stat-label">Pendapatan</div>
            <div class="bk-stat-value" style="font-size:22px;">
                Rp {{ number_format($stats['pendapatan'] / 1000000, 1, '.', ',') }}M
            </div>
            <div class="bk-stat-sub green">
                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                </svg>
                8.2%
            </div>
        </div>
        <div class="bk-stat">
            <div class="bk-stat-label">Kepuasan</div>
            <div class="bk-stat-value">4.9<span style="font-size:16px;color:#aaa;">/5.0</span></div>
            <div class="bk-stat-sub gray">
                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955
                                 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622
                                 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                98% Terverifikasi
            </div>
        </div>
    </div>

    {{-- ── TOOLBAR ── --}}
    <div class="bk-toolbar">
        <form method="GET" action="{{ route('admin.bookings.index') }}"
            style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
            <div style="display:flex;align-items:center;gap:6px;">
                <span class="bk-toolbar-label">Status</span>
                <select name="status" class="bk-select" onchange="this.form.submit()">
                    <option value="all" {{ $status === 'all' ? 'selected' : '' }}>Semua Status</option>
                    <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Menunggu</option>
                    <option value="confirmed" {{ $status === 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
                    <option value="completed" {{ $status === 'completed' ? 'selected' : '' }}>Selesai</option>
                    <option value="rejected" {{ $status === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
            <div style="display:flex;align-items:center;gap:6px;">
                <span class="bk-toolbar-label">Rentang Waktu</span>
                <select name="range" class="bk-select" onchange="this.form.submit()">
                    <option value="7" {{ $dateRange === '7' ? 'selected' : '' }}>7 Hari Terakhir</option>
                    <option value="30" {{ $dateRange === '30' ? 'selected' : '' }}>30 Hari Terakhir</option>
                    <option value="90" {{ $dateRange === '90' ? 'selected' : '' }}>90 Hari Terakhir</option>
                    <option value="all"{{ $dateRange === 'all' ? 'selected' : '' }}>Semua Waktu</option>
                </select>
            </div>
        </form>
    </div>

    {{-- ── TABLE CARD ── --}}
    <div class="bk-card">
        <div class="bk-table-wrap">
            <table class="bk-table">
                <thead>
                    <tr>
                        <th>ID Pesanan</th>
                        <th>Klien</th>
                        <th>Tanggal Sesi</th>
                        <th>Paket Layanan</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th style="text-align:right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bookings as $booking)
                        @php
                            $colors = ['#d4a8a0', '#a8b8d4', '#b4d4a8', '#d4c8a8', '#c4a8d4', '#a8c4d4'];
                            $color = $colors[$booking->id % count($colors)];
                            $initials = collect(explode(' ', $booking->user->name ?? 'U'))
                                ->map(fn($w) => strtoupper(substr($w, 0, 1)))
                                ->take(2)
                                ->join('');
                            $badgeClass = match ($booking->status) {
                                'confirmed' => 'bk-badge-confirmed',
                                'rejected' => 'bk-badge-rejected',
                                'completed' => 'bk-badge-completed',
                                'editing' => 'bk-badge-editing',
                                'done' => 'bk-badge-done',
                                default => 'bk-badge-pending',
                            };
                            $badgeLabel = match ($booking->status) {
                                'confirmed' => 'Confirmed',
                                'rejected' => 'Rejected',
                                'completed' => 'Completed',
                                'editing' => 'Editing',
                                'done' => 'Done',
                                default => 'Pending',
                            };
                            $orderId = str_pad($booking->id, 4, '0', STR_PAD_LEFT);
                        @endphp
                        <tr>
                            <td>
                                <div class="bk-order-id">#ORD-{{ $orderId }}</div>
                            </td>

                            <td>
                                <div style="display:flex;align-items:center;gap:10px;">
                                    <div class="bk-avatar" style="background:{{ $color }}">{{ $initials }}
                                    </div>
                                    <div>
                                        <div class="bk-client-name">{{ $booking->user->name ?? '-' }}</div>
                                        <div class="bk-client-email">{{ $booking->user->email ?? '' }}</div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="bk-date">{{ $booking->start_date->format('d M Y') }}</div>
                                <div class="bk-date-sub">s/d {{ $booking->end_date->format('d M Y') }}</div>
                            </td>

                            <td><span class="bk-pkg-tag">{{ $booking->package->name ?? '-' }}</span></td>

                            <td>
                                <div class="bk-total">{{ $booking->formatted_total }}</div>
                            </td>

                            <td><span class="bk-badge {{ $badgeClass }}">{{ $badgeLabel }}</span></td>

                            <td>
                                <div style="display:flex;gap:5px;justify-content:flex-end;">
                                    {{-- Edit --}}
                                    <button type="button" class="bk-act-btn edit" title="Update Status"
                                        onclick="openBkUpdateModal(
                                            {{ $booking->id }},
                                            '{{ addslashes($booking->user->name ?? '-') }}',
                                            '{{ addslashes($booking->package->name ?? '-') }}',
                                            '{{ $booking->status }}',
                                            '{{ addslashes($booking->notes ?? '') }}',
                                            '{{ addslashes($booking->drive_link ?? '') }}',
                                            '{{ $booking->payment_proof_url ?? '' }}'
                                        )">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5
                                                         m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>

                                    {{-- Hapus --}}
                                    <form method="POST" action="{{ route('admin.bookings.destroy', $booking) }}"
                                        onsubmit="return confirm('Hapus pesanan #ORD-{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}?')"
                                        style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="bk-act-btn del" title="Hapus">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862
                                                             a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6
                                                             m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="bk-empty">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7
                                                     a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    <p>Tidak ada pesanan ditemukan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ── Pagination ── --}}
        <div class="bk-pagination">
            @if ($bookings->total() > 0)
                <span>
                    Menampilkan {{ $bookings->firstItem() ?? 0 }}–{{ $bookings->lastItem() ?? 0 }}
                    dari {{ $bookings->total() }} pesanan
                </span>
            @else
                <span>Tidak ada pesanan</span>
            @endif

            @if ($bookings->hasPages())
                <div class="bk-page-btns">
                    {{-- Prev --}}
                    @if ($bookings->onFirstPage())
                        <span class="bk-page-btn disabled">‹</span>
                    @else
                        <a href="{{ $bookings->previousPageUrl() }}" class="bk-page-btn">‹</a>
                    @endif

                    {{-- Page numbers --}}
                    @php
                        $last = $bookings->lastPage();
                        $cur = $bookings->currentPage();
                    @endphp
                    @for ($p = 1; $p <= $last; $p++)
                        @if ($p === $cur)
                            <span class="bk-page-btn active">{{ $p }}</span>
                        @elseif ($p === 1 || $p === $last || abs($p - $cur) <= 1)
                            <a href="{{ $bookings->url($p) }}" class="bk-page-btn">{{ $p }}</a>
                        @elseif (abs($p - $cur) === 2)
                            <span class="bk-page-btn disabled"
                                style="border:none;background:none;min-width:20px;">…</span>
                        @endif
                    @endfor

                    {{-- Next --}}
                    @if ($bookings->hasMorePages())
                        <a href="{{ $bookings->nextPageUrl() }}" class="bk-page-btn">›</a>
                    @else
                        <span class="bk-page-btn disabled">›</span>
                    @endif
                </div>
            @else
                <div></div>
            @endif
        </div>
    </div>


    {{-- ── UPDATE MODAL ── --}}
    @include('admin.bookings.modal')

    <script></script>

@endsection
