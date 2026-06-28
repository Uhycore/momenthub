@extends('admin.layouts.app')

@section('page-title', 'Manajemen Pengguna')
@section('page-subtitle', 'Kelola pengguna yang terdaftar dalam sistem')

@section('content')
    {{-- Alpine modal state --}}
    <div x-data="{
        open: false,
        mode: 'create',
        submitting: false,
        form: { name: '', email: '', role: 'user' },
        formAction: '{{ route('admin.users.store') }}',
    
        openCreate() {
            this.mode = 'create';
            this.form = { name: '', email: '', role: 'user' };
            this.formAction = '{{ route('admin.users.store') }}';
            this.submitting = false;
            this.open = true;
        },
    
        openEdit(id, name, email, role) {
            this.mode = 'edit';
            this.form = { name, email, role };
            this.formAction = `{{ url('admin/users') }}/${id}`;
            this.submitting = false;
            this.open = true;
        },
    
        closeModal() {
            this.open = false;
            this.submitting = false;
        }
    }" @keydown.escape.window="closeModal()">


        {{-- HEADER --}}
        <div class="flex justify-between items-start mb-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight leading-none">Manajemen Pengguna</h1>
                <p class="text-xs text-gray-400 mt-1.5">Daftar seluruh pengguna terdaftar dalam sistem</p>
            </div>
            <button type="button" @click="openCreate()"
                class="inline-flex items-center gap-1.5 px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white text-[11px] font-bold uppercase tracking-widest rounded-lg transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Pengguna
            </button>
        </div>

        {{-- TABLE CARD --}}
        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">

            {{-- Card Header + Search --}}
            <div class="flex justify-between items-center px-6 py-4 border-b border-gray-100">
                <span class="text-sm font-bold text-gray-900">Daftar Pengguna</span>
                <div class="flex items-center gap-3">
                    {{-- Search --}}
                    <div class="relative">
                        <svg class="absolute left-2.5 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-gray-400 pointer-events-none"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z" />
                        </svg>
                        <input type="text" id="user-search" placeholder="Cari pengguna..."
                            class="pl-8 pr-3 py-1.5 text-xs text-gray-700 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent w-44 transition-colors">
                    </div>
                    <span class="text-xs text-gray-400">
                        {{ $users->total() }} pengguna ditemukan
                    </span>
                </div>
            </div>

            {{-- Table --}}
            <table class="w-full border-collapse" id="users-table">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="text-[9px] uppercase tracking-widest text-gray-400 font-semibold text-left px-6 py-3">#
                        </th>
                        <th class="text-[9px] uppercase tracking-widest text-gray-400 font-semibold text-left px-6 py-3">
                            Pengguna</th>
                        <th class="text-[9px] uppercase tracking-widest text-gray-400 font-semibold text-left px-6 py-3">
                            Role</th>
                        <th class="text-[9px] uppercase tracking-widest text-gray-400 font-semibold text-left px-6 py-3">
                            Bergabung</th>
                        <th class="text-[9px] uppercase tracking-widest text-gray-400 font-semibold text-left px-6 py-3">
                            Status</th>
                        <th class="text-[9px] uppercase tracking-widest text-gray-400 font-semibold text-left px-6 py-3">
                            Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $avatarBgs = [
                            'bg-yellow-600',
                            'bg-slate-700',
                            'bg-purple-600',
                            'bg-teal-600',
                            'bg-red-600',
                            'bg-blue-600',
                        ];
                    @endphp

                    @forelse ($users as $i => $u)
                        @php
                            $initials = collect(explode(' ', $u->name))
                                ->map(fn($w) => strtoupper(substr($w, 0, 1)))
                                ->take(2)
                                ->join('');

                            $avatarBg = $avatarBgs[$i % count($avatarBgs)];

                            $roleBadge = match ($u->role ?? 'user') {
                                'admin' => 'bg-gray-900 text-white',
                                default => 'bg-yellow-100 text-yellow-700 border border-yellow-300',
                            };
                        @endphp

                        <tr class="border-b border-gray-100 last:border-0 hover:bg-gray-50 transition-colors">

                            {{-- No --}}
                            <td class="px-6 py-3.5 text-xs text-gray-400">{{ $u->id }}</td>

                            {{-- Pengguna --}}
                            <td class="px-6 py-3.5">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-9 h-9 rounded-full {{ $avatarBg }} flex items-center justify-center text-xs font-bold text-white flex-shrink-0">
                                        {{ $initials }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold text-gray-900">{{ $u->name }}</div>
                                        <div class="text-xs text-gray-400 mt-0.5">{{ $u->email }}</div>
                                    </div>
                                </div>
                            </td>

                            {{-- Role --}}
                            <td class="px-6 py-3.5">
                                <span
                                    class="inline-block text-[9px] font-bold uppercase tracking-widest px-2.5 py-1 rounded {{ $roleBadge }}">
                                    {{ ucfirst($u->role ?? 'user') }}
                                </span>
                            </td>

                            {{-- Bergabung --}}
                            <td class="px-6 py-3.5 text-xs text-gray-500">
                                {{ $u->created_at->translatedFormat('d M Y') }}
                            </td>

                            {{-- Status --}}
                            <td class="px-6 py-3.5">
                                @if ($u->id === auth()->id())
                                    <span class="text-xs font-semibold text-emerald-500">&#9679; Aktif</span>
                                @else
                                    <span class="text-xs text-gray-400">&#9675; Nonaktif</span>
                                @endif
                            </td>

                            {{-- Tindakan --}}
                            <td class="px-6 py-3.5">
                                <div class="flex gap-1.5">
                                    {{-- Edit --}}
                                    <button type="button"
                                        @click="openEdit(
                                            {{ $u->id }},
                                            {{ Js::from($u->name) }},
                                            {{ Js::from($u->email) }},
                                            {{ Js::from($u->role ?? 'user') }}
                                        )"
                                        class="inline-flex items-center justify-center w-7 h-7 rounded border border-gray-200 text-gray-400 hover:border-yellow-500 hover:text-yellow-600 transition-colors"
                                        title="Edit pengguna">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>

                                    {{-- Delete --}}
                                    <form method="POST" action="{{ route('admin.users.destroy', $u->id) }}"
                                        onsubmit="return confirm('Hapus pengguna {{ addslashes($u->name) }}? Tindakan ini tidak dapat dibatalkan.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center justify-center w-7 h-7 rounded border border-gray-200 text-gray-400 hover:border-red-400 hover:text-red-500 transition-colors"
                                            title="Hapus pengguna"
                                            @if ($u->id === auth()->id()) disabled title="Tidak dapat menghapus akun sendiri" @endif>
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="text-gray-400 text-sm">Belum ada pengguna terdaftar.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination --}}
            <div class="flex justify-between items-center px-6 py-3.5 border-t border-gray-100 text-xs text-gray-400">
                <span>Menampilkan {{ $users->firstItem() }}–{{ $users->lastItem() }} dari {{ $users->total() }}</span>
                <div class="[&_.pagination]:flex [&_.pagination]:gap-1">
                    {{ $users->links() }}
                </div>
            </div>
        </div>

        {{-- Include Modal Component --}}
        @include('admin.users.modal')

    </div>{{-- end x-data --}}

    {{-- Client-side search --}}
    <script>
        document.getElementById('user-search').addEventListener('input', function() {
            const q = this.value.toLowerCase();
            document.querySelectorAll('#users-table tbody tr').forEach(row => {
                row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
            });
        });

        function togglePassword(inputId, btn) {
            const input = document.getElementById(inputId);
            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            // Swap icon opacity as visual cue
            btn.style.opacity = isHidden ? '1' : '0.5';
        }
    </script>
@endsection
