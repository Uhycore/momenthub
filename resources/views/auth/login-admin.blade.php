<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Admin — MomentHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'DM Sans', sans-serif;
        }


        /* Input focus ring */
        .input-field:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
        }

        /* Subtle fade-in */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(12px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-up {
            animation: fadeUp 0.45s ease both;
        }

        .fade-up-2 {
            animation: fadeUp 0.45s 0.1s ease both;
        }
    </style>
</head>

<body class="min-h-screen bg-gray-100 flex flex-col">

    {{-- ===== NAVBAR ===== --}}
    <nav class="bg-white border-b border-gray-200 px-6 py-3 flex items-center justify-between">
        {{-- Logo --}}
        <div class="flex items-center gap-2 text-gray-900 font-semibold text-sm">
            {{-- ikon kamera sederhana --}}
            <svg class="w-5 h-5 text-gray-700" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2">
                <circle cx="12" cy="13" r="4" />
                <path d="M9 3h6l1.5 2H20a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1h3.5L9 3z" />
            </svg>
            MomentHub
        </div>

        {{-- Nav links --}}
        <div class="flex items-center gap-6 text-sm">
            <a href="{{ url('/') }}" class="text-gray-500 hover:text-gray-800 transition-colors">Beranda</a>
            <a href="#" class="text-gray-900 font-semibold border-b-2 border-gray-900 pb-0.5">Portal Admin</a>
        </div>

        {{-- Help icon --}}
        <button
            class="w-7 h-7 rounded-full border border-gray-300 flex items-center justify-center
                       text-gray-500 hover:bg-gray-50 transition-colors text-xs font-bold">?</button>
    </nav>

    {{-- ===== MAIN ===== --}}
    <main class="flex-1 flex items-center justify-center px-4 py-12">

        <div class="w-full max-w-md fade-up">

            {{-- ← Kembali ke Beranda --}}
            <a href="{{ url('/') }}"
                class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-800
                      mb-3 transition-colors">
                ← Kembali ke Beranda
            </a>

            {{-- Card utama --}}
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">

                {{-- Konten form --}}
                <div class="px-10 pt-10 pb-8">

                    {{-- Badge --}}
                    <div class="flex justify-center mb-5">
                        <span
                            class="bg-yellow-400 text-yellow-900 text-[10px] font-bold tracking-widest
                                     uppercase px-3 py-1 rounded-full">
                            Portal Admin
                        </span>
                    </div>

                    {{-- Judul & subtitle --}}
                    <h1 class="text-3xl font-bold text-gray-900 text-center mb-2">
                        Akses Admin
                    </h1>
                    <p class="text-sm text-gray-500 text-center mb-8 leading-relaxed">
                        Silakan masuk untuk mengelola pesanan dan konten MomentHub.
                    </p>

                    {{-- Session Status --}}
                    @if (session('status'))
                        <div
                            class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg
                                    text-sm text-green-700">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{-- Form --}}
                    <form method="POST" action="{{ route('login_admin.store') }}">
                        @csrf

                        {{-- Email --}}
                        <div class="mb-5">
                            <label for="email"
                                class="block text-xs font-semibold text-gray-500 tracking-widest
                                          uppercase mb-1.5">
                                Email Admin
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path d="M20 4H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0
                                                 2-2V6a2 2 0 0 0-2-2z" />
                                        <polyline points="22,6 12,13 2,6" />
                                    </svg>
                                </span>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                    autofocus autocomplete="username"
                                    class="input-field w-full pl-9 pr-4 py-3 border border-gray-200
                                              rounded-lg bg-gray-50 text-sm text-gray-800
                                              placeholder-gray-400 transition-all duration-200
                                              @error('email') border-red-400 bg-red-50 @enderror">
                            </div>
                            @error('email')
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="mb-6">
                            <div class="flex items-center justify-between mb-1.5">
                                <label for="password"
                                    class="text-xs font-semibold text-gray-500 tracking-widest uppercase">
                                    Kata Sandi
                                </label>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}"
                                        class="text-xs text-blue-500 hover:text-blue-700 transition-colors">
                                        Lupa sandi?
                                    </a>
                                @endif
                            </div>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <rect x="3" y="11" width="18" height="11" rx="2"
                                            ry="2" />
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                                    </svg>
                                </span>
                                <input id="password" type="password" name="password" required
                                    autocomplete="current-password"
                                    class="input-field w-full pl-9 pr-4 py-3 border border-gray-200
                                              rounded-lg bg-gray-50 text-sm text-gray-800
                                              placeholder-gray-400 transition-all duration-200
                                              @error('password') border-red-400 bg-red-50 @enderror">
                            </div>
                            @error('password')
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Submit button --}}
                        <button type="submit"
                            class="w-full bg-gray-900 hover:bg-gray-700 active:scale-[0.98]
                                       text-white font-semibold text-sm py-3.5 rounded-lg
                                       transition-all duration-200 tracking-wide">
                            Masuk ke Dashboard
                        </button>

                    </form>

                    {{-- Security badge --}}
                    <div class="mt-6 flex justify-center">
                        <span
                            class="inline-flex items-center gap-1.5 text-[10px] text-gray-400
                                     font-medium tracking-wider border border-gray-200 rounded-full
                                     px-3 py-1 bg-gray-50">
                            <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" stroke-width="2.5"
                                viewBox="0 0 24 24">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                            </svg>
                            ENKRIPSI 256-BIT AKTIF
                        </span>
                    </div>

                </div>

                {{-- Footer card --}}
                <div class="border-t border-gray-100 bg-gray-50 px-10 py-4 text-center text-sm text-gray-500">
                    Bukan admin?
                    <a href="{{ route('login') }}"
                        class="text-blue-500 hover:text-blue-700 font-medium underline
                              underline-offset-2 transition-colors ml-0.5">
                        Halaman Login
                    </a>
                </div>

            </div>{{-- /card --}}

        </div>

    </main>

    {{-- ===== FOOTER ===== --}}
    <footer
        class="py-5 px-6 flex items-center justify-between text-[11px] text-gray-400 uppercase
                   tracking-widest border-t border-gray-200 bg-white">
        <span>© 2024 MomentHub. Editorial Photography Curator.</span>
        <div class="flex gap-5">
            <a href="#" class="hover:text-gray-600 transition-colors">Privacy</a>
            <a href="#" class="hover:text-gray-600 transition-colors">Terms</a>
            <a href="#" class="hover:text-gray-600 transition-colors">Support</a>
        </div>
    </footer>

</body>

</html>
