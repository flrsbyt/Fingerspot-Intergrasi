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
</style>

<!-- Header -->
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 dash-header">
    <h3 class="m-0">📊 Dashboard</h3>
    <span class="mono-code" style="font-size:0.7rem;">
        <i class="fa-regular fa-clock me-1"></i> {{ now()->format('d M Y H:i') }}
    </span>
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
                            <th class="text-end">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($latestAttlogs as $log)
                        <tr>
                            <td><span class="mono-code">{{ $log->pin }}</span></td>
                            <td class="text-muted-soft">{{ $log->scan_time->format('d M H:i') }}</td>
                            <td class="text-end">
                                <span class="badge {{ $log->status == 'check-in' ? 'badge-soft-success' : 'badge-soft-danger' }}">
                                    {{ $log->status }}
                                </span>
                            </td>
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
@endsection