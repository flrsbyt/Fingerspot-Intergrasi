@extends('layouts.admin')

@section('title', 'Detail Webhook Log')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">🔗 Detail Webhook Log</h1>
    <a href="{{ route('webhook-logs.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card p-4">
    <div class="row">
        <div class="col-md-6">
            <table class="table table-borderless">
                <tr>
                    <th width="150">ID</th>
                    <td>: {{ $webhookLog->id }}</td>
                </tr>
                <tr>
                    <th>Event Type</th>
                    <td>: <code>{{ $webhookLog->event_type }}</code></td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>: 
                        <span class="badge {{ $webhookLog->status == 'received' ? 'badge-warning' : 'badge-success' }}">
                            {{ $webhookLog->status }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>Waktu</th>
                    <td>: {{ $webhookLog->created_at->format('d M Y H:i:s') }}</td>
                </tr>
            </table>
        </div>
        <div class="col-md-6">
            <div class="card bg-light p-3 mb-2">
                <h6 class="text-muted">📥 Payload</h6>
                <pre class="small mb-0" style="max-height: 200px; overflow: auto;">{{ json_encode($webhookLog->payload, JSON_PRETTY_PRINT) }}</pre>
            </div>
            <div class="card bg-light p-3">
                <h6 class="text-muted">📦 Processed Data</h6>
                <pre class="small mb-0" style="max-height: 200px; overflow: auto;">{{ json_encode($webhookLog->processed_data, JSON_PRETTY_PRINT) }}</pre>
            </div>
        </div>
    </div>
</div>
@endsection