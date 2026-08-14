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

<!-- Header dengan Total -->
<div class="d-flex justify-content-between align-items-center mb-4 page-header">
    <h1 class="h4 m-0">📋 Data Absensi</h1>
    <div class="header-right">
        <span class="total-badge">Total: {{ $attlogs->total() }}</span>
    </div>
</div>

<!-- Command Panel Filter -->
<div class="command-panel mb-4">
    <div class="row g-3 align-items-end">
        <div class="col-md-12">
            <form method="GET" class="row g-2">
                <div class="col-md-2">
                    <label style="font-size: 0.8rem; font-weight: 600; margin-bottom: 4px; color: #374151;">PIN</label>
                    <input type="text" name="pin" class="form-control form-control-modern" placeholder="Cari PIN..." value="{{ request('pin') }}">
                </div>
                <div class="col-md-2">
                    <label style="font-size: 0.8rem; font-weight: 600; margin-bottom: 4px; color: #374151;">Metode</label>
                    <select name="verify" class="form-control form-control-modern">
                        <option value="">-- Semua --</option>
                        <option value="1" {{ request('verify') == '1' ? 'selected' : '' }}>👆 Sidik Jari</option>
                        <option value="2" {{ request('verify') == '2' ? 'selected' : '' }}>🔑 Password</option>
                        <option value="3" {{ request('verify') == '3' ? 'selected' : '' }}>💳 Kartu</option>
                        <option value="4" {{ request('verify') == '4' ? 'selected' : '' }}>😊 Wajah</option>
                        <option value="6" {{ request('verify') == '6' ? 'selected' : '' }}>🤚 Telapak Tangan</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label style="font-size: 0.8rem; font-weight: 600; margin-bottom: 4px; color: #374151;">Status</label>
                    <select name="status" class="form-control form-control-modern">
                        <option value="">-- Semua --</option>
                        <option value="check-in" {{ request('status') == 'check-in' ? 'selected' : '' }}>✅ Check-in</option>
                        <option value="check-out" {{ request('status') == 'check-out' ? 'selected' : '' }}>❌ Check-out</option>
                        <option value="break-in" {{ request('status') == 'break-in' ? 'selected' : '' }}>☕ Break-in</option>
                        <option value="break-out" {{ request('status') == 'break-out' ? 'selected' : '' }}>🔙 Break-out</option>
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
                <div class="col-md-2">
                    <label style="font-size: 0.8rem; font-weight: 600; margin-bottom: 4px; color: #374151;">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn-modern btn-modern-primary" style="flex: 1;">
                            <i class="fas fa-filter"></i> Filter
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
                    <th>PIN</th>
                    <th>Waktu Scan</th>
                    <th>Metode</th>
                    <th>Status</th>
                    <th style="width: 80px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($attlogs as $log)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <span class="mono-code">{{ $log->pin }}</span>
                        @if($log->photo_url)
                        <a href="{{ $log->photo_url }}" target="_blank" class="ms-1" title="Lihat foto">
                            <i class="fas fa-camera" style="color: #6366F1; font-size: 0.75rem;"></i>
                        </a>
                        @endif
                    </td>
                    <td>{{ $log->scan_time->format('d M Y H:i:s') }}</td>
                    <td>
                        @php
                            $verifyMethods = [
                                1 => ['icon' => 'fa-fingerprint', 'label' => 'Sidik Jari', 'color' => '#6366F1'],
                                2 => ['icon' => 'fa-key', 'label' => 'Password', 'color' => '#F59E0B'],
                                3 => ['icon' => 'fa-id-card', 'label' => 'Kartu', 'color' => '#10B981'],
                                4 => ['icon' => 'fa-face-smile', 'label' => 'Wajah', 'color' => '#EC4899'],
                                6 => ['icon' => 'fa-hand', 'label' => 'Telapak Tangan', 'color' => '#8B5CF6'],
                            ];
                            $verify = $verifyMethods[$log->verify] ?? ['icon' => 'fa-question', 'label' => 'Unknown', 'color' => '#6B7280'];
                        @endphp
                        <span style="color: {{ $verify['color'] }}; font-size: 0.8rem; font-weight: 500;">
                            <i class="fas {{ $verify['icon'] }}"></i> {{ $verify['label'] }}
                        </span>
                    </td>
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
                    <td colspan="6" class="text-center text-muted py-4">
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


@endsection