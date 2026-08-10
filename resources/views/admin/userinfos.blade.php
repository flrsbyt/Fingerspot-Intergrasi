@extends('layouts.admin')

@section('title', 'Data Userinfo')

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
    
    .btn-modern-success {
        background: #10B981;
        color: #FFFFFF;
    }
    .btn-modern-success:hover {
        background: #059669;
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
    
    .btn-modern-danger {
        background: #EF4444;
        color: #FFFFFF;
        padding: 8px 16px;
        font-size: 0.8rem;
        border-radius: 6px;
        min-width: 32px;
        min-height: 32px;
    }
    .btn-modern-danger:hover {
        background: #DC2626;
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
    <h1 class="h4 m-0">👤 Manajemen Karyawan</h1>
    <div class="header-right">
        <span class="total-badge">Total: {{ $userinfos->total() }}</span>
        <button type="button" class="reload-badge" onclick="syncUserinfo(this)">
            <i class="fas fa-sync-alt"></i> Reload
        </button>
    </div>
</div>

<!-- Command Panel -->
<div class="command-panel mb-4">
    <div class="row g-3 align-items-end">
        <div class="col-md-12">
            <form method="GET" class="row g-2">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control form-control-modern" placeholder="Cari nama, PIN" value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <select name="department" class="form-control form-control-modern">
                        <option value="">Semua Dept</option>
                        @php
                            $deptList = ['IT', 'HR', 'Finance', 'Marketing', 'Operations'];
                        @endphp
                        @foreach($deptList as $dept)
                            <option value="{{ $dept }}" {{ request('department') == $dept ? 'selected' : '' }}>
                                {{ $dept }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="position" class="form-control form-control-modern">
                        <option value="">Semua Position</option>
                        @php
                            $posList = ['Staff', 'Senior Staff', 'Supervisor', 'Manager'];
                        @endphp
                        @foreach($posList as $pos)
                            <option value="{{ $pos }}" {{ request('position') == $pos ? 'selected' : '' }}>
                                {{ $pos }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn-modern btn-modern-primary w-100">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                </div>
                <div class="col-md-1">
                    <a href="{{ route('userinfos.index') }}" class="btn-modern btn-modern-outline w-100" title="Reset Filter">
                        <i class="fas fa-undo"></i>
                    </a>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn-modern btn-modern-success w-100" data-bs-toggle="modal" data-bs-target="#tambahKaryawanModal">
                        <i class="fas fa-user-plus"></i> Tambah
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Tambah Karyawan -->
<div class="modal fade modal-modern" id="tambahKaryawanModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('command.set-userinfo') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">➕ Tambah Karyawan ke Mesin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label form-label-modern">Mesin Absensi *</label>
                        <select name="device" class="form-control form-control-modern" required>
                            <option value="">-- Pilih Mesin --</option>
                            @php
                                $devices = App\Models\Pin::where('is_active', true)->get();
                            @endphp
                            @foreach($devices as $device)
                                <option value="{{ $device->pin }}">{{ $device->device_name }} ({{ $device->pin }})</option>
                            @endforeach
                        </select>
                        <small class="text-muted" style="font-size: 0.75rem;">Pilih mesin absensi tempat karyawan akan ditambahkan</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label form-label-modern">PIN Karyawan *</label>
                        <input type="text" name="pin" class="form-control form-control-modern" placeholder="Contoh: 1010007" required>
                        <small class="text-muted" style="font-size: 0.75rem;">ID unik untuk karyawan (biasanya dari sistem HR)</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label form-label-modern">Nama Lengkap *</label>
                        <input type="text" name="name" class="form-control form-control-modern" placeholder="Nama lengkap karyawan" required>
                        <small class="text-muted" style="font-size: 0.75rem;">Nama yang akan tampil di mesin absensi</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modern btn-modern-outline" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-modern btn-modern-success">
                        <i class="fas fa-upload"></i> Kirim ke Mesin
                    </button>
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
                    <th>Nama</th>
                    <th>Department</th>
                    <th>Position</th>
                    <th style="width: 120px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($userinfos as $user)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><span class="mono-code">{{ $user->pin }}</span></td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->department ?? '-' }}</td>
                    <td>{{ $user->position ?? '-' }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('userinfos.show', $user->id) }}" class="btn-modern btn-modern-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <button type="button" class="btn-modern btn-modern-danger" onclick="hapusUser(this, '{{ $user->pin }}')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        <i class="fa-regular fa-database me-2"></i> Belum ada data karyawan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- PAGINATION -->
@if ($userinfos->hasPages())
<div class="pagination-wrapper-custom">
    <div class="pagination-info-custom">
        <span>
            Menampilkan 
            <strong>{{ $userinfos->firstItem() }}</strong> 
            - 
            <strong>{{ $userinfos->lastItem() }}</strong> 
            dari 
            <strong>{{ $userinfos->total() }}</strong> 
            data
        </span>
    </div>
    <nav>
        <ul class="pagination-custom">
            @if ($userinfos->onFirstPage())
                <li class="page-item-custom disabled"><span class="page-link-custom"><i class="fas fa-chevron-left"></i></span></li>
            @else
                <li class="page-item-custom"><a class="page-link-custom" href="{{ $userinfos->previousPageUrl() }}"><i class="fas fa-chevron-left"></i></a></li>
            @endif

            @php
                $start = max(1, $userinfos->currentPage() - 2);
                $end = min($userinfos->lastPage(), $userinfos->currentPage() + 2);
                if ($start > 1) {
                    echo '<li class="page-item-custom"><a class="page-link-custom" href="' . $userinfos->url(1) . '">1</a></li>';
                    if ($start > 2) echo '<li class="page-item-custom disabled"><span class="page-link-custom">…</span></li>';
                }
                for ($i = $start; $i <= $end; $i++) {
                    $active = $i == $userinfos->currentPage() ? 'active' : '';
                    echo '<li class="page-item-custom ' . $active . '"><a class="page-link-custom" href="' . $userinfos->url($i) . '">' . $i . '</a></li>';
                }
                if ($end < $userinfos->lastPage()) {
                    if ($end < $userinfos->lastPage() - 1) echo '<li class="page-item-custom disabled"><span class="page-link-custom">…</span></li>';
                    echo '<li class="page-item-custom"><a class="page-link-custom" href="' . $userinfos->url($userinfos->lastPage()) . '">' . $userinfos->lastPage() . '</a></li>';
                }
            @endphp

            @if ($userinfos->hasMorePages())
                <li class="page-item-custom"><a class="page-link-custom" href="{{ $userinfos->nextPageUrl() }}"><i class="fas fa-chevron-right"></i></a></li>
            @else
                <li class="page-item-custom disabled"><span class="page-link-custom"><i class="fas fa-chevron-right"></i></span></li>
            @endif
        </ul>
    </nav>
</div>
@endif

<!-- Form untuk Sync (hidden) -->
<form action="{{ route('command.get-userinfo') }}" method="POST" id="syncUserinfoForm" style="display:none;">
    @csrf
</form>

<script>
function syncUserinfo(btn) {
    const form = document.getElementById('syncUserinfoForm');
    const formData = new FormData(form);
    const data = Object.fromEntries(formData);
    
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Loading...';
    
    fetch('{{ route("command.get-userinfo") }}', {
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
        btn.innerHTML = '<i class="fas fa-sync-alt"></i> Reload';
    });
}

function hapusUser(btn, pin) {
    if (!confirm(`Yakin hapus user dengan PIN ${pin} dari mesin?`)) return;
    
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
    
    fetch('{{ route("command.delete-userinfo") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        body: JSON.stringify({ pin: pin })
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
        btn.innerHTML = '<i class="fas fa-trash"></i>';
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