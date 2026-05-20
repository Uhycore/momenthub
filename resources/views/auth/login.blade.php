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
            background: #F5F3EE;
            font-family: 'DM Sans', sans-serif;
        }

        .mh-page {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background: #F5F3EE;
        }

        .mh-main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem 2rem;
        }

        .mh-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            max-width: 980px;
            width: 100%;
            align-items: center;
        }

        /* LEFT */
        .mh-brand-label {
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 0.14em;
            color: #888780;
            text-transform: uppercase;
            margin: 0 0 0.5rem;
        }

        .mh-brand-title {
            font-family: 'Playfair Display', serif;
            font-size: 3rem;
            font-weight: 700;
            color: #1a1916;
            line-height: 1.05;
            margin: 0 0 1.5rem;
        }

        .mh-hero {
            position: relative;
            border-radius: 18px;
            overflow: hidden;
            aspect-ratio: 4/5;
            max-height: 440px;
            background: #1a1916;
        }

        .mh-hero img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            opacity: 0.9;
        }

        .mh-caption {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 1.5rem;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.72) 0%, transparent 100%);
        }

        .mh-caption blockquote {
            margin: 0 0 5px;
            font-size: 15px;
            font-style: italic;
            color: #fff;
        }

        .mh-caption cite {
            font-size: 10px;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.5);
            font-style: normal;
        }

        /* RIGHT: FORM CARD */
        .mh-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 2.5rem 2.25rem;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04), 0 8px 24px rgba(0, 0, 0, 0.06);
            width: 100%;
        }

        .mh-heading {
            font-family: 'Playfair Display', serif;
            font-size: 1.9rem;
            font-weight: 700;
            color: #1a1916;
            line-height: 1.15;
            margin: 0 0 0.4rem;
        }

        .mh-subheading {
            font-size: 14px;
            color: #888780;
            line-height: 1.55;
            margin: 0 0 2rem;
        }

        .mh-status {
            font-size: 13px;
            color: #3B6D11;
            background: #EAF3DE;
            border-radius: 8px;
            padding: 8px 12px;
            margin-bottom: 1.25rem;
        }

        .mh-field {
            margin-bottom: 1.2rem;
        }

        .mh-label-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 7px;
        }

        .mh-label {
            font-size: 13px;
            font-weight: 500;
            color: #3C3A38;
        }

        .mh-forgot {
            font-size: 12.5px;
            color: #BA7517;
            text-decoration: none;
        }

        .mh-forgot:hover {
            text-decoration: underline;
        }

        .mh-input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }

        .mh-icon {
            position: absolute;
            left: 11px;
            color: #B4B2A9;
            display: flex;
            align-items: center;
            pointer-events: none;
        }

        .mh-icon svg {
            width: 15px;
            height: 15px;
        }

        .mh-input {
            width: 100%;
            padding: 11px 12px 11px 37px;
            font-size: 14px;
            font-family: 'DM Sans', sans-serif;
            color: #1a1916;
            background: #F5F3EE;
            border: 1px solid #D3D1C7;
            border-radius: 10px;
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
        }

        .mh-input:focus {
            border-color: #888780;
            box-shadow: 0 0 0 3px rgba(136, 135, 128, 0.14);
            background: #fff;
        }

        .mh-input::placeholder {
            color: #C4C2BA;
        }

        .mh-input.pr {
            padding-right: 40px;
        }

        .mh-toggle {
            position: absolute;
            right: 11px;
            background: none;
            border: none;
            cursor: pointer;
            color: #B4B2A9;
            padding: 0;
            display: flex;
            align-items: center;
        }

        .mh-toggle:hover {
            color: #5F5E5A;
        }

        .mh-toggle svg {
            width: 15px;
            height: 15px;
        }

        .mh-error {
            display: block;
            font-size: 12px;
            color: #E24B4A;
            margin-top: 4px;
        }

        .mh-remember {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 1.5rem;
        }

        .mh-remember input[type="checkbox"] {
            width: 15px;
            height: 15px;
            accent-color: #1a1916;
            cursor: pointer;
            flex-shrink: 0;
        }

        .mh-remember label {
            font-size: 13px;
            color: #888780;
            cursor: pointer;
        }

        .mh-btn {
            width: 100%;
            padding: 13px;
            background: #1a1916;
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 500;
            font-family: 'DM Sans', sans-serif;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: background 0.15s, transform 0.1s;
        }

        .mh-btn:hover {
            background: #2C2C2A;
        }

        .mh-btn:active {
            transform: scale(0.99);
        }

        .mh-btn svg {
            width: 15px;
            height: 15px;
        }

        .mh-register {
            text-align: center;
            margin-top: 1.25rem;
            font-size: 13px;
            color: #888780;
        }

        .mh-register a {
            color: #BA7517;
            font-weight: 500;
            text-decoration: none;
        }

        .mh-register a:hover {
            text-decoration: underline;
        }

        /* FOOTER */
        .mh-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.1rem 2rem;
            border-top: 1px solid #E5E3DC;
            font-size: 11px;
            color: #B4B2A9;
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }

        .mh-footer-links {
            display: flex;
            gap: 1.5rem;
        }

        .mh-footer-links a {
            color: #B4B2A9;
            text-decoration: none;
        }

        .mh-footer-links a:hover {
            color: #5F5E5A;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .mh-grid {
                grid-template-columns: 1fr;
                gap: 0;
            }

            .mh-left {
                display: none;
            }

            .mh-main {
                padding: 2rem 1.25rem;
            }
        }
    </style>

    <div class="mh-page">
        <main class="mh-main">
            <div class="mh-grid">

                <!-- LEFT -->
                <div class="mh-left">
                    <p class="mh-brand-label">The Photografer</p>
                    <h1 class="mh-brand-title">MomentHub</h1>
                    <div class="mh-hero">
                        <img src="{{ asset('images/login_user.jpg') }}" alt="Editorial portrait">
                        <div class="mh-caption">
                            <blockquote>"Capturing the soul of every moment."</blockquote>
                            <cite>Curated by Momentum Noir</cite>
                        </div>
                    </div>
                </div>

                <!-- RIGHT -->
                <div class="mh-card">

                    @if (session('status'))
                        <div class="mh-status">{{ session('status') }}</div>
                    @endif

                    <h2 class="mh-heading">Selamat Datang Kembali</h2>
                    <p class="mh-subheading">Masuk untuk mengakses galeri dan jadwal pemotretan Anda.</p>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email -->
                        <div class="mh-field">
                            <div class="mh-label-row">
                                <label class="mh-label" for="email">Email</label>
                            </div>
                            <div class="mh-input-wrap">
                                <span class="mh-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                    </svg>
                                </span>
                                <input id="email" class="mh-input" type="email" name="email"
                                    value="{{ old('email') }}" placeholder="nama@email.com" required autofocus
                                    autocomplete="username">
                            </div>
                            @error('email')
                                <span class="mh-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mh-field">
                            <div class="mh-label-row">
                                <label class="mh-label" for="password">Kata Sandi</label>
                                @if (Route::has('password.request'))
                                    <a class="mh-forgot" href="{{ route('password.request') }}">Lupa Kata Sandi?</a>
                                @endif
                            </div>
                            <div class="mh-input-wrap">
                                <span class="mh-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                                    </svg>
                                </span>
                                <input id="password" class="mh-input pr" type="password" name="password"
                                    placeholder="••••••••" required autocomplete="current-password">
                                <button type="button" class="mh-toggle" onclick="togglePw()"
                                    aria-label="Tampilkan kata sandi">
                                    <svg id="eye-ico" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <span class="mh-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Remember me -->
                        <div class="mh-remember">
                            <input id="remember_me" type="checkbox" name="remember">
                            <label for="remember_me">Ingat Saya</label>
                        </div>

                        <!-- Submit -->
                        <button type="submit" class="mh-btn">
                            Masuk
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                            </svg>
                        </button>

                        <p class="mh-register">
                            Belum punya akun? <a href="{{ route('register') }}">Daftar Sekarang</a>
                        </p>

                    </form>
                </div>

            </div>
        </main>

        <footer class="mh-footer">
            <span>&copy; {{ date('Y') }} MomentHub. Editorial Photography Curator.</span>
            <div class="mh-footer-links">
                <a href="#">Privacy</a>
                <a href="#">Terms</a>
                <a href="#">Support</a>
            </div>
        </footer>
    </div>

    <script>
        function togglePw() {
            const inp = document.getElementById('password');
            const ico = document.getElementById('eye-ico');
            if (inp.type === 'password') {
                inp.type = 'text';
                ico.innerHTML =
                    '<path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />';
            } else {
                inp.type = 'password';
                ico.innerHTML =
                    '<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />';
            }
        }
    </script>

</x-guest-layout>
