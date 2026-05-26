<div class="pf-card">
    <div class="pf-card-head">
        <div class="pf-card-bar"></div>
        <div>
            <h2>Ubah Password</h2>
            <p>Gunakan password panjang dan acak agar akun Anda tetap aman.</p>
        </div>
    </div>

    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <div class="pf-card-body">

            {{-- Current Password --}}
            <div>
                <label class="pf-label" for="update_password_current_password">Password Saat Ini</label>
                <input id="update_password_current_password" name="current_password" type="password" class="pf-input"
                    autocomplete="current-password" />
                @foreach ($errors->updatePassword->get('current_password') as $msg)
                    <div class="pf-input-error">{{ $msg }}</div>
                @endforeach
            </div>

            {{-- New Password --}}
            <div>
                <label class="pf-label" for="update_password_password">Password Baru</label>
                <input id="update_password_password" name="password" type="password" class="pf-input"
                    autocomplete="new-password" />
                @foreach ($errors->updatePassword->get('password') as $msg)
                    <div class="pf-input-error">{{ $msg }}</div>
                @endforeach
            </div>

            {{-- Confirm Password --}}
            <div>
                <label class="pf-label" for="update_password_password_confirmation">Konfirmasi Password Baru</label>
                <input id="update_password_password_confirmation" name="password_confirmation" type="password"
                    class="pf-input" autocomplete="new-password" />
                @foreach ($errors->updatePassword->get('password_confirmation') as $msg)
                    <div class="pf-input-error">{{ $msg }}</div>
                @endforeach
            </div>

        </div>

        <div class="pf-card-foot">
            <button type="submit" class="pf-btn pf-btn-primary">Simpan Password</button>
            @if (session('status') === 'password-updated')
                <span class="pf-saved-tag" x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)">
                    ✓ Tersimpan
                </span>
            @endif
        </div>

    </form>
</div>
