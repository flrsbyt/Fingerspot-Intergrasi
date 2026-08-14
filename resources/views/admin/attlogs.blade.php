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
    
    .device-status-online {
        background: #D1FAE5;
        color: #059669;
        padding: 4px 12px;
        border-radius: 100px;
        font-size: 0.75rem;
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
        font-size: 0.75rem;
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
    
    .realtime-indicator {
        font-size: 0.75rem;
        color: #6B7280;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    
    .realtime-indicator.active {
        color: #059669;
    }
    
    .realtime-indicator .dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #6B7280;
    }
    
    .realtime-indicator.active .dot {
        background: #059669;
        animation: pulse-green 2s infinite;
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

<!-- Header dengan Total + Device Status -->
<div class="d-flex justify-content-between align-items-center mb-4 page-header">
    <div>
        <h1 class="h4 m-0">📋 Data Absensi</h1>
        <div class="realtime-indicator mt-1" id="realtimeIndicator">
            <span class="dot"></span>
            <span id="realtimeStatus">Checking connection...</span>
        </div>
    </div>
    <div class="header-right">
        <div id="deviceStatusContainer" class="d-flex gap-2 mb-2">
            <!-- Device status will be loaded here -->
        </div>
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

<!-- Realtime Script -->
<script>
let pollingInterval = null;
let deviceStatusInterval = null;
let lastAttlogId = {{ $attlogs->max('id') ?? 0 }};
let isRealtimeActive = false;

// Start realtime monitoring
function startRealtimeMonitoring() {
    if (isRealtimeActive) return;
    
    isRealtimeActive = true;
    updateRealtimeIndicator(true);
    
    // Poll for new attlogs every 10 seconds (reduced from 5s for better performance)
    pollingInterval = setInterval(() => {
        fetchNewAttlogs();
    }, 10000);
    
    // Check device status every 30 seconds (cached for 30s, so this is optimal)
    deviceStatusInterval = setInterval(() => {
        checkDeviceStatus();
    }, 30000);
    
    // Initial check
    checkDeviceStatus();
}

// Stop realtime monitoring
function stopRealtimeMonitoring() {
    isRealtimeActive = false;
    updateRealtimeIndicator(false);
    
    if (pollingInterval) {
        clearInterval(pollingInterval);
        pollingInterval = null;
    }
    
    if (deviceStatusInterval) {
        clearInterval(deviceStatusInterval);
        deviceStatusInterval = null;
    }
}

// Update realtime indicator
function updateRealtimeIndicator(active) {
    const indicator = document.getElementById('realtimeIndicator');
    const status = document.getElementById('realtimeStatus');
    
    if (active) {
        indicator.classList.add('active');
        status.textContent = 'Realtime Active';
    } else {
        indicator.classList.remove('active');
        status.textContent = 'Realtime Paused';
    }
}

// Fetch new attlogs
function fetchNewAttlogs() {
    const url = new URL('{{ route("realtime.attlogs") }}', window.location.origin);
    url.searchParams.append('last_id', lastAttlogId);
    url.searchParams.append('limit', 10);
    
    // Add current filters
    const pinInput = document.querySelector('input[name="pin"]');
    if (pinInput && pinInput.value) {
        url.searchParams.append('pin', pinInput.value);
    }
    
    const verifySelect = document.querySelector('select[name="verify"]');
    if (verifySelect && verifySelect.value) {
        url.searchParams.append('verify', verifySelect.value);
    }
    
    const statusSelect = document.querySelector('select[name="status"]');
    if (statusSelect && statusSelect.value) {
        url.searchParams.append('status', statusSelect.value);
    }
    
    const startDateInput = document.querySelector('input[name="start_date"]');
    if (startDateInput && startDateInput.value) {
        url.searchParams.append('start_date', startDateInput.value);
    }
    
    const endDateInput = document.querySelector('input[name="end_date"]');
    if (endDateInput && endDateInput.value) {
        url.searchParams.append('end_date', endDateInput.value);
    }
    
    fetch(url)
        .then(response => response.json())
        .then(result => {
            if (result.success && result.data.length > 0) {
                // Update last ID
                lastAttlogId = result.last_id;
                
                // Add new rows to table
                const tbody = document.querySelector('tbody');
                const emptyRow = tbody.querySelector('tr td[colspan]');
                
                if (emptyRow) {
                    // Remove empty row if exists
                    emptyRow.closest('tr').remove();
                }
                
                // Add new rows at the top
                result.data.forEach(attlog => {
                    const newRow = createAttlogRow(attlog, tbody.children.length + 1);
                    tbody.insertBefore(newRow, tbody.firstChild);
                });
                
                // Update row numbers
                updateRowNumbers();
                
                // Update total count
                const totalBadge = document.querySelector('.total-badge');
                if (totalBadge) {
                    const currentTotal = parseInt(totalBadge.textContent.replace('Total: ', ''));
                    totalBadge.textContent = 'Total: ' + (currentTotal + result.data.length);
                }
                
                // Show notification
                showNewDataNotification(result.data.length);
            }
        })
        .catch(error => {
            console.error('Error fetching new attlogs:', error);
        });
}

// Create attlog row HTML
function createAttlogRow(attlog, index) {
    const tr = document.createElement('tr');
    
    const verifyMethods = {
        1: {icon: 'fa-fingerprint', label: 'Sidik Jari', color: '#6366F1'},
        2: {icon: 'fa-key', label: 'Password', color: '#F59E0B'},
        3: {icon: 'fa-id-card', label: 'Kartu', color: '#10B981'},
        4: {icon: 'fa-face-smile', label: 'Wajah', color: '#EC4899'},
        6: {icon: 'fa-hand', label: 'Telapak Tangan', color: '#8B5CF6'},
    };
    const verify = verifyMethods[attlog.verify] || {icon: 'fa-question', label: 'Unknown', color: '#6B7280'};
    
    const statusClass = attlog.status === 'check-in' ? 'badge-modern-success' : 'badge-modern-danger';
    const scanTime = new Date(attlog.scan_time).toLocaleString('en-GB', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
    });
    
    const photoLink = attlog.photo_url ? 
        `<a href="${attlog.photo_url}" target="_blank" class="ms-1" title="Lihat foto">
            <i class="fas fa-camera" style="color: #6366F1; font-size: 0.75rem;"></i>
        </a>` : '';
    
    tr.innerHTML = `
        <td>${index}</td>
        <td>
            <span class="mono-code">${attlog.pin}</span>
            ${photoLink}
        </td>
        <td>${scanTime}</td>
        <td>
            <span style="color: ${verify.color}; font-size: 0.8rem; font-weight: 500;">
                <i class="fas ${verify.icon}"></i> ${verify.label}
            </span>
        </td>
        <td>
            <span class="${statusClass}">
                ${attlog.status}
            </span>
        </td>
        <td>
            <a href="/attlogs/${attlog.id}" class="btn-modern btn-modern-info">
                <i class="fas fa-eye"></i>
            </a>
        </td>
    `;
    
    // Add animation class
    tr.style.animation = 'fadeIn 0.5s ease-in';
    
    return tr;
}

// Update row numbers
function updateRowNumbers() {
    const rows = document.querySelectorAll('tbody tr');
    rows.forEach((row, index) => {
        const firstCell = row.querySelector('td:first-child');
        if (firstCell) {
            firstCell.textContent = index + 1;
        }
    });
}

// Check device status
function checkDeviceStatus() {
    fetch('{{ route("realtime.device-status") }}')
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                updateDeviceStatusUI(result.devices);
            }
        })
        .catch(error => {
            console.error('Error checking device status:', error);
        });
}

// Update device status UI
function updateDeviceStatusUI(devices) {
    const container = document.getElementById('deviceStatusContainer');
    if (!container) return;
    
    container.innerHTML = devices.map(device => {
        const statusClass = device.online ? 'device-status-online' : 'device-status-offline';
        const statusText = device.online ? '🟢 Online' : '🔴 Offline';
        
        return `
            <div class="${statusClass}" title="${device.device_name} (${device.pin})">
                <span class="device-status-dot"></span>
                <span style="font-size: 0.7rem;">${device.pin}</span>
            </div>
        `;
    }).join('');
}

// Show new data notification
function showNewDataNotification(count) {
    // Create a simple toast notification
    const toast = document.createElement('div');
    toast.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: #059669;
        color: white;
        padding: 12px 20px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        z-index: 9999;
        animation: slideIn 0.3s ease-out;
        font-size: 0.9rem;
        font-weight: 500;
    `;
    toast.innerHTML = `✅ ${count} data absensi baru masuk`;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.animation = 'slideOut 0.3s ease-in';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes slideOut {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }
`;
document.head.appendChild(style);

// Start monitoring when page loads
document.addEventListener('DOMContentLoaded', function() {
    startRealtimeMonitoring();
});

// Stop monitoring when page is hidden
document.addEventListener('visibilitychange', function() {
    if (document.hidden) {
        stopRealtimeMonitoring();
    } else {
        startRealtimeMonitoring();
    }
});

// Clean up on page unload
window.addEventListener('beforeunload', function() {
    stopRealtimeMonitoring();
});
</script>

@endsection