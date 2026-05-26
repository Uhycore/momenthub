<div class="pf-card">
    <div class="pf-card-head">
        <div class="pf-card-bar"></div>
        <div>
            <h2>Informasi Profil</h2>
            <p>Perbarui nama dan alamat email akun Anda.</p>
        </div>
    </div>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <div class="pf-card-body">

            {{-- Name --}}
            <div>
                <label class="pf-label" for="name">Nama</label>
                <input id="name" name="name" type="text" class="pf-input"
                    value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
                @foreach ($errors->get('name') as $msg)
                    <div class="pf-input-error">{{ $msg }}</div>
                @endforeach
            </div>

            {{-- Email --}}
            <div>
                <label class="pf-label" for="email">Email</label>
                <input id="email" name="email" type="email" class="pf-input"
                    value="{{ old('email', $user->email) }}" required autocomplete="username" />
                @foreach ($errors->get('email') as $msg)
                    <div class="pf-input-error">{{ $msg }}</div>
                @endforeach

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                    <div class="pf-verify-box">
                        <span>Email belum terverifikasi.</span>
                        <button form="send-verification" class="pf-verify-btn">
                            Kirim ulang verifikasi →
                        </button>
                    </div>
                    @if (session('status') === 'verification-link-sent')
                        <div class="pf-sent-badge">✓ Link verifikasi telah dikirim ke email Anda.</div>
                    @endif
                @endif
            </div>

        </div>

        <div class="pf-card-foot">
            <button type="submit" class="pf-btn pf-btn-primary">Simpan Perubahan</button>
            @if (session('status') === 'profile-updated')
                <span class="pf-saved-tag" x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)">
                    ✓ Tersimpan
                </span>
            @endif
        </div>

    </form>
</div>
