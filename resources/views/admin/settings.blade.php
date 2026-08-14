@extends('layouts.admin')

@section('title', 'Pengaturan')

@section('content')
<style>
    /* ===== HEADER ===== */
    .settings-header h1 {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700;
        color: #0B0F19;
        font-size: 1.4rem;
        margin: 0;
    }
    .settings-header .subtitle {
        font-size: 0.85rem;
        color: #6B7280;
    }
    
    /* ===== CARD ===== */
    .settings-card {
        background: #FFFFFF;
        border: 1px solid #EEF0F4;
        border-radius: 16px;
        padding: 22px 24px;
        transition: all 0.25s ease;
        height: 100%;
    }
    .settings-card:hover {
        border-color: #D1D5DB;
    }
    
    .settings-card .card-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 600;
        font-size: 0.85rem;
        color: #111827;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        letter-spacing: -0.01em;
    }
    .settings-card .card-title .title-left {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .settings-card .card-title i {
        color: #6366F1;
        font-size: 1rem;
        width: 20px;
        text-align: center;
    }
    
    .btn-edit {
        background: transparent;
        border: 1px solid #E5E7EB;
        border-radius: 8px;
        padding: 4px 12px;
        font-size: 0.7rem;
        font-weight: 500;
        color: #6B7280;
        transition: all 0.2s;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .btn-edit:hover {
        background: #F3F4FF;
        border-color: #6366F1;
        color: #6366F1;
    }
    
    /* ===== DISPLAY DATA ===== */
    .data-row {
        display: flex;
        padding: 8px 0;
        border-bottom: 1px solid #F5F6F8;
    }
    .data-row:last-child {
        border-bottom: none;
    }
    .data-row .label {
        width: 120px;
        font-size: 0.75rem;
        color: #6B7280;
        font-weight: 500;
        flex-shrink: 0;
    }
    .data-row .value {
        font-size: 0.82rem;
        color: #111827;
        font-weight: 500;
        word-break: break-all;
    }
    .data-row .value code {
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.7rem;
        background: #F3F4FF;
        color: #6366F1;
        padding: 2px 8px;
        border-radius: 4px;
    }
    .data-row .value.text-muted {
        color: #9CA3AF;
        font-weight: 400;
    }
    
    /* ===== FORM DALAM MODAL ===== */
    .form-group-modal {
        margin-bottom: 14px;
    }
    .form-group-modal:last-of-type {
        margin-bottom: 0;
    }
    .form-label-modal {
        display: block;
        font-size: 0.78rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 4px;
    }
    .form-control-modal {
        width: 100%;
        padding: 8px 12px;
        font-size: 0.82rem;
        border: 1px solid #E5E7EB;
        border-radius: 10px;
        background: #F9FAFB;
        transition: all 0.2s ease;
        color: #111827;
    }
    .form-control-modal:focus {
        border-color: #6366F1;
        background: #FFFFFF;
        outline: none;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.10);
    }
    textarea.form-control-modal {
        resize: vertical;
        min-height: 60px;
        font-family: 'Inter', sans-serif;
    }
    
    /* ===== BUTTONS ===== */
    .btn-custom {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 8px 18px;
        font-size: 0.78rem;
        font-weight: 600;
        border: none;
        border-radius: 10px;
        transition: all 0.2s ease;
        cursor: pointer;
        text-decoration: none;
        min-height: 38px;
        font-family: 'Inter', sans-serif;
    }
    .btn-custom-primary {
        background: #6366F1;
        color: #FFFFFF;
    }
    .btn-custom-primary:hover {
        background: #4F46E5;
        transform: translateY(-1px);
        box-shadow: 0 4px 14px rgba(99, 102, 241, 0.25);
    }
    .btn-custom-success {
        background: #10B981;
        color: #FFFFFF;
    }
    .btn-custom-success:hover {
        background: #059669;
        transform: translateY(-1px);
        box-shadow: 0 4px 14px rgba(16, 185, 129, 0.25);
    }
    .btn-custom-warning {
        background: #F59E0B;
        color: #FFFFFF;
    }
    .btn-custom-warning:hover {
        background: #D97706;
        transform: translateY(-1px);
        box-shadow: 0 4px 14px rgba(245, 158, 11, 0.25);
    }
    .btn-custom-danger {
        background: #EF4444;
        color: #FFFFFF;
    }
    .btn-custom-danger:hover {
        background: #DC2626;
        transform: translateY(-1px);
        box-shadow: 0 4px 14px rgba(239, 68, 68, 0.25);
    }
    .btn-custom-outline {
        background: transparent;
        color: #6366F1;
        border: 1px solid #E5E7EB;
    }
    .btn-custom-outline:hover {
        background: #F3F4FF;
        border-color: #6366F1;
    }
    .btn-custom-sm {
        padding: 5px 10px;
        font-size: 0.7rem;
        min-height: 32px;
        min-width: 32px;
        border-radius: 8px;
    }
    .btn-custom-block {
        width: 100%;
    }
    
    /* ===== DIVIDER ===== */
    .divider-light {
        border: none;
        border-top: 1px solid #F0F2F5;
        margin: 14px 0;
    }
    
    /* ===== DEVICE STATUS ===== */
    .device-status-box {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 14px;
        background: #F9FAFB;
        border-radius: 12px;
        border: 1px solid #F0F2F5;
        font-size: 0.8rem;
    }
    .device-status-box .dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
        flex-shrink: 0;
    }
    .device-status-box .dot.online {
        background: #10B981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.20);
    }
    .device-status-box .dot.offline {
        background: #EF4444;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.20);
    }
    .device-status-box .status-label {
        font-weight: 500;
        color: #111827;
    }
    .device-status-box .status-meta {
        margin-left: auto;
        color: #6B7280;
        font-size: 0.75rem;
    }
    
    /* ===== BADGE MINI ===== */
    .badge-mini {
        display: inline-block;
        padding: 2px 10px;
        border-radius: 100px;
        font-size: 0.6rem;
        font-weight: 600;
    }
    .badge-mini-success {
        background: #D1FAE5;
        color: #059669;
    }
    .badge-mini-danger {
        background: #FEE2E2;
        color: #DC2626;
    }
    
    /* ===== TABLE PERANGKAT ===== */
    .table-device {
        font-size: 0.75rem;
        margin: 0;
    }
    .table-device thead th {
        font-size: 0.6rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #6B7280;
        font-weight: 600;
        padding: 6px 0 4px 0;
        border-bottom: 1px solid #F0F2F5;
        background: transparent;
    }
    .table-device tbody td {
        padding: 6px 0;
        border-bottom: 1px solid #F5F6F8;
        color: #1F2937;
        vertical-align: middle;
    }
    .table-device tbody tr:last-child td {
        border-bottom: none;
    }
    .table-device code {
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.65rem;
        background: #F3F4FF;
        color: #6366F1;
        padding: 2px 6px;
        border-radius: 4px;
    }
    
    /* ===== INFO BOX ===== */
    .info-box {
        background: linear-gradient(135deg, #FEF3C7 0%, #FFFFFF 100%);
        border: 1px solid #FCD34D;
        border-radius: 12px;
        padding: 20px 24px;
        margin-top: 24px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .info-box ul {
        margin: 0;
        padding-left: 20px;
        font-size: 0.85rem;
        color: #92400E;
        list-style: disc;
    }
    .info-box ul li + li {
        margin-top: 8px;
    }
    .info-box ul li strong {
        color: #B45309;
    }
    
    /* ===== TABLE MODERN ===== */
    .table-modern {
        background: #FFFFFF;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #E6E8EC;
    }
    .table-modern thead {
        background: linear-gradient(135deg, #F3F4FF 0%, #FFFFFF 100%);
        border-bottom: 2px solid #E6E8EC;
    }
    .table-modern thead th {
        padding: 14px 20px;
        font-size: 0.75rem;
        font-weight: 700;
        color: #6B7280;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .table-modern tbody td {
        padding: 16px 20px;
        font-size: 0.85rem;
        color: #0B0F19;
        border-bottom: 1px solid #F0F2F5;
        vertical-align: middle;
    }
    .table-modern tbody tr:last-child td {
        border-bottom: none;
    }
    .table-modern tbody tr:hover {
        background: #F9FAFB;
    }
    .table-modern code {
        background: #F3F4FF;
        color: #6366F1;
        padding: 4px 10px;
        border-radius: 6px;
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.8rem;
    }
    
    /* ===== MODAL ===== */
    .modal-custom .modal-content {
        border: 1px solid #EEF0F4;
        border-radius: 16px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.12);
    }
    .modal-custom .modal-header {
        border-bottom: 1px solid #F0F2F5;
        padding: 18px 24px;
    }
    .modal-custom .modal-header .modal-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700;
        font-size: 1.05rem;
        color: #0B0F19;
    }
    .modal-custom .modal-body {
        padding: 22px 24px;
    }
    .modal-custom .modal-footer {
        border-top: 1px solid #F0F2F5;
        padding: 14px 24px;
    }
    
    /* ===== CONTAINER ===== */
    .settings-container {
        max-width: 1200px;
        margin: 0 auto;
    }
    
    @media (max-width: 768px) {
        .settings-card {
            padding: 16px;
        }
        .settings-header h1 {
            font-size: 1.1rem;
        }
        .settings-header .subtitle {
            font-size: 0.7rem;
        }
        .device-status-box {
            flex-wrap: wrap;
        }
        .device-status-box .status-meta {
            margin-left: 0;
            width: 100%;
        }
        .data-row {
            flex-direction: column;
            padding: 6px 0;
        }
        .data-row .label {
            width: 100%;
            font-size: 0.7rem;
        }
        .data-row .value {
            font-size: 0.78rem;
        }
    }
</style>

<!-- ============================================================ -->
<!-- HEADER                                                        -->
<!-- ============================================================ -->
<div class="settings-container">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 settings-header">
        <div>
            <h1>⚙️ Pengaturan</h1>
            <span class="subtitle">Kelola konfigurasi aplikasi dan integrasi perangkat</span>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- API CONFIG TABLE (FULL WIDTH - TOP)                          -->
    <!-- ============================================================ -->
    <div class="settings-card mb-4">
        <div class="card-title">
            <span class="title-left">
                <i class="fas fa-plug"></i> Konfigurasi Fingerspot API
            </span>
            <button class="btn-edit" data-bs-toggle="modal" data-bs-target="#modalApi">
                <i class="fas fa-pen"></i> Ubah
            </button>
        </div>

        <div style="overflow-x: auto;">
            <table class="table-modern" style="width:100%;">
                <thead>
                    <tr>
                        <th style="width: 25%;">Parameter</th>
                        <th>Nilai</th>
                        <th style="width: 15%; text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>API URL</strong></td>
                        <td><code>{{ $settings['api_url'] }}</code></td>
                        <td style="text-align: right;">
                            <button class="btn-custom btn-custom-sm btn-custom-outline" onclick="navigator.clipboard.writeText('{{ $settings['api_url'] }}')">
                                <i class="fas fa-copy"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>API Key</strong></td>
                        <td><code>{{ str_repeat('•', 16) }}</code></td>
                        <td style="text-align: right;">
                            <button class="btn-custom btn-custom-sm btn-custom-outline" onclick="navigator.clipboard.writeText('{{ $settings['api_key'] }}')">
                                <i class="fas fa-copy"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Webhook URL</strong></td>
                        <td><code>{{ $settings['webhook_url'] }}</code></td>
                        <td style="text-align: right;">
                            <button class="btn-custom btn-custom-sm btn-custom-outline" onclick="navigator.clipboard.writeText('{{ $settings['webhook_url'] }}')">
                                <i class="fas fa-copy"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- DEVICE CONTROL PANEL                                          -->
    <!-- ============================================================ -->
    <div class="settings-card mb-4">
        <div class="card-title">
            <span class="title-left">
                <i class="fas fa-cog"></i> Kontrol Mesin Absensi
            </span>
        </div>

        <div class="row g-3 align-items-end">
            {{-- Ambil Semua PIN --}}
            <div class="col-md-3">
                <label style="font-size: 0.8rem; font-weight: 600; margin-bottom: 4px; color: #374151;">Sinkronisasi Data</label>
                <button type="button" class="btn-custom btn-custom-primary w-100" onclick="getAllPin(this)">
                    <i class="fas fa-key"></i> Ambil Semua PIN
                </button>
                <small class="text-muted" style="font-size: 0.7rem;">Download data user dari mesin</small>
            </div>

            {{-- Get Userinfo --}}
            <div class="col-md-3">
                <label style="font-size: 0.8rem; font-weight: 600; margin-bottom: 4px; color: #374151;">Ambil Data User</label>
                <button type="button" class="btn-custom btn-custom-success w-100" onclick="getUserinfo(this)">
                    <i class="fas fa-users"></i> Get Userinfo
                </button>
                <small class="text-muted" style="font-size: 0.7rem;">Download data user lengkap</small>
            </div>

            {{-- Set Time --}}
            <div class="col-md-3">
                <label style="font-size: 0.8rem; font-weight: 600; margin-bottom: 4px; color: #374151;">Atur Waktu</label>
                <div class="d-flex gap-2">
                    <input type="datetime-local" id="timezoneInput" class="form-control" style="font-size: 0.8rem; border: 1px solid #E5E7EB; border-radius: 8px; padding: 8px 12px;" value="{{ date('Y-m-d\TH:i') }}">
                    <button type="button" class="btn-custom btn-custom-warning" onclick="setTime(this)" title="Set Waktu Mesin">
                        <i class="fas fa-clock"></i>
                    </button>
                </div>
                <small class="text-muted" style="font-size: 0.7rem;">Sinkronisasi waktu mesin</small>
            </div>

            {{-- Restart Mesin --}}
            <div class="col-md-3">
                <label style="font-size: 0.8rem; font-weight: 600; margin-bottom: 4px; color: #374151;">Restart</label>
                <button type="button" class="btn-custom btn-custom-danger w-100" onclick="restartMesin(this)">
                    <i class="fas fa-power-off"></i> Restart Mesin
                </button>
                <small class="text-muted" style="font-size: 0.7rem;">⚠️ Mesin akan restart otomatis</small>
            </div>
        </div>

        <hr class="my-3" style="border-color: #E6E8EC;">

        <h6 style="font-size: 0.75rem; font-weight: 600; color: #6B7280; margin-bottom: 12px; text-transform: uppercase; letter-spacing: 0.05em;">
            <i class="fas fa-user-plus me-1"></i> Register User Online
        </h6>

        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label style="font-size: 0.8rem; font-weight: 600; margin-bottom: 4px; color: #374151;">PIN *</label>
                <input type="text" id="registerPin" class="form-control" style="font-size: 0.8rem; border: 1px solid #E5E7EB; border-radius: 8px; padding: 8px 12px;" placeholder="Contoh: 1" required>
            </div>
            <div class="col-md-3">
                <label style="font-size: 0.8rem; font-weight: 600; margin-bottom: 4px; color: #374151;">Jari (1-10) *</label>
                <input type="text" id="registerVerification" class="form-control" style="font-size: 0.8rem; border: 1px solid #E5E7EB; border-radius: 8px; padding: 8px 12px;" placeholder="1-10" required>
            </div>
            <div class="col-md-4">
                <label style="font-size: 0.8rem; font-weight: 600; margin-bottom: 4px; color: #374151;">Mesin *</label>
                <select id="registerDevice" class="form-control" style="font-size: 0.8rem; border: 1px solid #E5E7EB; border-radius: 8px; padding: 8px 12px;" required>
                    <option value="">-- Pilih Mesin --</option>
                    @php
                        $devices = App\Models\Pin::where('is_active', true)->get();
                    @endphp
                    @foreach($devices as $device)
                        <option value="{{ $device->pin }}">{{ $device->device_name }} ({{ $device->pin }})</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label style="font-size: 0.8rem; font-weight: 600; margin-bottom: 4px; color: #374151;">&nbsp;</label>
                <button type="button" class="btn-custom btn-custom-success w-100" onclick="registerOnline(this)">
                    <i class="fas fa-user-plus"></i> Register
                </button>
            </div>
        </div>
        <small class="text-muted" style="font-size: 0.7rem;">Registrasi user langsung ke mesin absensi</small>
    </div>

</div>

<!-- ============================================================ -->
<!-- MODAL - UBAH KONFIGURASI FINGERSPOT API                           -->
<!-- ============================================================ -->
<div class="modal fade modal-custom" id="modalApi" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('settings.update') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">✏️ Ubah Konfigurasi Fingerspot API</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group-modal">
                        <label class="form-label-modal">API URL</label>
                        <input type="url" name="api_url" class="form-control-modal" value="{{ $settings['api_url'] }}">
                    </div>
                    <div class="form-group-modal">
                        <label class="form-label-modal">API Key</label>
                        <input type="text" name="api_key" class="form-control-modal" value="{{ $settings['api_key'] }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-custom btn-custom-outline" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-custom btn-custom-primary">
                        <i class="fas fa-save"></i> Simpan API
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ============================================================ -->
<!-- SCRIPT AJAX                                                   -->
<!-- ============================================================ -->
<script>
// ============================================
// DEVICE CONTROL FUNCTIONS
// ============================================

// 1. Get All PIN
function getAllPin(btn) {
    const deviceId = prompt('Masukkan Cloud ID mesin:');
    
    if (!deviceId) {
        showToast('❌ Cloud ID mesin wajib diisi', 'error');
        return;
    }
    
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Loading...';
    
    fetch('{{ route("command.get-all-pin") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        body: JSON.stringify({ device: deviceId })
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            showToast('✅ ' + result.message, 'success');
        } else {
            showToast('❌ ' + result.message, 'error');
        }
    })
    .catch(() => {
        showToast('❌ Gagal terhubung ke server', 'error');
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-key"></i> Ambil Semua PIN';
    });
}

// 2. Get Userinfo
function getUserinfo(btn) {
    const deviceId = prompt('Masukkan Cloud ID mesin:');
    
    if (!deviceId) {
        showToast('❌ Cloud ID mesin wajib diisi', 'error');
        return;
    }
    
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Loading...';
    
    fetch('{{ route("command.get-userinfo") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        body: JSON.stringify({ device: deviceId, pin: 'all' })
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            showToast('✅ ' + result.message, 'success');
        } else {
            showToast('❌ ' + result.message, 'error');
        }
    })
    .catch(() => {
        showToast('❌ Gagal terhubung ke server', 'error');
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-users"></i> Get Userinfo';
    });
}

// 3. Set Time
function setTime(btn) {
    const deviceId = prompt('Masukkan Cloud ID mesin:');
    
    if (!deviceId) {
        showToast('❌ Cloud ID mesin wajib diisi', 'error');
        return;
    }
    
    const input = document.getElementById('timezoneInput');
    const timezone = input.value;
    
    if (!timezone) {
        showToast('⚠️ Pilih waktu terlebih dahulu!', 'warning');
        return;
    }
    
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
    
    fetch('{{ route("command.set-time") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        body: JSON.stringify({ device: deviceId, timezone: timezone })
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            showToast('✅ ' + result.message, 'success');
        } else {
            showToast('❌ ' + result.message, 'error');
        }
    })
    .catch(() => {
        showToast('❌ Gagal terhubung ke server', 'error');
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-clock"></i>';
    });
}

// 4. Restart Mesin
function restartMesin(btn) {
    const deviceId = prompt('Masukkan Cloud ID mesin:');
    
    if (!deviceId) {
        showToast('❌ Cloud ID mesin wajib diisi', 'error');
        return;
    }
    
    if (!confirm('⚠️ Yakin mau restart mesin?')) return;
    
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Loading...';
    
    fetch('{{ route("command.restart-mesin") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        body: JSON.stringify({ device: deviceId })
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            showToast('✅ ' + result.message, 'success');
        } else {
            showToast('❌ ' + result.message, 'error');
        }
    })
    .catch(() => {
        showToast('❌ Gagal terhubung ke server', 'error');
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-power-off"></i> Restart Mesin';
    });
}

// 5. Register Online
function registerOnline(btn) {
    const pin = document.getElementById('registerPin').value;
    const verification = document.getElementById('registerVerification').value;
    const device = document.getElementById('registerDevice').value;
    
    if (!pin || !verification || !device) {
        showToast('⚠️ Semua field wajib diisi!', 'warning');
        return;
    }
    
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Loading...';
    
    fetch('{{ route("command.register-online") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        body: JSON.stringify({ device: device, pin: pin, verification: verification })
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            showToast('✅ ' + result.message, 'success');
            document.getElementById('registerPin').value = '';
            document.getElementById('registerVerification').value = '';
        } else {
            showToast('❌ ' + result.message, 'error');
        }
    })
    .catch(() => {
        showToast('❌ Gagal terhubung ke server', 'error');
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-user-plus"></i> Register';
    });
}

// ============================================
// TOAST NOTIFICATION
// ============================================
function showToast(message, type) {
    if (typeof window.showToast === 'function') {
        window.showToast(message, type);
    } else {
        alert(message);
    }
}

// ============================================
// MODAL FORM SUBMIT
// ============================================
document.getElementById('formApi')?.addEventListener('submit', function(e) {
    e.preventDefault();
    showToast('✅ Konfigurasi API berhasil disimpan!', 'success');
    bootstrap.Modal.getInstance(document.getElementById('modalApi')).hide();
});
</script>
@endsection