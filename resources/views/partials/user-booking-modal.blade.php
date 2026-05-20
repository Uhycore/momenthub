@php
    /*
    resources/views/partials/user-booking-modal.blade.php
    Trigger: openUbModal(id, packageId, pkgName, total, startDate, endDate, notes, canEdit)
*/
@endphp

<style>
    #ub-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.55);
        backdrop-filter: blur(4px);
        z-index: 300;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.22s ease;
    }

    #ub-overlay.open {
        opacity: 1;
        pointer-events: all;
    }

    #ub-modal-box {
        background: #fff;
        border-radius: 18px;
        width: 100%;
        max-width: 500px;
        max-height: 92vh;
        overflow-y: auto;
        box-shadow: 0 24px 64px rgba(0, 0, 0, 0.22);
        transform: translateY(16px) scale(0.98);
        transition: transform 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
        scrollbar-width: thin;
    }

    #ub-overlay.open #ub-modal-box {
        transform: translateY(0) scale(1);
    }

    .ubm-header {
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

    .ubm-badge {
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
        margin-bottom: 5px;
    }

    .ubm-title {
        font-size: 18px;
        font-weight: 800;
        color: #111;
        letter-spacing: -0.02em;
    }

    .ubm-close {
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
        transition: all 0.13s;
        flex-shrink: 0;
    }

    .ubm-close:hover {
        background: #f5f5f3;
        color: #333;
    }

    .ubm-close svg {
        width: 13px;
        height: 13px;
    }

    .ubm-body {
        padding: 22px 26px;
    }

    .ubm-group {
        margin-bottom: 16px;
    }

    .ubm-label {
        display: block;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.11em;
        text-transform: uppercase;
        color: #999;
        margin-bottom: 5px;
    }

    .ubm-label .req {
        color: #e53e3e;
        margin-left: 2px;
    }

    .ubm-pkg-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #f9f9f7;
        border: 1.5px solid #eeeeec;
        border-radius: 10px;
        padding: 12px 14px;
        margin-bottom: 20px;
    }

    .ubm-pkg-name {
        font-size: 13.5px;
        font-weight: 700;
        color: #111;
    }

    .ubm-pkg-sub {
        font-size: 10px;
        color: #aaa;
        margin-top: 1px;
    }

    .ubm-pkg-price {
        font-size: 15px;
        font-weight: 800;
        color: #111;
        white-space: nowrap;
    }

    .ubm-date-info {
        font-size: 11.5px;
        color: #888;
        background: #f5f5f3;
        border-radius: 7px;
        padding: 8px 12px;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .ubm-date-info svg {
        width: 13px;
        height: 13px;
        flex-shrink: 0;
        color: #bbb;
    }

    .ubm-row-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    .ubm-input,
    .ubm-textarea {
        width: 100%;
        padding: 10px 12px;
        border: 1.5px solid #e8e8e6;
        border-radius: 9px;
        font-size: 13px;
        color: #111;
        background: #fafaf8;
        font-family: inherit;
        box-sizing: border-box;
        transition: border-color 0.15s, box-shadow 0.15s;
    }

    .ubm-input:focus,
    .ubm-textarea:focus {
        outline: none;
        border-color: #f5c518;
        box-shadow: 0 0 0 3px rgba(245, 197, 24, 0.14);
        background: #fff;
    }

    .ubm-input.error {
        border-color: #fc8181;
        background: #fff5f5;
    }

    .ubm-input:disabled {
        background: #f5f5f3;
        color: #aaa;
        cursor: not-allowed;
    }

    .ubm-textarea {
        resize: vertical;
        min-height: 72px;
        line-height: 1.6;
    }

    .ubm-check-btn {
        width: 100%;
        padding: 10px;
        border: 1.5px solid #111;
        border-radius: 9px;
        background: transparent;
        color: #111;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        cursor: pointer;
        font-family: inherit;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.13s;
        margin-top: 4px;
    }

    .ubm-check-btn:hover:not(:disabled) {
        background: #111;
        color: #fff;
    }

    .ubm-check-btn:disabled {
        opacity: 0.35;
        cursor: not-allowed;
    }

    .ubm-avail {
        display: none;
        padding: 11px 14px;
        border-radius: 9px;
        font-size: 12.5px;
        font-weight: 500;
        margin-top: 10px;
        align-items: center;
        gap: 8px;
    }

    .ubm-avail.show {
        display: flex;
    }

    .ubm-avail.ok {
        background: #e8f7ee;
        color: #1d7a40;
        border: 1px solid #b8e8c8;
    }

    .ubm-avail.err {
        background: #fff0f0;
        color: #c53030;
        border: 1px solid #fbb;
    }

    .ubm-avail svg {
        width: 15px;
        height: 15px;
        flex-shrink: 0;
    }

    .ubm-divider {
        border: none;
        border-top: 1px solid #f0f0ee;
        margin: 18px 0;
    }

    .ubm-file {
        width: 100%;
        padding: 8px 10px;
        border: 1.5px solid #e8e8e6;
        border-radius: 9px;
        font-size: 12.5px;
        color: #555;
        background: #fafaf8;
        font-family: inherit;
        cursor: pointer;
        box-sizing: border-box;
    }

    .ubm-file::file-selector-button {
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
    }

    .ubm-file::file-selector-button:hover {
        background: #e4e4e2;
    }

    @keyframes ubm-spin {
        to {
            transform: rotate(360deg);
        }
    }

    .ubm-spin {
        width: 13px;
        height: 13px;
        border: 2px solid rgba(0, 0, 0, 0.15);
        border-top-color: #111;
        border-radius: 50%;
        animation: ubm-spin 0.7s linear infinite;
        display: none;
    }

    .ubm-spin.show {
        display: inline-block;
    }

    .ubm-footer {
        display: flex;
        gap: 8px;
        padding: 16px 26px 22px;
        border-top: 1px solid #f0f0ee;
    }

    .ubm-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 10px 20px;
        border-radius: 9px;
        font-size: 12.5px;
        font-weight: 700;
        cursor: pointer;
        border: none;
        font-family: inherit;
        transition: all 0.13s;
    }

    .ubm-btn svg {
        width: 13px;
        height: 13px;
    }

    .ubm-btn-cancel {
        background: transparent;
        color: #888;
        border: 1.5px solid #e8e8e6;
    }

    .ubm-btn-cancel:hover {
        background: #f5f5f3;
        color: #333;
    }

    .ubm-btn-save {
        flex: 1;
        background: #111;
        color: #fff;
    }

    .ubm-btn-save:hover:not(:disabled) {
        background: #333;
    }

    .ubm-btn-save:disabled {
        background: #ccc;
        cursor: not-allowed;
        pointer-events: none;
    }
</style>

<div id="ub-overlay" onclick="handleUbOverlay(event)">
    <div id="ub-modal-box" role="dialog" aria-modal="true">

        {{-- Header --}}
        <div class="ubm-header">
            <div>
                <div class="ubm-badge">Detail Pesanan</div>
                <div class="ubm-title" id="ubm-title">—</div>
            </div>
            <button class="ubm-close" onclick="closeUbModal()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="ubm-body">
            <form id="ubm-form" method="POST" action="" enctype="multipart/form-data">
                @csrf @method('PATCH')

                {{-- Hidden fields --}}
                <input type="hidden" id="ubm-pkg-id" name="_pkg_id">

                {{-- Package row --}}
                <div class="ubm-pkg-row">
                    <div>
                        <div class="ubm-pkg-name" id="ubm-pkg-name">—</div>
                        <div class="ubm-pkg-sub">Paket yang dipesan</div>
                    </div>
                    <div class="ubm-pkg-price" id="ubm-pkg-price">—</div>
                </div>

                {{-- Current dates info --}}
                <div class="ubm-date-info">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span id="ubm-date-info-text">—</span>
                </div>

                {{-- Date pickers --}}
                <div class="ubm-row-2 ubm-group">
                    <div>
                        <label class="ubm-label" for="ubm-start">
                            Tanggal Mulai <span class="req">*</span>
                        </label>
                        <input type="date" id="ubm-start" name="start_date" class="ubm-input"
                            onchange="ubOnDateChange()">
                    </div>
                    <div>
                        <label class="ubm-label" for="ubm-end">
                            Tanggal Selesai <span class="req">*</span>
                        </label>
                        <input type="date" id="ubm-end" name="end_date" class="ubm-input"
                            onchange="ubOnDateChange()">
                    </div>
                </div>

                {{-- Check availability --}}
                <div class="ubm-group" id="ubm-check-section">
                    <button type="button" id="ubm-check-btn" class="ubm-check-btn" onclick="ubCheckAvail()">
                        <div class="ubm-spin" id="ubm-spin"></div>
                        <svg id="ubm-check-icon" width="14" height="14" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span id="ubm-check-label">Cek Ketersediaan</span>
                    </button>
                    <div class="ubm-avail" id="ubm-avail">
                        <svg id="ubm-avail-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            stroke-width="2.5"></svg>
                        <span id="ubm-avail-msg"></span>
                    </div>
                </div>

                <hr class="ubm-divider">

                {{-- Bukti pembayaran --}}
                <div class="ubm-group">
                    <label class="ubm-label" for="ubm-proof">Upload Bukti Pembayaran</label>
                    <input type="file" id="ubm-proof" name="payment_proof" class="ubm-file"
                        accept="image/jpeg,image/png,image/webp,application/pdf">
                    <div style="font-size:10.5px;color:#bbb;margin-top:4px;">
                        JPG, PNG, WebP, atau PDF — maks 5 MB (opsional)
                    </div>
                </div>

                {{-- Catatan --}}
                <div class="ubm-group">
                    <label class="ubm-label" for="ubm-notes">Catatan</label>
                    <textarea id="ubm-notes" name="notes" class="ubm-textarea" rows="2" maxlength="500"
                        placeholder="Konsep, lokasi, atau permintaan khusus…"></textarea>
                </div>

            </form>
        </div>

        {{-- Footer --}}
        <div class="ubm-footer">
            <button type="button" class="ubm-btn ubm-btn-cancel" onclick="closeUbModal()">
                Tutup
            </button>
            <button type="button" id="ubm-save-btn" class="ubm-btn ubm-btn-save" onclick="submitUbForm()" disabled>
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
                <span id="ubm-save-label">Simpan Perubahan</span>
            </button>
        </div>

    </div>
</div>

<script>
    let _ubBookingId = null;
    let _ubPkgId = null;
    let _ubOrigStart = '';
    let _ubOrigEnd = '';
    let _ubChecked = false;
    let _ubCanEdit = false;

    // ── Open ──────────────────────────────────────────────────────────────
    function openUbModal(id, packageId, pkgName, total, startDate, endDate, notes, canEdit) {
        _ubBookingId = id;
        _ubPkgId = packageId;
        _ubOrigStart = startDate;
        _ubOrigEnd = endDate;
        _ubCanEdit = canEdit;
        _ubChecked = false;

        // Form action
        document.getElementById('ubm-form').action = '/user/booking/' + id;
        document.getElementById('ubm-pkg-id').value = packageId;

        // Titles & info
        document.getElementById('ubm-title').textContent = 'Pesanan #MH-' + String(id).padStart(5, '0');
        document.getElementById('ubm-pkg-name').textContent = pkgName;
        document.getElementById('ubm-pkg-price').textContent = total;
        document.getElementById('ubm-notes').value = notes || '';

        // Date info label
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'];

        function fmt(d) {
            const [y, m, day] = d.split('-');
            return day + ' ' + months[parseInt(m) - 1] + ' ' + y;
        }
        document.getElementById('ubm-date-info-text').textContent =
            'Tanggal saat ini: ' + fmt(startDate) +
            (startDate !== endDate ? ' — ' + fmt(endDate) : '');

        // Pre-fill dates
        const today = new Date().toISOString().split('T')[0];
        const startEl = document.getElementById('ubm-start');
        const endEl = document.getElementById('ubm-end');

        startEl.min = today;
        endEl.min = today;
        startEl.value = startDate;
        endEl.value = endDate;

        // If read-only (can't edit), disable date inputs and hide check button
        startEl.disabled = !canEdit;
        endEl.disabled = !canEdit;
        document.getElementById('ubm-check-section').style.display = canEdit ? '' : 'none';
        document.getElementById('ubm-proof').disabled = !canEdit;

        // Save button
        if (canEdit) {
            // Tanggal awal sama → langsung bisa simpan (tanpa cek ulang)
            _ubChecked = true;
            document.getElementById('ubm-save-btn').disabled = false;
            document.getElementById('ubm-check-label').textContent = 'Tanggal tidak berubah';
            document.getElementById('ubm-avail').classList.remove('show', 'ok', 'err');
        } else {
            // Read-only mode: simpan hanya untuk catatan & bukti bayar
            _ubChecked = true;
            document.getElementById('ubm-save-btn').disabled = false;
        }

        document.getElementById('ub-overlay').classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    // ── Close ─────────────────────────────────────────────────────────────
    function closeUbModal() {
        document.getElementById('ub-overlay').classList.remove('open');
        document.body.style.overflow = '';
    }

    function handleUbOverlay(e) {
        if (e.target === document.getElementById('ub-overlay')) closeUbModal();
    }
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') closeUbModal();
    });

    // ── Date change ───────────────────────────────────────────────────────
    function ubOnDateChange() {
        const start = document.getElementById('ubm-start').value;
        const end = document.getElementById('ubm-end').value;

        if (start) {
            document.getElementById('ubm-end').min = start;
            if (end < start) document.getElementById('ubm-end').value = start;
        }

        // Sama dgn tanggal asli → tetap bisa simpan tanpa cek ulang
        if (start === _ubOrigStart && end === _ubOrigEnd) {
            _ubChecked = true;
            document.getElementById('ubm-save-btn').disabled = false;
            document.getElementById('ubm-avail').classList.remove('show', 'ok', 'err');
            document.getElementById('ubm-check-label').textContent = 'Tanggal tidak berubah';
        } else {
            // Tanggal berubah → wajib cek dulu
            _ubChecked = false;
            document.getElementById('ubm-save-btn').disabled = true;
            document.getElementById('ubm-avail').classList.remove('show', 'ok', 'err');
            document.getElementById('ubm-check-label').textContent = 'Cek Ketersediaan';
        }
    }

    // ── Check availability ────────────────────────────────────────────────
    async function ubCheckAvail() {
        const start = document.getElementById('ubm-start').value;
        const end = document.getElementById('ubm-end').value;
        let valid = true;

        ['ubm-start', 'ubm-end'].forEach(id => {
            const el = document.getElementById(id);
            if (!el.value) {
                el.classList.add('error');
                valid = false;
            } else el.classList.remove('error');
        });
        if (!valid) return;
        if (end < start) {
            ubSetAvail(false, 'Tanggal selesai tidak boleh sebelum tanggal mulai.');
            return;
        }

        const btn = document.getElementById('ubm-check-btn');
        const spin = document.getElementById('ubm-spin');
        const icon = document.getElementById('ubm-check-icon');
        const label = document.getElementById('ubm-check-label');

        btn.disabled = true;
        spin.classList.add('show');
        icon.style.display = 'none';
        label.textContent = 'Mengecek…';

        try {
            const res = await fetch('{{ route('booking.check') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    package_id: _ubPkgId, // ← fix: dari variabel, bukan dari DOM
                    start_date: start,
                    end_date: end,
                    booking_id: _ubBookingId, // ← exclude diri sendiri
                }),
            });

            const data = await res.json();
            ubSetAvail(data.available, data.message);
            _ubChecked = data.available;
            document.getElementById('ubm-save-btn').disabled = !data.available;

        } catch {
            ubSetAvail(false, 'Gagal terhubung ke server. Coba lagi.');
        } finally {
            btn.disabled = false;
            spin.classList.remove('show');
            icon.style.display = '';
            label.textContent = 'Cek Ulang';
        }
    }

    function ubSetAvail(ok, msg) {
        const el = document.getElementById('ubm-avail');
        const icon = document.getElementById('ubm-avail-icon');
        el.classList.remove('show', 'ok', 'err');
        el.classList.add('show', ok ? 'ok' : 'err');
        document.getElementById('ubm-avail-msg').textContent = msg;
        icon.innerHTML = ok ?
            '<path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>' :
            '<path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>';
    }

    // ── Submit ────────────────────────────────────────────────────────────
    function submitUbForm() {
        const proof = document.getElementById('ubm-proof');
        if (proof.files[0] && proof.files[0].size > 5 * 1024 * 1024) {
            alert('Ukuran file maksimal 5 MB.');
            return;
        }
        const btn = document.getElementById('ubm-save-btn');
        btn.disabled = true;
        document.getElementById('ubm-save-label').textContent = 'Menyimpan…';
        document.getElementById('ubm-form').submit();
    }

    window.openUbModal = openUbModal;
    window.closeUbModal = closeUbModal;
</script>
