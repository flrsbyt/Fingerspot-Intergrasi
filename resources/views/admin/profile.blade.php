@extends('layouts.admin')

@section('title', 'Profil Perusahaan')

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
    .btn-custom-outline {
        background: transparent;
        color: #6366F1;
        border: 1px solid #E5E7EB;
    }
    .btn-custom-outline:hover {
        background: #F3F4FF;
        border-color: #6366F1;
    }
    
    /* ===== MODAL ===== */
    .modal-custom .modal-content {
        border: 1px solid #E6E8EC;
        border-radius: 16px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.15);
    }
    .modal-custom .modal-header {
        border-bottom: 1px solid #F0F2F5;
        padding: 16px 24px;
    }
    .modal-custom .modal-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 600;
        font-size: 0.95rem;
        color: #111827;
    }
    .modal-custom .modal-body {
        padding: 20px 24px;
    }
    .modal-custom .modal-footer {
        border-top: 1px solid #F0F2F5;
        padding: 16px 24px;
    }
</style>

<div class="settings-container">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 settings-header">
        <div>
            <h1>🏢 Profil Perusahaan</h1>
            <span class="subtitle">Kelola informasi perusahaan Anda</span>
        </div>
    </div>

    <div class="settings-card">
        <div class="card-title">
            <span class="title-left">
                <i class="fas fa-building"></i> Informasi Perusahaan
            </span>
            <button class="btn-edit" data-bs-toggle="modal" data-bs-target="#modalProfil">
                <i class="fas fa-pen"></i> Edit
            </button>
        </div>

        <div class="data-row">
            <div class="label">Nama Perusahaan</div>
            <div class="value">{{ $settings['company_name'] }}</div>
        </div>
        <div class="data-row">
            <div class="label">Email</div>
            <div class="value">{{ $settings['company_email'] }}</div>
        </div>
        <div class="data-row">
            <div class="label">Telepon</div>
            <div class="value">{{ $settings['company_phone'] }}</div>
        </div>
        <div class="data-row">
            <div class="label">Alamat</div>
            <div class="value">{{ $settings['company_address'] }}</div>
        </div>
    </div>
</div>

<!-- Modal Edit Profil -->
<div class="modal fade modal-custom" id="modalProfil" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">✏️ Edit Profil Perusahaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group-modal">
                        <label class="form-label-modal">Nama Perusahaan</label>
                        <input type="text" name="company_name" class="form-control-modal" value="{{ $settings['company_name'] }}" required>
                    </div>
                    <div class="form-group-modal">
                        <label class="form-label-modal">Email</label>
                        <input type="email" name="company_email" class="form-control-modal" value="{{ $settings['company_email'] }}" required>
                    </div>
                    <div class="form-group-modal">
                        <label class="form-label-modal">Telepon</label>
                        <input type="text" name="company_phone" class="form-control-modal" value="{{ $settings['company_phone'] }}">
                    </div>
                    <div class="form-group-modal">
                        <label class="form-label-modal">Alamat</label>
                        <textarea name="company_address" class="form-control-modal" rows="3">{{ $settings['company_address'] }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-custom btn-custom-outline" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-custom btn-custom-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
