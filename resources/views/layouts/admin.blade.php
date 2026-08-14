<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'FingerSpot Integration')</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700&family=Inter:wght@400;500&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --dark: #0B0F19;
            --dark-soft: #161F30;
            --bg-light: #FAFAFC;
            --card-bg: #FFFFFF;
            --border-color: #E6E8EC;
            --accent-purple: #9FA1FF;
            --accent-purple-tint: #F3F4FF;
            --text-main: #1F2937;
            --text-muted: #6B7280;
        }
        
        * { 
            box-sizing: border-box; 
            transition: all 0.2s ease-in-out;
        }
        
        body {
            background-color: var(--bg-light);
            color: var(--text-main);
            font-family: 'Inter', sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        /* Topbar */
        .topbar {
            background: #FFFFFF;
            border-bottom: 1px solid #E6E8EC;
            padding: 8px 24px;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        .topbar .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            padding: 8px 16px;
            border-radius: 10px;
            transition: all 0.2s ease;
        }

        .topbar .user-profile:hover {
            background: #F3F4FF;
        }

        .topbar .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #6366F1, #9FA1FF);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1rem;
        }

        .topbar .user-info {
            display: flex;
            flex-direction: column;
        }

        .topbar .user-name {
            font-weight: 600;
            font-size: 0.9rem;
            color: #0B0F19;
        }

        .topbar .user-company {
            font-size: 0.75rem;
            color: #6B7280;
        }

        .topbar .dropdown-menu {
            min-width: 280px;
            border: 1px solid #E6E8EC;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            padding: 8px;
        }

        .topbar .dropdown-item {
            padding: 10px 16px;
            border-radius: 8px;
            font-size: 0.85rem;
            color: #374151;
            transition: all 0.2s ease;
        }

        .topbar .dropdown-item:hover {
            background: #F3F4FF;
            color: #6366F1;
        }

        .topbar .dropdown-divider {
            margin: 8px 0;
            border-color: #E6E8EC;
        }

        .topbar .dropdown-header {
            padding: 12px 16px;
            font-size: 0.75rem;
            font-weight: 600;
            color: #6B7280;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        h1, h2, h3, h4, h5 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            letter-spacing: -0.01em;
        }
        
        .sidebar {
            background: #FFFFFF;
            min-height: 100vh;
            padding: 0;
            box-shadow: 2px 0 10px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            border-right: 1px solid #E6E8EC;
        }
        
        .sidebar .nav-link {
            color: #4B5563;
            padding: 12px 20px;
            border-radius: 8px;
            margin: 4px 12px;
            transition: all 0.2s ease-in-out;
            font-weight: 500;
            font-size: 0.9rem;
        }
        
        .sidebar .nav-link:hover {
            background: #F9FAFB;
            color: #6366F1;
        }
        
        .sidebar .nav-link.active {
            background: #F3F4FF;
            color: #6366F1;
        }
        
        .sidebar .nav-link i {
            width: 24px;
            margin-right: 10px;
            text-align: center;
        }
        
        .sidebar .brand {
            padding: 24px 20px;
            color: #0B0F19;
            border-bottom: 1px solid #E6E8EC;
            margin-bottom: 10px;
        }
        
        .sidebar .brand h3 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            font-size: 1.25rem;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .sidebar .brand small {
            color: #6B7280;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .sidebar .brand i {
            color: #6366F1;
        }
        
        .main-content {
            padding: 0;
            max-width: 100%;
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow: hidden;
        }

        .content-wrapper {
            flex: 1;
            overflow-y: auto;
            padding: 40px;
        }
        
        .card {
            border: 1px solid var(--border-color);
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.02);
            transition: transform 0.2s, box-shadow 0.2s;
            background: var(--card-bg);
        }
        
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.04);
        }
        
        .stat-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            color: var(--text-main);
            padding: 24px;
            border-radius: 12px;
        }
        
        .stat-card .number {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--dark);
        }
        
        .stat-card .label {
            font-size: 0.85rem;
            color: var(--text-muted);
            font-weight: 500;
        }
        
        .btn-primary {
            background: #6366F1;
            border: none;
            padding: 10px 24px;
            border-radius: 8px;
            font-weight: 500;
            color: #FFFFFF;
        }
        
        .btn-primary:hover {
            background: #4F46E5;
        }
        
        .btn-secondary {
            background: #F3F4FF;
            border: 1px solid #E6E8EC;
            padding: 10px 24px;
            border-radius: 8px;
            font-weight: 500;
            color: #6366F1;
        }
        
        .btn-secondary:hover {
            background: #E8E9FF;
            border-color: #6366F1;
        }
        
        .table {
            background: var(--card-bg);
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid var(--border-color);
        }
        
        .table thead {
            background: var(--bg-light);
            color: var(--text-muted);
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        .table-hover tbody tr:hover {
            background: var(--bg-light);
        }
        
        .badge-primary {
            background: var(--accent-purple-tint);
            color: #6366F1;
        }
        
        .badge-success {
            background: #D1FAE5;
            color: #059669;
        }
        
        .badge-danger {
            background: #FEE2E2;
            color: #DC2626;
        }
        
        .badge-warning {
            background: #FEF3C7;
            color: #D97706;
        }
    </style>
    <style>
    /* Toast Notification */
    .toast-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        max-width: 350px;
    }
    .toast-custom {
        background: white;
        border-radius: 12px;
        padding: 16px 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.15);
        border-left: 4px solid var(--accent-purple);
        margin-bottom: 10px;
        animation: slideIn 0.3s ease;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .toast-custom.success { border-left-color: #10B981; }
    .toast-custom.error { border-left-color: #EF4444; }
    .toast-custom.warning { border-left-color: #F59E0B; }
    .toast-custom.info { border-left-color: #3B82F6; }
    
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes fadeOut {
        from { opacity: 1; }
        to { opacity: 0; transform: translateX(100%); }
    }
    
    .btn-loading {
        position: relative;
        pointer-events: none;
        opacity: 0.7;
    }
    .btn-loading .spinner {
        display: inline-block;
        width: 16px;
        height: 16px;
        border: 2px solid rgba(255,255,255,0.3);
        border-top-color: white;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
        margin-right: 8px;
    }
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
</style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar d-none d-md-block">
                <div class="brand">
                    <h3><i class="fa-solid fa-layer-group"></i> SyncAttendance</h3>
                    <small>Universal Attendance API Hub</small>
                </div>
                <nav class="nav flex-column">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                    <a href="{{ route('attlogs.index') }}" class="nav-link {{ request()->routeIs('attlogs*') ? 'active' : '' }}">
                        <i class="fas fa-clock"></i> Data Attlog
                    </a>
                    <a href="{{ route('userinfos.index') }}" class="nav-link {{ request()->routeIs('userinfos*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i> Data Userinfo
                    </a>
                    <a href="{{ route('pins.index') }}" class="nav-link {{ request()->routeIs('pins*') ? 'active' : '' }}">
                        <i class="fas fa-key"></i> Data PIN
                    </a>
                    <a href="{{ route('api-requests.index') }}" class="nav-link {{ request()->routeIs('api-requests*') ? 'active' : '' }}">
                        <i class="fas fa-code"></i> API Logs
                    </a>
                    <a href="{{ route('webhook-logs.index') }}" class="nav-link {{ request()->routeIs('webhook-logs*') ? 'active' : '' }}">
                        <i class="fa-solid fa-satellite-dish"></i> Webhook Logs
                    </a>
                    <a href="{{ route('command-logs.index') }}" class="nav-link {{ request()->routeIs('command-logs*') ? 'active' : '' }}">
                        <i class="fas fa-history"></i> Command Logs
                    </a>
                    <a href="{{ route('settings') }}" class="nav-link {{ request()->routeIs('settings*') ? 'active' : '' }}">
                        <i class="fas fa-cog"></i> Pengaturan
                    </a>
                </nav>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-10 main-content">
                <!-- Topbar -->
                <nav class="topbar">
                    <div class="d-flex justify-content-end align-items-center">
                        <div class="dropdown">
                            <div class="user-profile" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                                <div class="user-avatar">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <div class="user-info">
                                    <span class="user-name">{{ Auth::user()->name }}</span>
                                    <span class="user-company">{{ \App\Models\CompanyProfile::first()?->company_name ?? 'Perusahaan' }}</span>
                                </div>
                                <i class="fas fa-chevron-down" style="font-size: 0.75rem; color: #6B7280;"></i>
                            </div>
                            
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="{{ route('profile.index') }}" class="dropdown-item">
                                    <i class="fas fa-building me-2"></i> Profil Perusahaan
                                </a>
                                <a href="{{ route('changelog.index') }}" class="dropdown-item">
                                    <i class="fas fa-history me-2"></i> Changelog
                                </a>
                                <hr class="dropdown-divider">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item" style="width: 100%; text-align: left; border: none; background: none; cursor: pointer;">
                                        <i class="fas fa-sign-out-alt me-2" style="color: #EF4444;"></i> Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </nav>

                <div class="content-wrapper">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div></div>
                        <div id="realtime-clock" style="font-weight: 600; color: #6366F1; font-size: 0.85rem;">
                            <i class="fa-regular fa-clock me-1"></i> <span id="clock-time"></span>
                        </div>
                    </div>
                    
                    @if(session('message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Toast Container -->
<div class="toast-container" id="toastContainer"></div>

<script>
// ========== GLOBAL FUNCTIONS ==========

// Toast Notification
function showToast(message, type = 'success') {
    const container = document.getElementById('toastContainer');
    const icons = {
        success: '✅',
        error: '❌',
        warning: '⚠️',
        info: 'ℹ️'
    };
    
    const toast = document.createElement('div');
    toast.className = `toast-custom ${type}`;
    toast.innerHTML = `
        <span style="font-size:1.3rem;">${icons[type] || 'ℹ️'}</span>
        <span style="flex:1;font-size:0.9rem;">${message}</span>
        <button onclick="this.parentElement.remove()" style="background:none;border:none;font-size:1.2rem;cursor:pointer;opacity:0.5;">&times;</button>
    `;
    
    container.appendChild(toast);
    
    setTimeout(() => {
        toast.style.animation = 'fadeOut 0.3s ease forwards';
        setTimeout(() => toast.remove(), 400);
    }, 5000);
}

// Loading State
function setLoading(button, loading = true) {
    if (loading) {
        button.classList.add('btn-loading');
        button.dataset.originalHtml = button.innerHTML;
        button.innerHTML = `<span class="spinner"></span> Memproses...`;
        button.disabled = true;
    } else {
        button.classList.remove('btn-loading');
        button.innerHTML = button.dataset.originalHtml || 'Submit';
        button.disabled = false;
    }
}

// CSRF Token
function getCsrfToken() {
    return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
}

// Fetch dengan JSON
async function fetchJson(url, method = 'POST', data = {}) {
    const response = await fetch(url, {
        method: method,
        headers: {
            'X-CSRF-TOKEN': getCsrfToken(),
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        body: JSON.stringify(data),
    });
    return response.json();
}

// Realtime Clock
function updateClock() {
    const now = new Date();
    const options = { 
        day: '2-digit', 
        month: 'short', 
        year: 'numeric', 
        hour: '2-digit', 
        minute: '2-digit',
        hour12: false
    };
    const clockElement = document.getElementById('clock-time');
    if (clockElement) {
        clockElement.textContent = now.toLocaleDateString('en-GB', options).replace(',', '');
    }
}

// Update clock every second
setInterval(updateClock, 1000);
updateClock(); // Initial call
</script>
</body>
</html>