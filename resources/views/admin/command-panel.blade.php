@extends('layouts.admin')

@section('title', 'Command Panel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">⚡ Command Panel</h1>
    <span class="text-muted">Kirim perintah ke mesin Fingerspot</span>
</div>

@if(session('message'))
    <div class="alert alert-info alert-dismissible fade show">
        {{ session('message') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row g-3">
    <!-- 1. Get Attlog -->
    <div class="col-md-6 col-lg-4">
        <div class="card p-3">
            <h6 class="text-muted">📥 Get Attlog</h6>
            <p class="small text-muted">Ambil data absensi dari mesin</p>
            <form action="{{ route('command.get-attlog') }}" method="POST">
                @csrf
                <div class="row g-2">
                    <div class="col-6">
                        <input type="date" name="start_date" class="form-control form-control-sm" value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="col-6">
                        <input type="date" name="end_date" class="form-control form-control-sm" value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="col-12">
                        <input type="text" name="pin" class="form-control form-control-sm" placeholder="PIN (kosongkan untuk semua)">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-sm w-100 mt-2">
                    <i class="fas fa-download"></i> Ambil Data
                </button>
            </form>
        </div>
    </div>

    <!-- 2. Get Userinfo -->
    <div class="col-md-6 col-lg-4">
        <div class="card p-3">
            <h6 class="text-muted">👤 Get Userinfo</h6>
            <p class="small text-muted">Ambil data user dari mesin</p>
            <form action="{{ route('command.get-userinfo') }}" method="POST">
                @csrf
                <input type="text" name="pin" class="form-control form-control-sm" placeholder="PIN (kosongkan untuk semua)">
                <button type="submit" class="btn btn-primary btn-sm w-100 mt-2">
                    <i class="fas fa-users"></i> Ambil User
                </button>
            </form>
        </div>
    </div>

    <!-- 3. Set Userinfo -->
    <div class="col-md-6 col-lg-4">
        <div class="card p-3">
            <h6 class="text-muted">➕ Set Userinfo</h6>
            <p class="small text-muted">Kirim data user ke mesin</p>
            <form action="{{ route('command.set-userinfo') }}" method="POST">
                @csrf
                <input type="text" name="pin" class="form-control form-control-sm mb-1" placeholder="PIN *" required>
                <input type="text" name="name" class="form-control form-control-sm mb-1" placeholder="Nama *" required>
                <input type="text" name="department" class="form-control form-control-sm mb-1" placeholder="Department">
                <input type="text" name="position" class="form-control form-control-sm mb-1" placeholder="Position">
                <input type="text" name="card_number" class="form-control form-control-sm mb-1" placeholder="Card Number">
                <button type="submit" class="btn btn-success btn-sm w-100 mt-2">
                    <i class="fas fa-upload"></i> Kirim User
                </button>
            </form>
        </div>
    </div>

    <!-- 4. Delete Userinfo -->
    <div class="col-md-6 col-lg-4">
        <div class="card p-3">
            <h6 class="text-muted">🗑️ Delete Userinfo</h6>
            <p class="small text-muted">Hapus data user dari mesin</p>
            <form action="{{ route('command.delete-userinfo') }}" method="POST">
                @csrf
                <input type="text" name="pin" class="form-control form-control-sm" placeholder="PIN *" required>
                <button type="submit" class="btn btn-danger btn-sm w-100 mt-2">
                    <i class="fas fa-trash"></i> Hapus User
                </button>
            </form>
        </div>
    </div>

    <!-- 5. Get All PIN -->
    <div class="col-md-6 col-lg-4">
        <div class="card p-3">
            <h6 class="text-muted">🔑 Get All PIN</h6>
            <p class="small text-muted">Ambil semua User ID dari mesin</p>
            <form action="{{ route('command.get-all-pin') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary btn-sm w-100">
                    <i class="fas fa-key"></i> Ambil PIN
                </button>
            </form>
        </div>
    </div>

    <!-- 6. Set Time -->
    <div class="col-md-6 col-lg-4">
        <div class="card p-3">
            <h6 class="text-muted">🕐 Set Time</h6>
            <p class="small text-muted">Ubah waktu/timezone mesin</p>
            <form action="{{ route('command.set-time') }}" method="POST">
                @csrf
                <input type="datetime-local" name="timezone" class="form-control form-control-sm" value="{{ date('Y-m-d\TH:i') }}">
                <button type="submit" class="btn btn-warning btn-sm w-100 mt-2">
                    <i class="fas fa-clock"></i> Set Time
                </button>
            </form>
        </div>
    </div>

    <!-- 7. Register Online -->
    <div class="col-md-6 col-lg-4">
        <div class="card p-3">
            <h6 class="text-muted">📝 Register Online</h6>
            <p class="small text-muted">Registrasi user ke mesin</p>
            <form action="{{ route('command.register-online') }}" method="POST">
                @csrf
                <input type="text" name="pin" class="form-control form-control-sm mb-1" placeholder="PIN *" required>
                <input type="text" name="name" class="form-control form-control-sm mb-1" placeholder="Nama *" required>
                <button type="submit" class="btn btn-primary btn-sm w-100 mt-2">
                    <i class="fas fa-user-plus"></i> Register
                </button>
            </form>
        </div>
    </div>

    <!-- 8. Restart Mesin -->
    <div class="col-md-6 col-lg-4">
        <div class="card p-3">
            <h6 class="text-muted">🔄 Restart Mesin</h6>
            <p class="small text-muted">Restart mesin Fingerspot</p>
            <form action="{{ route('command.restart-mesin') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm w-100" onclick="return confirm('Yakin mau restart mesin?')">
                    <i class="fas fa-power-off"></i> Restart
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Status Info -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card p-3">
            <h6 class="text-muted">ℹ️ Informasi</h6>
            <ul class="small mb-0">
                <li>Pastikan koneksi internet stabil sebelum mengirim perintah.</li>
                <li>Setiap perintah akan tercatat di <strong>API Logs</strong> dan <strong>Command Logs</strong>.</li>
                <li>Response dari mesin akan masuk melalui <strong>Webhook</strong> dan tersimpan di <strong>Webhook Logs</strong>.</li>
            </ul>
        </div>
    </div>
</div>
@endsection