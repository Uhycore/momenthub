<style>
    #bk-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.58);
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

    #bk-overlay.open {
        opacity: 1;
        pointer-events: all;
    }

    #bk-modal {
        background: #fff;
        border-radius: 18px;
        width: 100%;
        max-width: 500px;
        max-height: 92vh;
        overflow-y: auto;
        box-shadow: 0 24px 64px rgba(0, 0, 0, 0.24);
        transform: translateY(16px) scale(0.98);
        transition: transform 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
        scrollbar-width: thin;
    }

    #bk-overlay.open #bk-modal {
        transform: translateY(0) scale(1);
    }

    .bk-header {
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

    .bk-badge {
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

    .bk-title {
        font-size: 18px;
        font-weight: 800;
        color: #111;
        letter-spacing: -0.02em;
    }

    .bk-close {
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

    .bk-close:hover {
        background: #f5f5f3;
        color: #333;
    }

    .bk-close svg {
        width: 13px;
        height: 13px;
    }

    .bk-body {
        padding: 22px 26px;
    }

    .bk-pkg-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #f9f9f7;
        border: 1.5px solid #eeeeec;
        border-radius: 10px;
        padding: 12px 14px;
        margin-bottom: 20px;
    }

    .bk-pkg-name {
        font-size: 13.5px;
        font-weight: 700;
        color: #111;
    }

    .bk-pkg-sub {
        font-size: 10px;
        color: #aaa;
        margin-top: 1px;
    }

    .bk-pkg-price {
        font-size: 15px;
        font-weight: 800;
        color: #111;
        white-space: nowrap;
    }

    .bk-group {
        margin-bottom: 15px;
    }

    .bk-label {
        display: block;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.11em;
        text-transform: uppercase;
        color: #999;
        margin-bottom: 5px;
    }

    .bk-label .req {
        color: #e53e3e;
        margin-left: 2px;
    }

    .bk-input,
    .bk-textarea {
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

    .bk-input:focus,
    .bk-textarea:focus {
        outline: none;
        border-color: #f5c518;
        box-shadow: 0 0 0 3px rgba(245, 197, 24, 0.14);
        background: #fff;
    }

    .bk-input.error {
        border-color: #fc8181;
        background: #fff5f5;
    }

    .bk-textarea {
        resize: vertical;
        min-height: 70px;
        line-height: 1.6;
    }

    .bk-row-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    /* ── Estimasi harga ── */
    #bk-estimate {
        display: none;
        background: #f9f9f7;
        border: 1.5px solid #eeeeec;
        border-radius: 10px;
        padding: 12px 14px;
        margin-top: 10px;
        flex-direction: column;
        gap: 0;
    }

    #bk-estimate.show {
        display: flex;
    }

    .bk-est-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 12px;
        color: #555;
        padding: 3px 0;
    }

    .bk-est-row.total {
        font-size: 13.5px;
        font-weight: 800;
        color: #111;
        border-top: 1px solid #e8e8e6;
        margin-top: 6px;
        padding-top: 8px;
    }

    /* Peringatan pembulatan */
    #bk-round-warn {
        display: none;
        align-items: flex-start;
        gap: 7px;
        font-size: 11px;
        color: #92400e;
        background: #fffbe6;
        border: 1px solid #f5e08a;
        border-radius: 8px;
        padding: 8px 11px;
        margin-top: 8px;
        line-height: 1.5;
    }

    #bk-round-warn.show {
        display: flex;
    }

    #bk-round-warn svg {
        width: 14px;
        height: 14px;
        flex-shrink: 0;
        margin-top: 1px;
    }

    .bk-file-input {
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

    .bk-file-input:focus {
        outline: none;
        border-color: #f5c518;
    }

    .bk-file-input::file-selector-button {
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

    .bk-file-input::file-selector-button:hover {
        background: #e4e4e2;
    }

    .bk-check-btn {
        width: 100%;
        padding: 11px;
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

    .bk-check-btn:hover:not(:disabled) {
        background: #111;
        color: #fff;
    }

    .bk-check-btn:disabled {
        opacity: 0.35;
        cursor: not-allowed;
    }

    .bk-avail {
        display: none;
        padding: 11px 14px;
        border-radius: 9px;
        font-size: 12.5px;
        font-weight: 500;
        margin-top: 10px;
        align-items: center;
        gap: 8px;
    }

    .bk-avail.show {
        display: flex;
    }

    .bk-avail.ok {
        background: #e8f7ee;
        color: #1d7a40;
        border: 1px solid #b8e8c8;
    }

    .bk-avail.err {
        background: #fff0f0;
        color: #c53030;
        border: 1px solid #fbb;
    }

    .bk-avail svg {
        width: 16px;
        height: 16px;
        flex-shrink: 0;
    }

    .bk-divider {
        border: none;
        border-top: 1px solid #f0f0ee;
        margin: 18px 0;
    }

    .bk-footer {
        display: flex;
        gap: 8px;
        padding: 16px 26px 22px;
        border-top: 1px solid #f0f0ee;
    }

    .bk-btn {
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

    .bk-btn-cancel {
        background: transparent;
        color: #888;
        border: 1.5px solid #e8e8e6;
        flex-shrink: 0;
    }

    .bk-btn-cancel:hover {
        background: #f5f5f3;
        color: #333;
    }

    .bk-btn-submit {
        flex: 1;
        background: #111;
        color: #fff;
    }

    .bk-btn-submit:hover:not(:disabled) {
        background: #333;
    }

    .bk-btn-submit:disabled {
        background: #d0d0ce;
        color: #aaa;
        cursor: not-allowed;
        pointer-events: none;
    }

    .bk-btn svg {
        width: 13px;
        height: 13px;
    }

    @keyframes bk-spin {
        to {
            transform: rotate(360deg);
        }
    }

    .bk-spin {
        width: 13px;
        height: 13px;
        border: 2px solid rgba(0, 0, 0, 0.15);
        border-top-color: #111;
        border-radius: 50%;
        animation: bk-spin 0.7s linear infinite;
        display: none;
    }

    .bk-spin.show {
        display: inline-block;
    }

    .bk-btn-submit .bk-spin {
        border-top-color: #fff;
        border-color: rgba(255, 255, 255, 0.2);
    }
</style>

<div id="bk-overlay" onclick="handleBkOverlay(event)">
    <div id="bk-modal" role="dialog" aria-modal="true" aria-labelledby="bk-title">

        {{-- Header --}}
        <div class="bk-header">
            <div>
                <div class="bk-badge">Pemesanan Sesi</div>
                <div class="bk-title" id="bk-title">Pilih Tanggal Sesi</div>
            </div>
            <button class="bk-close" onclick="closeBkModal()" aria-label="Tutup">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="bk-body">
            <form id="bk-form" method="POST" action="{{ route('booking.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="package_id" id="bk-pkg-id">

                {{-- Package summary --}}
                <div class="bk-pkg-row">
                    <div>
                        <div class="bk-pkg-name" id="bk-pkg-name">—</div>
                        <div class="bk-pkg-sub" id="bk-pkg-sub">Paket yang dipilih</div>
                    </div>
                    <div class="bk-pkg-price" id="bk-pkg-price">—</div>
                </div>

                {{-- Waktu Mulai & Selesai --}}
                <div class="bk-row-2 bk-group">
                    <div>
                        <label class="bk-label" for="bk-start">
                            Mulai <span class="req">*</span>
                        </label>
                        <input type="datetime-local" id="bk-start" name="start_date" class="bk-input"
                            onchange="onDateChange()">
                    </div>
                    <div>
                        <label class="bk-label" for="bk-end">
                            Selesai <span class="req">*</span>
                        </label>
                        <input type="datetime-local" id="bk-end" name="end_date" class="bk-input"
                            onchange="onDateChange()">
                    </div>
                </div>

                {{-- Estimasi harga (muncul otomatis setelah pilih waktu) --}}
                <div id="bk-estimate">
                    <div class="bk-est-row">
                        <span>Durasi aktual</span>
                        <span id="bk-est-actual">—</span>
                    </div>
                    <div class="bk-est-row">
                        <span>Ditagih</span>
                        <span id="bk-est-billed">—</span>
                    </div>
                    <div class="bk-est-row">
                        <span>Tarif</span>
                        <span id="bk-est-rate">—</span>
                    </div>
                    <div class="bk-est-row total">
                        <span>Estimasi Total</span>
                        <span id="bk-est-total">—</span>
                    </div>
                </div>

                {{-- Peringatan pembulatan --}}
                <div id="bk-round-warn">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
                    </svg>
                    <span id="bk-round-warn-text"></span>
                </div>

                {{-- Cek Ketersediaan --}}
                <div class="bk-group" style="margin-top:14px;">
                    <button type="button" id="bk-check-btn" class="bk-check-btn" onclick="checkAvailability()">
                        <div class="bk-spin" id="bk-spin"></div>
                        <svg id="bk-check-icon" width="15" height="15" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span id="bk-check-label">Cek Ketersediaan</span>
                    </button>

                    <div class="bk-avail" id="bk-avail">
                        <svg id="bk-avail-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            stroke-width="2.5"></svg>
                        <span id="bk-avail-msg"></span>
                    </div>
                </div>

                <hr class="bk-divider">

                {{-- Bukti Pembayaran --}}
                <div class="bk-group">
                    <label class="bk-label" for="bk-proof">Bukti Pembayaran</label>
                    <input type="file" id="bk-proof" name="payment_proof" class="bk-file-input"
                        accept="image/jpeg,image/png,image/webp,application/pdf">
                    <div style="font-size:10.5px;color:#bbb;margin-top:4px;">
                        JPG, PNG, WebP, atau PDF — maks 5 MB (opsional, bisa dikirim belakangan)
                    </div>
                </div>

                {{-- Catatan --}}
                <div class="bk-group">
                    <label class="bk-label" for="bk-notes">Catatan</label>
                    <textarea id="bk-notes" name="notes" class="bk-textarea" rows="2"
                        placeholder="Konsep, lokasi, atau permintaan khusus…" maxlength="500"></textarea>
                </div>

            </form>
        </div>

        {{-- Footer --}}
        <div class="bk-footer">
            <button type="button" class="bk-btn bk-btn-cancel" onclick="closeBkModal()">Batal</button>
            <button type="button" id="bk-submit-btn" class="bk-btn bk-btn-submit" onclick="submitBk()" disabled>
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
                <div class="bk-spin" id="bk-submit-spin"></div>
                <span id="bk-submit-label">Konfirmasi Pesanan</span>
            </button>
        </div>

    </div>
</div>

<script>
    let bkAvailable = false;
    let bkPricePerHour = 0;

    // ── Format Rupiah ───────────────────────────────
    function fmtRp(n) {
        return 'Rp ' + parseInt(n).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    // ── Open ────────────────────────────────────────
    function openBkModal(pkgId, pkgName, pkgPrice, pkgPriceRaw) {
        resetBk();

        bkPricePerHour = parseInt(pkgPriceRaw) || parseInt((pkgPrice || '').replace(/\D/g, '')) || 0;

        document.getElementById('bk-pkg-id').value = pkgId;
        document.getElementById('bk-pkg-name').textContent = pkgName;
        document.getElementById('bk-pkg-price').textContent = pkgPrice; // formatted
        document.getElementById('bk-pkg-sub').textContent = pkgPrice + '/jam';
        document.getElementById('bk-title').textContent = pkgName;
        document.getElementById('bk-est-rate').textContent = pkgPrice + '/jam';

        const now = new Date();
        now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
        const minVal = now.toISOString().slice(0, 16);
        document.getElementById('bk-start').min = minVal;
        document.getElementById('bk-end').min = minVal;

        document.getElementById('bk-overlay').classList.add('open');
        document.body.style.overflow = 'hidden';
        setTimeout(() => document.getElementById('bk-start').focus(), 260);
    }

    // ── Close ───────────────────────────────────────
    function closeBkModal() {
        document.getElementById('bk-overlay').classList.remove('open');
        document.body.style.overflow = '';
    }

    function handleBkOverlay(e) {
        if (e.target === document.getElementById('bk-overlay')) closeBkModal();
    }

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') closeBkModal();
    });

    // ── Reset ───────────────────────────────────────
    function resetBk() {
        document.getElementById('bk-form').reset();
        bkAvailable = false;
        document.getElementById('bk-submit-btn').disabled = true;
        document.getElementById('bk-check-label').textContent = 'Cek Ketersediaan';
        document.getElementById('bk-check-icon').style.display = '';
        document.getElementById('bk-avail').classList.remove('show', 'ok', 'err');
        document.getElementById('bk-estimate').classList.remove('show');
        document.getElementById('bk-round-warn').classList.remove('show');
        ['bk-start', 'bk-end'].forEach(id => document.getElementById(id).classList.remove('error'));
    }

    // ── Kalkulasi estimasi (live, tanpa fetch) ──────
    function calcEstimate() {
        const start = document.getElementById('bk-start').value;
        const end = document.getElementById('bk-end').value;
        const est = document.getElementById('bk-estimate');
        const warn = document.getElementById('bk-round-warn');

        if (!start || !end || end <= start) {
            est.classList.remove('show');
            warn.classList.remove('show');
            return;
        }

        const totalMins = Math.round((new Date(end) - new Date(start)) / 60000);
        const billedHrs = Math.ceil(totalMins / 60);
        const totalPrice = billedHrs * bkPricePerHour;

        const h = Math.floor(totalMins / 60);
        const m = totalMins % 60;
        const actualStr = h > 0 ?
            `${h} jam${m > 0 ? ` ${m} menit` : ''}` :
            `${m} menit`;

        document.getElementById('bk-est-actual').textContent = actualStr;
        document.getElementById('bk-est-billed').textContent = `${billedHrs} jam`;
        document.getElementById('bk-est-total').textContent = fmtRp(totalPrice);
        est.classList.add('show');

        // Peringatan kalau bukan bulat jam
        if (totalMins % 60 !== 0) {
            document.getElementById('bk-round-warn-text').textContent =
                `Durasi ${actualStr} dibulatkan ke atas menjadi ${billedHrs} jam. ` +
                `Harga tetap dihitung per jam penuh.`;
            warn.classList.add('show');
        } else {
            warn.classList.remove('show');
        }
    }

    // ── Saat datetime berubah ───────────────────────
    function onDateChange() {
        bkAvailable = false;
        document.getElementById('bk-submit-btn').disabled = true;
        document.getElementById('bk-avail').classList.remove('show', 'ok', 'err');
        document.getElementById('bk-check-label').textContent = 'Cek Ketersediaan';

        const start = document.getElementById('bk-start').value;
        if (start) {
            document.getElementById('bk-end').min = start;
            if (document.getElementById('bk-end').value &&
                document.getElementById('bk-end').value <= start) {
                document.getElementById('bk-end').value = '';
            }
        }

        calcEstimate();
    }

    // ── Check Availability ──────────────────────────
    async function checkAvailability() {
        const pkgId = document.getElementById('bk-pkg-id').value;
        const start = document.getElementById('bk-start').value;
        const end = document.getElementById('bk-end').value;

        let valid = true;
        ['bk-start', 'bk-end'].forEach(id => {
            const el = document.getElementById(id);
            if (!el.value) {
                el.classList.add('error');
                valid = false;
            } else el.classList.remove('error');
        });
        if (!valid) return;

        if (end <= start) {
            setAvailResult(false, 'Waktu selesai harus setelah waktu mulai.');
            return;
        }

        const btn = document.getElementById('bk-check-btn');
        const spin = document.getElementById('bk-spin');
        const icon = document.getElementById('bk-check-icon');
        const label = document.getElementById('bk-check-label');

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
                    package_id: pkgId,
                    start_date: start.replace('T', ' ') + ':00',
                    end_date: end.replace('T', ' ') + ':00',
                }),
            });

            const data = await res.json();
            setAvailResult(data.available, data.message);
            bkAvailable = data.available;
            document.getElementById('bk-submit-btn').disabled = !data.available;

        } catch {
            setAvailResult(false, 'Gagal terhubung ke server. Coba lagi.');
        } finally {
            btn.disabled = false;
            spin.classList.remove('show');
            icon.style.display = '';
            label.textContent = 'Cek Ulang';
        }
    }

    function setAvailResult(ok, msg) {
        const el = document.getElementById('bk-avail');
        const icon = document.getElementById('bk-avail-icon');
        const text = document.getElementById('bk-avail-msg');

        el.classList.remove('show', 'ok', 'err');
        el.classList.add('show', ok ? 'ok' : 'err');
        text.textContent = msg;

        icon.innerHTML = ok ?
            '<path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>' :
            '<path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>';
    }

    // ── Submit ──────────────────────────────────────
    function submitBk() {
        if (!bkAvailable) return;

        const fileInput = document.getElementById('bk-proof');
        if (fileInput.files[0] && fileInput.files[0].size > 5 * 1024 * 1024) {
            alert('Ukuran file bukti pembayaran maksimal 5 MB.');
            return;
        }

        const btn = document.getElementById('bk-submit-btn');
        const spin = document.getElementById('bk-submit-spin');
        const label = document.getElementById('bk-submit-label');

        btn.disabled = true;
        spin.classList.add('show');
        label.textContent = 'Memproses…';

        document.getElementById('bk-form').submit();
    }

    window.openBkModal = openBkModal;
    window.closeBkModal = closeBkModal;
</script>
