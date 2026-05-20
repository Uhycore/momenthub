<x-guest-layout>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;1,400&family=Playfair+Display:wght@700&display=swap"
        rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'DM Sans', sans-serif;
        }

        .rg-page {
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 100vh;
        }

        /* ===== LEFT: DARK HERO ===== */
        .rg-left {
            position: relative;
            background: #0d0d0b;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 2.5rem;
            overflow: hidden;
        }

        .rg-left img.rg-bg {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.45;
            display: block;
        }

        .rg-left-content {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            height: 100%;
            justify-content: space-between;
        }

        .rg-logo {
            font-family: 'DM Sans', sans-serif;
            font-size: 16px;
            font-weight: 500;
            color: #ffffff;
            letter-spacing: 0.01em;
            margin: 0;
        }

        .rg-hero-text {
            margin-top: auto;
            padding-bottom: 0.5rem;
        }

        .rg-headline {
            font-family: 'DM Sans', sans-serif;
            font-size: clamp(2rem, 3.5vw, 2.75rem);
            font-weight: 700;
            color: #ffffff;
            line-height: 1.15;
            margin: 0 0 2rem;
        }

        .rg-quote {
            border-left: 3px solid #D4A017;
            padding-left: 1.25rem;
            margin: 0;
        }

        .rg-quote p {
            font-size: 14px;
            font-style: italic;
            color: rgba(255, 255, 255, 0.75);
            line-height: 1.6;
            margin: 0 0 0.6rem;
        }

        .rg-quote cite {
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #D4A017;
            font-style: normal;
        }

        /* ===== RIGHT: FORM ===== */
        .rg-right {
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem 3.5rem;
        }

        .rg-form-wrap {
            width: 100%;
            max-width: 440px;
        }

        .rg-heading {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 700;
            color: #1a1916;
            margin: 0 0 0.35rem;
            line-height: 1.15;
        }

        .rg-subheading {
            font-size: 14px;
            color: #888780;
            margin: 0 0 2rem;
            line-height: 1.5;
        }

        /* Divider */
        .rg-divider {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.75rem;
        }

        .rg-divider-line {
            flex: 1;
            height: 1px;
            background: #E5E3DC;
        }

        .rg-divider span {
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #B4B2A9;
            white-space: nowrap;
        }

        /* Field */
        .rg-field {
            margin-bottom: 1.2rem;
        }

        .rg-label {
            display: block;
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #5F5E5A;
            margin-bottom: 7px;
        }

        .rg-input {
            width: 100%;
            padding: 12px 14px;
            font-size: 14px;
            font-family: 'DM Sans', sans-serif;
            color: #1a1916;
            background: #F5F3EE;
            border: 1px solid transparent;
            border-radius: 8px;
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
        }

        .rg-input:focus {
            border-color: #D4A017;
            box-shadow: 0 0 0 3px rgba(212, 160, 23, 0.12);
            background: #fff;
        }

        .rg-input::placeholder {
            color: #C4C2BA;
        }

        /* Side-by-side password row */
        .rg-field-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1.2rem;
        }

        /* Error */
        .rg-error {
            display: block;
            font-size: 12px;
            color: #E24B4A;
            margin-top: 4px;
        }

        /* Submit */
        .rg-btn {
            width: 100%;
            padding: 14px;
            background: #D4A017;
            color: #1a1916;
            border: none;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 700;
            font-family: 'DM Sans', sans-serif;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            cursor: pointer;
            margin-top: 0.5rem;
            transition: background 0.15s, transform 0.1s;
        }

        .rg-btn:hover {
            background: #BA8A0E;
        }

        .rg-btn:active {
            transform: scale(0.99);
        }

        /* Login link */
        .rg-login {
            text-align: center;
            margin-top: 1.25rem;
            font-size: 13.5px;
            color: #888780;
        }

        .rg-login a {
            color: #1a1916;
            font-weight: 600;
            text-decoration: none;
        }

        .rg-login a:hover {
            text-decoration: underline;
        }

        /* Terms */
        .rg-terms {
            text-align: center;
            margin-top: 1.75rem;
            font-size: 12px;
            color: #B4B2A9;
            line-height: 1.6;
        }

        .rg-terms a {
            color: #B4B2A9;
            text-decoration: underline;
        }

        .rg-terms a:hover {
            color: #5F5E5A;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .rg-page {
                grid-template-columns: 1fr;
            }

            .rg-left {
                display: none;
            }

            .rg-right {
                padding: 2rem 1.5rem;
            }

            .rg-field-row {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="rg-page">

        {{-- LEFT: Dark Hero --}}
        <div class="rg-left">
            <img class="rg-bg" src="{{ asset('images/register_user.jpg') }}" alt="Photography background">
            <div class="rg-left-content">
                <p class="rg-logo">MomentHub</p>
                <div class="rg-hero-text">
                    <h1 class="rg-headline">Abadikan Momen yang<br>Paling Berarti.</h1>
                    <blockquote class="rg-quote">
                        <p>"Fotografi adalah cara untuk merasakan, menyentuh, dan mencintai apa yang kita lihat
                            selamanya."</p>
                        <cite>— Aaron Siskind</cite>
                    </blockquote>
                </div>
            </div>
        </div>

        {{-- RIGHT: Form --}}
        <div class="rg-right">
            <div class="rg-form-wrap">

                <h2 class="rg-heading">Buat Akun</h2>
                <p class="rg-subheading">Bergabunglah dengan komunitas kurator visual kami.</p>

                <div class="rg-divider">
                    <div class="rg-divider-line"></div>
                    <span>Atau Gunakan Email</span>
                    <div class="rg-divider-line"></div>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    {{-- Nama Lengkap --}}
                    <div class="rg-field">
                        <label class="rg-label" for="name">Nama Lengkap</label>
                        <input id="name" class="rg-input" type="text" name="name" value="{{ old('name') }}"
                            placeholder="Arka Wiratama" required autofocus autocomplete="name">
                        @error('name')
                            <span class="rg-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="rg-field">
                        <label class="rg-label" for="email">Email</label>
                        <input id="email" class="rg-input" type="email" name="email" value="{{ old('email') }}"
                            placeholder="arka@domain.com" required autocomplete="username">
                        @error('email')
                            <span class="rg-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Password & Konfirmasi (2 kolom) --}}
                    <div class="rg-field-row">
                        <div>
                            <label class="rg-label" for="password">Kata Sandi</label>
                            <input id="password" class="rg-input" type="password" name="password"
                                placeholder="••••••••" required autocomplete="new-password">
                            @error('password')
                                <span class="rg-error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label class="rg-label" for="password_confirmation">Konfirmasi</label>
                            <input id="password_confirmation" class="rg-input" type="password"
                                name="password_confirmation" placeholder="••••••••" required
                                autocomplete="new-password">
                            @error('password_confirmation')
                                <span class="rg-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- Submit --}}
                    <button type="submit" class="rg-btn">Daftar Sekarang</button>

                    {{-- Login link --}}
                    <p class="rg-login">
                        Sudah memiliki akun? <a href="{{ route('login') }}">Masuk di sini</a>
                    </p>

                    {{-- Terms --}}
                    <p class="rg-terms">
                        Dengan mendaftar, Anda menyetujui
                        <a href="#">Ketentuan Layanan dan Kebijakan Privasi</a> kami.
                    </p>

                </form>
            </div>
        </div>

    </div>

</x-guest-layout>
