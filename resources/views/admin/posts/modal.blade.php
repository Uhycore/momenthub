{{--
    admin/posts/modal.blade.php
    @include('admin.posts.modal') dari index
    JS: openPostModal() → create | openPostModal(postData) → edit
--}}

<style>
    #post-modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(10, 10, 10, 0.55);
        backdrop-filter: blur(3px);
        z-index: 200;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.22s ease;
    }

    #post-modal-overlay.open {
        opacity: 1;
        pointer-events: all;
    }

    #post-modal {
        background: #fff;
        border-radius: 18px;
        width: 100%;
        max-width: 560px;
        max-height: 92vh;
        overflow-y: auto;
        box-shadow: 0 24px 60px rgba(0, 0, 0, 0.22);
        transform: translateY(16px) scale(0.98);
        transition: transform 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
        scrollbar-width: thin;
        scrollbar-color: #e0e0de transparent;
    }

    #post-modal-overlay.open #post-modal {
        transform: translateY(0) scale(1);
    }

    /* ── Header ── */
    .pm-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        padding: 22px 26px 18px;
        border-bottom: 1px solid #f0f0ee;
        position: sticky;
        top: 0;
        background: #fff;
        z-index: 2;
        border-radius: 18px 18px 0 0;
    }

    .pm-badge {
        display: inline-block;
        font-size: 9px;
        font-weight: 700;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: #c89a00;
        background: #fffbe6;
        border: 1px solid #f5e08a;
        padding: 3px 9px;
        border-radius: 20px;
        margin-bottom: 6px;
    }

    .pm-title {
        font-size: 19px;
        font-weight: 800;
        color: #111;
        letter-spacing: -0.02em;
    }

    .pm-close {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        border: 1.5px solid #e8e8e6;
        background: transparent;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: #aaa;
        transition: all 0.15s;
        flex-shrink: 0;
        margin-top: 2px;
    }

    .pm-close:hover {
        background: #f5f5f3;
        color: #333;
        border-color: #ccc;
    }

    .pm-close svg {
        width: 13px;
        height: 13px;
    }

    /* ── Body ── */
    .pm-body {
        padding: 22px 26px;
    }

    .pm-group {
        margin-bottom: 16px;
    }

    .pm-group:last-child {
        margin-bottom: 0;
    }

    .pm-label {
        display: block;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: #999;
        margin-bottom: 5px;
    }

    .pm-label .req {
        color: #e53e3e;
        margin-left: 2px;
    }

    .pm-input,
    .pm-select,
    .pm-textarea {
        width: 100%;
        padding: 10px 13px;
        border: 1.5px solid #e8e8e6;
        border-radius: 9px;
        font-size: 13.5px;
        color: #111;
        background: #fafaf8;
        font-family: inherit;
        transition: border-color 0.15s, box-shadow 0.15s;
        box-sizing: border-box;
    }

    .pm-input:focus,
    .pm-select:focus,
    .pm-textarea:focus {
        outline: none;
        border-color: #f5c518;
        box-shadow: 0 0 0 3px rgba(245, 197, 24, 0.15);
        background: #fff;
    }

    .pm-input.error {
        border-color: #fc8181;
        background: #fff5f5;
    }

    .pm-textarea {
        resize: vertical;
        min-height: 75px;
        line-height: 1.6;
    }

    .pm-select {
        cursor: pointer;
    }

    /* ── File input ── */
    .pm-file-input {
        width: 100%;
        padding: 8px 10px;
        border: 1.5px solid #e8e8e6;
        border-radius: 9px;
        font-size: 12.5px;
        color: #555;
        background: #fafaf8;
        font-family: inherit;
        cursor: pointer;
        transition: border-color 0.15s;
        box-sizing: border-box;
    }

    .pm-file-input:focus {
        outline: none;
        border-color: #f5c518;
    }

    .pm-file-input::file-selector-button {
        background: #f0f0ee;
        border: none;
        border-radius: 6px;
        padding: 4px 11px;
        font-size: 11.5px;
        font-weight: 600;
        color: #444;
        cursor: pointer;
        margin-right: 10px;
        font-family: inherit;
        transition: background 0.12s;
    }

    .pm-file-input::file-selector-button:hover {
        background: #e4e4e2;
    }

    /* ── Image comparison (before / after) ── */
    .pm-img-compare {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        margin-bottom: 10px;
    }

    .pm-img-col {}

    .pm-img-col-label {
        font-size: 9px;
        font-weight: 700;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: #bbb;
        margin-bottom: 5px;
    }

    .pm-img-box {
        width: 100%;
        height: 130px;
        border-radius: 9px;
        overflow: hidden;
        background: #f0f0ee;
        border: 1.5px solid #e8e8e6;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .pm-img-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .pm-img-box-empty svg {
        width: 28px;
        height: 28px;
        color: #ccc;
    }

    .pm-img-box-label {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.45);
        color: #fff;
        font-size: 9px;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-align: center;
        padding: 4px 0;
        text-transform: uppercase;
    }

    /* Single upload preview (create mode) */
    .pm-upload-preview {
        display: none;
        margin-top: 8px;
        border-radius: 9px;
        overflow: hidden;
        border: 1.5px solid #e8e8e6;
        height: 140px;
        position: relative;
    }

    .pm-upload-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .pm-upload-preview-label {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.4);
        color: #fff;
        font-size: 9px;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-align: center;
        padding: 4px 0;
        text-transform: uppercase;
    }

    .pm-error {
        font-size: 11px;
        color: #e53e3e;
        margin-top: 4px;
        display: none;
    }

    /* ── Footer ── */
    .pm-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 26px 22px;
        border-top: 1px solid #f0f0ee;
    }

    .pm-footer-hint {
        font-size: 10.5px;
        color: #ccc;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .pm-footer-hint svg {
        width: 12px;
        height: 12px;
    }

    .pm-btn-group {
        display: flex;
        gap: 8px;
    }

    .pm-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 9px 18px;
        border-radius: 9px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        border: none;
        font-family: inherit;
        transition: all 0.15s;
    }

    .pm-btn svg {
        width: 13px;
        height: 13px;
    }

    .pm-btn-cancel {
        background: transparent;
        color: #888;
        border: 1.5px solid #e8e8e6;
    }

    .pm-btn-cancel:hover {
        background: #f5f5f3;
        color: #333;
    }

    .pm-btn-save {
        background: #111;
        color: #fff;
    }

    .pm-btn-save:hover {
        background: #333;
    }

    .pm-btn-save:disabled {
        background: #ccc;
        cursor: not-allowed;
        pointer-events: none;
    }
</style>

<div id="post-modal-overlay" onclick="handleOverlayClick(event)">
    <div id="post-modal" role="dialog" aria-modal="true">

        {{-- Header --}}
        <div class="pm-header">
            <div>
                <div class="pm-badge" id="pm-badge-text">New Content</div>
                <div class="pm-title" id="pm-title-text">Upload Content</div>
            </div>
            <button class="pm-close" onclick="closePostModal()" aria-label="Tutup">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="pm-body">
            <form id="pm-form" method="POST" enctype="multipart/form-data" action="{{ route('admin.posts.store') }}">
                @csrf
                <input type="hidden" name="_method" id="pm-method" value="POST">

                {{-- Judul --}}
                <div class="pm-group">
                    <label class="pm-label" for="pm-input-title">
                        Judul Post <span class="req">*</span>
                    </label>
                    <input type="text" id="pm-input-title" name="title" class="pm-input"
                        placeholder="Contoh: Urban Geometry: Seoul 2024" maxlength="255">
                    <div class="pm-error" id="pm-err-title"></div>
                </div>

                {{-- Tipe --}}
                <div class="pm-group">
                    <label class="pm-label" for="pm-input-type">
                        Tipe <span class="req">*</span>
                    </label>
                    <select id="pm-input-type" name="type" class="pm-select">
                        <option value="gallery">Gallery</option>
                        <option value="editorial">Editorial</option>
                    </select>
                </div>

                {{-- Deskripsi --}}
                <div class="pm-group">
                    <label class="pm-label" for="pm-input-excerpt">Deskripsi Singkat</label>
                    <textarea id="pm-input-excerpt" name="excerpt" class="pm-textarea" rows="2"
                        placeholder="Ringkasan singkat konten ini…" maxlength="500"></textarea>
                </div>

                {{-- Gambar -- tampilan beda untuk create vs edit --}}
                <div class="pm-group">
                    <label class="pm-label">Gambar</label>

                    {{-- EDIT MODE: before / after side-by-side --}}
                    <div id="pm-img-compare" class="pm-img-compare" style="display:none">
                        {{-- Before --}}
                        <div class="pm-img-col">
                            <div class="pm-img-col-label">Foto Sekarang</div>
                            <div class="pm-img-box" id="pm-box-before">
                                <div class="pm-img-box-empty">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M14 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        {{-- After --}}
                        <div class="pm-img-col">
                            <div class="pm-img-col-label">Foto Baru</div>
                            <div class="pm-img-box" id="pm-box-after">
                                <div class="pm-img-box-empty" id="pm-after-placeholder">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- File input --}}
                    <input type="file" name="image" id="pm-input-image" class="pm-file-input"
                        accept="image/jpeg,image/png,image/webp" onchange="handleImageChange(event)">
                    <div style="font-size:10.5px;color:#bbb;margin-top:4px">
                        JPG, PNG, WebP — maks 5 MB
                    </div>

                    {{-- CREATE MODE: single preview below file input --}}
                    <div class="pm-upload-preview" id="pm-upload-preview">
                        <img id="pm-upload-preview-img" src="" alt="Preview">
                        <div class="pm-upload-preview-label">Preview</div>
                    </div>
                </div>

            </form>
        </div>

        {{-- Footer --}}
        <div class="pm-footer">
            <div class="pm-footer-hint">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                </svg>
                Langsung dipublikasikan
            </div>
            <div class="pm-btn-group">
                <button type="button" class="pm-btn pm-btn-cancel" onclick="closePostModal()">
                    Batal
                </button>
                <button type="button" class="pm-btn pm-btn-save" id="pm-submit-btn" onclick="submitPostForm()">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    <span id="pm-submit-label">Publikasikan</span>
                </button>
            </div>
        </div>

    </div>
</div>

<script>
    const PM_ROUTES = {
        store: '{{ route('admin.posts.store') }}',
        update: (id) => '{{ route('admin.posts.update', ':id') }}'.replace(':id', id),
    };

    let pmIsEditMode = false;

    // ── Open ───────────────────────────────────────────────────────────────

    function openPostModal(post = null) {
        resetModal();
        pmIsEditMode = !!post;

        if (post) {
            // EDIT MODE
            document.getElementById('pm-badge-text').textContent = 'Edit Konten';
            document.getElementById('pm-title-text').textContent = 'Edit Post';
            document.getElementById('pm-submit-label').textContent = 'Simpan Perubahan';
            document.getElementById('pm-method').value = 'PUT';
            document.getElementById('pm-form').action = PM_ROUTES.update(post.id);

            document.getElementById('pm-input-title').value = post.title ?? '';
            document.getElementById('pm-input-type').value = post.type ?? 'gallery';
            document.getElementById('pm-input-excerpt').value = post.excerpt ?? '';

            // Tampilkan before/after panel
            document.getElementById('pm-img-compare').style.display = 'grid';
            document.getElementById('pm-upload-preview').style.display = 'none';

            // Set foto "before"
            const boxBefore = document.getElementById('pm-box-before');
            boxBefore.innerHTML = '';
            if (post.image_url) {
                const img = document.createElement('img');
                img.src = post.image_url;
                img.alt = 'Foto sekarang';
                boxBefore.appendChild(img);
                const lbl = document.createElement('div');
                lbl.className = 'pm-img-box-label';
                lbl.textContent = 'Sekarang';
                boxBefore.appendChild(lbl);
            } else {
                boxBefore.innerHTML = `<div class="pm-img-box-empty">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M14 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg></div>`;
            }

            // Reset "after" box
            resetAfterBox();

        } else {
            // CREATE MODE
            document.getElementById('pm-badge-text').textContent = 'New Content';
            document.getElementById('pm-title-text').textContent = 'Upload Content';
            document.getElementById('pm-submit-label').textContent = 'Publikasikan';
            document.getElementById('pm-method').value = 'POST';
            document.getElementById('pm-form').action = PM_ROUTES.store;

            document.getElementById('pm-img-compare').style.display = 'none';
            document.getElementById('pm-upload-preview').style.display = 'none';
        }

        document.getElementById('post-modal-overlay').classList.add('open');
        document.body.style.overflow = 'hidden';
        setTimeout(() => document.getElementById('pm-input-title').focus(), 260);
    }

    // ── Close ──────────────────────────────────────────────────────────────

    function closePostModal() {
        document.getElementById('post-modal-overlay').classList.remove('open');
        document.body.style.overflow = '';
    }

    function handleOverlayClick(e) {
        if (e.target === document.getElementById('post-modal-overlay')) closePostModal();
    }

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closePostModal();
    });

    // ── Reset ──────────────────────────────────────────────────────────────

    function resetModal() {
        document.getElementById('pm-form').reset();
        document.getElementById('pm-method').value = 'POST';
        document.getElementById('pm-upload-preview').style.display = 'none';
        document.getElementById('pm-upload-preview-img').src = '';
        document.getElementById('pm-img-compare').style.display = 'none';
        document.getElementById('pm-err-title').style.display = 'none';
        document.getElementById('pm-err-title').textContent = '';
        document.getElementById('pm-input-title').classList.remove('error');
        resetAfterBox();
    }

    function resetAfterBox() {
        const box = document.getElementById('pm-box-after');
        box.innerHTML = `<div class="pm-img-box-empty" id="pm-after-placeholder">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg></div>`;
    }

    // ── Image change handler ───────────────────────────────────────────────

    function handleImageChange(e) {
        const file = e.target.files[0];
        if (!file) return;

        if (file.size > 5 * 1024 * 1024) {
            alert('Ukuran gambar maksimal 5 MB.');
            e.target.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = (ev) => {
            if (pmIsEditMode) {
                // Update "after" box
                const box = document.getElementById('pm-box-after');
                box.innerHTML = '';
                const img = document.createElement('img');
                img.src = ev.target.result;
                img.alt = 'Foto baru';
                box.appendChild(img);
                const lbl = document.createElement('div');
                lbl.className = 'pm-img-box-label';
                lbl.textContent = 'Baru';
                box.appendChild(lbl);
            } else {
                // Show single preview below file input
                const preview = document.getElementById('pm-upload-preview');
                document.getElementById('pm-upload-preview-img').src = ev.target.result;
                preview.style.display = 'block';
            }
        };
        reader.readAsDataURL(file);
    }

    // ── Submit ─────────────────────────────────────────────────────────────

    function submitPostForm() {
        const title = document.getElementById('pm-input-title');
        const errTitle = document.getElementById('pm-err-title');

        if (!title.value.trim()) {
            title.classList.add('error');
            errTitle.textContent = 'Judul tidak boleh kosong.';
            errTitle.style.display = 'block';
            title.focus();
            return;
        }
        title.classList.remove('error');
        errTitle.style.display = 'none';

        const btn = document.getElementById('pm-submit-btn');
        btn.disabled = true;
        document.getElementById('pm-submit-label').textContent = 'Menyimpan…';
        document.getElementById('pm-form').submit();
    }

    window.openPostModal = openPostModal;
    window.closePostModal = closePostModal;
</script>
