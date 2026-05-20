@extends('admin.layouts.app')

@section('content')
    {{-- HEADER --}}
    <div class="flex justify-between items-start mb-1">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight leading-none">Manajemen Pengguna</h1>
            <p class="text-xs text-gray-400 mt-1.5">Daftar seluruh pengguna terdaftar dalam sistem</p>
        </div>
        <a href="#"
            class="inline-flex items-center gap-1.5 px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white text-[11px] font-bold uppercase tracking-widest rounded-lg transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Pengguna
        </a>
    </div>

    {{-- TABLE CARD --}}
    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">

        {{-- Card Header --}}
        <div class="flex justify-between items-center px-6 py-4 border-b border-gray-100">
            <span class="text-sm font-bold text-gray-900">Daftar Pengguna</span>
            <span class="text-xs text-gray-400">
                {{ isset($users) && method_exists($users, 'total') ? $users->total() : count($users ?? []) }} pengguna
                ditemukan
            </span>
        </div>

        {{-- Table --}}
        <table class="w-full border-collapse" id="users-table">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="text-[9px] uppercase tracking-widest text-gray-400 font-semibold text-left px-6 py-3">#</th>
                    <th class="text-[9px] uppercase tracking-widest text-gray-400 font-semibold text-left px-6 py-3">
                        Pengguna</th>
                    <th class="text-[9px] uppercase tracking-widest text-gray-400 font-semibold text-left px-6 py-3">Role
                    </th>
                    <th class="text-[9px] uppercase tracking-widest text-gray-400 font-semibold text-left px-6 py-3">
                        Bergabung</th>
                    <th class="text-[9px] uppercase tracking-widest text-gray-400 font-semibold text-left px-6 py-3">Status
                    </th>
                    <th class="text-[9px] uppercase tracking-widest text-gray-400 font-semibold text-left px-6 py-3">
                        Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $dummyUsers = [
                        [
                            'id' => 1,
                            'name' => 'Elena Moretti',
                            'email' => 'elena@example.com',
                            'role' => 'admin',
                            'joined' => '12 Jan 2024',
                            'status' => 'online',
                        ],
                        [
                            'id' => 2,
                            'name' => 'Marcus Vane',
                            'email' => 'marcus@example.com',
                            'role' => 'editor',
                            'joined' => '03 Mar 2024',
                            'status' => 'offline',
                        ],
                        [
                            'id' => 3,
                            'name' => 'Julianne Thorne',
                            'email' => 'julianne@example.com',
                            'role' => 'user',
                            'joined' => '18 Apr 2024',
                            'status' => 'online',
                        ],
                        [
                            'id' => 4,
                            'name' => 'Ryan Castillo',
                            'email' => 'ryan@example.com',
                            'role' => 'user',
                            'joined' => '22 Jun 2024',
                            'status' => 'offline',
                        ],
                        [
                            'id' => 5,
                            'name' => 'Amara Osei',
                            'email' => 'amara@example.com',
                            'role' => 'editor',
                            'joined' => '05 Agt 2024',
                            'status' => 'online',
                        ],
                    ];
                    $list = isset($users) ? $users : $dummyUsers;

                    $avatarBgs = [
                        'bg-yellow-600',
                        'bg-slate-700',
                        'bg-purple-600',
                        'bg-teal-600',
                        'bg-red-600',
                        'bg-blue-600',
                    ];
                @endphp

                @foreach ($list as $i => $u)
                    @php
                        $isArray = is_array($u);
                        $uid = $isArray ? $u['id'] : $u->id;
                        $uname = $isArray ? $u['name'] : $u->name;
                        $uemail = $isArray ? $u['email'] : $u->email;
                        $urole = $isArray ? $u['role'] : $u->role ?? 'user';
                        $ujoined = $isArray ? $u['joined'] : $u->created_at->format('d M Y');
                        $ustatus = $isArray ? $u['status'] : 'offline';

                        $initials = collect(explode(' ', $uname))
                            ->map(fn($w) => strtoupper(substr($w, 0, 1)))
                            ->take(2)
                            ->join('');

                        $avatarBg = $avatarBgs[$i % count($avatarBgs)];

                        $roleBadge = match ($urole) {
                            'admin' => 'bg-gray-900 text-white',
                            'editor' => 'bg-gray-100 text-gray-600 border border-gray-300',
                            default => 'bg-yellow-100 text-yellow-700 border border-yellow-300',
                        };
                    @endphp

                    <tr class="border-b border-gray-100 last:border-0 hover:bg-gray-50 transition-colors">

                        {{-- No --}}
                        <td class="px-6 py-3.5 text-xs text-gray-400">{{ $uid }}</td>

                        {{-- Pengguna --}}
                        <td class="px-6 py-3.5">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-9 h-9 rounded-full {{ $avatarBg }} flex items-center justify-center text-xs font-bold text-white flex-shrink-0">
                                    {{ $initials }}
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-gray-900">{{ $uname }}</div>
                                    <div class="text-xs text-gray-400 mt-0.5">{{ $uemail }}</div>
                                </div>
                            </div>
                        </td>

                        {{-- Role --}}
                        <td class="px-6 py-3.5">
                            <span
                                class="inline-block text-[9px] font-bold uppercase tracking-widest px-2.5 py-1 rounded {{ $roleBadge }}">
                                {{ ucfirst($urole) }}
                            </span>
                        </td>

                        {{-- Bergabung --}}
                        <td class="px-6 py-3.5 text-xs text-gray-500">{{ $ujoined }}</td>

                        {{-- Status --}}
                        <td class="px-6 py-3.5">
                            @if ($ustatus === 'online')
                                <span class="text-xs font-semibold text-emerald-500">&#9679; Aktif</span>
                            @else
                                <span class="text-xs text-gray-400">&#9675; Nonaktif</span>
                            @endif
                        </td>

                        {{-- Tindakan --}}
                        <td class="px-6 py-3.5">
                            <div class="flex gap-1.5">
                                <a href="#"
                                    class="inline-flex items-center justify-center w-7 h-7 rounded border border-gray-200 text-gray-400 hover:border-yellow-500 hover:text-yellow-600 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <form method="POST" action="#"
                                    onsubmit="return confirm('Hapus pengguna {{ $uname }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center justify-center w-7 h-7 rounded border border-gray-200 text-gray-400 hover:border-red-400 hover:text-red-500 transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Pagination --}}
        @if (isset($users) && method_exists($users, 'links'))
            <div class="flex justify-between items-center px-6 py-3.5 border-t border-gray-100 text-xs text-gray-400">
                <span>Menampilkan {{ $users->firstItem() }}–{{ $users->lastItem() }} dari {{ $users->total() }}</span>
                <div>{{ $users->links() }}</div>
            </div>
        @else
            <div class="flex justify-between items-center px-6 py-3.5 border-t border-gray-100 text-xs text-gray-400">
                <span>Menampilkan {{ count($list) }} pengguna</span>
                <div class="flex gap-1">
                    <button
                        class="inline-flex items-center justify-center min-w-[30px] h-7 px-1.5 border border-gray-200 rounded text-xs font-semibold text-gray-500 hover:border-yellow-500 hover:text-yellow-600 transition-colors">&#8249;</button>
                    <button
                        class="inline-flex items-center justify-center min-w-[30px] h-7 px-1.5 border border-yellow-500 rounded text-xs font-semibold text-yellow-600 bg-yellow-50">1</button>
                    <button
                        class="inline-flex items-center justify-center min-w-[30px] h-7 px-1.5 border border-gray-200 rounded text-xs font-semibold text-gray-500 hover:border-yellow-500 hover:text-yellow-600 transition-colors">&#8250;</button>
                </div>
            </div>
        @endif
    </div>

    {{-- Client-side search --}}
    <script>
        document.getElementById('user-search').addEventListener('input', function() {
            const q = this.value.toLowerCase();
            document.querySelectorAll('#users-table tbody tr').forEach(row => {
                row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
            });
        });
    </script>
@endsection
