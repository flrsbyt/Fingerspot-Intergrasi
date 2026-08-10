<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WebhookLog;

class WebhookLogController extends Controller
{
    public function index(Request $request)
    {
        $query = WebhookLog::query();

        if ($request->filled('event_type')) {
            $query->where('event_type', $request->event_type);
        }

        $webhookLogs = $query->latest()->paginate(30);

        return view('admin.webhook-logs', compact('webhookLogs'));
    }

    public function show($id)
    {
        $webhookLog = WebhookLog::findOrFail($id);
        return view('admin.webhook-log-detail', compact('webhookLog'));
    }
}