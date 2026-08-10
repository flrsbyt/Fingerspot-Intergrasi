@extends('layouts.admin')

@section('title', 'Detail Attlog')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">🕐 Detail Attlog</h1>
    <a href="{{ route('attlogs.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card p-4">
    <div class="row">
        <div class="col-md-6">
            <table class="table table-borderless">
                <tr>
                    <th width="150">ID</th>
                    <td>: {{ $attlog->id }}</td>
                </tr>
                <tr>
                    <th>PIN</th>
                    <td>: <code>{{ $attlog->pin }}</code></td>
                </tr>
                <tr>
                    <th>Scan Time</th>
                    <td>: {{ $attlog->scan_time->format('d M Y H:i:s') }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>: 
                        <span class="badge {{ $attlog->status == 'check-in' ? 'badge-success' : 'badge-danger' }}">
                            {{ $attlog->status }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>Dibuat</th>
                    <td>: {{ $attlog->created_at->diffForHumans() }}</td>
                </tr>
            </table>
        </div>
        <div class="col-md-6">
            <div class="card bg-light p-3">
                <h6 class="text-muted">📦 Raw Payload</h6>
                <pre class="small mb-0" style="max-height: 300px; overflow: auto;">{{ json_encode($attlog->raw_payload, JSON_PRETTY_PRINT) }}</pre>
            </div>
        </div>
    </div>
</div>
@endsection