@extends('layouts.admin')

@section('title', 'Changelog')

@section('content')
<style>
    /* ===== HEADER ===== */
    .settings-header h1 {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700;
        color: #0B0F19;
        font-size: 1.4rem;
        margin: 0;
    }
    .settings-header .subtitle {
        font-size: 0.85rem;
        color: #6B7280;
    }
    
    /* ===== CARD ===== */
    .settings-card {
        background: #FFFFFF;
        border: 1px solid #EEF0F4;
        border-radius: 16px;
        padding: 22px 24px;
        transition: all 0.25s ease;
        height: 100%;
    }
    .settings-card:hover {
        border-color: #D1D5DB;
    }
    
    .settings-card .card-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 600;
        font-size: 0.85rem;
        color: #111827;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        letter-spacing: -0.01em;
    }
    .settings-card .card-title .title-left {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .settings-card .card-title i {
        color: #6366F1;
        font-size: 1rem;
        width: 20px;
        text-align: center;
    }
    
    /* ===== CHANGELOG ITEM ===== */
    .changelog-item {
        border-bottom: 1px solid #E6E8EC;
        padding-bottom: 24px;
        margin-bottom: 24px;
    }
    .changelog-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
        margin-bottom: 0;
    }
    .changelog-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }
    .version-badge {
        background: #6366F1;
        color: white;
        padding: 4px 12px;
        border-radius: 100px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    .changelog-date {
        color: #6B7280;
        font-size: 0.85rem;
    }
    .changelog-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .changelog-list li {
        padding: 8px 0;
        color: #374151;
        font-size: 0.85rem;
        display: flex;
        align-items: flex-start;
        gap: 8px;
    }
    .changelog-list li i {
        color: #10B981;
        margin-top: 2px;
    }
</style>

<div class="settings-container">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 settings-header">
        <div>
            <h1>📜 Changelog</h1>
            <span class="subtitle">Riwayat pembaruan aplikasi</span>
        </div>
    </div>

    <div class="settings-card">
        <div class="card-title">
            <span class="title-left">
                <i class="fas fa-history"></i> Versi Aplikasi
            </span>
        </div>

        @foreach($changelogs as $changelog)
            <div class="changelog-item">
                <div class="changelog-header">
                    <span class="version-badge">{{ $changelog['version'] }}</span>
                    <span class="changelog-date">{{ date('d M Y', strtotime($changelog['date'])) }}</span>
                </div>
                <ul class="changelog-list">
                    @foreach($changelog['changes'] as $change)
                        <li>
                            <i class="fas fa-check-circle"></i>
                            {{ $change }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>
</div>
@endsection
