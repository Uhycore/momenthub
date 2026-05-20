@extends('user.layouts.app')

@section('title', 'Pesanan Saya')

@section('content')
    <style>
        .ub-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 28px;
            flex-wrap: wrap;
        }

        .ub-search-wrap {
            position: relative;
            flex: 1;
            max-width: 380px;
        }

        .ub-search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 16px;
            height: 16px;
            color: #bbb;
            pointer-events: none;
        }

        .ub-search {
            width: 100%;
            padding: 10px 14px 10px 38px;
            border: 1.5px solid #e8e8e6;
            border-radius: 10px;
            font-size: 13px;
            color: #111;
            background: #fff;
            font-family: inherit;
            transition: border-color 0.15s, box-shadow 0.15s;
            box-sizing: border-box;
        }

        .ub-search:focus {
            outline: none;
            border-color: #f5c518;
            box-shadow: 0 0 0 3px rgba(245, 197, 24, 0.13);
        }

        .ub-search::placeholder {
            color: #bbb;
        }

        .ub-filter-tabs {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }

        .ub-tab {
            padding: 8px 18px;
            border-radius: 20px;
            font-size: 12.5px;
            font-weight: 600;
            color: #888;
            background: #fff;
            border: 1.5px solid #e8e8e6;
            text-decoration: none;
            transition: all 0.13s;
            white-space: nowrap;
        }

        .ub-tab:hover {
            color: #111;
            border-color: #aaa;
        }

        .ub-tab.active {
            background: #111;
            color: #fff;
            border-color: #111;
        }

        /* Cards */
        .ub-list {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .ub-card {
            background: #fff;
            border-radius: 14px;
            padding: 22px 24px;
            display: flex;
            gap: 20px;
            align-items: flex-start;
            border: 1px solid #f0f0ee;
        }

        /* Left accent strip */
        .ub-accent {
            width: 4px;
            flex-shrink: 0;
            border-radius: 4px;
            align-self: stretch;
            min-height: 80px;
        }

        .ub-accent-pending {
            background: #d0d0ce;
        }

        .ub-accent-confirmed {
            background: #f5c518;
        }

        .ub-accent-completed {
            background: #93c5fd;
        }

        .ub-accent-editing {
            background: #c4b5fd;
        }

        .ub-accent-done {
            background: #86efac;
        }

        .ub-accent-rejected {
            background: #fca5a5;
        }

        /* Info */
        .ub-info {
            flex: 1;
            min-width: 0;
        }

        .ub-type-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 6px;
        }

        .ub-type-label {
            font-size: 9.5px;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #aaa;
        }

        .ub-badge {
            font-size: 9px;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 3px 9px;
            border-radius: 20px;
            white-space: nowrap;
        }

        .ub-badge-pending {
            background: #f0f0ee;
            color: #777;
        }

        .ub-badge-confirmed {
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
        }

        .ub-badge-completed {
            background: #dbeafe;
            color: #1e40af;
            border: 1px solid #93c5fd;
        }

        .ub-badge-editing {
            background: #ede9fe;
            color: #5b21b6;
            border: 1px solid #c4b5fd;
        }

        .ub-badge-done {
            background: #e8f7ee;
            color: #1d7a40;
            border: 1px solid #b8e8c8;
        }

        .ub-badge-rejected {
            background: #fee2e2;
            color: #b91c1c;
            border: 1px solid #fca5a5;
        }

        .ub-pkg-name {
            font-size: 19px;
            font-weight: 800;
            color: #111;
            letter-spacing: -0.02em;
            margin-bottom: 4px;
        }

        .ub-meta {
            font-size: 12px;
            color: #aaa;
            margin-bottom: 14px;
        }

        .ub-drive-link {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 11.5px;
            font-weight: 600;
            color: #c89a00;
            background: #fffbe6;
            border: 1px solid #f5e08a;
            padding: 5px 12px;
            border-radius: 7px;
            text-decoration: none;
            margin-bottom: 14px;
            transition: background 0.12s;
        }

        .ub-drive-link:hover {
            background: #fef3c7;
        }

        .ub-drive-link svg {
            width: 12px;
            height: 12px;
        }

        .ub-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            align-items: center;
        }

        .ub-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 16px;
            border-radius: 9px;
            font-size: 12.5px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.13s;
            text-decoration: none;
            border: none;
            font-family: inherit;
        }

        .ub-btn svg {
            width: 13px;
            height: 13px;
        }

        .ub-btn-dark {
            background: #111;
            color: #fff;
        }

        .ub-btn-dark:hover {
            background: #333;
        }

        .ub-btn-yellow {
            background: #f5c518;
            color: #111;
        }

        .ub-btn-yellow:hover {
            background: #e6b800;
        }

        .ub-btn-outline {
            background: transparent;
            color: #999;
            border: 1.5px solid #e0e0de;
        }

        .ub-btn-outline:hover {
            border-color: #e53e3e;
            color: #e53e3e;
            background: #fff0f0;
        }

        /* Total col */
        .ub-total-col {
            text-align: right;
            flex-shrink: 0;
        }

        .ub-total-label {
            font-size: 10px;
            color: #aaa;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .ub-total-value {
            font-size: 17px;
            font-weight: 800;
            color: #111;
            white-space: nowrap;
        }

        /* Empty */
        .ub-empty {
            text-align: center;
            padding: 60px 20px;
            color: #bbb;
        }

        .ub-empty svg {
            width: 44px;
            height: 44px;
            margin: 0 auto 14px;
            display: block;
        }

        .ub-empty h3 {
            font-size: 16px;
            font-weight: 700;
            color: #888;
            margin-bottom: 6px;
        }

        .ub-empty p {
            font-size: 13px;
        }

        /* CTA */
        .ub-cta {
            margin-top: 32px;
            padding: 26px 28px;
            background: #fff;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
            flex-wrap: wrap;
            border: 1px solid #f0f0ee;
        }

        .ub-cta h3 {
            font-size: 15px;
            font-weight: 800;
            color: #111;
            margin-bottom: 4px;
        }

        .ub-cta p {
            font-size: 12.5px;
            color: #aaa;
            max-width: 360px;
            line-height: 1.5;
        }

        .ub-cta-btn {
            padding: 10px 22px;
            border-radius: 10px;
            background: #fff;
            border: 1.5px solid #111;
            font-size: 12.5px;
            font-weight: 700;
            color: #111;
            text-decoration: none;
            white-space: nowrap;
            transition: all 0.13s;
        }

        .ub-cta-btn:hover {
            background: #111;
            color: #fff;
        }

        /* Footer */
        .ub-footer {
            margin-top: 28px;
            padding-top: 18px;
            border-top: 1px solid #e8e8e6;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }

        .ub-footer-left {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            color: #aaa;
        }

        .ub-footer-left svg {
            width: 14px;
            height: 14px;
            flex-shrink: 0;
        }

        .ub-footer-links {
            display: flex;
            gap: 20px;
        }

        .ub-footer-links a {
            font-size: 12px;
            color: #999;
            text-decoration: none;
        }

        .ub-footer-links a:hover {
            color: #111;
        }
    </style>

    {{-- ── Search + Filter ── --}}
    <div class="ub-topbar">
        <div class="ub-search-wrap">
            <svg class="ub-search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input type="text" class="ub-search" id="ub-search" placeholder="Cari ID pesanan atau paket..."
                oninput="ubFilter()">
        </div>
        <div class="ub-filter-tabs">
            <a href="{{ route('user.bookings') }}" class="ub-tab {{ $filter === 'all' ? 'active' : '' }}">Semua</a>
            <a href="{{ route('user.bookings', ['filter' => 'diproses']) }}"
                class="ub-tab {{ $filter === 'diproses' ? 'active' : '' }}">Diproses</a>
            <a href="{{ route('user.bookings', ['filter' => 'selesai']) }}"
                class="ub-tab {{ $filter === 'selesai' ? 'active' : '' }}">Selesai</a>
            <a href="{{ route('user.bookings', ['filter' => 'dibatalkan']) }}"
                class="ub-tab {{ $filter === 'dibatalkan' ? 'active' : '' }}">Dibatalkan</a>
        </div>
    </div>

    {{-- ── List ── --}}
    @if ($bookings->isNotEmpty())
        <div class="ub-list" id="ub-list">
            @foreach ($bookings as $booking)
                @php
                    $badgeClass = match ($booking->status) {
                        'confirmed' => 'ub-badge-confirmed',
                        'completed' => 'ub-badge-completed',
                        'editing' => 'ub-badge-editing',
                        'done' => 'ub-badge-done',
                        'rejected' => 'ub-badge-rejected',
                        default => 'ub-badge-pending',
                    };
                    $badgeLabel = match ($booking->status) {
                        'confirmed' => 'Dikonfirmasi',
                        'completed' => 'Terlaksana',
                        'editing' => 'Editing',
                        'done' => 'Selesai',
                        'rejected' => 'Dibatalkan',
                        default => 'Menunggu',
                    };
                    $accentClass = match ($booking->status) {
                        'confirmed' => 'ub-accent-confirmed',
                        'completed' => 'ub-accent-completed',
                        'editing' => 'ub-accent-editing',
                        'done' => 'ub-accent-done',
                        'rejected' => 'ub-accent-rejected',
                        default => 'ub-accent-pending',
                    };
                    $orderId = '#MH-' . str_pad($booking->id, 5, '0', STR_PAD_LEFT);
                    $canEdit = in_array($booking->status, ['pending', 'confirmed']);
                    $canCancel = $booking->status === 'pending';
                @endphp

                <div class="ub-card" data-search="{{ strtolower($orderId . ' ' . ($booking->package->name ?? '')) }}">

                    {{-- Accent strip --}}
                    <div class="ub-accent {{ $accentClass }}"></div>

                    {{-- Info --}}
                    <div class="ub-info">
                        <div class="ub-type-row">
                            <span class="ub-type-label">Sesi Fotografi</span>
                            <span class="ub-badge {{ $badgeClass }}">{{ $badgeLabel }}</span>
                        </div>

                        <div class="ub-pkg-name">{{ $booking->package->name ?? 'Paket Fotografi' }}</div>

                        <div class="ub-meta">
                            {{ $orderId }} &bull;
                            {{ $booking->start_date->format('d M Y') }}
                            @if (!$booking->start_date->equalTo($booking->end_date))
                                — {{ $booking->end_date->format('d M Y') }}
                            @endif
                        </div>

                        @if ($booking->drive_link)
                            <a href="{{ $booking->drive_link }}" target="_blank" class="ub-drive-link">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4
                                             M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                                Buka Hasil Foto di Drive
                            </a>
                        @else
                            <div class="ub-drive-link">Hasil Foto belum tersedia</div>
                        @endif

                        <div class="ub-actions">
                            {{-- Lihat Detail / Edit --}}
                            <button type="button" class="ub-btn ub-btn-dark"
                                onclick="openUbModal(
                                    {{ $booking->id }},
                                    {{ $booking->package_id }},
                                    '{{ addslashes($booking->package->name ?? '') }}',
                                    '{{ $booking->formatted_total }}',
                                    '{{ $booking->start_date->format('Y-m-d') }}',
                                    '{{ $booking->end_date->format('Y-m-d') }}',
                                    '{{ addslashes($booking->notes ?? '') }}',
                                    {{ $canEdit ? 'true' : 'false' }}
                                )">
                                @if ($canEdit)
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5
                                                 m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                @endif
                                Lihat Detail
                            </button>

                            @if ($booking->status === 'done')
                                <a href="#" class="ub-btn ub-btn-yellow">
                                    <svg fill="currentColor" viewBox="0 0 20 20" width="13" height="13">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462
                                                 c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292
                                                 c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034
                                                 c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118
                                                 L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    Beri Ulasan
                                </a>
                            @endif

                            @if ($canCancel)
                                <form method="POST" action="{{ route('user.booking.cancel', $booking) }}"
                                    onsubmit="return confirm('Batalkan pesanan {{ $orderId }}?')"
                                    style="display:inline;">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="ub-btn ub-btn-outline">Batalkan</button>
                                </form>
                            @endif
                        </div>
                    </div>

                    {{-- Total --}}
                    <div class="ub-total-col">
                        <div class="ub-total-label">Total Pembayaran</div>
                        <div class="ub-total-value">{{ $booking->formatted_total }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="ub-empty">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2
                         M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            <h3>Belum ada pesanan</h3>
            <p>Kamu belum pernah memesan sesi fotografi. Yuk mulai!</p>
        </div>
    @endif

    {{-- CTA --}}
    <div class="ub-cta">
        <div>
            <h3>Ingin memesan sesi baru?</h3>
            <p>Pilih fotografer terbaik kami dan abadikan momen berharga Anda dengan kualitas sinematik eksklusif.</p>
        </div>
        <a href="{{ route('price') }}" class="ub-cta-btn">Eksplor Fotografer</a>
    </div>

    {{-- Footer --}}
    <div class="ub-footer">
        <div class="ub-footer-left">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
            </svg>
            Semua pesanan dilindungi oleh MomentHub Guarantee
        </div>
        <div class="ub-footer-links">
            <a href="#">Bantuan</a>
            <a href="#">Syarat &amp; Ketentuan</a>
            <a href="#">Hubungi Kami</a>
        </div>
    </div>

    @include('partials.user-booking-modal')

    <script>
        function ubFilter() {
            const q = document.getElementById('ub-search').value.toLowerCase();
            document.querySelectorAll('.ub-card').forEach(card => {
                card.style.display = (card.dataset.search || '').includes(q) ? '' : 'none';
            });
        }
    </script>
@endsection
