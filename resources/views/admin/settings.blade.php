@extends('layouts.admin')

@section('title', 'Pengaturan')

@section('content')
<style>
    .page-header h1 {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700;
        color: #0B0F19;
        margin: 0;
    }
    
    .header-right {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .total-badge {
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.8rem;
        background: #F3F4FF;
        color: #6366F1;
        padding: 6px 14px;
        border-radius: 100px;
        font-weight: 500;
    }
    
    .settings-card {
        background: #FFFFFF;
        border: 1px solid #E6E8EC;
        border-radius: 14px;
        padding: 20px 24px;
        transition: all 0.25s ease;
        height: 100%;
    }
    .settings-card:hover {
        border-color: #9FA1FF;
    }
    
    .settings-card .card-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 600;
        font-size: 0.85rem;
        color: #0B0F19;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }
    .settings-card .card-title .title-left {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .settings-card .card-title i {
        color: #6366F1;
        font-size: 1rem;
    }
    
    .btn-modern {
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 500;
        font-size: 0.85rem;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 42px;
        border: none;
        text-decoration: none;
    }
    
    .btn-modern-primary {
        background: #6366F1;
        color: #FFFFFF;
    }
    .btn-modern-primary:hover {
        background: #4F46E5;
        color: #FFFFFF;
    }
    
    .btn-modern-outline {
        background: transparent;
        color: #6366F1;
        border: 1px solid #E6E8EC;
    }
    .btn-modern-outline:hover {
        background: #F3F4FF;
        border-color: #6366F1;
    }
    
    .btn-modern-success {
        background: #10B981;
        color: #FFFFFF;
    }
    .btn-modern-success:hover {
        background: #059669;
        color: #FFFFFF;
    }
    
    .btn-edit {
        background: transparent;
        border: 1px solid #E6E8EC;
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
    
    .data-row {
        display: flex;
        padding: 8px 0;
        border-bottom: 1px solid #F3F4F6;
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
        color: #1F2937;
        font-weight: 500;
        word-break: break-all;
    }
    .data-row .value code {
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.75rem;
        background: #F3F4FF;
        color: #6366F1;
        padding: 2px 6px;
        border-radius: 4px;
    }
    
    .form-control-modern {
        border: 1px solid #E6E8EC;
        border-radius: 8px;
        padding: 10px 14px;
        font-size: 0.9rem;
        width: 100%;
    }
    .form-control-modern:focus {
        border-color: #9FA1FF;
        box-shadow: 0 0 0 3px rgba(159, 161, 255, 0.1);
        outline: none;
    }
    
    .table-modern {
        background: #FFFFFF;
        border: 1px solid #E6E8EC;
        border-radius: 14px;
        overflow: hidden;
    }
    
    .table-modern thead th {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #6B7280;
        font-weight: 600;
        border-bottom: 2px solid #E6E8EC;
        padding: 18px 16px;
        background: #FAFAFC;
    }
    
    .table-modern tbody td {
        padding: 16px;
        color: #1F2937;
        border-bottom: 1px solid #F3F4F6;
        font-size: 0.9rem;
    }
    
    .table-modern tbody tr:hover {
        background: #FAFAFC;
    }
    .table-modern tbody tr:last-child td {
        border-bottom: none;
    }
    
    .mono-code {
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.78rem;
        background: #F3F4FF;
        color: #6366F1;
        padding: 3px 8px;
        border-radius: 4px;
    }
    
    /* MODAL */
    .modal-modern .modal-content {
        border: 1px solid #E6E8EC;
        border-radius: 16px;
    }
    .modal-modern .modal-header {
        border-bottom: 1px solid #E6E8EC;
        padding: 20px 24px;
    }
    .modal-modern .modal-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700;
        color: #0B0F19;
    }
    .modal-modern .modal-body {
        padding: 24px;
    }
    .modal-modern .modal-footer {
        border-top: 1px solid #E6E8EC;
        padding: 16px 24px;
    }
    
    .form-label-modern {
        font-size: 0.85rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 6px;
    }
    
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
        padding: 10px 14px;
        font-size: 0.9rem;
        border: 1px solid #E6E8EC;
        border-radius: 8px;
        background: #FFFFFF;
        transition: all 0.2s ease;
        color: #1F2937;
    }
    .form-control-modal:focus {
        border-color: #9FA1FF;
        background: #FFFFFF;
        outline: none;
        box-shadow: 0 0 0 3px rgba(159, 161, 255, 0.1);
    }
    textarea.form-control-modal {
        resize: vertical;
        min-height: 60px;
        font-family: 'Inter', sans-serif;
    }
</style>

<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4 page-header">
    <h1 class="h4 m-0">⚙️ Pengaturan</h1>
</div>

<!-- API Config Card -->
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
                        <td><code class="mono-code">{{ $settings['api_url'] }}</code></td>
                        <td style="text-align: right;">
                            <button class="btn-modern btn-modern-outline btn-modern-sm" onclick="navigator.clipboard.writeText('{{ $settings['api_url'] }}')">
                                <i class="fas fa-copy"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>API Key</strong></td>
                        <td><code class="mono-code">{{ str_repeat('•', 16) }}</code></td>
                        <td style="text-align: right;">
                            <button class="btn-modern btn-modern-outline btn-modern-sm" onclick="navigator.clipboard.writeText('{{ $settings['api_key'] }}')">
                                <i class="fas fa-copy"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Webhook URL</strong></td>
                        <td><code class="mono-code">{{ $settings['webhook_url'] }}</code></td>
                        <td style="text-align: right;">
                            <button class="btn-modern btn-modern-outline btn-modern-sm" onclick="navigator.clipboard.writeText('{{ $settings['webhook_url'] }}')">
                                <i class="fas fa-copy"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
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