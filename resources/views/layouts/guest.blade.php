<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700&family=Inter:wght@400;500&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

        <!-- Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <style>
            :root {
                --dark: #0B0F19;
                --bg-light: #FAFAFC;
                --card-bg: #FFFFFF;
                --border-color: #E6E8EC;
                --accent-purple: #9FA1FF;
                --accent-purple-tint: #F3F4FF;
                --text-main: #1F2937;
                --text-muted: #6B7280;
            }

            body {
                background: var(--bg-light);
                color: var(--text-main);
                font-family: 'Inter', sans-serif;
                -webkit-font-smoothing: antialiased;
            }

            h1, h2, h3, h4, h5 {
                font-family: 'Plus Jakarta Sans', sans-serif;
                font-weight: 700;
                color: var(--dark);
            }

            .auth-container {
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 20px;
            }

            .auth-card {
                background: var(--card-bg);
                border: 1px solid var(--border-color);
                border-radius: 16px;
                padding: 32px;
                width: 100%;
                max-width: 420px;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            }

            .auth-logo {
                text-align: center;
                margin-bottom: 24px;
            }

            .auth-logo h1 {
                font-size: 1.5rem;
                margin: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 10px;
            }

            .auth-logo i {
                color: var(--accent-purple);
            }

            .form-label {
                font-family: 'Plus Jakarta Sans', sans-serif;
                font-weight: 600;
                font-size: 0.85rem;
                color: #374151;
                margin-bottom: 6px;
            }

            .form-control {
                border: 1px solid var(--border-color);
                border-radius: 8px;
                padding: 12px 16px;
                font-size: 0.9rem;
                transition: all 0.2s;
            }

            .form-control:focus {
                border-color: var(--accent-purple);
                box-shadow: 0 0 0 3px rgba(159, 161, 255, 0.1);
                outline: none;
            }

            .btn-primary {
                background: #6366F1;
                border: none;
                border-radius: 8px;
                padding: 12px 24px;
                font-weight: 600;
                font-size: 0.9rem;
                transition: all 0.2s;
            }

            .btn-primary:hover {
                background: #4F46E5;
            }

            .auth-links {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-top: 20px;
            }

            .auth-links a {
                color: #6366F1;
                text-decoration: none;
                font-weight: 500;
                font-size: 0.85rem;
            }

            .auth-links a:hover {
                color: #4F46E5;
            }

            .text-error {
                color: #EF4444;
                font-size: 0.8rem;
                margin-top: 4px;
            }
        </style>
    </head>
    <body>
        <div class="auth-container">
            <div class="auth-card">
                <div class="auth-logo">
                    <h1><i class="fas fa-fingerprint"></i> SyncAttendance</h1>
                </div>
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
