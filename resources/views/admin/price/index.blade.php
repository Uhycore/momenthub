@extends('admin.layouts.app')

@section('page-title', 'Manajemen Paket')
@section('page-subtitle', 'Kelola paket harga yang ditampilkan ke tamu')

@section('content')

    {{-- HEADER --}}
    <div class="flex justify-between items-start mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight leading-none">Manajemen Paket</h1>
            <p class="text-xs text-gray-400 mt-1.5">Daftar seluruh paket harga yang tersedia</p>
        </div>
        <button onclick="openPkgModal()"
            class="inline-flex items-center gap-1.5 px-4 py-2 bg-yellow-500 hover:bg-yellow-400
                   text-gray-900 text-[11px] font-bold uppercase tracking-widest rounded-lg transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Paket
        </button>
    </div>

    {{-- STAT PILLS --}}
    <div class="flex gap-3 mb-5">
        <a href="{{ route('admin.price.index') }}"
            class="px-4 py-1.5 rounded-full text-xs font-semibold transition-colors
                  {{ $filter === 'all' ? 'bg-gray-900 text-white' : 'bg-white text-gray-500 border border-gray-200 hover:border-gray-400' }}">
            Semua <span class="opacity-60">({{ $stats['total'] }})</span>
        </a>
        <a href="{{ route('admin.price.index', ['filter' => 'active']) }}"
            class="px-4 py-1.5 rounded-full text-xs font-semibold transition-colors
                  {{ $filter === 'active' ? 'bg-gray-900 text-white' : 'bg-white text-gray-500 border border-gray-200 hover:border-gray-400' }}">
            Aktif <span class="opacity-60">({{ $stats['active'] }})</span>
        </a>
        <a href="{{ route('admin.price.index', ['filter' => 'inactive']) }}"
            class="px-4 py-1.5 rounded-full text-xs font-semibold transition-colors
                  {{ $filter === 'inactive' ? 'bg-gray-900 text-white' : 'bg-white text-gray-500 border border-gray-200 hover:border-gray-400' }}">
            Nonaktif <span class="opacity-60">({{ $stats['inactive'] }})</span>
        </a>
    </div>

    {{-- TABLE CARD --}}
    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">

        {{-- Card Header --}}
        <div class="flex justify-between items-center px-6 py-4 border-b border-gray-100">
            <span class="text-sm font-bold text-gray-900">Daftar Paket Harga</span>
            <span class="text-xs text-gray-400">
                {{ $packages->total() }} paket ditemukan
            </span>
        </div>

        {{-- Table --}}
        <table class="w-full border-collapse">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="text-[9px] uppercase tracking-widest text-gray-400 font-semibold text-left px-6 py-3">#</th>
                    <th class="text-[9px] uppercase tracking-widest text-gray-400 font-semibold text-left px-6 py-3">Nama
                        Paket</th>
                    <th class="text-[9px] uppercase tracking-widest text-gray-400 font-semibold text-left px-6 py-3">Harga
                    </th>
                    <th class="text-[9px] uppercase tracking-widest text-gray-400 font-semibold text-left px-6 py-3">Durasi
                    </th>
                    <th class="text-[9px] uppercase tracking-widest text-gray-400 font-semibold text-left px-6 py-3">Foto
                    </th>
                    <th class="text-[9px] uppercase tracking-widest text-gray-400 font-semibold text-left px-6 py-3">Status
                    </th>
                    <th class="text-[9px] uppercase tracking-widest text-gray-400 font-semibold text-left px-6 py-3">
                        Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($packages as $pkg)
                    @php
                        $pkgData = json_encode([
                            'id' => $pkg->id,
                            'name' => $pkg->name,
                            'price' => $pkg->price,
                            'description' => $pkg->description,
                            'duration' => $pkg->duration,
                            'photo_count' => $pkg->photo_count,
                            'is_active' => $pkg->is_active,
                            'sort_order' => $pkg->sort_order,
                        ]);
                    @endphp
                    <tr class="border-b border-gray-100 last:border-0 hover:bg-gray-50 transition-colors">

                        {{-- No --}}
                        <td class="px-6 py-3.5 text-xs text-gray-400">{{ $pkg->id }}</td>

                        {{-- Nama Paket --}}
                        <td class="px-6 py-3.5">
                            <div class="text-sm font-semibold text-gray-900">{{ $pkg->name }}</div>
                            @if ($pkg->description)
                                <div class="text-xs text-gray-400 mt-0.5 max-w-xs truncate">
                                    {{ $pkg->description }}
                                </div>
                            @endif
                        </td>

                        {{-- Harga --}}
                        <td class="px-6 py-3.5">
                            <span class="text-sm font-bold text-gray-900">{{ $pkg->formatted_price }}</span>
                        </td>

                        {{-- Durasi --}}
                        <td class="px-6 py-3.5">
                            <span class="inline-flex items-center gap-1 text-xs text-gray-600">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $pkg->duration_label }}
                            </span>
                        </td>

                        {{-- Foto --}}
                        <td class="px-6 py-3.5">
                            <span class="inline-flex items-center gap-1 text-xs text-gray-600">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M14 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ $pkg->photo_count }} Foto
                            </span>
                        </td>

                        {{-- Status --}}
                        <td class="px-6 py-3.5">
                            @if ($pkg->is_active)
                                <span class="text-xs font-semibold text-emerald-500">&#9679; Aktif</span>
                            @else
                                <span class="text-xs text-gray-400">&#9675; Nonaktif</span>
                            @endif
                        </td>

                        {{-- Tindakan --}}
                        <td class="px-6 py-3.5">
                            <div class="flex gap-1.5">
                                {{-- Edit --}}
                                <a href="#" onclick='openPkgModal({{ $pkgData }}); return false'
                                    class="inline-flex items-center justify-center w-7 h-7 rounded border
                                          border-gray-200 text-gray-400 hover:border-yellow-500
                                          hover:text-yellow-600 transition-colors"
                                    title="Edit">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>

                                {{-- Toggle aktif --}}
                                <form method="POST" action="{{ route('admin.price.toggle', $pkg) }}"
                                    style="display:inline">
                                    @csrf @method('PATCH')
                                    <button type="submit"
                                        class="inline-flex items-center justify-center w-7 h-7 rounded border
                                                   border-gray-200 text-gray-400 transition-colors
                                                   {{ $pkg->is_active ? 'hover:border-orange-400 hover:text-orange-500' : 'hover:border-emerald-400 hover:text-emerald-500' }}"
                                        title="{{ $pkg->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                        @if ($pkg->is_active)
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                            </svg>
                                        @else
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                        @endif
                                    </button>
                                </form>

                                {{-- Hapus --}}
                                <form method="POST" action="{{ route('admin.price.destroy', $pkg) }}"
                                    onsubmit="return confirm('Hapus paket {{ $pkg->name }}?')" style="display:inline">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center justify-center w-7 h-7 rounded border
                                                   border-gray-200 text-gray-400 hover:border-red-400
                                                   hover:text-red-500 transition-colors"
                                        title="Hapus">
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
                        <td colspan="7" class="px-6 py-16 text-center text-gray-400">
                            <svg class="w-10 h-10 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10" />
                            </svg>
                            <p class="text-sm">Belum ada paket.
                                <button onclick="openPkgModal()"
                                    class="text-yellow-600 underline underline-offset-2 cursor-pointer
                                               bg-none border-none font-medium">
                                    Tambah sekarang.
                                </button>
                            </p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        @if ($packages->hasPages())
            <div class="flex justify-between items-center px-6 py-3.5 border-t border-gray-100 text-xs text-gray-400">
                <span>
                    Menampilkan {{ $packages->firstItem() }}–{{ $packages->lastItem() }}
                    dari {{ $packages->total() }}
                </span>
                <div>{{ $packages->links() }}</div>
            </div>
        @else
            <div class="px-6 py-3.5 border-t border-gray-100 text-xs text-gray-400">
                Menampilkan {{ $packages->count() }} paket
            </div>
        @endif
    </div>

    {{-- MODAL --}}
    @include('admin.price.modal')

@endsection
