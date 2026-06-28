<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Pesanan MomentHub</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #f2f2f0;
            color: #111;
            padding: 40px 20px;
        }

        .wrapper {
            max-width: 560px;
            margin: 0 auto;
        }

        /* ── Header ── */
        .header {
            text-align: center;
            margin-bottom: 28px;
        }

        .brand {
            font-size: 22px;
            font-weight: 800;
            color: #111;
            letter-spacing: -0.02em;
        }

        .brand span {
            color: #f5c518;
        }

        .brand-sub {
            font-size: 11px;
            color: #aaa;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            margin-top: 3px;
        }

        /* ── Card ── */
        .card {
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.07);
        }

        /* ── Card top accent ── */
        .card-accent {
            height: 4px;
            background: linear-gradient(90deg, #f5c518 0%, #e8a000 100%);
        }

        .card-body {
            padding: 32px 36px;
        }

        /* ── Greeting ── */
        .greeting {
            font-size: 20px;
            font-weight: 800;
            color: #111;
            margin-bottom: 6px;
        }

        .greeting-sub {
            font-size: 13px;
            color: #888;
            line-height: 1.6;
            margin-bottom: 28px;
        }

        /* ── Order ID badge ── */
        .order-badge {
            display: inline-block;
            background: #f9f9f7;
            border: 1.5px solid #eeeeec;
            border-radius: 9px;
            padding: 10px 16px;
            margin-bottom: 24px;
        }

        .order-badge-label {
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: #bbb;
            margin-bottom: 4px;
        }

        .order-badge-id {
            font-size: 18px;
            font-weight: 800;
            color: #111;
            letter-spacing: -0.01em;
            font-family: monospace;
        }

        /* ── Detail table ── */
        .detail-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }

        .detail-table tr {
            border-bottom: 1px solid #f5f5f3;
        }

        .detail-table tr:last-child {
            border-bottom: none;
        }

        .detail-table td {
            padding: 11px 0;
            font-size: 13px;
            vertical-align: top;
        }

        .detail-table td:first-child {
            color: #aaa;
            width: 40%;
            font-weight: 500;
        }

        .detail-table td:last-child {
            color: #111;
            font-weight: 600;
            text-align: right;
        }

        /* ── Total box ── */
        .total-box {
            background: #111;
            border-radius: 10px;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 28px;
        }

        .total-label {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.5);
        }

        .total-value {
            font-size: 22px;
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.02em;
        }

        /* ── Payment instruction ── */
        .payment-box {
            background: #fffbe6;
            border: 1px solid #f5e08a;
            border-radius: 10px;
            padding: 16px 20px;
            margin-bottom: 28px;
        }

        .payment-title {
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #92400e;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .payment-row {
            font-size: 13px;
            color: #78350f;
            margin-bottom: 5px;
            line-height: 1.6;
        }

        .payment-row strong {
            color: #111;
        }

        .payment-deadline {
            font-size: 11px;
            color: #b45309;
            font-style: italic;
            margin-top: 8px;
        }

        /* ── CTA Button ── */
        .cta-wrap {
            text-align: center;
            margin-bottom: 28px;
        }

        .cta-btn {
            display: inline-block;
            background: #111;
            color: #fff;
            text-decoration: none;
            font-size: 13px;
            font-weight: 700;
            padding: 12px 28px;
            border-radius: 9px;
            letter-spacing: 0.02em;
        }

        /* ── Divider ── */
        .divider {
            border: none;
            border-top: 1px solid #f0f0ee;
            margin: 24px 0;
        }

        /* ── Footer ── */
        .footer {
            text-align: center;
            font-size: 11px;
            color: #bbb;
            line-height: 1.7;
            padding: 20px 36px 28px;
        }

        .footer a {
            color: #c89a00;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="wrapper">

        {{-- Brand --}}
        <div class="header">
            <div class="brand">Moment<span>Hub</span></div>
            <div class="brand-sub">Photography Booking</div>
        </div>

        <div class="card">
            <div class="card-accent"></div>
            <div class="card-body">

                {{-- Greeting --}}
                <div class="greeting">Halo, {{ $booking->user->name }}! 👋</div>
                <p class="greeting-sub">
                    Pesanan sesi fotografi Anda telah berhasil diterima. Berikut detail pesanan dan
                    instruksi pembayaran Anda.
                </p>

                {{-- Order ID --}}
                <div class="order-badge">
                    <div class="order-badge-label">Nomor Pesanan</div>
                    <div class="order-badge-id">#MH-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</div>
                </div>

                {{-- Detail table --}}
                <table class="detail-table">
                    <tr>
                        <td>Paket</td>
                        <td>{{ $booking->package->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Mulai</td>
                        <td>{{ $booking->start_date->format('d M Y, H:i') }} WIB</td>
                    </tr>
                    <tr>
                        <td>Selesai</td>
                        <td>{{ $booking->end_date->format('d M Y, H:i') }} WIB</td>
                    </tr>
                    @php
                        $billedHours = (int) ceil($booking->start_date->diffInMinutes($booking->end_date) / 60);
                    @endphp
                    <tr>
                        <td>Durasi</td>
                        <td>{{ $billedHours }} jam</td>
                    </tr>
                    @if ($booking->notes)
                        <tr>
                            <td>Catatan</td>
                            <td>{{ $booking->notes }}</td>
                        </tr>
                    @endif
                    <tr>
                        <td>Status</td>
                        <td>
                            <span
                                style="background:#fef3c7;color:#92400e;padding:2px 8px;border-radius:5px;font-size:11px;font-weight:700;">
                                Menunggu Pembayaran
                            </span>
                        </td>
                    </tr>
                </table>

                {{-- Total --}}
                <div class="total-box">
                    <div class="total-label">Total Pembayaran</div>
                    <div class="total-value">{{ $booking->formatted_total }}</div>
                </div>

                {{-- Payment instruction --}}
                <div class="payment-box">
                    <div class="payment-title">
                        💳 Instruksi Pembayaran
                    </div>
                    <div class="payment-row">
                        Bank: <strong>Mandiri</strong>
                    </div>
                    <div class="payment-row">
                        No. Rekening: <strong>1234567890</strong>
                    </div>
                    <div class="payment-row">
                        Jumlah: <strong>{{ $booking->formatted_total }}</strong>
                    </div>
                    <div class="payment-row">
                        Batas Bayar: <strong>{{ $booking->start_date->copy()->subDay()->format('d M Y') }}</strong>
                    </div>
                    <div class="payment-deadline">
                        * Harap transfer sesuai nominal dan kirim bukti pembayaran melalui menu "Pesanan Saya".
                    </div>
                </div>

                {{-- CTA --}}
                <div class="cta-wrap">
                    <a href="{{ url('/user/booking') }}" class="cta-btn">
                        Lihat Pesanan Saya →
                    </a>
                </div>

                <hr class="divider">

                <p style="font-size:12px;color:#aaa;text-align:center;line-height:1.7;">
                    Jika ada pertanyaan, balas email ini atau hubungi kami melalui Instagram
                    <a href="https://instagram.com/uhycore" style="color:#c89a00;">@uhycore</a>.
                </p>

            </div>

            {{-- Footer --}}
            <div class="footer">
                © {{ date('Y') }} MomentHub · Photography Booking Platform<br>
                <a href="{{ url('/') }}">momenthub.id</a> ·
                <a href="{{ url('/user/bookings') }}">Kelola Pesanan</a>
            </div>
        </div>

    </div>
</body>

</html>
