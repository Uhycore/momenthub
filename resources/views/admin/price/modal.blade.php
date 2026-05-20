{{--
    admin/price/modal.blade.php
    @include('admin.price.modal') dari index
    JS: openPkgModal() → create | openPkgModal(pkgData) → edit
--}}

<style>
    #pkg-modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(10, 10, 10, 0.50);
        backdrop-filter: blur(3px);
        z-index: 200;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.2s ease;
    }

    #pkg-modal-overlay.open {
        opacity: 1;
        pointer-events: all;
    }

    #pkg-modal {
        background: #fff;
        border-radius: 16px;
        width: 100%;
        max-width: 500px;
        max-height: 92vh;
        overflow-y: auto;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.18);
        transform: translateY(14px) scale(0.98);
        transition: transform 0.22s cubic-bezier(0.34, 1.56, 0.64, 1);
        scrollbar-width: thin;
        scrollbar-color: #e0e0de transparent;
    }

    #pkg-modal-overlay.open #pkg-modal {
        transform: translateY(0) scale(1);
    }

    /* Header */
    .pkm-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        padding: 20px 24px 16px;
        border-bottom: 1px solid #f0f0ee;
        position: sticky;
        top: 0;
        background: #fff;
        z-index: 2;
        border-radius: 16px 16px 0 0;
    }

    .pkm-badge {
        display: inline-block;
        font-size: 9px;
        font-weight: 700;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: #92700a;
        background: #fffbe6;
        border: 1px solid #f5e08a;
        padding: 2px 8px;
        border-radius: 20px;
        margin-bottom: 5px;
    }

    .pkm-title {
        font-size: 18px;
        font-weight: 800;
        color: #111;
        letter-spacing: -0.02em;
    }

    .pkm-close {
        width: 28px;
        height: 28px;
        border-radius: 7px;
        border: 1.5px solid #e8e8e6;
        background: transparent;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: #aaa;
        transition: all 0.12s;
        flex-shrink: 0;
    }

    .pkm-close:hover {
        background: #f5f5f3;
        color: #333;
        border-color: #ccc;
    }

    .pkm-close svg {
        width: 12px;
        height: 12px;
    }

    /* Body */
    .pkm-body {
        padding: 20px 24px;
    }

    .pkm-group {
        margin-bottom: 15px;
    }

    .pkm-group:last-child {
        margin-bottom: 0;
    }

    .pkm-label {
        display: block;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.11em;
        text-transform: uppercase;
        color: #999;
        margin-bottom: 5px;
    }

    .pkm-label .req {
        color: #e53e3e;
        margin-left: 2px;
    }

    .pkm-input,
    .pkm-select,
    .pkm-textarea {
        width: 100%;
        padding: 9px 12px;
        border: 1.5px solid #e8e8e6;
        border-radius: 8px;
        font-size: 13px;
        color: #111;
        background: #fafaf8;
        font-family: inherit;
        transition: border-color 0.15s, box-shadow 0.15s;
        box-sizing: border-box;
    }

    .pkm-input:focus,
    .pkm-select:focus,
    .pkm-textarea:focus {
        outline: none;
        border-color: #f5c518;
        box-shadow: 0 0 0 3px rgba(245, 197, 24, 0.14);
        background: #fff;
    }

    .pkm-input.error {
        border-color: #fc8181;
        background: #fff5f5;
    }

    .pkm-textarea {
        resize: vertical;
        min-height: 72px;
        line-height: 1.6;
    }

    .pkm-select {
        cursor: pointer;
    }

    .pkm-row-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    /* Price input with prefix */
    .pkm-price-wrap {
        display: flex;
        align-items: center;
        border: 1.5px solid #e8e8e6;
        border-radius: 8px;
        background: #fafaf8;
        overflow: hidden;
        transition: border-color 0.15s, box-shadow 0.15s;
    }

    .pkm-price-wrap:focus-within {
        border-color: #f5c518;
        box-shadow: 0 0 0 3px rgba(245, 197, 24, 0.14);
        background: #fff;
    }

    .pkm-price-prefix {
        padding: 9px 12px 9px 12px;
        font-size: 12px;
        font-weight: 700;
        color: #aaa;
        background: #f5f5f3;
        border-right: 1.5px solid #e8e8e6;
        white-space: nowrap;
        flex-shrink: 0;
        user-select: none;
    }

    .pkm-price-input {
        flex: 1;
        padding: 9px 12px;
        border: none;
        outline: none;
        font-size: 13px;
        color: #111;
        background: transparent;
        font-family: inherit;
        min-width: 0;
    }

    /* Toggle switch for is_active */
    .pkm-toggle-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 13px;
        border: 1.5px solid #e8e8e6;
        border-radius: 8px;
        background: #fafaf8;
    }

    .pkm-toggle-label-txt {
        font-size: 13px;
        color: #333;
        font-weight: 500;
    }

    .pkm-toggle-sub {
        font-size: 10.5px;
        color: #aaa;
        margin-top: 1px;
    }

    .pkm-switch {
        position: relative;
        display: inline-block;
        width: 38px;
        height: 22px;
        flex-shrink: 0;
    }

    .pkm-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .pkm-slider {
        position: absolute;
        inset: 0;
        background: #ddd;
        border-radius: 22px;
        cursor: pointer;
        transition: background 0.2s;
    }

    .pkm-slider:before {
        content: '';
        position: absolute;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background: #fff;
        left: 3px;
        bottom: 3px;
        transition: transform 0.2s;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.18);
    }

    .pkm-switch input:checked+.pkm-slider {
        background: #111;
    }

    .pkm-switch input:checked+.pkm-slider:before {
        transform: translateX(16px);
    }

    .pkm-error {
        font-size: 11px;
        color: #e53e3e;
        margin-top: 3px;
        display: none;
    }

    /* Footer */
    .pkm-footer {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 8px;
        padding: 14px 24px 20px;
        border-top: 1px solid #f0f0ee;
    }

    .pkm-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 18px;
        border-radius: 8px;
        font-size: 12.5px;
        font-weight: 600;
        cursor: pointer;
        border: none;
        font-family: inherit;
        transition: all 0.12s;
    }

    .pkm-btn svg {
        width: 13px;
        height: 13px;
    }

    .pkm-btn-cancel {
        background: transparent;
        color: #888;
        border: 1.5px solid #e8e8e6;
    }

    .pkm-btn-cancel:hover {
        background: #f5f5f3;
        color: #333;
    }

    .pkm-btn-save {
        background: #111;
        color: #fff;
    }

    .pkm-btn-save:hover {
        background: #333;
    }

    .pkm-btn-save:disabled {
        background: #ccc;
        cursor: not-allowed;
        pointer-events: none;
    }
</style>

<div id="pkg-modal-overlay" onclick="handlePkgOverlayClick(event)">
    <div id="pkg-modal" role="dialog" aria-modal="true">

        {{-- Header --}}
        <div class="pkm-header">
            <div>
                <div class="pkm-badge" id="pkm-badge-text">Paket Baru</div>
                <div class="pkm-title" id="pkm-title-text">Tambah Paket</div>
            </div>
            <button class="pkm-close" onclick="closePkgModal()" aria-label="Tutup">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="pkm-body">
            <form id="pkm-form" method="POST" action="{{ route('admin.price.store') }}">
                @csrf
                <input type="hidden" name="_method" id="pkm-method" value="POST">

                {{-- Nama paket --}}
                <div class="pkm-group">
                    <label class="pkm-label" for="pkm-name">
                        Nama Paket <span class="req">*</span>
                    </label>
                    <input type="text" id="pkm-name" name="name" class="pkm-input"
                        placeholder="Contoh: Basic Portrait" maxlength="100">
                    <div class="pkm-error" id="pkm-err-name"></div>
                </div>

                {{-- Harga --}}
                <div class="pkm-group">
                    <label class="pkm-label" for="pkm-price">
                        Harga <span class="req">*</span>
                    </label>
                    <div class="pkm-price-wrap">
                        <span class="pkm-price-prefix">Rp</span>
                        <input type="number" id="pkm-price" name="price" class="pkm-price-input" placeholder="500000"
                            min="0" step="1000">
                    </div>
                    <div class="pkm-error" id="pkm-err-price"></div>
                </div>

                {{-- Durasi + Jumlah Foto --}}
                <div class="pkm-row-2">
                    <div class="pkm-group">
                        <label class="pkm-label" for="pkm-duration">
                            Durasi (Jam) <span class="req">*</span>
                        </label>
                        <input type="number" id="pkm-duration" name="duration" class="pkm-input" placeholder="2"
                            min="1" max="24">
                        <div class="pkm-error" id="pkm-err-duration"></div>
                    </div>
                    <div class="pkm-group">
                        <label class="pkm-label" for="pkm-photo-count">
                            Jumlah Foto <span class="req">*</span>
                        </label>
                        <input type="number" id="pkm-photo-count" name="photo_count" class="pkm-input" placeholder="30"
                            min="1">
                        <div class="pkm-error" id="pkm-err-photo"></div>
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div class="pkm-group">
                    <label class="pkm-label" for="pkm-desc">Deskripsi Singkat</label>
                    <textarea id="pkm-desc" name="description" class="pkm-textarea" rows="2"
                        placeholder="Cocok untuk sesi portrait individu…" maxlength="500"></textarea>
                </div>

                {{-- Status Aktif --}}
                <div class="pkm-group">
                    <label class="pkm-label">Status Tampil</label>
                    <div class="pkm-toggle-row">
                        <div>
                            <div class="pkm-toggle-label-txt">Tampilkan ke tamu</div>
                            <div class="pkm-toggle-sub">Paket akan muncul di halaman harga publik</div>
                        </div>
                        <label class="pkm-switch">
                            <input type="checkbox" id="pkm-is-active" name="is_active" value="1" checked>
                            <span class="pkm-slider"></span>
                        </label>
                    </div>
                </div>

            </form>
        </div>

        {{-- Footer --}}
        <div class="pkm-footer">
            <button type="button" class="pkm-btn pkm-btn-cancel" onclick="closePkgModal()">
                Batal
            </button>
            <button type="button" class="pkm-btn pkm-btn-save" id="pkm-submit-btn" onclick="submitPkgForm()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
                <span id="pkm-submit-label">Simpan Paket</span>
            </button>
        </div>

    </div>
</div>

<script>
    const PKG_ROUTES = {
        store: '{{ route('admin.price.store') }}',
        update: (id) => '{{ route('admin.price.update', ':id') }}'.replace(':id', id),
    };

    function openPkgModal(pkg = null) {
        resetPkgModal();

        if (pkg) {
            document.getElementById('pkm-badge-text').textContent = 'Edit Paket';
            document.getElementById('pkm-title-text').textContent = 'Edit Paket';
            document.getElementById('pkm-submit-label').textContent = 'Simpan Perubahan';
            document.getElementById('pkm-method').value = 'PUT';
            document.getElementById('pkm-form').action = PKG_ROUTES.update(pkg.id);

            document.getElementById('pkm-name').value = pkg.name ?? '';
            document.getElementById('pkm-price').value = pkg.price ?? '';
            document.getElementById('pkm-duration').value = pkg.duration ?? '';
            document.getElementById('pkm-photo-count').value = pkg.photo_count ?? '';
            document.getElementById('pkm-desc').value = pkg.description ?? '';
            document.getElementById('pkm-is-active').checked = !!pkg.is_active;
        } else {
            document.getElementById('pkm-badge-text').textContent = 'Paket Baru';
            document.getElementById('pkm-title-text').textContent = 'Tambah Paket';
            document.getElementById('pkm-submit-label').textContent = 'Simpan Paket';
            document.getElementById('pkm-method').value = 'POST';
            document.getElementById('pkm-form').action = PKG_ROUTES.store;
        }

        document.getElementById('pkg-modal-overlay').classList.add('open');
        document.body.style.overflow = 'hidden';
        setTimeout(() => document.getElementById('pkm-name').focus(), 220);
    }

    function closePkgModal() {
        document.getElementById('pkg-modal-overlay').classList.remove('open');
        document.body.style.overflow = '';
    }

    function handlePkgOverlayClick(e) {
        if (e.target === document.getElementById('pkg-modal-overlay')) closePkgModal();
    }

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closePkgModal();
    });

    function resetPkgModal() {
        document.getElementById('pkm-form').reset();
        document.getElementById('pkm-method').value = 'POST';
        document.getElementById('pkm-is-active').checked = true;

        ['pkm-err-name', 'pkm-err-price', 'pkm-err-duration', 'pkm-err-photo'].forEach(id => {
            const el = document.getElementById(id);
            el.style.display = 'none';
            el.textContent = '';
        });
        ['pkm-name', 'pkm-price', 'pkm-duration', 'pkm-photo-count'].forEach(id => {
            document.getElementById(id).classList.remove('error');
        });
    }

    function submitPkgForm() {
        let valid = true;

        const fields = [{
                id: 'pkm-name',
                err: 'pkm-err-name',
                msg: 'Nama paket wajib diisi.'
            },
            {
                id: 'pkm-price',
                err: 'pkm-err-price',
                msg: 'Harga wajib diisi.'
            },
            {
                id: 'pkm-duration',
                err: 'pkm-err-duration',
                msg: 'Durasi wajib diisi.'
            },
            {
                id: 'pkm-photo-count',
                err: 'pkm-err-photo',
                msg: 'Jumlah foto wajib diisi.'
            },
        ];

        fields.forEach(({
            id,
            err,
            msg
        }) => {
            const el = document.getElementById(id);
            const errEl = document.getElementById(err);
            if (!el.value.trim()) {
                el.classList.add('error');
                errEl.textContent = msg;
                errEl.style.display = 'block';
                if (valid) el.focus();
                valid = false;
            } else {
                el.classList.remove('error');
                errEl.style.display = 'none';
            }
        });

        if (!valid) return;

        const btn = document.getElementById('pkm-submit-btn');
        btn.disabled = true;
        document.getElementById('pkm-submit-label').textContent = 'Menyimpan…';
        document.getElementById('pkm-form').submit();
    }

    window.openPkgModal = openPkgModal;
    window.closePkgModal = closePkgModal;
</script>
