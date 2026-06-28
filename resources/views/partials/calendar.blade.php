{{--
    resources/views/partials/guest-calendar.blade.php
    @include('partials.guest-calendar')
    Taruh SEBELUM section CTA BANNER di dashboard.blade.php
--}}

<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

<style>
    .gc-wrap {
        background: #fafaf8;
        padding: 80px 0 72px;
        border-top: 1px solid #f0f0ee;
    }

    .gc-container {
        max-width: 1140px;
        margin: 0 auto;
        padding: 0 28px;
    }

    .gc-hero {
        text-align: center;
        margin-bottom: 52px;
    }

    .gc-hero-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: #fff;
        border: 1px solid #e8e8e6;
        border-radius: 20px;
        padding: 5px 14px;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: #888;
        margin-bottom: 20px;
    }

    .gc-hero-eyebrow span {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #f5c518;
        display: inline-block;
        flex-shrink: 0;
    }

    .gc-hero h2 {
        font-size: 42px;
        font-weight: 800;
        color: #111;
        letter-spacing: -0.03em;
        line-height: 1.1;
        margin-bottom: 14px;
    }

    .gc-hero h2 em {
        font-style: normal;
        color: #f5c518;
    }

    .gc-hero p {
        font-size: 14px;
        color: #888;
        line-height: 1.7;
        max-width: 460px;
        margin: 0 auto 28px;
    }

    .gc-stats {
        display: inline-flex;
        gap: 0;
        border: 1px solid #e8e8e6;
        border-radius: 12px;
        background: #fff;
        overflow: hidden;
    }

    .gc-stat-item {
        padding: 14px 28px;
        text-align: center;
        border-right: 1px solid #f0f0ee;
    }

    .gc-stat-item:last-child {
        border-right: none;
    }

    .gc-stat-num {
        font-size: 22px;
        font-weight: 800;
        color: #111;
        letter-spacing: -0.03em;
        display: block;
    }

    .gc-stat-lbl {
        font-size: 10.5px;
        font-weight: 600;
        color: #bbb;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        margin-top: 2px;
    }

    .gc-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #eeeeec;
        box-shadow: 0 2px 16px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .gc-card-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 18px 24px;
        border-bottom: 1px solid #f5f5f3;
        flex-wrap: wrap;
        gap: 12px;
    }

    .gc-card-title {
        font-size: 14px;
        font-weight: 700;
        color: #111;
    }

    .gc-card-sub {
        font-size: 11.5px;
        color: #aaa;
        margin-top: 1px;
    }

    .gc-legend {
        display: flex;
        gap: 14px;
        align-items: center;
        flex-wrap: wrap;
    }

    .gc-legend-item {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 11.5px;
        font-weight: 600;
        color: #888;
    }

    .gc-legend-dot {
        width: 10px;
        height: 10px;
        border-radius: 3px;
        flex-shrink: 0;
    }

    .gc-cal-body {
        padding: 20px 20px 16px;
    }

    /* ── FullCalendar overrides ── */
    #gc-cal .fc-toolbar {
        margin-bottom: 18px !important;
    }

    #gc-cal .fc-toolbar-title {
        font-size: 20px !important;
        font-weight: 800 !important;
        letter-spacing: -0.02em !important;
        color: #111 !important;
    }

    #gc-cal .fc-button {
        background: #f5f5f3 !important;
        border: 1.5px solid #e8e8e6 !important;
        color: #555 !important;
        font-size: 12px !important;
        font-weight: 600 !important;
        border-radius: 8px !important;
        padding: 5px 12px !important;
        box-shadow: none !important;
        transition: all 0.12s !important;
        font-family: inherit !important;
    }

    #gc-cal .fc-button:hover {
        background: #111 !important;
        border-color: #111 !important;
        color: #fff !important;
    }

    #gc-cal .fc-button-primary:not(:disabled).fc-button-active,
    #gc-cal .fc-button-primary:not(:disabled):active {
        background: #111 !important;
        border-color: #111 !important;
        color: #fff !important;
        box-shadow: none !important;
    }

    #gc-cal .fc-col-header-cell-cushion {
        font-size: 10px !important;
        font-weight: 700 !important;
        letter-spacing: 0.12em !important;
        text-transform: uppercase !important;
        color: #bbb !important;
        text-decoration: none !important;
        padding: 10px 4px !important;
    }

    #gc-cal .fc-daygrid-day-number {
        font-size: 12px !important;
        font-weight: 600 !important;
        color: #666 !important;
        text-decoration: none !important;
        padding: 6px 8px !important;
    }

    #gc-cal .fc-daygrid-day.fc-day-today {
        background: #fffbe6 !important;
    }

    #gc-cal .fc-daygrid-day.fc-day-today .fc-daygrid-day-number {
        background: #f5c518 !important;
        color: #111 !important;
        border-radius: 50% !important;
        width: 24px !important;
        height: 24px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        font-weight: 800 !important;
        padding: 0 !important;
        margin: 4px !important;
    }

    #gc-cal .fc-daygrid-day.fc-day-past .fc-daygrid-day-number {
        color: #ccc !important;
    }

    #gc-cal .fc-event {
        border-radius: 5px !important;
        border: none !important;
        padding: 2px 8px !important;
        font-size: 11.5px !important;
        font-weight: 700 !important;
        cursor: pointer !important;
        transition: opacity 0.12s !important;
    }

    #gc-cal .fc-event:hover {
        opacity: 0.85 !important;
    }

    #gc-cal .fc-event-title {
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
    }

    #gc-cal .fc-theme-standard td,
    #gc-cal .fc-theme-standard th {
        border-color: #f5f5f3 !important;
    }

    #gc-cal .fc-daygrid-day {
        min-height: 95px !important;
    }

    #gc-cal .fc-more-link {
        font-size: 10.5px !important;
        color: #bbb !important;
        font-weight: 600 !important;
        text-decoration: none !important;
    }

    #gc-cal .fc-more-link:hover {
        color: #555 !important;
    }

    #gc-cal .fc-scrollgrid {
        border: none !important;
        border-radius: 8px !important;
    }

    #gc-cal .fc-scrollgrid-section>td {
        border: none !important;
    }

    /* ── Tooltip ── */
    #gc-tip {
        position: fixed;
        z-index: 9999;
        pointer-events: none;
        background: #111;
        color: #fff;
        border-radius: 12px;
        padding: 13px 16px;
        max-width: 240px;
        min-width: 180px;
        box-shadow: 0 16px 40px rgba(0, 0, 0, 0.24);
        opacity: 0;
        transform: translateY(4px);
        transition: opacity 0.15s, transform 0.15s;
        line-height: 1.5;
    }

    #gc-tip.show {
        opacity: 1;
        transform: translateY(0);
    }

    .gc-tip-name {
        font-size: 14px;
        font-weight: 800;
        margin-bottom: 2px;
    }

    .gc-tip-pkg {
        font-size: 11px;
        color: rgba(255, 255, 255, 0.55);
        margin-bottom: 8px;
    }

    .gc-tip-badge {
        display: inline-block;
        padding: 3px 9px;
        border-radius: 5px;
        font-size: 10px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .gc-tip-date {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 11px;
        color: rgba(255, 255, 255, 0.5);
    }

    .gc-tip-date svg {
        width: 11px;
        height: 11px;
        flex-shrink: 0;
    }
</style>

{{-- ══ SECTION ═══════════════════════════════════════════════════════ --}}
<section class="gc-wrap">
    <div class="gc-container">

        {{-- Hero text --}}
        <div class="gc-hero">
            <div class="gc-hero-eyebrow">
                <span></span>
                Ketersediaan Real-Time
            </div>
            <h2>Cek Jadwal <em>Sesi Foto</em><br>Sebelum Memesan</h2>
            <p>
                Pantau tanggal yang sudah terbooking oleh klien lain dan temukan
                slot terbaik untuk momen Anda.
            </p>

            {{-- Live stats --}}
            <div class="gc-stats">
                <div class="gc-stat-item">
                    <span class="gc-stat-num" id="gc-count-confirmed">0</span>
                    <span class="gc-stat-lbl">Dikonfirmasi</span>
                </div>
                <div class="gc-stat-item">
                    <span class="gc-stat-num" id="gc-count-pending">0</span>
                    <span class="gc-stat-lbl">Menunggu</span>
                </div>
                <div class="gc-stat-item">
                    <span class="gc-stat-num" id="gc-count-month">0</span>
                    <span class="gc-stat-lbl">Bulan Ini</span>
                </div>
            </div>
        </div>

        {{-- Calendar card --}}
        <div class="gc-card">
            <div class="gc-card-head">
                <div>
                    <div class="gc-card-title">Kalender Pemesanan</div>
                    <div class="gc-card-sub">Hover event untuk detail. Klik untuk memesan.</div>
                </div>
                <div class="gc-legend">
                    <div class="gc-legend-item">
                        <div class="gc-legend-dot" style="background:#b58900;"></div>
                        Menunggu
                    </div>
                    <div class="gc-legend-item">
                        <div class="gc-legend-dot" style="background:#1a6e38;"></div>
                        Dikonfirmasi
                    </div>
                    <div class="gc-legend-item">
                        <div class="gc-legend-dot" style="background:#1e40af;"></div>
                        Terlaksana
                    </div>
                    <div class="gc-legend-item">
                        <div class="gc-legend-dot" style="background:#5b21b6;"></div>
                        Editing
                    </div>
                    <div class="gc-legend-item">
                        <div class="gc-legend-dot" style="background:#166534;"></div>
                        Selesai
                    </div>
                </div>
            </div>
            <div class="gc-cal-body">
                <div id="gc-cal"></div>
            </div>
        </div>

    </div>
</section>

{{-- Tooltip --}}
<div id="gc-tip">
    <div class="gc-tip-name" id="gc-tip-name"></div>
    <div class="gc-tip-pkg" id="gc-tip-pkg"></div>
    <div class="gc-tip-badge" id="gc-tip-badge"></div>
    <div class="gc-tip-date">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        <span id="gc-tip-date-text"></span>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const allEvents = @json($calendarEvents);

        // Peta warna → label warna tooltip
        const badgeTextColor = {
            '#1a6e38': '#4ade80', // confirmed → hijau terang
            '#1e40af': '#93c5fd', // completed → biru terang
            '#5b21b6': '#c4b5fd', // editing   → ungu terang
            '#166534': '#6ee7b7', // done      → emerald terang
            '#b58900': '#fbbf24', // pending   → kuning
        };

        // ── Live stats ────────────────────────────────────────────────
        const now = new Date();
        let confirmed = 0,
            pending = 0,
            thisMonth = 0;

        allEvents.forEach(ev => {
            if (ev.color === '#1a6e38') confirmed++;
            else pending++;

            const evStart = new Date(ev.start);
            if (evStart.getMonth() === now.getMonth() &&
                evStart.getFullYear() === now.getFullYear()) {
                thisMonth++;
            }
        });

        document.getElementById('gc-count-confirmed').textContent = confirmed;
        document.getElementById('gc-count-pending').textContent = pending;
        document.getElementById('gc-count-month').textContent = thisMonth;

        // ── Tooltip helpers ───────────────────────────────────────────
        const tip = document.getElementById('gc-tip');

        function fmtDate(dateObj) {
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

        // ── FullCalendar ──────────────────────────────────────────────
        const cal = new FullCalendar.Calendar(document.getElementById('gc-cal'), {
                initialView: 'dayGridMonth',
                locale: 'id',
                firstDay: 0,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: '',
                },
                buttonText: {
                    today: 'Hari Ini'
                },
                events: allEvents,
                eventDisplay: 'block',
                dayMaxEvents: 3,

                eventMouseEnter: function(info) {
                    const ev = info.event;
                    const ext = ev.extendedProps;

                    document.getElementById('gc-tip-name').textContent = ev.title;
                    document.getElementById('gc-tip-pkg').textContent = ext.package ?? '';

                    const badge = document.getElementById('gc-tip-badge');
                    badge.textContent = ext.status ?? '';
                    badge.style.background = ev.backgroundColor + '30';
                    badge.style.color = badgeTextColor[ev.backgroundColor] ?? '#fbbf24';

                    // Tanggal + jam
                    const start = ev.start;
                    const end = ev.end;
                    const startDate = fmtDate(start);
                    const startTime = fmtTime(start);

                    let dateText = '';
                    if (end) {
                        const endDate = fmtDate(end);
                        const endTime = fmtTime(end);
                        dateText = startDate === endDate ?
                            `${startDate}, ${startTime} – ${endTime} WIB` :
                            `${startDate} ${startTime} – ${endDate} ${endTime} WIB`;
                    } else {
                        dateText = `${startDate}, ${startTime} WIB`;
                    }

                    document.getElementById('gc-tip-date-text').textContent = dateText;
                    tip.classList.add('show');
                },

                eventMouseLeave: function() {
                    tip.classList.remove('show');
                },

                eventClick: function() {
                    @auth
                    window.location.href = '{{ route('price') }}';
                @else
                    window.location.href = '{{ route('login') }}';
                @endauth
            },
        });

    document.addEventListener('mousemove', function(e) {
        tip.style.left = (e.clientX + 18) + 'px';
        tip.style.top = (e.clientY - 12) + 'px';
    });

    cal.render();
    });
</script>
