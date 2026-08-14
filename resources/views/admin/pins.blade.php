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

<!-- Header dengan Total + Reload -->
<div class="d-flex justify-content-between align-items-center mb-4 page-header">
    <h1 class="h4 m-0">🔑 Manajemen Perangkat</h1>
    <div class="header-right">
        <span class="total-badge">Total: {{ $pins->total() }}</span>
        <span class="badge-mini {{ $anyDeviceOnline ? 'badge-mini-success' : 'badge-mini-danger' }}">
            {{ $anyDeviceOnline ? 'Ada Online' : 'Semua Offline' }}
        </span>
        <button type="button" class="reload-badge" onclick="getAllPin(this)">
            <i class="fas fa-sync-alt"></i> Reload
        </button>
    </div>
</div>

<!-- Command Panel -->
<div class="command-panel mb-4">
    <div class="row g-3 align-items-end">
        <div class="col-md-12">
            <form method="GET" class="row g-2 mb-3">
                <div class="col-md-3">
                    <label style="font-size: 0.8rem; font-weight: 600; margin-bottom: 4px; color: #374151;">Mesin Absensi</label>
                    <select name="device" class="form-control form-control-modern" onchange="this.form.submit()">
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
                <div class="col-md-3">
                    <label style="font-size: 0.8rem; font-weight: 600; margin-bottom: 4px; color: #374151;">Cari Cloud ID</label>
                    <input type="text" name="pin" class="form-control form-control-modern" placeholder="Masukkan Cloud ID..." value="{{ request('pin') }}">
                </div>
                <div class="col-md-2">
                    <label style="font-size: 0.8rem; font-weight: 600; margin-bottom: 4px; color: #374151;">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn-modern btn-modern-primary w-100">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                        <a href="{{ route('pins.index') }}" class="btn-modern btn-modern-outline" style="min-width: 42px;" title="Reset Filter">
                            <i class="fas fa-undo"></i>
                        </a>
                    </div>
                </div>
            </form>
            
            <hr class="my-3" style="border-color: #E6E8EC;">
            
            <h6 style="font-size: 0.75rem; font-weight: 600; color: #6B7280; margin-bottom: 12px; text-transform: uppercase; letter-spacing: 0.05em;">
                <i class="fas fa-cog me-1"></i> Kontrol Mesin Absensi
            </h6>
            
            <div class="row g-3 align-items-end">
                {{-- Ambil Semua PIN --}}
                <div class="col-md-3">
                    <label style="font-size: 0.8rem; font-weight: 600; margin-bottom: 4px; color: #374151;">Sinkronisasi Data</label>
                    <button type="button" class="btn-modern btn-modern-primary w-100" onclick="getAllPin(this)">
                        <i class="fas fa-key"></i> Ambil Semua PIN
                    </button>
                    <small class="text-muted" style="font-size: 0.7rem;">⚠️ Data user dikirim via webhook</small>
                </div>

                {{-- Get Userinfo --}}
                <div class="col-md-3">
                    <label style="font-size: 0.8rem; font-weight: 600; margin-bottom: 4px; color: #374151;">Ambil Data User</label>
                    <button type="button" class="btn-modern btn-modern-success w-100" onclick="getUserinfo(this)">
                        <i class="fas fa-users"></i> Get Userinfo
                    </button>
                    <small class="text-muted" style="font-size: 0.7rem;">Download data user lengkap</small>
                </div>

                {{-- Set Time --}}
                <div class="col-md-3">
                    <label style="font-size: 0.8rem; font-weight: 600; margin-bottom: 4px; color: #374151;">Atur Waktu</label>
                    <div class="d-flex gap-2">
                        <input type="datetime-local" id="timezoneInput" class="form-control form-control-modern" value="{{ date('Y-m-d\TH:i') }}">
                        <button type="button" class="btn-modern btn-modern-warning" onclick="setTime(this)" title="Set Waktu Mesin">
                            <i class="fas fa-clock"></i>
                        </button>
                    </div>
                    <small class="text-muted" style="font-size: 0.7rem;">Sinkronisasi waktu mesin</small>
                </div>

                {{-- Restart Mesin --}}
                <div class="col-md-3">
                    <label style="font-size: 0.8rem; font-weight: 600; margin-bottom: 4px; color: #374151;">Restart</label>
                    <button type="button" class="btn-modern btn-modern-danger w-100" onclick="restartMesin(this)">
                        <i class="fas fa-power-off"></i> Restart Mesin
                    </button>
                    <small class="text-muted" style="font-size: 0.7rem;">⚠️ Mesin akan restart otomatis</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Register Online Section -->
<div class="command-panel mb-4">
    <div class="row g-3 align-items-end">
        <div class="col-md-12">
            <h6 style="font-size: 0.75rem; font-weight: 600; color: #6B7280; margin-bottom: 12px; text-transform: uppercase; letter-spacing: 0.05em;">
                <i class="fas fa-user-plus me-1"></i> Register User Online
            </h6>
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label style="font-size: 0.8rem; font-weight: 600; margin-bottom: 4px; color: #374151;">PIN *</label>
                    <input type="text" id="registerPin" class="form-control form-control-modern" placeholder="Contoh: 1010007" required>
                </div>
                <div class="col-md-4">
                    <label style="font-size: 0.8rem; font-weight: 600; margin-bottom: 4px; color: #374151;">Nama Lengkap *</label>
                    <input type="text" id="registerName" class="form-control form-control-modern" placeholder="Nama karyawan" required>
                </div>
                <div class="col-md-3">
                    <label style="font-size: 0.8rem; font-weight: 600; margin-bottom: 4px; color: #374151;">Mesin *</label>
                    <select id="registerDevice" class="form-control form-control-modern" required>
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
                    <button type="button" class="btn-modern btn-modern-success w-100" onclick="registerOnline(this)">
                        <i class="fas fa-user-plus"></i> Register
                    </button>
                </div>
            </div>
            <small class="text-muted" style="font-size: 0.7rem;">Registrasi user langsung ke mesin absensi</small>
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
                    <th>Device Name</th>
                    <th>Device SN</th>
                    <th style="width: 120px;">Status Koneksi</th>
                    <th style="width: 100px;">Aksi</th>
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
                        @php
                            $deviceStatus = $deviceStatuses[$pin->pin] ?? null;
                            $isOnline = $deviceStatus['online'] ?? false;
                            $lastChecked = $deviceStatus['last_checked'] ?? 'N/A';
                            $statusCode = $deviceStatus['status_code'] ?? 'N/A';
                        @endphp
                        <div class="{{ $isOnline ? 'device-status-online' : 'device-status-offline' }}">
                            <span class="device-status-dot"></span>
                            <span>{{ $isOnline ? 'Online' : 'Offline' }}</span>
                        </div>
                        <div class="device-info-text">
                            Last checked: {{ $lastChecked }} | Status: {{ $statusCode }}
                        </div>
                    </td>
                    <td>
                        <button type="button" class="btn-modern btn-modern-sm btn-modern-outline" onclick="testConnection('{{ $pin->pin }}', this)" title="Test Koneksi">
                            <i class="fas fa-plug"></i>
                        </button>
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
                    <td colspan="6" class="text-center text-muted py-4">
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
// Auto-refresh device status every 30 seconds
let refreshInterval;
let isPageVisible = true;

document.addEventListener('visibilitychange', () => {
    isPageVisible = !document.hidden;
    if (isPageVisible) {
        refreshDeviceStatus();
    }
});

function refreshDeviceStatus() {
    fetch(window.location.href)
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newStatusCells = doc.querySelectorAll('td:nth-child(5)');
            const currentStatusCells = document.querySelectorAll('td:nth-child(5)');
            
            currentStatusCells.forEach((cell, index) => {
                if (newStatusCells[index]) {
                    cell.innerHTML = newStatusCells[index].innerHTML;
                }
            });
            
            // Update overall status badge
            const newBadge = doc.querySelector('.badge-mini');
            const currentBadge = document.querySelector('.badge-mini');
            if (newBadge && currentBadge) {
                currentBadge.className = newBadge.className;
                currentBadge.textContent = newBadge.textContent;
            }
        })
        .catch(() => {
            console.log('Failed to refresh device status');
        });
}

// Start auto-refresh
refreshInterval = setInterval(() => {
    if (isPageVisible) {
        refreshDeviceStatus();
    }
}, 30000);

// 1. Get All PIN (Reload)
function getAllPin(btn) {
    const deviceSelect = document.querySelector('select[name="device"]');
    const deviceId = deviceSelect ? deviceSelect.value : '';
    
    if (!deviceId) {
        showToast('❌ Pilih mesin absensi terlebih dahulu', 'error');
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
        btn.innerHTML = '<i class="fas fa-key"></i> Ambil Semua PIN';
    });
}

// 1.5 Get Userinfo
function getUserinfo(btn) {
    const deviceSelect = document.querySelector('select[name="device"]');
    const deviceId = deviceSelect ? deviceSelect.value : '';
    
    if (!deviceId) {
        showToast('❌ Pilih mesin absensi terlebih dahulu', 'error');
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
        btn.innerHTML = '<i class="fas fa-users"></i> Get Userinfo';
    });
}

// 2. Set Time
function setTime(btn) {
    const deviceSelect = document.querySelector('select[name="device"]');
    const deviceId = deviceSelect ? deviceSelect.value : '';
    
    if (!deviceId) {
        showToast('❌ Pilih mesin absensi terlebih dahulu', 'error');
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

// 3. Restart Mesin
function restartMesin(btn) {
    const deviceSelect = document.querySelector('select[name="device"]');
    const deviceId = deviceSelect ? deviceSelect.value : '';
    
    if (!deviceId) {
        showToast('❌ Pilih mesin absensi terlebih dahulu', 'error');
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

// 4. Register Online
function registerOnline(btn) {
    const pin = document.getElementById('registerPin').value;
    const name = document.getElementById('registerName').value;
    const device = document.getElementById('registerDevice').value;
    
    if (!pin || !name || !device) {
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
        body: JSON.stringify({ device: device, pin: pin, name: name })
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            showToast('✅ ' + result.message, 'success');
            document.getElementById('registerPin').value = '';
            document.getElementById('registerName').value = '';
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

// 5. Test Connection per Device
function testConnection(cloudId, btn) {
    btn.disabled = true;
    const originalIcon = btn.innerHTML;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
    
    fetch('{{ route("pins.test-connection") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        body: JSON.stringify({ cloud_id: cloudId })
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            showToast('✅ ' + result.message, 'success');
            setTimeout(() => location.reload(), 1000);
        } else {
            showToast('❌ ' + result.message, 'error');
        }
    })
    .catch(() => {
        showToast('❌ Gagal terhubung ke server', 'error');
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = originalIcon;
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