@php
    /*
    admin/bookings/modal.blade.php
    @include('admin.bookings.modal')
    Trigger: openBkUpdateModal(id, clientName, packageName, currentStatus, notes, driveLink, paymentProofUrl)
*/
@endphp

<style>
    #adm-bk-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(3px);
        z-index: 10000;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.2s ease;
    }

    #adm-bk-overlay.open {
        opacity: 1;
        pointer-events: all;
    }

    #adm-bk-modal {
        background: #fff;
        border-radius: 16px;
        width: 100%;
        max-width: 500px;
        max-height: 92vh;
        overflow-y: auto;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
        transform: translateY(14px) scale(0.98);
        transition: transform 0.22s cubic-bezier(0.34, 1.56, 0.64, 1);
        scrollbar-width: thin;
    }

    #adm-bk-overlay.open #adm-bk-modal {
        transform: translateY(0) scale(1);
    }

    /* Header */
    .abm-header {
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

    .abm-badge {
        font-size: 9px;
        font-weight: 700;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: #c89a00;
        background: #fffbe6;
        border: 1px solid #f5e08a;
        padding: 3px 9px;
        border-radius: 20px;
        display: inline-block;
        margin-bottom: 5px;
    }

    .abm-title {
        font-size: 17px;
        font-weight: 800;
        color: #111;
        letter-spacing: -0.02em;
    }

    .abm-close {
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

    .abm-close:hover {
        background: #f5f5f3;
        color: #333;
    }

    .abm-close svg {
        width: 12px;
        height: 12px;
    }

    /* Body */
    .abm-body {
        padding: 20px 24px;
    }

    .abm-group {
        margin-bottom: 16px;
    }

    .abm-group:last-child {
        margin-bottom: 0;
    }

    /* Info boxes */
    .abm-info-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        margin-bottom: 18px;
    }

    .abm-info-box {
        background: #f9f9f7;
        border: 1.5px solid #eeeeec;
        border-radius: 9px;
        padding: 10px 13px;
    }

    .abm-info-label {
        font-size: 9px;
        font-weight: 700;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: #bbb;
        margin-bottom: 3px;
    }

    .abm-info-value {
        font-size: 13px;
        font-weight: 600;
        color: #111;
    }

    /* Proof box */
    .abm-proof-box {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #f9f9f7;
        border: 1.5px solid #eeeeec;
        border-radius: 9px;
        padding: 10px 13px;
        margin-bottom: 18px;
    }

    .abm-proof-none {
        font-size: 12px;
        color: #bbb;
        font-style: italic;
    }

    .abm-proof-link {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 12px;
        font-weight: 600;
        color: #c89a00;
        text-decoration: none;
        background: #fffbe6;
        border: 1px solid #f5e08a;
        padding: 5px 12px;
        border-radius: 7px;
        transition: background 0.12s;
    }

    .abm-proof-link:hover {
        background: #fef3c7;
    }

    .abm-proof-link svg {
        width: 12px;
        height: 12px;
    }

    /* Form inputs */
    .abm-label {
        display: block;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.11em;
        text-transform: uppercase;
        color: #999;
        margin-bottom: 5px;
    }

    .abm-input,
    .abm-textarea {
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

    .abm-input:focus,
    .abm-textarea:focus {
        outline: none;
        border-color: #f5c518;
        box-shadow: 0 0 0 3px rgba(245, 197, 24, 0.12);
        background: #fff;
    }

    .abm-textarea {
        resize: vertical;
        min-height: 68px;
        line-height: 1.6;
    }

    /* Drive link input wrapper */
    .abm-drive-wrap {
        position: relative;
    }

    .abm-drive-icon {
        position: absolute;
        left: 11px;
        top: 50%;
        transform: translateY(-50%);
        width: 15px;
        height: 15px;
        color: #aaa;
        pointer-events: none;
    }

    .abm-drive-wrap .abm-input {
        padding-left: 34px;
    }

    .abm-drive-open {
        position: absolute;
        right: 9px;
        top: 50%;
        transform: translateY(-50%);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 26px;
        height: 26px;
        border-radius: 6px;
        border: 1px solid #e8e8e6;
        background: #fff;
        color: #888;
        cursor: pointer;
        transition: all 0.12s;
        text-decoration: none;
    }

    .abm-drive-open:hover {
        background: #f5f5f3;
        color: #333;
        border-color: #ccc;
    }

    .abm-drive-open svg {
        width: 12px;
        height: 12px;
    }

    .abm-drive-wrap .abm-input {
        padding-right: 40px;
    }

    /* Status chips */
    .abm-chips {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
        margin-top: 8px;
    }

    .abm-chip {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 10.5px;
        font-weight: 700;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        border: 1.5px solid #e8e8e6;
        cursor: pointer;
        transition: all 0.13s;
        background: #fff;
        color: #888;
    }

    .abm-chip:hover {
        border-color: #999;
        color: #333;
    }

    /* Chip colors per status */
    .abm-chip.sel-pending {
        background: #f0f0ee;
        color: #555;
        border-color: #ddd;
    }

    .abm-chip.sel-confirmed {
        background: #fef3c7;
        color: #92400e;
        border-color: #fde68a;
    }

    .abm-chip.sel-completed {
        background: #dbeafe;
        color: #1e40af;
        border-color: #93c5fd;
    }

    .abm-chip.sel-editing {
        background: #ede9fe;
        color: #5b21b6;
        border-color: #c4b5fd;
    }

    .abm-chip.sel-done {
        background: #111;
        color: #fff;
        border-color: #111;
    }

    .abm-chip.sel-rejected {
        background: #fee2e2;
        color: #b91c1c;
        border-color: #fca5a5;
    }

    /* Divider */
    .abm-divider {
        border: none;
        border-top: 1px solid #f0f0ee;
        margin: 16px 0;
    }

    /* Footer */
    .abm-footer {
        display: flex;
        gap: 8px;
        padding: 14px 24px 20px;
        border-top: 1px solid #f0f0ee;
    }

    .abm-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 9px 18px;
        border-radius: 9px;
        font-size: 12.5px;
        font-weight: 700;
        cursor: pointer;
        border: none;
        font-family: inherit;
        transition: all 0.13s;
    }

    .abm-btn-cancel {
        background: transparent;
        color: #888;
        border: 1.5px solid #e8e8e6;
    }

    .abm-btn-cancel:hover {
        background: #f5f5f3;
        color: #333;
    }

    .abm-btn-save {
        flex: 1;
        justify-content: center;
        background: #111;
        color: #fff;
    }

    .abm-btn-save:hover:not(:disabled) {
        background: #333;
    }

    .abm-btn-save:disabled {
        background: #ccc;
        cursor: not-allowed;
        pointer-events: none;
    }

    .abm-btn svg {
        width: 13px;
        height: 13px;
    }
</style>

<div id="adm-bk-overlay" onclick="handleAdmBkOverlay(event)">
    <div id="adm-bk-modal" role="dialog" aria-modal="true">

        {{-- Header --}}
        <div class="abm-header">
            <div>
                <div class="abm-badge">Update Pesanan</div>
                <div class="abm-title" id="abm-title">Detail Pesanan</div>
            </div>
            <button class="abm-close" onclick="closeAdmBkModal()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="abm-body">
            <form id="abm-form" method="POST" action="">
                @csrf @method('PUT')

                {{-- Info klien & paket --}}
                <div class="abm-info-row">
                    <div class="abm-info-box">
                        <div class="abm-info-label">Klien</div>
                        <div class="abm-info-value" id="abm-client">—</div>
                    </div>
                    <div class="abm-info-box">
                        <div class="abm-info-label">Paket</div>
                        <div class="abm-info-value" id="abm-package">—</div>
                    </div>
                </div>

                {{-- Bukti pembayaran --}}
                <div class="abm-group">
                    <label class="abm-label">Bukti Pembayaran</label>
                    <div class="abm-proof-box">
                        <div
                            style="font-size:9.5px;color:#aaa;font-weight:600;text-transform:uppercase;letter-spacing:0.1em;">
                            File Upload
                        </div>
                        <div id="abm-proof-slot">
                            <span class="abm-proof-none">Tidak ada bukti</span>
                        </div>
                    </div>
                </div>

                <hr class="abm-divider">

                {{-- Status chips --}}
                <div class="abm-group">
                    <label class="abm-label">Status Pesanan</label>
                    <div class="abm-chips">
                        @foreach ([
        'pending' => 'Menunggu',
        'confirmed' => 'Dikonfirmasi',
        'completed' => 'Terlaksana',
        'editing' => 'Editing',
        'done' => 'Selesai',
        'rejected' => 'Ditolak',
    ] as $val => $label)
                            <button type="button" class="abm-chip" id="chip-{{ $val }}"
                                onclick="selectAbmStatus('{{ $val }}')">
                                {{ $label }}
                            </button>
                        @endforeach
                    </div>
                    <input type="hidden" name="status" id="abm-status-input">
                </div>

                {{-- Link Google Drive --}}
                <div class="abm-group">
                    <label class="abm-label" for="abm-drive">Link Google Drive</label>
                    <div class="abm-drive-wrap">
                        <svg class="abm-drive-icon" viewBox="0 0 87.3 78" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M6.6 66.85l3.85 6.65c.8 1.4 1.95 2.5 3.3 3.3L27.5 53.5H0c0 1.55.4 3.1 1.2 4.5l5.4 8.85z"
                                fill="#aaa" />
                            <path
                                d="M43.65 25L29.9 1.2C28.55.4 27 0 25.45 0c-1.55 0-3.1.4-4.5 1.2L3.65 31.25 0 37.6c-.8 1.4-1.2 2.95-1.2 4.5H27.5l16.15-17.1z"
                                fill="#aaa" />
                            <path
                                d="M73.55 76.8c1.35-.8 2.5-1.9 3.3-3.3l1.6-2.75 7.65-13.2c.8-1.4 1.2-2.95 1.2-4.5H59.8l5.65 9.5 8.1 14.25z"
                                fill="#aaa" />
                            <path d="M43.65 25L57.4 1.2C56 .4 54.45 0 52.9 0H34.4c-1.55 0-3.1.4-4.5 1.2L43.65 25z"
                                fill="#aaa" />
                            <path
                                d="M59.8 53.5H27.5L13.75 76.8c1.4.8 2.95 1.2 4.5 1.2h50.8c1.55 0 3.1-.4 4.5-1.2L59.8 53.5z"
                                fill="#aaa" />
                            <path
                                d="M73.4 26.15l-16.2-14.9c-1.35-.8-2.9-1.25-4.5-1.25h-18.1L43.65 25l15.95 28.5h27.5c0-1.55-.4-3.1-1.2-4.5L73.4 26.15z"
                                fill="#aaa" />
                        </svg>
                        <input type="url" id="abm-drive" name="drive_link" class="abm-input"
                            placeholder="https://drive.google.com/..." oninput="updateDriveOpenBtn()">
                        <a href="#" id="abm-drive-open-btn" target="_blank" class="abm-drive-open"
                            title="Buka di tab baru" style="display:none;">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4
                                         M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                        </a>
                    </div>
                    <div style="font-size:10.5px;color:#bbb;margin-top:4px;">
                        Opsional — link folder atau file hasil foto di Google Drive
                    </div>
                </div>

                {{-- Catatan admin --}}
                <div class="abm-group">
                    <label class="abm-label" for="abm-notes">Catatan Admin</label>
                    <textarea id="abm-notes" name="notes" class="abm-textarea" rows="2" maxlength="500"
                        placeholder="Catatan untuk klien atau internal…"></textarea>
                </div>

            </form>
        </div>

        {{-- Footer --}}
        <div class="abm-footer">
            <button type="button" class="abm-btn abm-btn-cancel" onclick="closeAdmBkModal()">
                Batal
            </button>
            <button type="button" id="abm-save-btn" class="abm-btn abm-btn-save" onclick="submitAdmBkForm()" disabled>
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
                <span id="abm-save-label">Simpan Perubahan</span>
            </button>
        </div>

    </div>
</div>

<script>
    let admBkCurrentStatus = '';

    function openBkUpdateModal(id, clientName, packageName, currentStatus, notes, driveLink, paymentProofUrl) {
        // Reset
        document.querySelectorAll('.abm-chip').forEach(c => c.className = 'abm-chip');
        document.getElementById('abm-save-btn').disabled = true;
        admBkCurrentStatus = currentStatus;

        // Set form action
        document.getElementById('abm-form').action = '/admin/bookings/' + id;

        // Set info
        document.getElementById('abm-title').textContent = '#ORD-' + String(id).padStart(4, '0');
        document.getElementById('abm-client').textContent = clientName;
        document.getElementById('abm-package').textContent = packageName;
        document.getElementById('abm-notes').value = notes || '';

        // Bukti pembayaran
        const proofSlot = document.getElementById('abm-proof-slot');
        if (paymentProofUrl) {
            proofSlot.innerHTML = `
            <a href="${paymentProofUrl}" target="_blank" class="abm-proof-link">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943
                             9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                Lihat Bukti
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="width:10px;height:10px;">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
            </a>`;
        } else {
            proofSlot.innerHTML = '<span class="abm-proof-none">Tidak ada bukti</span>';
        }

        // Drive link
        const driveInput = document.getElementById('abm-drive');
        driveInput.value = driveLink || '';
        updateDriveOpenBtn();

        // Set status chip
        selectAbmStatus(currentStatus, false);

        document.getElementById('adm-bk-overlay').classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closeAdmBkModal() {
        document.getElementById('adm-bk-overlay').classList.remove('open');
        document.body.style.overflow = '';
    }

    function handleAdmBkOverlay(e) {
        if (e.target === document.getElementById('adm-bk-overlay')) closeAdmBkModal();
    }

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') closeAdmBkModal();
    });

    function selectAbmStatus(status, enableSave = true) {
        document.querySelectorAll('.abm-chip').forEach(c => c.className = 'abm-chip');
        const chip = document.getElementById('chip-' + status);
        if (chip) chip.className = 'abm-chip sel-' + status;
        document.getElementById('abm-status-input').value = status;

        if (enableSave) {
            document.getElementById('abm-save-btn').disabled = (status === admBkCurrentStatus);
        } else {
            document.getElementById('abm-save-btn').disabled = true;
        }
    }

    // Aktifkan tombol save juga saat drive_link berubah
    document.getElementById('abm-drive').addEventListener('input', () => {
        const currentStatus = document.getElementById('abm-status-input').value;
        if (currentStatus) {
            document.getElementById('abm-save-btn').disabled = false;
        }
    });

    function updateDriveOpenBtn() {
        const val = document.getElementById('abm-drive').value.trim();
        const btn = document.getElementById('abm-drive-open-btn');
        if (val && val.startsWith('http')) {
            btn.href = val;
            btn.style.display = 'inline-flex';
        } else {
            btn.style.display = 'none';
        }
    }

    function submitAdmBkForm() {
        const btn = document.getElementById('abm-save-btn');
        const label = document.getElementById('abm-submit-label') || document.getElementById('abm-save-label');
        btn.disabled = true;
        label.textContent = 'Menyimpan…';
        document.getElementById('abm-form').submit();
    }

    window.openBkUpdateModal = openBkUpdateModal;
    window.closeAdmBkModal = closeAdmBkModal;
</script>
