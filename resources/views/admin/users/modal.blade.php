{{--
    resources/views/admin/users/modal.blade.php
    Diinclude di dalam x-data Alpine di index.blade.php
    Dipanggil: @include('admin.users.modal')
--}}

<div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center" role="dialog" aria-modal="true"
    x-bind:aria-label="mode === 'create' ? 'Tambah Pengguna' : 'Edit Pengguna'">
    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm" x-show="open"
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="closeModal()"></div>

    {{-- Modal Card --}}
    <div class="relative w-full max-w-md mx-4 bg-white rounded-xl shadow-xl overflow-hidden" x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95 translate-y-2"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-95 translate-y-2">
        {{-- Modal Header --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <div>
                <h2 class="text-base font-bold text-gray-900"
                    x-text="mode === 'create' ? 'Tambah Pengguna' : 'Edit Pengguna'"></h2>
                <p class="text-xs text-gray-400 mt-0.5"
                    x-text="mode === 'create' ? 'Isi detail pengguna baru' : 'Perbarui informasi pengguna'"></p>
            </div>
            <button @click="closeModal()"
                class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-gray-400 hover:bg-gray-100 hover:text-gray-600 transition-colors"
                type="button">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Form --}}
        <form method="POST" x-bind:action="formAction" @submit="submitting = true">
            @csrf
            {{-- Method override: POST untuk create, PUT untuk update --}}
            <template x-if="mode === 'edit'">
                <input type="hidden" name="_method" value="PUT">
            </template>

            <div class="px-6 py-5 space-y-4">

                {{-- Name --}}
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-500 mb-1.5">Nama
                        Lengkap</label>
                    <input type="text" name="name" x-model="form.name"
                        class="w-full px-3.5 py-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-colors placeholder-gray-300"
                        placeholder="Masukkan nama lengkap" required autocomplete="name">
                    @error('name')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-500 mb-1.5">Alamat
                        Email</label>
                    <input type="email" name="email" x-model="form.email"
                        class="w-full px-3.5 py-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-colors placeholder-gray-300"
                        placeholder="nama@email.com" required autocomplete="email">
                    @error('email')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Role --}}
                <div>
                    <label
                        class="block text-[10px] font-bold uppercase tracking-widest text-gray-500 mb-1.5">Role</label>
                    <div class="relative">
                        <select name="role" x-model="form.role"
                            class="w-full px-3.5 py-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-colors appearance-none pr-9"
                            required>
                            <option value="" disabled>Pilih role...</option>
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                        </select>
                        <div
                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                    @error('role')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-500 mb-1.5">
                        Password
                        <span x-show="mode === 'edit'"
                            class="normal-case font-normal text-gray-400 tracking-normal ml-1">(kosongkan jika tidak
                            diubah)</span>
                    </label>
                    <div class="relative">
                        <input type="password" name="password" id="modal-password" x-bind:required="mode === 'create'"
                            class="w-full px-3.5 py-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-colors placeholder-gray-300 pr-10"
                            placeholder="Minimal 8 karakter" autocomplete="new-password">
                        <button type="button"
                            class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400 hover:text-gray-600 transition-colors"
                            onclick="togglePassword('modal-password', this)" tabindex="-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password Confirmation --}}
                <div>
                    <label
                        class="block text-[10px] font-bold uppercase tracking-widest text-gray-500 mb-1.5">Konfirmasi
                        Password</label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" id="modal-password-confirm"
                            x-bind:required="mode === 'create'"
                            class="w-full px-3.5 py-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-colors placeholder-gray-300 pr-10"
                            placeholder="Ulangi password" autocomplete="new-password">
                        <button type="button"
                            class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400 hover:text-gray-600 transition-colors"
                            onclick="togglePassword('modal-password-confirm', this)" tabindex="-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    @error('password_confirmation')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            {{-- Modal Footer --}}
            <div class="flex justify-end gap-2 px-6 py-4 bg-gray-50 border-t border-gray-100">
                <button type="button" @click="closeModal()"
                    class="px-4 py-2 text-xs font-bold uppercase tracking-widest text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-100 transition-colors">
                    Batal
                </button>
                <button type="submit" x-bind:disabled="submitting"
                    class="inline-flex items-center gap-2 px-4 py-2 text-xs font-bold uppercase tracking-widest text-white bg-yellow-600 hover:bg-yellow-700 disabled:opacity-60 disabled:cursor-not-allowed rounded-lg transition-colors">
                    <svg x-show="submitting" class="w-3.5 h-3.5 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4" />
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z" />
                    </svg>
                    <span
                        x-text="submitting ? 'Menyimpan...' : (mode === 'create' ? 'Tambah Pengguna' : 'Simpan Perubahan')"></span>
                </button>
            </div>
        </form>
    </div>
</div>
