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


    {{-- Tooltip --}}
    <div id="ud-tip">
        <div class="ud-tip-title" id="ud-tip-title"></div>
        <div class="ud-tip-date" id="ud-tip-date"></div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const events = @json($calendarEvents);
            const tip = document.getElementById('ud-tip');

            function fmt(dateObj) {
                if (!dateObj) return '';
                return dateObj.toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'short',
                    year: 'numeric'
                });
            }

            function fmtTime(dateObj) {
                if (!dateObj) return '';
                return dateObj.toLocaleTimeString('id-ID', {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
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

                    document.getElementById('ud-tip-title').textContent =
                        ev.title + ' — ' + (ext.status ?? '');

                    const start = ev.start;
                    const end = ev.end;

                    let dateText = '';
                    if (end) {
                        const startDate = fmt(start);
                        const endDate = fmt(end);
                        const startTime = fmtTime(start);
                        const endTime = fmtTime(end);

                        if (startDate === endDate) {
                            // Sesi 1 hari: "28 Jun 2026, 08:00 – 12:00 WIB"
                            dateText = `${startDate}, ${startTime} – ${endTime} WIB`;
                        } else {
                            // Beda hari: "28 Jun 2026 08:00 – 29 Jun 2026 12:00 WIB"
                            dateText = `${startDate} ${startTime} – ${endDate} ${endTime} WIB`;
                        }
                    } else {
                        dateText = `${fmt(start)}, ${fmtTime(start)} WIB`;
                    }

                    document.getElementById('ud-tip-date').textContent = dateText;
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
