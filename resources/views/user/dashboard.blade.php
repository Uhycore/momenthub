@extends('user.layouts.app')
@section('title', 'Dashboard')

@section('content')

    {{-- FullCalendar --}}
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

    <style>
        /* ── Heading ── */
        .ud-greeting {
            margin-bottom: 32px;
        }

        .ud-greeting h1 {
            font-size: 26px;
            font-weight: 800;
            color: #111;
            letter-spacing: -0.02em;
            margin-bottom: 3px;
        }

        .ud-greeting p {
            font-size: 13px;
            color: #aaa;
            line-height: 1.6;
            max-width: 560px;
        }

        /* ── Stat row ── */
        .ud-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 20px;
        }

        .ud-stat {
            background: #fff;
            border-radius: 14px;
            padding: 18px 20px;
            border: 1px solid #f0f0ee;
        }

        .ud-stat.dark {
            background: #111;
            border-color: #111;
        }

        .ud-stat-lbl {
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: #bbb;
            margin-bottom: 8px;
        }

        .ud-stat.dark .ud-stat-lbl {
            color: rgba(255, 255, 255, 0.35);
        }

        .ud-stat-val {
            font-size: 24px;
            font-weight: 800;
            color: #111;
            letter-spacing: -0.03em;
            line-height: 1;
        }

        .ud-stat.dark .ud-stat-val {
            color: #fff;
        }

        .ud-stat-sub {
            font-size: 10.5px;
            color: #bbb;
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .ud-stat.dark .ud-stat-sub {
            color: rgba(255, 255, 255, 0.3);
        }

        /* ── Info cards ── */
        .ud-info {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 12px;
            margin-bottom: 20px;
        }

        .ud-ic {
            background: #fff;
            border-radius: 14px;
            padding: 20px;
            border: 1px solid #f0f0ee;
        }

        .ud-ic.yellow {
            background: #f5c518;
            border-color: #f5c518;
        }

        .ud-ic.muted {
            background: #f9f9f7;
            border-color: #f0f0ee;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .ud-ic-eyebrow {
            font-size: 9.5px;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #aaa;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* ── Badge ── */
        .ud-badge {
            display: inline-block;
            font-size: 9px;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 3px 8px;
            border-radius: 5px;
        }

        .ud-badge-confirmed {
            background: #e8f7ee;
            color: #1d8a45;
        }

        .ud-badge-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .ud-badge-rejected {
            background: #fee2e2;
            color: #b91c1c;
        }

        .ud-badge-done {
            background: #e8f7ee;
            color: #1d8a45;
        }

        .ud-badge-completed {
            background: #dbeafe;
            color: #1e40af;
        }

        .ud-badge-editing {
            background: #ede9fe;
            color: #5b21b6;
        }

        /* ── Bottom grid ── */
        .ud-grid {
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            gap: 16px;
            margin-bottom: 20px;
        }

        .ud-card {
            background: #fff;
            border-radius: 14px;
            border: 1px solid #f0f0ee;
            overflow: hidden;
        }

        .ud-card-head {
            padding: 14px 20px;
            border-bottom: 1px solid #f0f0ee;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .ud-card-bar {
            width: 3px;
            height: 15px;
            background: #111;
            border-radius: 2px;
            flex-shrink: 0;
        }

        .ud-card-head h3 {
            font-size: 13.5px;
            font-weight: 700;
            color: #111;
        }

        .ud-card-head a {
            margin-left: auto;
            font-size: 11px;
            font-weight: 700;
            color: #c89a00;
            text-decoration: none;
        }

        .ud-card-head a:hover {
            color: #111;
        }

        /* Table */
        .ud-table {
            width: 100%;
            border-collapse: collapse;
        }

        .ud-table thead th {
            text-align: left;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #bbb;
            padding: 10px 18px;
            border-bottom: 1px solid #f0f0ee;
        }

        .ud-table tbody tr {
            border-bottom: 1px solid #f7f7f5;
            transition: background .12s;
        }

        .ud-table tbody tr:last-child {
            border-bottom: none;
        }

        .ud-table tbody tr:hover {
            background: #fafaf8;
        }

        .ud-table td {
            padding: 12px 18px;
            vertical-align: middle;
        }

        .ud-t-name {
            font-size: 12.5px;
            font-weight: 600;
            color: #111;
        }

        .ud-t-sub {
            font-size: 10.5px;
            color: #bbb;
            margin-top: 1px;
        }

        .ud-t-date {
            font-size: 11.5px;
            color: #777;
        }

        .ud-table-empty {
            text-align: center;
            padding: 32px 20px;
            color: #ccc;
            font-size: 12.5px;
        }

        /* ── Calendar ── */
        .ud-cal-card {
            background: #fff;
            border-radius: 14px;
            border: 1px solid #f0f0ee;
            overflow: hidden;
            margin-bottom: 20px;
        }

        #ud-cal .fc-toolbar-title {
            font-size: 17px !important;
            font-weight: 800 !important;
            color: #111 !important;
        }

        #ud-cal .fc-button {
            background: #f5f5f3 !important;
            border: 1.5px solid #e8e8e6 !important;
            color: #555 !important;
            font-size: 11.5px !important;
            font-weight: 600 !important;
            border-radius: 7px !important;
            padding: 4px 10px !important;
            box-shadow: none !important;
            font-family: inherit !important;
        }

        #ud-cal .fc-button:hover {
            background: #111 !important;
            border-color: #111 !important;
            color: #fff !important;
        }

        #ud-cal .fc-button-primary:not(:disabled).fc-button-active {
            background: #111 !important;
            border-color: #111 !important;
            color: #fff !important;
            box-shadow: none !important;
        }

        #ud-cal .fc-col-header-cell-cushion {
            font-size: 9.5px !important;
            font-weight: 700 !important;
            letter-spacing: 0.12em !important;
            text-transform: uppercase !important;
            color: #bbb !important;
            text-decoration: none !important;
        }

        #ud-cal .fc-daygrid-day-number {
            font-size: 11.5px !important;
            font-weight: 600 !important;
            color: #888 !important;
            text-decoration: none !important;
        }

        #ud-cal .fc-daygrid-day.fc-day-today {
            background: #fffbe6 !important;
        }

        #ud-cal .fc-daygrid-day.fc-day-today .fc-daygrid-day-number {
            background: #f5c518 !important;
            color: #111 !important;
            border-radius: 50% !important;
            width: 22px !important;
            height: 22px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-weight: 800 !important;
            padding: 0 !important;
            margin: 3px !important;
        }

        #ud-cal .fc-event {
            border-radius: 4px !important;
            border: none !important;
            padding: 1px 6px !important;
            font-size: 11px !important;
            font-weight: 600 !important;
        }

        #ud-cal .fc-theme-standard td,
        #ud-cal .fc-theme-standard th {
            border-color: #f5f5f3 !important;
        }

        #ud-cal .fc-daygrid-day {
            min-height: 80px !important;
        }

        #ud-cal .fc-more-link {
            font-size: 10px !important;
            color: #bbb !important;
        }

        #ud-cal .fc-scrollgrid {
            border: none !important;
        }

        #ud-cal .fc-scrollgrid-section>td {
            border: none !important;
        }

        /* Tooltip */
        #ud-tip {
            position: fixed;
            background: #111;
            color: #fff;
            border-radius: 10px;
            padding: 10px 14px;
            max-width: 200px;
            font-size: 12px;
            line-height: 1.5;
            pointer-events: none;
            z-index: 9999;
            box-shadow: 0 10px 28px rgba(0, 0, 0, 0.22);
            opacity: 0;
            transition: opacity 0.15s;
        }

        #ud-tip.show {
            opacity: 1;
        }

        .ud-tip-title {
            font-size: 12.5px;
            font-weight: 800;
            margin-bottom: 2px;
        }

        .ud-tip-date {
            font-size: 10.5px;
            color: rgba(255, 255, 255, 0.5);
        }

        /* ── Footer ── */
        .ud-footer {
            background: #fff;
            border-radius: 14px;
            padding: 32px;
            border: 1px solid #f0f0ee;
        }

        .ud-footer-grid {
            display: grid;
            grid-template-columns: 1.4fr 1fr 1fr 1fr;
            gap: 24px;
            margin-bottom: 24px;
        }

        .ud-footer-brand {
            font-size: 15px;
            font-weight: 800;
            color: #111;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .ud-footer-brand-icon {
            width: 26px;
            height: 26px;
            background: #111;
            border-radius: 7px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .ud-footer-brand-icon svg {
            width: 12px;
            height: 12px;
            color: #f5c518;
        }

        .ud-footer-desc {
            font-size: 12px;
            color: #aaa;
            line-height: 1.7;
            max-width: 210px;
        }

        .ud-footer-col-title {
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #bbb;
            margin-bottom: 12px;
        }

        .ud-footer-col a {
            display: block;
            font-size: 12px;
            color: #777;
            text-decoration: none;
            margin-bottom: 8px;
            transition: color .12s;
        }

        .ud-footer-col a:hover {
            color: #111;
        }

        .ud-footer-bottom {
            border-top: 1px solid #f0f0ee;
            padding-top: 16px;
            font-size: 11px;
            color: #ccc;
        }
    </style>

    {{-- ── Greeting ── --}}
    <div class="ud-greeting">
        <h1>Selamat Datang, {{ Auth::user()->name }}.</h1>
        <p>Pantau status sesi foto, lihat jadwal mendatang, dan kelola pesanan Anda dari sini.</p>
    </div>

    {{-- ── Stats ── --}}
    <div class="ud-stats">
        <div class="ud-stat">
            <div class="ud-stat-lbl">Total Pesanan</div>
            <div class="ud-stat-val">{{ $totalBookings }}</div>
            <div class="ud-stat-sub">Sepanjang waktu</div>
        </div>
        <div class="ud-stat dark">
            <div class="ud-stat-lbl">Total Pengeluaran</div>
            <div class="ud-stat-val" style="font-size:18px;">
                Rp {{ number_format($totalSpent / 1000, 0, ',', '.') }}K
            </div>
            <div class="ud-stat-sub">Semua sesi</div>
        </div>
        <div class="ud-stat">
            <div class="ud-stat-lbl">Sesi Selesai</div>
            <div class="ud-stat-val">{{ $totalDone }}</div>
            <div class="ud-stat-sub">Status done</div>
        </div>
        <div class="ud-stat">
            <div class="ud-stat-lbl">Menunggu</div>
            <div class="ud-stat-val" style="{{ $pendingCount > 0 ? 'color:#c89a00;' : '' }}">
                {{ $pendingCount }}
            </div>
            <div class="ud-stat-sub">Belum dikonfirmasi</div>
        </div>
    </div>

    {{-- ── Info cards ── --}}
    <div class="ud-info">

        {{-- Sesi Mendatang --}}
        <div class="ud-ic">
            <div class="ud-ic-eyebrow">
                <span>Sesi Mendatang</span>
                @if ($nextBooking)
                    <span class="ud-badge ud-badge-{{ $nextBooking->status }}">
                        {{ $nextBooking->status_label }}
                    </span>
                @endif
            </div>
            @if ($nextBooking)
                <div
                    style="font-size:18px;font-weight:800;color:#111;letter-spacing:-0.02em;margin-bottom:10px;line-height:1.2;">
                    {{ $nextBooking->package->name ?? 'Paket Fotografi' }}
                </div>
                <div style="display:flex;align-items:center;gap:6px;font-size:12px;color:#aaa;">
                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    {{ $nextBooking->start_date->format('d M Y') }}
                    @if (!$nextBooking->start_date->equalTo($nextBooking->end_date))
                        — {{ $nextBooking->end_date->format('d M Y') }}
                    @endif
                </div>
            @else
                <div style="font-size:13px;color:#ccc;font-style:italic;margin-top:8px;">
                    Tidak ada sesi mendatang.
                </div>
                <a href="{{ route('price') }}"
                    style="display:inline-block;margin-top:12px;font-size:11.5px;font-weight:700;
                      color:#111;text-decoration:none;border-bottom:1.5px solid #111;">
                    Pesan Sekarang →
                </a>
            @endif
        </div>

        {{-- Galeri Siap --}}
        @if ($readyGallery)
            <div class="ud-ic yellow">
                <div style="font-size:13px;font-weight:800;color:#111;margin-bottom:8px;">Galeri Siap! 🎉</div>
                <p style="font-size:12.5px;color:rgba(0,0,0,0.6);line-height:1.5;margin-bottom:16px;">
                    Sesi <strong>{{ $readyGallery->package->name ?? 'foto' }}</strong> Anda telah selesai diproses.
                </p>
                <a href="{{ $readyGallery->drive_link }}" target="_blank"
                    style="display:inline-block;background:#111;color:#fff;font-size:12px;font-weight:700;
                      padding:9px 18px;border-radius:8px;text-decoration:none;">
                    Buka Galeri
                </a>
            </div>
        @else
            <div class="ud-ic" style="background:#f9f9f7;border-color:#f0f0ee;">
                <div class="ud-ic-eyebrow">Galeri</div>
                <div style="font-size:13px;color:#ccc;font-style:italic;margin-top:8px;">
                    Belum ada galeri yang siap.
                </div>
                <p style="font-size:11.5px;color:#bbb;margin-top:8px;line-height:1.5;">
                    Galeri akan tersedia setelah sesi foto selesai diedit.
                </p>
            </div>
        @endif

        {{-- Bantuan --}}
        <div class="ud-ic muted">
            <div
                style="width:40px;height:40px;background:#fff;border-radius:50%;border:1px solid #e8e8e6;
                    display:flex;align-items:center;justify-content:center;margin-bottom:12px;">
                <svg width="18" height="18" fill="none" stroke="#888" viewBox="0 0 24 24" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536
                             M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536
                             M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <div style="font-size:13px;font-weight:600;color:#111;margin-bottom:8px;">Butuh bantuan kurasi?</div>
            <p style="font-size:11.5px;color:#aaa;line-height:1.5;margin-bottom:12px;">
                Tim kurator kami siap membantu konsep sesi foto Anda.
            </p>
            <a href="#"
                style="font-size:10px;font-weight:800;letter-spacing:0.1em;text-transform:uppercase;
                           color:#c89a00;text-decoration:none;">
                Hubungi Konsultan →
            </a>
        </div>

    </div>

    {{-- ── Table + Calendar ── --}}
    <div class="ud-grid">

        {{-- Status Pemesanan --}}
        <div class="ud-card">
            <div class="ud-card-head">
                <div class="ud-card-bar"></div>
                <h3>Status Pemesanan</h3>
                <a href="{{ route('user.bookings') }}">Lihat semua →</a>
            </div>
            <table class="ud-table">
                <thead>
                    <tr>
                        <th>Layanan</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentBookings as $bk)
                        <tr>
                            <td>
                                <div class="ud-t-name">{{ $bk->package->name ?? '-' }}</div>
                                <div class="ud-t-sub">#MH-{{ str_pad($bk->id, 5, '0', STR_PAD_LEFT) }}</div>
                            </td>
                            <td>
                                <span class="ud-t-date">{{ $bk->start_date->format('d M Y') }}</span>
                            </td>
                            <td>
                                <span class="ud-badge ud-badge-{{ $bk->status }}">
                                    {{ $bk->status_label }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="ud-table-empty">
                                Belum ada pesanan.
                                <a href="{{ route('price') }}" style="color:#c89a00;text-decoration:none;font-weight:600;">
                                    Pesan sekarang
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Kalender mini ── --}}
        <div class="ud-cal-card">
            <div class="ud-card-head">
                <div class="ud-card-bar"></div>
                <h3>Jadwal Sesi</h3>
                <div style="display:flex;gap:10px;margin-left:auto;">
                    <span style="display:flex;align-items:center;gap:5px;font-size:10.5px;font-weight:600;color:#888;">
                        <span
                            style="width:8px;height:8px;border-radius:2px;background:#1a6e38;display:inline-block;"></span>
                        Confirmed
                    </span>
                    <span style="display:flex;align-items:center;gap:5px;font-size:10.5px;font-weight:600;color:#888;">
                        <span
                            style="width:8px;height:8px;border-radius:2px;background:#b58900;display:inline-block;"></span>
                        Pending
                    </span>
                </div>
            </div>
            <div style="padding:14px 14px 10px;">
                <div id="ud-cal"></div>
            </div>
        </div>

    </div>

    {{-- ── Footer ── --}}
    <div class="ud-footer">
        <div class="ud-footer-grid">
            <div>
                <div class="ud-footer-brand">
                    <div class="ud-footer-brand-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69
                                     h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118
                                     l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176
                                     0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363
                                     -1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                    </div>
                    MomentHub
                </div>
                <p class="ud-footer-desc">Layanan fotografi premium untuk mengabadikan momen berharga Anda.</p>
            </div>
            <div class="ud-footer-col">
                <div class="ud-footer-col-title">Perusahaan</div>
                <a href="#">Tentang Kami</a>
                <a href="#">Kontak</a>
                <a href="#">Blog</a>
            </div>
            <div class="ud-footer-col">
                <div class="ud-footer-col-title">Bantuan</div>
                <a href="#">Pusat Bantuan</a>
                <a href="#">Syarat &amp; Ketentuan</a>
                <a href="#">Kebijakan Privasi</a>
            </div>
            <div class="ud-footer-col">
                <div class="ud-footer-col-title">Navigasi</div>
                <a href="{{ route('home') }}">Beranda</a>
                <a href="{{ route('gallery') }}">Galeri</a>
                <a href="{{ route('price') }}">Pemesanan</a>
                <a href="{{ route('user.bookings') }}">Pesanan Saya</a>
            </div>
        </div>
        <div class="ud-footer-bottom">© {{ date('Y') }} MomentHub. All rights reserved.</div>
    </div>

    {{-- Tooltip --}}
    <div id="ud-tip">
        <div class="ud-tip-title" id="ud-tip-title"></div>
        <div class="ud-tip-date" id="ud-tip-date"></div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const events = @json($calendarEvents);
            const tip = document.getElementById('ud-tip');

            function fmt(s) {
                if (!s) return '';
                const d = new Date(s + 'T00:00:00');
                return d.toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'short',
                    year: 'numeric'
                });
            }

            const cal = new FullCalendar.Calendar(document.getElementById('ud-cal'), {
                initialView: 'dayGridMonth',
                locale: 'id',
                firstDay: 0,
                height: 'auto',
                headerToolbar: {
                    left: 'prev,next',
                    center: 'title',
                    right: ''
                },
                buttonText: {
                    today: 'Hari Ini'
                },
                events: events,
                eventDisplay: 'block',
                dayMaxEvents: 2,
                eventMouseEnter: function(info) {
                    const ev = info.event;
                    const ext = ev.extendedProps;
                    document.getElementById('ud-tip-title').textContent = ev.title + ' — ' + (ext
                        .status ?? '');
                    const endMs = ev.end ? ev.end.getTime() - 86400000 : null;
                    const endStr = endMs ? new Date(endMs).toISOString().split('T')[0] : null;
                    const s = fmt(ev.start.toISOString().split('T')[0]);
                    const e = endStr ? fmt(endStr) : s;
                    document.getElementById('ud-tip-date').textContent = s === e ? s : s + ' — ' + e;
                    tip.classList.add('show');
                },
                eventMouseLeave: function() {
                    tip.classList.remove('show');
                },
                eventClick: function() {
                    window.location.href = '{{ route('user.bookings') }}';
                },
            });

            document.addEventListener('mousemove', e => {
                tip.style.left = (e.clientX + 14) + 'px';
                tip.style.top = (e.clientY - 6) + 'px';
            });

            cal.render();
        });
    </script>

@endsection
