@extends('layouts.admin')

@section('title', 'Command Logs')

@section('content')
<style>
    /* Modern Admin Page Styles matching dashboard */
    .page-header h1 {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700;
        color: #0B0F19;
        letter-spacing: -0.01em;
    }
    
    .page-header .total-badge {
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.8rem;
        background: #F3F4FF;
        color: #6366F1;
        padding: 6px 12px;
        border-radius: 100px;
        font-weight: 500;
    }
    
    /* Command Panel Card */
    .command-panel {
        background: linear-gradient(135deg, #FFFFFF 0%, #FAFAFC 100%);
        border: 1px solid #E6E8EC;
        border-radius: 14px;
        padding: 20px 24px;
    }
    
    /* Modern Buttons */
    .btn-modern {
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 500;
        font-size: 0.85rem;
        transition: all 0.2s ease-in-out;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        white-space: nowrap;
        min-height: 42px;
    }
    
    .btn-modern-primary {
        background: #6366F1;
        color: #FFFFFF;
        border: none;
    }
    
    .btn-modern-primary:hover {
        background: #4F46E5;
        transform: translateY(-1px);
    }
    
    /* Modern Table */
    .table-modern {
        background: #FFFFFF;
        border: 1px solid #E6E8EC;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        border-bottom: none;
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
        position: sticky;
        top: 0;
        z-index: 10;
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
        vertical-align: middle;
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
        padding: 3px 8px;
        border-radius: 4px;
    }
    
    .form-control-modern {
        border: 1px solid #E6E8EC;
        border-radius: 8px;
        padding: 10px 14px;
        font-size: 0.9rem;
        transition: all 0.2s ease-in-out;
    }
    
    .form-control-modern:focus {
        border-color: #9FA1FF;
        box-shadow: 0 0 0 3px rgba(159, 161, 255, 0.1);
    }
    
    .form-select-modern {
        border: 1px solid #E6E8EC;
        border-radius: 8px;
        padding: 10px 14px;
        font-size: 0.9rem;
        transition: all 0.2s ease-in-out;
    }
    
    .form-select-modern:focus {
        border-color: #9FA1FF;
        box-shadow: 0 0 0 3px rgba(159, 161, 255, 0.1);
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
    
    /* Pagination Styling */
    .pagination .page-link {
        border: 1px solid #E6E8EC;
        color: #6366F1;
        padding: 8px 14px;
        border-radius: 6px;
        margin: 0 2px;
        font-size: 0.85rem;
        transition: all 0.2s ease-in-out;
    }
    
    .pagination .page-link:hover {
        background: #F3F4FF;
        border-color: #6366F1;
        color: #4F46E5;
    }
    
    .pagination .page-item.active .page-link {
        background: #6366F1;
        border-color: #6366F1;
        color: #FFFFFF;
    }
    
    .pagination .page-item.disabled .page-link {
        color: #9CA3AF;
        border-color: #E6E8EC;
        background: #FAFAFC;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4 page-header">
    <h1 class="h4 m-0">Command Logs</h1>
    <span class="total-badge">Total: {{ $commandLogs->total() }}</span>
</div>

<!-- Filter -->
<div class="command-panel mb-4">
    <form method="GET" class="row g-3">
        <div class="col-md-4">
            <input type="text" name="command" class="form-control form-control-modern" placeholder="Cari command" value="{{ request('command') }}">
        </div>
        <div class="col-md-4">
            <select name="status" class="form-select form-select-modern">
                <option value="">Semua Status</option>
                <option value="executed" {{ request('status') == 'executed' ? 'selected' : '' }}>Executed</option>
                <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
            </select>
        </div>
        <div class="col-md-4">
            <button type="submit" class="btn-modern btn-modern-primary w-100">
                <i class="fas fa-search"></i> Filter
            </button>
        </div>
    </form>
</div>

<div class="table-modern">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Command</th>
                    <th>Status</th>
                    <th>Message</th>
                    <th>Waktu</th>
                </tr>
            </thead>
            <tbody>
                @forelse($commandLogs as $log)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><span class="mono-code">{{ $log->command }}</span></td>
                    <td>
                        <span class="{{ $log->status == 'executed' ? 'badge-modern-success' : 'badge-modern-danger' }}">
                            {{ $log->status }}
                        </span>
                    </td>
                    <td>{{ $log->message ?? '-' }}</td>
                    <td>{{ $log->created_at->diffForHumans() }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4" style="font-size: 0.9rem;">Belum ada data</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4 d-flex justify-content-center">
    {{ $commandLogs->links() }}
</div>
@endsection