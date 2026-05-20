@extends('admin.layouts.app')

@section('page-title', 'Post Management')
@section('page-subtitle', now()->translatedFormat('l, d F Y'))

@section('content')

    <style>
        /* ─── HERO HEADER ─────────────────────────────────── */
        .ph-hero-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .ph-toolkit-label {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            color: #c89a00;
            margin-bottom: 8px;
        }

        .ph-hero-title {
            font-size: 32px;
            font-weight: 800;
            color: #111;
            line-height: 1.1;
            letter-spacing: -0.03em;
        }

        .ph-upload-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #f5c518;
            color: #111;
            font-size: 12.5px;
            font-weight: 700;
            padding: 11px 18px;
            border-radius: 10px;
            text-decoration: none;
            white-space: nowrap;
            flex-shrink: 0;
            transition: background 0.15s, transform 0.1s;
        }

        .ph-upload-btn:hover {
            background: #e6b800;
            transform: translateY(-1px);
        }

        .ph-upload-btn svg {
            width: 15px;
            height: 15px;
        }

        /* ─── FILTER TABS ─────────────────────────────────── */
        .ph-tabs {
            display: flex;
            gap: 6px;
            margin-bottom: 22px;
        }

        .ph-tab {
            padding: 7px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            color: #888;
            background: transparent;
            border: 1.5px solid transparent;
            text-decoration: none;
            transition: all 0.15s;
            cursor: pointer;
        }

        .ph-tab:hover {
            color: #111;
            background: #f0f0ee;
        }

        .ph-tab.active {
            background: #111;
            color: #fff;
            border-color: #111;
        }

        /* ─── MAIN GRID ───────────────────────────────────── */
        .ph-main-grid {
            display: grid;
            grid-template-columns: 1fr 260px;
            gap: 16px;
            margin-bottom: 36px;
        }

        /* ─── FEATURED CARD ───────────────────────────────── */
        .ph-featured {
            background: #fff;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.07);
            position: relative;
        }

        .ph-featured-img {
            width: 100%;
            height: 240px;
            object-fit: cover;
            display: block;
            background: #d0d0cc;
        }

        .ph-featured-img-placeholder {
            width: 100%;
            height: 240px;
            background: linear-gradient(135deg, #2a2a28 0%, #1a1a18 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .ph-featured-img-placeholder svg {
            width: 40px;
            height: 40px;
            color: rgba(255, 255, 255, 0.2);
        }

        .ph-featured-body {
            padding: 18px 20px 20px;
        }

        .ph-featured-title-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 8px;
        }

        .ph-featured-title {
            font-size: 17px;
            font-weight: 700;
            color: #111;
            letter-spacing: -0.01em;
        }

        .ph-featured-meta {
            display: flex;
            gap: 16px;
            font-size: 11px;
            color: #aaa;
        }

        .ph-featured-meta span {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .ph-featured-meta svg {
            width: 12px;
            height: 12px;
        }

        /* Status badges */
        .badge {
            display: inline-block;
            font-size: 9.5px;
            font-weight: 700;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            padding: 3px 9px;
            border-radius: 5px;
            white-space: nowrap;
        }

        .badge-published {
            background: #e8f7ee;
            color: #1d8a45;
        }

        .badge-draft {
            background: #f0f0ee;
            color: #888;
        }

        /* ─── SIDE CARDS ──────────────────────────────────── */
        .ph-side-cards {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .ph-side-card {
            background: #fff;
            border-radius: 12px;
            padding: 13px 14px;
            display: flex;
            gap: 12px;
            align-items: flex-start;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
            transition: box-shadow 0.15s;
        }

        .ph-side-card:hover {
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
        }

        .ph-side-thumb {
            width: 52px;
            height: 52px;
            border-radius: 8px;
            object-fit: cover;
            flex-shrink: 0;
            background: #e0e0de;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .ph-side-thumb svg {
            width: 20px;
            height: 20px;
            color: #bbb;
        }

        .ph-side-info {
            flex: 1;
            min-width: 0;
        }

        .ph-side-type {
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #bbb;
            margin-bottom: 3px;
        }

        .ph-side-title {
            font-size: 12.5px;
            font-weight: 600;
            color: #111;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            margin-bottom: 3px;
        }

        .ph-side-meta {
            font-size: 10.5px;
            color: #aaa;
        }

        .ph-side-actions {
            display: flex;
            gap: 4px;
            margin-top: 6px;
        }

        .ph-action-btn {
            width: 24px;
            height: 24px;
            border-radius: 6px;
            border: 1px solid #e8e8e6;
            background: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.12s;
            text-decoration: none;
        }

        .ph-action-btn:hover {
            background: #f5f5f3;
            border-color: #ccc;
        }

        .ph-action-btn svg {
            width: 11px;
            height: 11px;
            color: #666;
        }

        .ph-action-btn.del:hover {
            background: #fff0f0;
            border-color: #ffb0b0;
        }

        .ph-action-btn.del svg {
            color: #e53e3e;
        }

        /* ─── ARCHIVES SECTION ────────────────────────────── */
        .ph-archives-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 14px;
        }

        .ph-archives-header h2 {
            font-size: 15px;
            font-weight: 700;
            color: #111;
        }

        .ph-archives-header a {
            font-size: 11.5px;
            font-weight: 600;
            color: #c89a00;
            text-decoration: none;
        }

        .ph-archives-header a:hover {
            text-decoration: underline;
        }

        .ph-archives-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
        }

        .ph-archive-card {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
            transition: transform 0.15s, box-shadow 0.15s;
            text-decoration: none;
        }

        .ph-archive-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .ph-archive-thumb {
            width: 100%;
            height: 120px;
            object-fit: cover;
            display: block;
            background: #e0e0de;
        }

        .ph-archive-thumb-ph {
            width: 100%;
            height: 120px;
            background: linear-gradient(135deg, #ddd 0%, #ccc 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .ph-archive-thumb-ph svg {
            width: 24px;
            height: 24px;
            color: rgba(0, 0, 0, 0.2);
        }

        .ph-archive-info {
            padding: 10px 12px;
        }

        .ph-archive-title {
            font-size: 12px;
            font-weight: 700;
            color: #111;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            margin-bottom: 3px;
        }

        .ph-archive-meta {
            font-size: 10.5px;
            color: #aaa;
        }

        /* Empty state */
        .ph-empty {
            text-align: center;
            padding: 60px 20px;
            color: #bbb;
        }

        .ph-empty svg {
            width: 40px;
            height: 40px;
            margin: 0 auto 12px;
            display: block;
        }

        .ph-empty p {
            font-size: 13px;
        }
    </style>

    {{-- ═══ HERO HEADER ═════════════════════════════════════════ --}}
    <div class="ph-hero-header">
        <div>
            <div class="ph-toolkit-label">Curator Toolkit</div>
            <div class="ph-hero-title">Manage your visual<br>narrative.</div>
        </div>
        <button onclick="openPostModal()" class="ph-upload-btn">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
            </svg>
            Upload New Content
        </button>
    </div>

    {{-- ═══ FILTER TABS ══════════════════════════════════════════ --}}
    <div class="ph-tabs">
        <a href="{{ route('admin.posts.index') }}" class="ph-tab {{ $filter === 'all' ? 'active' : '' }}">
            All Posts
            <span style="margin-left:4px;opacity:0.6;font-size:10px">({{ $stats['total'] }})</span>
        </a>
        <a href="{{ route('admin.posts.index', ['filter' => 'gallery']) }}"
            class="ph-tab {{ $filter === 'gallery' ? 'active' : '' }}">
            Galleries
        </a>
        <a href="{{ route('admin.posts.index', ['filter' => 'editorial']) }}"
            class="ph-tab {{ $filter === 'editorial' ? 'active' : '' }}">
            Editorials
        </a>
        <a href="{{ route('admin.posts.index', ['filter' => 'draft']) }}"
            class="ph-tab {{ $filter === 'draft' ? 'active' : '' }}">
            Drafts
        </a>
    </div>

    {{-- ═══ MAIN GRID: Featured + Side Cards ════════════════════ --}}
    <div class="ph-main-grid">

        {{-- Featured Post --}}
        <div class="ph-featured">
            @if ($featured)
                {{-- Cover image --}}
                @if ($featured->image_url)
                    <img src="{{ $featured->image_url }}" alt="{{ $featured->title }}" class="ph-featured-img">
                @else
                    <div class="ph-featured-img-placeholder">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M14 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                @endif

                <div class="ph-featured-body">
                    <div class="ph-featured-title-row">
                        <span class="ph-featured-title">{{ $featured->title }}</span>
                        <span class="badge badge-published">Published</span>
                    </div>
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-top:4px">
                        <div class="ph-featured-meta">
                            @if ($featured->published_at)
                                <span>
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ $featured->published_at->format('d M Y') }}
                                </span>
                            @endif
                        </div>
                        {{-- Edit & Delete buttons --}}
                        <div style="display:flex;gap:6px">
                            @php
                                $featuredData = json_encode([
                                    'id' => $featured->id,
                                    'title' => $featured->title,
                                    'type' => $featured->type,
                                    'excerpt' => $featured->excerpt,
                                    'image_url' => $featured->image_url,
                                ]);
                            @endphp
                            <a href="#" onclick='openPostModal({{ $featuredData }}); return false'
                                class="ph-action-btn" title="Edit">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <form method="POST" action="{{ route('admin.posts.destroy', $featured) }}"
                                onsubmit="return confirm('Hapus postingan ini?')" style="display:inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="ph-action-btn del" title="Hapus">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                {{-- Empty featured --}}
                <div class="ph-empty"
                    style="height:320px;display:flex;flex-direction:column;align-items:center;justify-content:center">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4" />
                    </svg>
                    <p>Belum ada postingan. <button onclick="openPostModal()"
                            style="color:#c89a00;background:none;border:none;cursor:pointer;font-size:inherit;padding:0;text-decoration:underline">Buat
                            pertama.</button></p>
                </div>
            @endif
        </div>

        {{-- Side Cards --}}
        <div class="ph-side-cards">
            @forelse ($sideCards as $post)
                <div class="ph-side-card">
                    {{-- Thumb --}}
                    <div class="ph-side-thumb">
                        @if ($post->image_url)
                            <img src="{{ $post->image_url }}" alt="{{ $post->title }}"
                                style="width:100%;height:100%;object-fit:cover;border-radius:8px">
                        @else
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M14 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        @endif
                    </div>

                    <div class="ph-side-info">
                        <div class="ph-side-type">{{ $post->type_label }}</div>
                        <div class="ph-side-title">{{ $post->title }}</div>
                        <div class="ph-side-meta">
                            Published: {{ $post->time_ago }}
                        </div>
                        <div class="ph-side-actions">
                            @php
                                $postData = json_encode([
                                    'id' => $post->id,
                                    'title' => $post->title,
                                    'type' => $post->type,
                                    'excerpt' => $post->excerpt,
                                    'image_url' => $post->image_url,
                                ]);
                            @endphp
                            <a href="#" onclick='openPostModal({{ $postData }}); return false'
                                class="ph-action-btn" title="Edit">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <form method="POST" action="{{ route('admin.posts.destroy', $post) }}"
                                onsubmit="return confirm('Hapus postingan ini?')" style="display:inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="ph-action-btn del" title="Hapus">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="ph-side-card" style="justify-content:center;color:#bbb;font-size:12px">
                    Tidak ada postingan lain.
                </div>
            @endforelse
        </div>

    </div>

    {{-- ═══ RECENT ARCHIVES ══════════════════════════════════════ --}}
    @if ($archives->isNotEmpty())
        <div>
            <div class="ph-archives-header">
                <h2>Recent Archives</h2>
                <a href="{{ route('admin.posts.index', ['filter' => 'all']) }}">View All Archive</a>
            </div>

            <div class="ph-archives-grid">
                @foreach ($archives as $post)
                    @php
                        $archiveData = json_encode([
                            'id' => $post->id,
                            'title' => $post->title,
                            'type' => $post->type,
                            'excerpt' => $post->excerpt,
                            'image_url' => $post->image_url,
                        ]);
                    @endphp
                    <div class="ph-archive-card">
                        @if ($post->image_url)
                            <img src="{{ $post->image_url }}" alt="{{ $post->title }}" class="ph-archive-thumb">
                        @else
                            <div class="ph-archive-thumb-ph">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M14 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                        <div class="ph-archive-info">
                            <div class="ph-archive-title">{{ $post->title }}</div>
                            <div style="display:flex;align-items:center;justify-content:space-between;margin-top:4px">
                                <div class="ph-archive-meta">
                                    {{ ucfirst($post->type) }} •
                                    {{ $post->published_at?->format('d M') ?? '-' }}
                                </div>
                                <div style="display:flex;gap:4px">
                                    <a href="#" onclick='openPostModal({{ $archiveData }}); return false'
                                        class="ph-action-btn" title="Edit">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <form method="POST" action="{{ route('admin.posts.destroy', $post) }}"
                                        onsubmit="return confirm('Hapus postingan ini?')" style="display:inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="ph-action-btn del" title="Hapus">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- ═══ MODAL ════════════════════════════════════════════════ --}}
    @include('admin.posts.modal')

@endsection
