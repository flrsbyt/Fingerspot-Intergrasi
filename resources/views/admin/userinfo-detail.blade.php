@extends('layouts.admin')

@section('title', 'Detail Userinfo')

@section('content')
<style>
    .detail-header h1 {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700;
        color: #0B0F19;
    }
    
    .btn-back {
        background: #FFFFFF;
        color: #6366F1;
        border: 1px solid #E6E8EC;
        padding: 8px 18px;
        border-radius: 8px;
        font-weight: 500;
        font-size: 0.85rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
    }
    .btn-back:hover {
        background: #F3F4FF;
        border-color: #6366F1;
        color: #4F46E5;
    }
    
    .detail-card {
        background: #FFFFFF;
        border: 1px solid #E6E8EC;
        border-radius: 14px;
        padding: 24px 28px;
    }
    
    .detail-table td {
        padding: 10px 0;
        border: none;
        font-size: 0.9rem;
    }
    
    .detail-table .label {
        color: #6B7280;
        font-weight: 500;
        width: 140px;
    }
    
    .detail-table .value {
        color: #1F2937;
        font-weight: 500;
    }
    
    .detail-table .value code {
        font-family: 'JetBrains Mono', monospace;
        background: #F3F4FF;
        color: #6366F1;
        padding: 2px 10px;
        border-radius: 4px;
    }
    
    .badge-modern-success {
        background: #D1FAE5;
        color: #059669;
        padding: 4px 12px;
        border-radius: 100px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .card-raw {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 16px;
        max-height: 320px;
        overflow: auto;
    }
    
    .card-raw pre {
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.75rem;
        color: #1F2937;
        margin: 0;
        white-space: pre-wrap;
        word-break: break-all;
        line-height: 1.6;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4 detail-header">
    <h1 class="h4 m-0">👤 Detail Userinfo</h1>
    <a href="{{ route('userinfos.index') }}" class="btn-back">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="detail-card">
    <div class="row g-4">
        {{-- KOLOM KIRI - DATA --}}
        <div class="col-md-6">
            <table class="table detail-table">
                <tr>
                    <td class="label">ID</td>
                    <td class="value">: {{ $userinfo->id }}</td>
                </tr>
                <tr>
                    <td class="label">PIN</td>
                    <td class="value">: <code>{{ $userinfo->pin }}</code></td>
                </tr>
                <tr>
                    <td class="label">Nama</td>
                    <td class="value">: {{ $userinfo->name }}</td>
                </tr>
                <tr>
                    <td class="label">Department</td>
                    <td class="value">: {{ $userinfo->department ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Position</td>
                    <td class="value">: {{ $userinfo->position ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Card Number</td>
                    <td class="value">: {{ $userinfo->card_number ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Status</td>
                    <td class="value">: 
                        <span class="badge-modern-success">Active</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">Dibuat</td>
                    <td class="value">: {{ $userinfo->created_at->diffForHumans() }}</td>
                </tr>
            </table>
        </div>

        {{-- KOLOM KANAN - RAW PAYLOAD --}}
        <div class="col-md-6">
            <div class="card-raw">
                <h6 class="text-muted" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 10px;">
                    📦 Raw Payload
                </h6>
                <pre>{{ json_encode($userinfo->raw_payload, JSON_PRETTY_PRINT) }}</pre>
            </div>
        </div>
    </div>
</div>
@endsection