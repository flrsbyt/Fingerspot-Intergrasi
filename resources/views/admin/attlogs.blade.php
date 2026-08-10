@extends('layouts.admin')

@section('title', 'Data Attlog')

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
    
    .btn-modern-info {
        background: #6366F1;
        color: #FFFFFF;
        padding: 8px 16px;
        font-size: 0.8rem;
        border-radius: 6px;
        min-width: 32px;
        min-height: 32px;
    }
    .btn-modern-info:hover {
        background: #4F46E5;
        color: #FFFFFF;
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
    
    .badge-modern-success {
        background: #D1FAE5;
        color: #059669;
        padding: 4px 12px;
        border-radius: 100px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .badge-modern-danger {
        background: #FEE2E2;
        color: #DC2626;
        padding: 4px 12px;
        border-radius: 100px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    /* PAGINATION CUSTOM */
    .pagination-wrapper-custom {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        padding: 16px 20px 8px;
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

<!-- Header dengan Total + Reload -->
<div class="d-flex justify-content-between align-items-center mb-4 page-header">
    <h1 class="h4 m-0">📋 Data Absensi</h1>
    <div class="header-right">
        <span class="total-badge">Total: {{ $attlogs->total() }}</span>
        <button type="button" class="reload-badge" onclick="syncAttlog(this)">
            <i class="fas fa-sync-alt"></i> Reload
        </button>
    </div>
</div>

<!-- Command Panel Filter -->
<div class="command-panel mb-4">
    <div class="row g-3 align-items-end">
        <div class="col-md-12">
            <form method="GET" class="row g-2">
                <div class="col-md-3">
                    <label style="font-size: 0.8rem; font-weight: 600; margin-bottom: 4px; color: #374151;">Mesin Absensi</label>
                    <select name="device" class="form-control form-control-modern">
                        <option value="">-- Semua Mesin --</option>
                        @php
                            $devices = App\Models\Pin::where('is_active', true)->get();
                        @endphp
                        @foreach($devices as $device)
                            <option value="{{ $device->pin }}" {{ request('device') == $device->pin ? 'selected' : '' }}>
                                {{ $device->device_name }} ({{ $device->pin }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label style="font-size: 0.8rem; font-weight: 600; margin-bottom: 4px; color: #374151;">Status</label>
                    <select name="status" class="form-control form-control-modern">
                        <option value="">-- Semua --</option>
                        <option value="check-in" {{ request('status') == 'check-in' ? 'selected' : '' }}>✅ Check-in</option>
                        <option value="check-out" {{ request('status') == 'check-out' ? 'selected' : '' }}>❌ Check-out</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label style="font-size: 0.8rem; font-weight: 600; margin-bottom: 4px; color: #374151;">Dari Tanggal</label>
                    <input type="date" name="start_date" class="form-control form-control-modern" value="{{ request('start_date') }}">
                </div>
                <div class="col-md-2">
                    <label style="font-size: 0.8rem; font-weight: 600; margin-bottom: 4px; color: #374151;">Sampai Tanggal</label>
                    <input type="date" name="end_date" class="form-control form-control-modern" value="{{ request('end_date') }}">
                </div>
                <div class="col-md-3">
                    <label style="font-size: 0.8rem; font-weight: 600; margin-bottom: 4px; color: #374151;">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn-modern btn-modern-primary" style="flex: 1;">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                        <button type="button" class="btn-modern btn-modern-primary" onclick="syncAttlog(this)">
                            <i class="fas fa-sync"></i> Sync
                        </button>
                        <a href="{{ route('attlogs.index') }}" class="btn-modern btn-modern-outline" style="min-width: 42px;" title="Reset Filter">
                            <i class="fas fa-undo"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Tabel -->
<div class="table-modern">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th style="width: 50px;">#</th>
                    <th>Cloud ID</th>
                    <th>Scan Time</th>
                    <th>Status</th>
                    <th style="width: 80px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($attlogs as $log)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><span class="mono-code">{{ $log->pin }}</span></td>
                    <td>{{ $log->scan_time->format('d M Y H:i:s') }}</td>
                    <td>
                        <span class="{{ $log->status == 'check-in' ? 'badge-modern-success' : 'badge-modern-danger' }}">
                            {{ $log->status }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('attlogs.show', $log->id) }}" class="btn-modern btn-modern-info">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">
                        <i class="fa-regular fa-database me-2"></i> Belum ada data absensi
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- PAGINATION -->
@if ($attlogs->hasPages())
<div class="pagination-wrapper-custom">
    <div class="pagination-info-custom">
        <span>
            Menampilkan 
            <strong>{{ $attlogs->firstItem() }}</strong> 
            - 
            <strong>{{ $attlogs->lastItem() }}</strong> 
            dari 
            <strong>{{ $attlogs->total() }}</strong> 
            data
        </span>
    </div>
    <nav>
        <ul class="pagination-custom">
            @if ($attlogs->onFirstPage())
                <li class="page-item-custom disabled"><span class="page-link-custom"><i class="fas fa-chevron-left"></i></span></li>
            @else
                <li class="page-item-custom"><a class="page-link-custom" href="{{ $attlogs->previousPageUrl() }}"><i class="fas fa-chevron-left"></i></a></li>
            @endif

            @php
                $start = max(1, $attlogs->currentPage() - 2);
                $end = min($attlogs->lastPage(), $attlogs->currentPage() + 2);
                if ($start > 1) {
                    echo '<li class="page-item-custom"><a class="page-link-custom" href="' . $attlogs->url(1) . '">1</a></li>';
                    if ($start > 2) echo '<li class="page-item-custom disabled"><span class="page-link-custom">…</span></li>';
                }
                for ($i = $start; $i <= $end; $i++) {
                    $active = $i == $attlogs->currentPage() ? 'active' : '';
                    echo '<li class="page-item-custom ' . $active . '"><a class="page-link-custom" href="' . $attlogs->url($i) . '">' . $i . '</a></li>';
                }
                if ($end < $attlogs->lastPage()) {
                    if ($end < $attlogs->lastPage() - 1) echo '<li class="page-item-custom disabled"><span class="page-link-custom">…</span></li>';
                    echo '<li class="page-item-custom"><a class="page-link-custom" href="' . $attlogs->url($attlogs->lastPage()) . '">' . $attlogs->lastPage() . '</a></li>';
                }
            @endphp

            @if ($attlogs->hasMorePages())
                <li class="page-item-custom"><a class="page-link-custom" href="{{ $attlogs->nextPageUrl() }}"><i class="fas fa-chevron-right"></i></a></li>
            @else
                <li class="page-item-custom disabled"><span class="page-link-custom"><i class="fas fa-chevron-right"></i></span></li>
            @endif
        </ul>
    </nav>
</div>
@endif

<!-- Form untuk Reload (hidden) -->
<form action="{{ route('command.get-attlog') }}" method="POST" id="syncAttlogForm" style="display:none;">
    @csrf
    <input type="hidden" name="device" value="{{ request('device') }}">
    <input type="hidden" name="start_date" value="{{ request('start_date') ?? date('Y-m-d') }}">
    <input type="hidden" name="end_date" value="{{ request('end_date') ?? date('Y-m-d') }}">
    <input type="hidden" name="pin" value="all">
</form>

<script>
function syncAttlog(btn) {
    const deviceSelect = document.querySelector('select[name="device"]');
    const deviceId = deviceSelect ? deviceSelect.value : '';
    
    if (!deviceId) {
        showToast('❌ Pilih mesin absensi terlebih dahulu', 'error');
        return;
    }
    
    const form = document.getElementById('syncAttlogForm');
    const formData = new FormData(form);
    const data = Object.fromEntries(formData);
    data.device = deviceId;
    
    // Loading state
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Loading...';
    
    fetch('{{ route("command.get-attlog") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            showToast('✅ ' + result.message, 'success');
            setTimeout(() => location.reload(), 1500);
        } else {
            showToast('❌ ' + result.message, 'error');
        }
    })
    .catch(() => {
        showToast('❌ Gagal terhubung ke server', 'error');
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-sync"></i> Sync';
    });
}

function showToast(message, type) {
    if (typeof window.showToast === 'function') {
        window.showToast(message, type);
    } else {
        alert(message);
    }
}
</script>
@endsection