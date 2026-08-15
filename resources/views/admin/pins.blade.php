@extends('layouts.admin')

@section('title', 'Data PIN')

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
    
    .reload-badge {
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.8rem;
        background: #FFFFFF;
        color: #6366F1;
        padding: 6px 14px;
        border-radius: 100px;
        font-weight: 500;
        border: 1px solid #E6E8EC;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .reload-badge:hover {
        background: #F3F4FF;
        border-color: #6366F1;
    }
    .reload-badge i {
        font-size: 0.75rem;
    }
    
    .command-panel {
        background: #FFFFFF;
        border: 1px solid #E6E8EC;
        border-radius: 14px;
        padding: 20px 24px;
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
        white-space: nowrap;
    }
    
    .btn-modern-primary {
        background: #6366F1;
        color: #FFFFFF;
    }
    .btn-modern-primary:hover {
        background: #4F46E5;
        color: #FFFFFF;
    }
    
    .btn-modern-success {
        background: #10B981;
        color: #FFFFFF;
    }
    .btn-modern-success:hover {
        background: #059669;
        color: #FFFFFF;
    }
    
    .btn-modern-warning {
        background: #F59E0B;
        color: #FFFFFF;
    }
    .btn-modern-warning:hover {
        background: #D97706;
        color: #FFFFFF;
    }
    
    .btn-modern-danger {
        background: #EF4444;
        color: #FFFFFF;
    }
    .btn-modern-danger:hover {
        background: #DC2626;
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
    
    .btn-modern-sm {
        padding: 6px 12px;
        font-size: 0.75rem;
        min-height: 32px;
        border-radius: 6px;
        min-width: 32px;
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
    
    .table-modern thead th:first-child {
        padding-left: 20px;
    }
    
    .table-modern thead th:last-child {
        padding-right: 20px;
    }
    
    .table-modern tbody td {
        padding: 16px;
        color: #1F2937;
        border-bottom: 1px solid #F3F4F6;
        font-size: 0.9rem;
    }
    
    .table-modern tbody td:first-child {
        padding-left: 20px;
    }
    
    .table-modern tbody td:last-child {
        padding-right: 20px;
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
        padding: 3px 10px;
        border-radius: 4px;
    }
    
    .form-control-modern {
        border: 1px solid #E6E8EC;
        border-radius: 8px;
        padding: 10px 14px;
        font-size: 0.9rem;
        width: 100%;
        background: #FAFAFC;
        transition: all 0.2s;
    }
    .form-control-modern:focus {
        border-color: #9FA1FF;
        box-shadow: 0 0 0 3px rgba(159, 161, 255, 0.1);
        outline: none;
        background: #FFFFFF;
    }
    
    .badge-modern-success {
        background: #D1FAE5;
        color: #059669;
        padding: 4px 14px;
        border-radius: 100px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .badge-modern-danger {
        background: #FEE2E2;
        color: #DC2626;
        padding: 4px 14px;
        border-radius: 100px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .device-status-online {
        display: flex;
        align-items: center;
        gap: 6px;
        color: #059669;
        font-weight: 600;
        font-size: 0.8rem;
    }
    
    .device-status-offline {
        display: flex;
        align-items: center;
        gap: 6px;
        color: #DC2626;
        font-weight: 600;
        font-size: 0.8rem;
    }
    
    .device-status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: currentColor;
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
    
    .device-info-text {
        font-size: 0.7rem;
        color: #6B7280;
        margin-top: 4px;
    }
    
    .device-status-online {
        background: #D1FAE5;
        color: #059669;
        padding: 4px 12px;
        border-radius: 100px;
        font-size: 0.7rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    
    .device-status-offline {
        background: #FEE2E2;
        color: #DC2626;
        padding: 4px 12px;
        border-radius: 100px;
        font-size: 0.7rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    
    .device-status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
    }
    
    .device-status-online .device-status-dot {
        background: #059669;
        box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.2);
        animation: pulse-green 2s infinite;
    }
    
    .device-status-offline .device-status-dot {
        background: #DC2626;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.2);
    }
    
    @keyframes pulse-green {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
    
    .device-info-text {
        font-size: 0.7rem;
        color: #6B7280;
        margin-top: 2px;
    }
    
    /* PAGINATION CUSTOM */
    .pagination-wrapper-custom {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        padding: 16px 20px 12px;
        border-top: 1px solid #E6E8EC;
        background: #FAFAFC;
        border-radius: 0 0 14px 14px;
    }
    
    .pagination-info-custom {
        font-size: 0.8rem;
        color: #6B7280;
        font-family: 'Inter', sans-serif;
    }
    .pagination-info-custom strong {
        color: #0B0F19;
        font-weight: 600;
    }
    
    .pagination-custom {
        display: flex;
        gap: 4px;
        margin: 0;
        padding: 0;
        list-style: none;
        flex-wrap: wrap;
    }
    
    .page-item-custom {
        display: inline-block;
    }
    
    .page-link-custom {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 36px;
        height: 36px;
        padding: 0 12px;
        border: 1px solid #E6E8EC;
        border-radius: 8px;
        background: #FFFFFF;
        color: #1F2937;
        font-size: 0.8rem;
        font-weight: 500;
        transition: all 0.2s;
        text-decoration: none;
    }
    .page-link-custom:hover {
        background: #F3F4FF;
        border-color: #9FA1FF;
        color: #6366F1;
        text-decoration: none;
    }
    .page-item-custom.active .page-link-custom {
        background: #6366F1;
        border-color: #6366F1;
        color: #FFFFFF;
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.25);
    }
    .page-item-custom.disabled .page-link-custom {
        opacity: 0.4;
        cursor: not-allowed;
        pointer-events: none;
    }
    
    @media (max-width: 576px) {
        .pagination-wrapper-custom {
            flex-direction: column;
            align-items: stretch;
            text-align: center;
            gap: 16px;
        }
        .pagination-custom {
            justify-content: center;
        }
        .page-link-custom {
            min-width: 32px;
            height: 32px;
            font-size: 0.7rem;
            padding: 0 8px;
        }
    }
</style>

<!-- Header dengan Total -->
<div class="d-flex justify-content-between align-items-center mb-4 page-header">
    <h1 class="h4 m-0">🔑 Manajemen Perangkat</h1>
    <div class="header-right">
        <span class="total-badge">Total: {{ $pins->total() }}</span>
    </div>
</div>

<!-- Command Panel - Tambah Mesin Absensi -->
<div class="command-panel mb-4">
    <form action="{{ route('settings.add-device') }}" method="POST">
        @csrf
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label form-label-modern">Cloud ID *</label>
                <input type="text" name="pin" class="form-control form-control-modern" placeholder="Contoh: ABC123XYZ" required>
                <small class="text-muted" style="font-size: 0.75rem;">ID Cloud dari Fingerspot</small>
            </div>
            <div class="col-md-4">
                <label class="form-label form-label-modern">Nama Perangkat *</label>
                <input type="text" name="device_name" class="form-control form-control-modern" placeholder="Contoh: Mesin Kantor Pusat" required>
                <small class="text-muted" style="font-size: 0.75rem;">Nama untuk identifikasi</small>
            </div>
            <div class="col-md-4">
                <label class="form-label form-label-modern">&nbsp;</label>
                <button type="submit" class="btn-modern btn-modern-success w-100">
                    <i class="fas fa-plus"></i> Tambah Perangkat
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Tabel -->
<div class="table-modern">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th style="width: 50px;">#</th>
                    <th>Cloud ID</th>
                    <th>Device Name</th>
                    <th>Device SN</th>
                    <th style="width: 80px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pins as $pin)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><span class="mono-code">{{ $pin->pin }}</span></td>
                    <td>{{ $pin->device_name ?? '-' }}</td>
                    <td>{{ $pin->device_sn ?? '-' }}</td>
                    <td>
                        <form action="{{ route('pins.destroy', $pin->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-modern btn-modern-sm btn-modern-danger" onclick="return confirm('Hapus perangkat ini?')" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">
                        <i class="fa-regular fa-database me-2"></i> Belum ada data PIN
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- PAGINATION -->
@if ($pins->hasPages())
<div class="pagination-wrapper-custom">
    <div class="pagination-info-custom">
        <span>
            Menampilkan 
            <strong>{{ $pins->firstItem() }}</strong> 
            - 
            <strong>{{ $pins->lastItem() }}</strong> 
            dari 
            <strong>{{ $pins->total() }}</strong> 
            data
        </span>
    </div>
    <nav>
        <ul class="pagination-custom">
            @if ($pins->onFirstPage())
                <li class="page-item-custom disabled"><span class="page-link-custom"><i class="fas fa-chevron-left"></i></span></li>
            @else
                <li class="page-item-custom"><a class="page-link-custom" href="{{ $pins->previousPageUrl() }}"><i class="fas fa-chevron-left"></i></a></li>
            @endif

            @php
                $start = max(1, $pins->currentPage() - 2);
                $end = min($pins->lastPage(), $pins->currentPage() + 2);
                if ($start > 1) {
                    echo '<li class="page-item-custom"><a class="page-link-custom" href="' . $pins->url(1) . '">1</a></li>';
                    if ($start > 2) echo '<li class="page-item-custom disabled"><span class="page-link-custom">…</span></li>';
                }
                for ($i = $start; $i <= $end; $i++) {
                    $active = $i == $pins->currentPage() ? 'active' : '';
                    echo '<li class="page-item-custom ' . $active . '"><a class="page-link-custom" href="' . $pins->url($i) . '">' . $i . '</a></li>';
                }
                if ($end < $pins->lastPage()) {
                    if ($end < $pins->lastPage() - 1) echo '<li class="page-item-custom disabled"><span class="page-link-custom">…</span></li>';
                    echo '<li class="page-item-custom"><a class="page-link-custom" href="' . $pins->url($pins->lastPage()) . '">' . $pins->lastPage() . '</a></li>';
                }
            @endphp

            @if ($pins->hasMorePages())
                <li class="page-item-custom"><a class="page-link-custom" href="{{ $pins->nextPageUrl() }}"><i class="fas fa-chevron-right"></i></a></li>
            @else
                <li class="page-item-custom disabled"><span class="page-link-custom"><i class="fas fa-chevron-right"></i></span></li>
            @endif
        </ul>
    </nav>
</div>
@endif


<script>
// Show toast notification
function showToast(message, type) {
    if (typeof window.showToast === 'function') {
        window.showToast(message, type);
    } else {
        alert(message);
    }
}
</script>
@endsection