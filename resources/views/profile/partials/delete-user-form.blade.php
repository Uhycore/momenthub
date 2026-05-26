<div class="pf-card">
    <div class="pf-card-head">
        <div class="pf-card-bar pf-card-bar-red"></div>
        <div>
            <h2>Hapus Akun</h2>
            <p>Tindakan ini permanen dan tidak dapat dibatalkan.</p>
        </div>
    </div>

    <div class="pf-card-body">
        <p class="pf-danger-text">
            Setelah akun dihapus, seluruh data dan resource Anda akan dihapus secara permanen.
            Pastikan Anda telah mengunduh data yang ingin disimpan sebelum melanjutkan.
        </p>
        <div>
            <button class="pf-btn pf-btn-danger" x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                Hapus Akun
            </button>
        </div>
    </div>
</div>

{{-- Modal konfirmasi --}}
<x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
    <form method="post" action="{{ route('profile.destroy') }}" style="padding: 28px;">
        @csrf
        @method('delete')

        <div class="pf-warn-badge">
            <svg width="10" height="10" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            Tindakan Berbahaya
        </div>

        <h3>Hapus akun secara permanen?</h3>
        <p>
            Seluruh data Anda termasuk pesanan, riwayat, dan informasi akun akan dihapus selamanya.
            Masukkan password untuk mengkonfirmasi.
        </p>

        <div>
            <label class="pf-label" for="del-password">Password</label>
            <input id="del-password" name="password" type="password" class="pf-input"
                placeholder="Masukkan password Anda" />
            @foreach ($errors->userDeletion->get('password') as $msg)
                <div class="pf-input-error">{{ $msg }}</div>
            @endforeach
        </div>

        <div class="pf-modal-foot">
            <button type="button" class="pf-btn pf-btn-secondary" x-on:click="$dispatch('close')">
                Batal
            </button>
            <button type="submit" class="pf-btn pf-btn-danger">
                Ya, Hapus Akun
            </button>
        </div>

    </form>
</x-modal>
