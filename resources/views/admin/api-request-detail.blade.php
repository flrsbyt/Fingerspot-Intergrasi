@extends('layouts.admin')

@section('title', 'Detail API Request')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">📡 Detail API Request</h1>
    <a href="{{ route('api-requests.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card p-4">
    <div class="row">
        <div class="col-md-6">
            <table class="table table-borderless">
                <tr>
                    <th width="150">ID</th>
                    <td>: {{ $apiRequest->id }}</td>
                </tr>
                <tr>
                    <th>Command</th>
                    <td>: <code>{{ $apiRequest->command }}</code></td>
                </tr>
                <tr>
                    <th>Request ID</th>
                    <td>: {{ $apiRequest->request_id ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>: 
                        <span class="badge {{ $apiRequest->status == 'success' ? 'badge-success' : ($apiRequest->status == 'pending' ? 'badge-warning' : 'badge-danger') }}">
                            {{ $apiRequest->status }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>Waktu</th>
                    <td>: {{ $apiRequest->created_at->format('d M Y H:i:s') }}</td>
                </tr>
            </table>
        </div>
        <div class="col-md-6">
            <div class="card bg-light p-3 mb-2">
                <h6 class="text-muted">📤 Payload</h6>
                <pre class="small mb-0" style="max-height: 200px; overflow: auto;">{{ json_encode($apiRequest->payload, JSON_PRETTY_PRINT) }}</pre>
            </div>
            <div class="card bg-light p-3">
                <h6 class="text-muted">📥 Response</h6>
                <pre class="small mb-0" style="max-height: 200px; overflow: auto;">{{ json_encode($apiRequest->response, JSON_PRETTY_PRINT) }}</pre>
            </div>
        </div>
    </div>
</div>
@endsection