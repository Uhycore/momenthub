@php
    /*
    resources/views/partials/contact-section.blade.php
    @include('partials.contact-section')

    Taruh SEBELUM {{-- CTA BANNER --}} atau SEBELUM footer di dashboard.blade.php
    Ganti: nomor WA, email, alamat, dan src Google Maps embed
*/
@endphp

<style>
    .cs-section {
        background: #0d0d0d;
        padding: 72px 0;
    }

    .cs-container {
        max-width: 1080px;
        margin: 0 auto;
        padding: 0 28px;
    }

    /* ── Header ── */
    .cs-head {
        margin-bottom: 44px;
    }

    .cs-head-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        font-size: 9.5px;
        font-weight: 700;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: #c89a00;
        border: 1px solid rgba(245, 197, 24, 0.25);
        border-radius: 20px;
        padding: 4px 12px;
        margin-bottom: 14px;
    }

    .cs-head-eyebrow span {
        width: 5px;
        height: 5px;
        border-radius: 50%;
        background: #f5c518;
        flex-shrink: 0;
    }

    .cs-head h2 {
        font-size: 36px;
        font-weight: 800;
        color: #fff;
        letter-spacing: -0.03em;
        line-height: 1.15;
        margin-bottom: 10px;
    }

    .cs-head h2 em {
        font-style: normal;
        color: #f5c518;
    }

    .cs-head p {
        font-size: 13.5px;
        color: rgba(255, 255, 255, 0.4);
        max-width: 420px;
        line-height: 1.65;
    }

    /* ── Grid ── */
    .cs-grid {
        display: grid;
        grid-template-columns: 1fr 1.4fr;
        gap: 20px;
        align-items: start;
    }

    /* ── Left: Info + WA button ── */
    .cs-left {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    /* Info Kontak box */
    .cs-info-box {
        background: #1a1a1a;
        border: 1px solid #2a2a2a;
        border-radius: 16px;
        padding: 22px 22px 18px;
    }

    .cs-info-box-title {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        font-weight: 800;
        color: #fff;
        margin-bottom: 18px;
    }

    .cs-info-box-title svg {
        width: 16px;
        height: 16px;
        color: #f5c518;
    }

    .cs-info-item {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 13px 0;
        border-bottom: 1px solid #242424;
    }

    .cs-info-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .cs-info-icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .cs-info-icon.email {
        background: rgba(245, 197, 24, 0.1);
    }

    .cs-info-icon.wa {
        background: rgba(37, 211, 102, 0.1);
    }

    .cs-info-icon.loc {
        background: rgba(96, 165, 250, 0.1);
    }

    .cs-info-icon svg {
        width: 18px;
        height: 18px;
    }

    .cs-info-icon.email svg {
        color: #f5c518;
    }

    .cs-info-icon.wa svg {
        color: #25D366;
    }

    .cs-info-icon.loc svg {
        color: #60a5fa;
    }

    .cs-info-lbl {
        font-size: 10px;
        font-weight: 600;
        color: rgba(255, 255, 255, 0.35);
        letter-spacing: 0.05em;
        margin-bottom: 3px;
    }

    .cs-info-val {
        font-size: 14px;
        font-weight: 700;
        color: #fff;
        line-height: 1.3;
    }

    .cs-info-val a {
        color: #fff;
        text-decoration: none;
        transition: color 0.13s;
    }

    .cs-info-val a:hover {
        color: #f5c518;
    }

    /* WA CTA */
    .cs-wa-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        background: #25D366;
        color: #fff;
        text-decoration: none;
        padding: 16px;
        border-radius: 14px;
        font-size: 14px;
        font-weight: 800;
        transition: background 0.13s, transform 0.13s;
        box-shadow: 0 6px 20px rgba(37, 211, 102, 0.25);
    }

    .cs-wa-btn:hover {
        background: #1db95a;
        transform: translateY(-2px);
        box-shadow: 0 10px 28px rgba(37, 211, 102, 0.35);
    }

    .cs-wa-btn svg {
        width: 22px;
        height: 22px;
    }

    .cs-wa-sub {
        text-align: center;
        font-size: 10.5px;
        color: rgba(255, 255, 255, 0.25);
        margin-top: 8px;
    }

    /* ── Right: Maps ── */
    .cs-right {}

    .cs-map-box {
        background: #1a1a1a;
        border: 1px solid #2a2a2a;
        border-radius: 16px;
        overflow: hidden;
    }

    .cs-map-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 18px;
        border-bottom: 1px solid #242424;
    }

    .cs-map-head-left {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .cs-map-head-left svg {
        width: 14px;
        height: 14px;
        color: #60a5fa;
    }

    .cs-map-head-left span {
        font-size: 12.5px;
        font-weight: 700;
        color: #fff;
    }

    .cs-map-open {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 10.5px;
        font-weight: 700;
        color: rgba(255, 255, 255, 0.35);
        text-decoration: none;
        transition: color 0.13s;
    }

    .cs-map-open:hover {
        color: #f5c518;
    }

    .cs-map-open svg {
        width: 11px;
        height: 11px;
    }

    .cs-map-iframe {
        width: 100%;
        height: 340px;
        display: block;
        border: none;
    }

    .cs-map-addr {
        padding: 12px 18px;
        display: flex;
        align-items: center;
        gap: 8px;
        border-top: 1px solid #242424;
    }

    .cs-map-addr svg {
        width: 14px;
        height: 14px;
        color: #60a5fa;
        flex-shrink: 0;
    }

    .cs-map-addr span {
        font-size: 12px;
        color: rgba(255, 255, 255, 0.45);
    }
</style>

{{-- ══ SECTION ══════════════════════════════════════════════════════ --}}
<section class="cs-section">
    <div class="cs-container">

        {{-- Header --}}
        <div class="cs-head">
            <div class="cs-head-eyebrow">
                <span></span>
                Hubungi Kami
            </div>
            <h2>Ada Pertanyaan?<br>Kami <em>Siap Membantu.</em></h2>
            <p>Konsultasikan konsep foto Anda langsung bersama tim kurator MomentHub. Respons cepat, ramah, dan
                profesional.</p>
        </div>

        {{-- Grid --}}
        <div class="cs-grid">

            {{-- Left ── Info + WA --}}
            <div class="cs-left">
                <div class="cs-info-box">
                    <div class="cs-info-box-title">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857
                                     M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857
                                     m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Info Kontak
                    </div>

                    {{-- Email --}}
                    <div class="cs-info-item">
                        <div class="cs-info-icon email">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <div class="cs-info-lbl">Email</div>
                            {{-- Ganti email --}}
                            <div class="cs-info-val">
                                <a href="mailto:hello@momenthub.id">hello@momenthub.id</a>
                            </div>
                        </div>
                    </div>

                    {{-- WhatsApp --}}
                    <div class="cs-info-item">
                        <div class="cs-info-icon wa">
                            <svg fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297
                                         -.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475
                                         -.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347
                                         .446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669
                                         -1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0
                                         -.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213
                                         3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195
                                         1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124
                                         -.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214
                                         -3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884
                                         9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003
                                         5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0
                                         .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882
                                         11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821
                                         0 00-3.48-8.413z" />
                            </svg>
                        </div>
                        <div>
                            <div class="cs-info-lbl">WhatsApp</div>
                            {{-- Ganti nomor --}}
                            <div class="cs-info-val">
                                <a href="https://wa.me/6285647234364" target="_blank">+62 856-4723-4364</a>
                            </div>
                        </div>
                    </div>

                    {{-- Lokasi --}}
                    <div class="cs-info-item">
                        <div class="cs-info-icon loc">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243
                                         a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div>
                            <div class="cs-info-lbl">Lokasi</div>
                            {{-- Ganti alamat --}}
                            <div class="cs-info-val">Kemangsen, Balongbendo<br>Sidoarjo, Jawa Timur</div>
                        </div>
                    </div>
                </div>

                {{-- WA CTA button --}}
                {{-- Ganti nomor WA dan pesan default --}}
                <a href="https://wa.me/6285647234364?text=Halo%20MomentHub%2C%20saya%20ingin%20konsultasi%20paket%20foto"
                    target="_blank" class="cs-wa-btn">
                    <svg fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297
                                 -.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883
                                 -.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52
                                 .149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916
                                 -2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372
                                 -.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2
                                 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758
                                 -.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421
                                 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86
                                 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898
                                 a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815
                                 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057
                                 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893
                                 a11.821 11.821 0 00-3.48-8.413z" />
                    </svg>
                    Chat via WhatsApp
                </a>
                <div class="cs-wa-sub">Akan membuka WhatsApp dengan pesan yang sudah terisi otomatis</div>
            </div>

            {{-- Right ── Maps --}}
            <div class="cs-right">
                <div class="cs-map-box">
                    <div class="cs-map-head">
                        <div class="cs-map-head-left">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3
                                         m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4
                                         m0 13V4m0 0L9 7" />
                            </svg>
                            <span>Peta Lokasi</span>
                        </div>
                        {{-- Ganti href ke link Google Maps biasa --}}
                        <a href="https://maps.google.com/?q=Kemangsen,Balongbendo,Sidoarjo" target="_blank"
                            class="cs-map-open">
                            Buka Maps
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4
                                         M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                        </a>
                    </div>

                    {{--
                        Ganti src embed maps:
                        1. Buka maps.google.com → cari lokasi
                        2. Share → Embed a map → copy src dari <iframe>
                    --}}
                    <iframe class="cs-map-iframe"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3956.2!2d112.626!3d-7.387!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7e4a2f1a1a1a1%3A0x1!2sKemangsen%2C%20Balongbendo%2C%20Sidoarjo!5e0!3m2!1sid!2sid!4v1"
                        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                        title="Lokasi MomentHub" style="pointer-events:auto;">
                    </iframe>

                    <div class="cs-map-addr">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243
                                     a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>Kemangsen, Balongbendo, Sidoarjo, Jawa Timur</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
