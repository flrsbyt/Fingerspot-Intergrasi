@extends('layouts.admin')

@section('title', 'SyncAttendance Dashboard')

@section('content')
<!-- Font & Style -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700&family=Inter:wght@400;500&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

<style>
    body {
        font-family: 'Inter', sans-serif;
        background: #FAFAFC;
    }
    
    .dash-header h3 {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700;
        color: #0B0F19;
    }
    
    /* Stat Cards */
    .stat-card-elegant {
        background: #FFFFFF;
        border: 1px solid #E6E8EC;
        border-radius: 14px;
        padding: 20px 24px;
        position: relative;
        transition: all 0.3s;
        height: 100%;
    }
    
    .stat-card-elegant:hover {
        border-color: #9FA1FF;
        box-shadow: 0 8px 30px rgba(159, 161, 255, 0.10);
        transform: translateY(-3px);
    }
    
    .stat-card-elegant .stat-number {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 2rem;
        font-weight: 700;
        color: #0B0F19;
        margin: 0;
    }
    
    .stat-card-elegant .stat-label {
        font-size: 0.78rem;
        color: #6B7280;
        font-weight: 500;
        margin-top: 2px;
    }
    
    .stat-card-elegant .stat-icon {
        position: absolute;
        right: 16px;
        top: 16px;
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: #F3F4FF;
        color: #6366F1;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
    }
    
    /* Sub Stat Cards */
    .sub-stat-card {
        background: #FFFFFF;
        border: 1px solid #E6E8EC;
        border-radius: 12px;
        padding: 16px 20px;
        transition: all 0.3s;
        height: 100%;
    }
    
    .sub-stat-card:hover {
        border-color: #9FA1FF;
        box-shadow: 0 6px 20px rgba(159, 161, 255, 0.08);
    }
    
    .sub-stat-card .sub-number {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 1.5rem;
        font-weight: 700;
        color: #0B0F19;
        margin: 0;
    }
    
    .sub-stat-card .sub-label {
        font-size: 0.75rem;
        color: #6B7280;
        font-weight: 500;
    }
    
    /* Card Umum */
    .dashboard-card {
        background: #FFFFFF;
        border: 1px solid #E6E8EC;
        border-radius: 14px;
        padding: 20px 24px;
        transition: all 0.3s;
        height: 100%;
    }
    
    .dashboard-card:hover {
        border-color: #E0E4E8;
        box-shadow: 0 8px 24px rgba(0,0,0,0.04);
    }
    
    .card-title-elegant {
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #6B7280;
        margin-bottom: 14px;
    }
    
    /* Table */
    .table-elegant {
        font-size: 0.82rem;
        margin-bottom: 0;
    }
    
    .table-elegant thead th {
        font-size: 0.65rem;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: #6B7280;
        font-weight: 600;
        border-bottom: 1px solid #E6E8EC;
        padding: 8px 0;
        background: transparent;
    }
    
    .table-elegant tbody td {
        padding: 8px 0;
        border-bottom: 1px solid #F3F4F6;
        vertical-align: middle;
        color: #1F2937;
    }
    
    .table-elegant tbody tr:hover td {
        background: #FAFAFC;
    }
    
    .table-elegant tbody tr:last-child td {
        border-bottom: none;
    }
    
    .mono-code {
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.7rem;
        background: #F3F4FF;
        color: #6366F1;
        padding: 2px 8px;
        border-radius: 4px;
    }
    
    .badge-soft-success {
        background: #ECFDF5;
        color: #059669;
        font-weight: 500;
        font-size: 0.6rem;
        padding: 3px 10px;
        border-radius: 100px;
    }
    
    .badge-soft-danger {
        background: #FEF2F2;
        color: #DC2626;
        font-weight: 500;
        font-size: 0.6rem;
        padding: 3px 10px;
        border-radius: 100px;
    }
    
    .badge-soft-warning {
        background: #FFFBEB;
        color: #D97706;
        font-weight: 500;
        font-size: 0.6rem;
        padding: 3px 10px;
        border-radius: 100px;
    }
    
    .text-muted-soft {
        color: #9CA3AF;
        font-size: 0.75rem;
    }
    
    /* Device Status */
    .device-status-card {
        background: #FFFFFF;
        border: 1px solid #E6E8EC;
        border-radius: 12px;
        padding: 16px 20px;
        transition: all 0.3s;
        height: 100%;
    }
    
    .device-status-card:hover {
        border-color: #9FA1FF;
        box-shadow: 0 6px 20px rgba(159, 161, 255, 0.08);
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
    
    /* Verify Methods */
    .verify-method-bar {
        height: 8px;
        border-radius: 4px;
        background: #E5E7EB;
        overflow: hidden;
    }
    
    .verify-method-fill {
        height: 100%;
        border-radius: 4px;
        transition: width 0.5s ease;
    }
    
    /* Realtime Indicator */
    .realtime-badge {
        font-size: 0.7rem;
        color: #6B7280;
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        background: #F3F4F6;
        border-radius: 100px;
    }
    
    .realtime-badge.active {
        color: #059669;
        background: #ECFDF5;
    }
    
    .realtime-badge .dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #6B7280;
    }
    
    .realtime-badge.active .dot {
        background: #059669;
        animation: pulse-green 2s infinite;
    }
</style>

<!-- Header -->
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 dash-header">
    <div>
        <h3 class="m-0">📊 Dashboard</h3>
        <div class="realtime-badge mt-2" id="realtimeIndicator">
            <span class="dot"></span>
            <span id="realtimeStatus">Checking...</span>
        </div>
    </div>
    <div class="d-flex align-items-center gap-3">
        <span class="mono-code" style="font-size:0.7rem;">
            <i class="fa-regular fa-clock me-1"></i> {{ now()->format('d M Y H:i') }}
        </span>
    </div>
</div>

<!-- Statistik Cards Utama -->
<div class="row g-3 mb-4">
    <div class="col-md-3 col-sm-6">
        <div class="stat-card-elegant">
            <div class="stat-icon"><i class="fas fa-users"></i></div>
            <div class="stat-number">{{ $totalKaryawan }}</div>
            <div class="stat-label">Total Personil</div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card-elegant">
            <div class="stat-icon"><i class="fa-regular fa-calendar-check"></i></div>
            <div class="stat-number">{{ $totalAbsensi }}</div>
            <div class="stat-label">Total Log Absensi</div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card-elegant">
            <div class="stat-icon"><i class="fas fa-key"></i></div>
            <div class="stat-number">{{ $totalPin }}</div>
            <div class="stat-label">Kredensial Terdaftar</div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card-elegant">
            <div class="stat-icon"><i class="fas fa-code"></i></div>
            <div class="stat-number">{{ $totalApiRequests }}</div>
            <div class="stat-label">API Request</div>
        </div>
    </div>
</div>

<!-- Device Status -->
<div class="row g-3 mb-4">
    @foreach($deviceStatus as $device)
    <div class="col-md-4 col-sm-6">
        <div class="device-status-card">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div>
                    <div style="font-size:0.75rem; font-weight:600; color:#374151;">{{ $device['device_name'] }}</div>
                    <div class="mono-code" style="font-size:0.7rem; color:#6B7280;">{{ $device['pin'] }}</div>
                </div>
                <div class="{{ $device['online'] ? 'device-status-online' : 'device-status-offline' }}">
                    <span class="device-status-dot"></span>
                    <span>{{ $device['online'] ? 'Online' : 'Offline' }}</span>
                </div>
            </div>
            <div style="font-size:0.7rem; color:#9CA3AF;">
                Last checked: {{ $device['last_checked'] }}
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Verification Methods Stats -->
<div class="row g-3 mb-4">
    <div class="col-md-12">
        <div class="dashboard-card">
            <div class="card-title-elegant"><i class="fa-solid fa-fingerprint me-2"></i>Metode Verifikasi</div>
            <div class="row g-3">
                <div class="col-md-2 col-4">
                    <div class="text-center">
                        <div style="font-size:1.2rem; font-weight:700; color:#6366F1;">{{ $verifyStats['fingerprint'] }}</div>
                        <div style="font-size:0.7rem; color:#6B7280;">👆 Sidik Jari</div>
                        <div class="verify-method-bar mt-2">
                            <div class="verify-method-fill" style="width: {{ $totalAbsensi > 0 ? ($verifyStats['fingerprint'] / $totalAbsensi * 100) : 0 }}%; background: #6366F1;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-4">
                    <div class="text-center">
                        <div style="font-size:1.2rem; font-weight:700; color:#F59E0B;">{{ $verifyStats['password'] }}</div>
                        <div style="font-size:0.7rem; color:#6B7280;">🔑 Password</div>
                        <div class="verify-method-bar mt-2">
                            <div class="verify-method-fill" style="width: {{ $totalAbsensi > 0 ? ($verifyStats['password'] / $totalAbsensi * 100) : 0 }}%; background: #F59E0B;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-4">
                    <div class="text-center">
                        <div style="font-size:1.2rem; font-weight:700; color:#10B981;">{{ $verifyStats['card'] }}</div>
                        <div style="font-size:0.7rem; color:#6B7280;">💳 Kartu</div>
                        <div class="verify-method-bar mt-2">
                            <div class="verify-method-fill" style="width: {{ $totalAbsensi > 0 ? ($verifyStats['card'] / $totalAbsensi * 100) : 0 }}%; background: #10B981;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-4">
                    <div class="text-center">
                        <div style="font-size:1.2rem; font-weight:700; color:#EC4899;">{{ $verifyStats['face'] }}</div>
                        <div style="font-size:0.7rem; color:#6B7280;">😊 Wajah</div>
                        <div class="verify-method-bar mt-2">
                            <div class="verify-method-fill" style="width: {{ $totalAbsensi > 0 ? ($verifyStats['face'] / $totalAbsensi * 100) : 0 }}%; background: #EC4899;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-4">
                    <div class="text-center">
                        <div style="font-size:1.2rem; font-weight:700; color:#8B5CF6;">{{ $verifyStats['palm'] }}</div>
                        <div style="font-size:0.7rem; color:#6B7280;">🤚 Telapak Tangan</div>
                        <div class="verify-method-bar mt-2">
                            <div class="verify-method-fill" style="width: {{ $totalAbsensi > 0 ? ($verifyStats['palm'] / $totalAbsensi * 100) : 0 }}%; background: #8B5CF6;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-4">
                    <div class="text-center">
                        <div style="font-size:1.2rem; font-weight:700; color:#6B7280;">{{ $totalAbsensi - array_sum($verifyStats) }}</div>
                        <div style="font-size:0.7rem; color:#6B7280;">❓ Lainnya</div>
                        <div class="verify-method-bar mt-2">
                            <div class="verify-method-fill" style="width: {{ $totalAbsensi > 0 ? (($totalAbsensi - array_sum($verifyStats)) / $totalAbsensi * 100) : 0 }}%; background: #6B7280;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistik Sekunder -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="sub-stat-card d-flex justify-content-between align-items-center">
            <div>
                <div class="sub-label">📥 Webhook Diterima</div>
                <div class="sub-number">{{ $totalWebhookLogs }}</div>
            </div>
            <i class="fa-solid fa-satellite-dish text-muted opacity-50"></i>
        </div>
    </div>
    <div class="col-md-4">
        <div class="sub-stat-card d-flex justify-content-between align-items-center">
            <div>
                <div class="sub-label">📋 Command Eksekusi</div>
                <div class="sub-number">{{ $totalCommandLogs }}</div>
            </div>
            <i class="fa-solid fa-terminal text-muted opacity-50"></i>
        </div>
    </div>
    <div class="col-md-4">
        <div class="sub-stat-card d-flex justify-content-between align-items-center">
            <div>
                <div class="sub-label">📌 Absensi Hari Ini</div>
                <div class="sub-number" style="color:#6366F1;">{{ $absensiHariIni }}</div>
            </div>
            <i class="fa-regular fa-clock text-muted opacity-50"></i>
        </div>
    </div>
</div>

<!-- Grafik -->
<div class="row g-3 mb-4">
    <div class="col-md-12">
        <div class="dashboard-card">
            <div class="card-title-elegant"><i class="fa-solid fa-chart-line me-2"></i>Tren Absensi (7 Hari Terakhir)</div>
            <canvas id="attlogChart" height="80"></canvas>
        </div>
    </div>
</div>

<!-- Tabel Terbaru -->
<div class="row g-3">
    <div class="col-md-6">
        <div class="dashboard-card">
            <div class="card-title-elegant"><i class="fa-regular fa-clock me-2"></i>Absensi Terbaru</div>
            <div class="table-responsive">
                <table class="table table-elegant">
                    <thead>
                        <tr>
                            <th>PIN</th>
                            <th>Waktu</th>
                            <th>Metode</th>
                            <th class="text-end">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($latestAttlogs as $log)
                        <tr>
                            <td>
                                <span class="mono-code">{{ $log->pin }}</span>
                                @if($log->photo_url)
                                <a href="{{ $log->photo_url }}" target="_blank" class="ms-1" title="Lihat foto">
                                    <i class="fas fa-camera" style="color: #6366F1; font-size: 0.7rem;"></i>
                                </a>
                                @endif
                            </td>
                            <td class="text-muted-soft">{{ $log->scan_time->format('d M H:i') }}</td>
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
                                <span style="color: {{ $verify['color'] }}; font-size: 0.75rem; font-weight: 500;">
                                    <i class="fas {{ $verify['icon'] }}"></i> {{ $verify['label'] }}
                                </span>
                            </td>
                            <td class="text-end">
                                <span class="badge {{ $log->status == 'check-in' ? 'badge-soft-success' : 'badge-soft-danger' }}">
                                    {{ $log->status }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-3" style="font-size:0.85rem;">Belum ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="dashboard-card">
            <div class="card-title-elegant"><i class="fa-solid fa-code-branch me-2"></i>API Request Terbaru</div>
            <div class="table-responsive">
                <table class="table table-elegant">
                    <thead>
                        <tr>
                            <th>Command</th>
                            <th class="text-center">Status</th>
                            <th class="text-end">Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($latestApiRequests as $req)
                        <tr>
                            <td><span class="mono-code">{{ $req->command }}</span></td>
                            <td class="text-center">
                                <span class="badge {{ $req->status == 'success' ? 'badge-soft-success' : ($req->status == 'pending' ? 'badge-soft-warning' : 'badge-soft-danger') }}">
                                    {{ $req->status }}
                                </span>
                            </td>
                            <td class="text-end text-muted-soft">{{ $req->created_at->diffForHumans() }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-3" style="font-size:0.85rem;">Belum ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('attlogChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                label: 'Jumlah Absensi',
                data: @json($chartData),
                backgroundColor: 'rgba(159, 161, 255, 0.08)',
                borderColor: '#9FA1FF',
                borderWidth: 2,
                tension: 0.2,
                fill: true,
                pointBackgroundColor: '#9FA1FF',
                pointBorderColor: '#fff',
                pointBorderWidth: 1.5,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { 
                        color: '#6B7280', 
                        font: { family: 'JetBrains Mono', size: 10 } 
                    }
                },
                y: {
                    border: { dash: [4, 4] },
                    grid: { color: '#F3F4F6' },
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        color: '#6B7280',
                        font: { size: 10 }
                    }
                }
            }
        }
    });
});
</script>

<!-- Realtime Dashboard Script -->
<script>
let dashboardInterval = null;
let isRealtimeActive = false;

// Start realtime monitoring for dashboard
function startDashboardRealtime() {
    if (isRealtimeActive) return;
    
    isRealtimeActive = true;
    updateRealtimeIndicator(true);
    
    // Update stats every 30 seconds
    dashboardInterval = setInterval(() => {
        updateDashboardStats();
    }, 30000);
    
    // Initial update
    updateDashboardStats();
}

// Stop realtime monitoring
function stopDashboardRealtime() {
    isRealtimeActive = false;
    updateRealtimeIndicator(false);
    
    if (dashboardInterval) {
        clearInterval(dashboardInterval);
        dashboardInterval = null;
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

// Update dashboard stats
function updateDashboardStats() {
    fetch('{{ route("realtime.system-stats") }}')
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                // Update stat cards if needed
                // For now, we'll just update the indicator to show it's working
                console.log('Dashboard stats updated:', result.stats);
            }
        })
        .catch(error => {
            console.error('Error updating dashboard stats:', error);
        });
}

// Start monitoring when page loads
document.addEventListener('DOMContentLoaded', function() {
    startDashboardRealtime();
});

// Stop monitoring when page is hidden
document.addEventListener('visibilitychange', function() {
    if (document.hidden) {
        stopDashboardRealtime();
    } else {
        startDashboardRealtime();
    }
});

// Clean up on page unload
window.addEventListener('beforeunload', function() {
    stopDashboardRealtime();
});
</script>

@endsection