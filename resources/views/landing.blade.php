<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SyncAttendance — Universal Attendance API Hub</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
            
            /* Warna Ungu Klimis Request-an */
            --accent-purple: #9FA1FF;
            --accent-purple-tint: #F3F4FF;
            
            --text-main: #1F2937;
            --text-muted: #6B7280;
        }

        * { 
            box-sizing: border-box; 
            transition: all 0.2s ease-in-out;
        }

        html { scroll-behavior: smooth; }

        body {
            background: var(--bg-light);
            color: var(--text-main);
            font-family: 'Inter', sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        h1, h2, h3, h4, h5 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            letter-spacing: -0.01em;
        }

        .mono {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.8rem;
        }

        .badge-tag {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            background: var(--accent-purple-tint);
            color: #6366F1; /* Darker variant for text readability */
            padding: 6px 12px;
            border-radius: 100px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-weight: 500;
        }

        /* ---------- Navbar ---------- */
        .navbar {
            background: rgba(250, 250, 252, 0.8);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-color);
            padding: 16px 0;
        }

        .navbar-brand {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            font-size: 1.2rem;
            color: var(--dark) !important;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .navbar-brand i {
            color: var(--accent-purple);
        }

        .nav-link {
            font-size: 0.9rem;
            color: var(--text-muted) !important;
            font-weight: 500;
            padding: 8px 16px !important;
        }

        .nav-link:hover { color: var(--dark) !important; }

        /* ---------- Buttons ---------- */
        .btn-elegant {
            background: var(--dark);
            color: #fff;
            border: none;
            padding: 10px 24px;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 12px rgba(11, 15, 25, 0.05);
        }
        .btn-elegant:hover { background: #1E293B; color: #fff; transform: translateY(-1px); }

        .btn-elegant-outline {
            background: transparent;
            color: var(--dark);
            border: 1px solid var(--border-color);
            padding: 10px 24px;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-elegant-outline:hover { background: #F1F5F9; border-color: var(--dark); color: var(--dark); }

        /* ---------- Hero ---------- */
        .hero {
            padding: 160px 0 100px;
            position: relative;
        }

        .hero h1 {
            font-size: 3.2rem;
            line-height: 1.15;
            color: var(--dark);
        }

        .hero h1 span.accent {
            background: linear-gradient(120deg, #7C3AED, var(--accent-purple));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero p.lead-text {
            font-size: 1.1rem;
            color: var(--text-muted);
            line-height: 1.6;
            margin-top: 20px;
        }

        /* Minimal UI Mockup Preview */
        .hero-mockup {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.03);
        }

        .mockup-header {
            display: flex;
            align-items: center;
            gap: 6px;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 14px;
            margin-bottom: 18px;
        }

        .mockup-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #E5E7EB;
        }
        .mockup-dot.active { background: var(--accent-purple); }

        /* ---------- Features ---------- */
        .features { padding: 80px 0; }

        .section-head h2 {
            font-size: 2.2rem;
            margin-top: 12px;
        }

        .feature-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 32px 28px;
            height: 100%;
        }

        .feature-card:hover {
            border-color: var(--accent-purple);
            box-shadow: 0 12px 30px rgba(159, 161, 255, 0.15);
            transform: translateY(-2px);
        }

        .feature-card .icon-box {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background: var(--accent-purple-tint);
            color: #6366F1;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            margin-bottom: 20px;
        }

        .feature-card h5 {
            font-size: 1.1rem;
            margin-bottom: 10px;
            color: var(--dark);
        }

        .feature-card p {
            color: var(--text-muted);
            font-size: 0.92rem;
            line-height: 1.55;
            margin-bottom: 0;
        }

        /* ---------- CTA ---------- */
        .cta {
            margin: 60px 0 40px;
            padding: 80px 0;
            background: var(--dark);
            border-radius: 20px;
            color: #fff;
            position: relative;
            overflow: hidden;
        }

        .cta h2 { font-size: 2.4rem; }
        .cta p { color: #94A3B8; max-width: 520px; margin: 16px auto 32px; }

        .btn-cta-white {
            background: #FFFFFF;
            color: var(--dark);
            padding: 12px 32px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.95rem;
        }
        .btn-cta-white:hover { background: var(--accent-purple-tint); transform: translateY(-1px); color: var(--dark); }

        /* ---------- Footer ---------- */
        .footer {
            padding: 40px 0;
            border-top: 1px solid var(--border-color);
        }

        .footer p {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.78rem;
            color: var(--text-muted);
        }

        @media (max-width: 991px) {
            .hero { padding: 120px 0 60px; text-align: center; }
            .hero p.lead-text { margin-left: auto; margin-right: auto; }
            .hero .d-flex { justify-content: center; }
            .hero-mockup { margin-top: 40px; }
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#">
            <i class="fa-solid fa-layer-group me-1"></i>
            <span>SyncAttendance</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item"><a class="nav-link" href="#features">Fitur</a></li>
                <li class="nav-item"><a class="nav-link" href="#about">Tentang</a></li>
                <li class="nav-item">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn-elegant ms-lg-2">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="btn-elegant-outline ms-lg-2">
                            Register
                        </a>
                        <a href="{{ route('login') }}" class="btn-elegant ms-lg-2">
                            Sign In
                        </a>
                    @endauth
                </li>
            </ul>
        </div>
    </div>
</nav>

<section class="hero">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <span class="badge-tag">Unified Hardware API</span>
                <h1 class="mt-3 mb-0">
                    Satu API Gateway untuk <span class="accent">Semua Mesin</span> Absensi.
                </h1>
                <p class="lead-text">
                    Hubungkan, kelola, dan sinkronisasi berbagai tipe mesin biometrik absensi langsung ke sistem cloud Anda melalui integrasi Webhook dan API terpadu. Tanpa dependensi vendor spesifik.
                </p>
                <div class="d-flex gap-3 mt-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn-elegant">
                            Buka Dashboard <i class="fa-solid fa-arrow-right font-size-sm"></i>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn-elegant">Masukkan Akses</a>
                        <a href="{{ route('register') }}" class="btn-elegant-outline">Mulai Integrasi</a>
                    @endauth
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="hero-mockup">
                    <div class="mockup-header justify-content-between">
                        <div class="d-flex gap-1.5">
                            <span class="mockup-dot"></span>
                            <span class="mockup-dot"></span>
                            <span class="mockup-dot active"></span>
                        </div>
                        <span class="mono text-muted" style="font-size: 0.7rem;">live_stream_active</span>
                    </div>
                    <div class="p-2">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <small class="text-muted d-block uppercase mono" style="font-size: 0.65rem;">GATEWAY STATUS</small>
                                <span class="fw-bold" style="font-size: 0.95rem;">Terminal _Cluster_01A</span>
                            </div>
                            <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 rounded mono" style="font-size: 0.7rem;">Online</span>
                        </div>
                        <div class="bg-light p-3 rounded border border-light-subtle mb-2">
                            <div class="d-flex justify-content-between text-muted mono mb-1" style="font-size: 0.7rem;">
                                <span>[POST] /webhook/logs</span>
                                <span>200 OK</span>
                            </div>
                            <span class="mono d-block text-truncate text-secondary" style="font-size: 0.75rem;">{"device_id": "HW-9921", "user_id": "USR-202", "timestamp": "12:38:49"}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="features" id="features">
    <div class="container">
        <div class="section-head text-center mb-5">
            <span class="badge-tag">Kapabilitas Core</span>
            <h2 class="mx-auto mt-2" style="max-width: 540px;">Arsitektur modern untuk pengelolaan log hardware</h2>
        </div>
        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="feature-card">
                    <div class="icon-box"><i class="fa-regular fa-clock"></i></div>
                    <h5>Real-time Sync Log</h5>
                    <p>Ambil riwayat dan mutasi presensi secara *realtime* langsung sesaat setelah karyawan melakukan pemindaian.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="feature-card">
                    <div class="icon-box"><i class="fa-regular fa-user"></i></div>
                    <h5>Manajemen Karyawan</h5>
                    <p>Metode pencatatan data terpusat untuk mendaftarkan, memperbarui, atau menghapus hak akses personil ke mesin tujuan.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="feature-card">
                    <div class="icon-box"><i class="fa-solid fa-terminal"></i></div>
                    <h5>Command Orchestrator</h5>
                    <p>Kirim instruksi antrean tugas (*queued commands*) langsung ke mesin seperti penyelarasan waktu dan *restart* jarak jauh.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="feature-card">
                    <div class="icon-box"><i class="fa-solid fa-code"></i></div>
                    <h5>Log API Komprehensif</h5>
                    <p>Pantau status kesehatan payload data keluar-masuk sistem dengan pencatatan HTTP status code yang detail.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="feature-card">
                    <div class="icon-box"><i class="fa-solid fa-satellite-dish"></i></div>
                    <h5>Webhook Terotomatisasi</h5>
                    <p>Kirimkan data hasil tangkapan dari mesin secara instan ke *endpoint* aplikasi internal milik perusahaan Anda.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="feature-card">
                    <div class="icon-box"><i class="fa-solid fa-clock-rotate-left"></i></div>
                    <h5>Audit Trails</h5>
                    <p>Simpan histori perubahan konfigurasi terminal untuk keperluan transparansi data serta mitigasi eror operasional.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="about" class="container">
    <div class="cta text-center">
        <div class="container">
            <span class="badge-tag" style="background: rgba(255,255,255,0.08); color: var(--accent-purple);">Mulai Integrasi</span>
            <h2 class="mt-3">Siap membangun infrastruktur presensi yang modular?</h2>
            <p>Konsolidasikan seluruh terminal mesin absensi dalam satu infrastruktur API yang andal dan terukur.</p>
            @auth
                <a href="{{ route('dashboard') }}" class="btn-cta-white text-decoration-none d-inline-block">
                    Buka Dashboard Panel
                </a>
            @else
                <a href="{{ route('login') }}" class="btn-cta-white text-decoration-none d-inline-block">
                    Mulai Sekarang
                </a>
            @endauth
        </div>
    </div>
</section>

<footer class="footer">
    <div class="container text-center">
        <p class="mb-0">
            © {{ date('Y') }} SyncAttendance Platform — Engineered with clarity.
        </p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>