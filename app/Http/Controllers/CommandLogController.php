<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CommandLog;

class CommandLogController extends Controller
{
    public function index(Request $request)
    {
        $query = CommandLog::query();

        if ($request->filled('command')) {
            $query->where('command', 'like', "%{$request->command}%");
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $commandLogs = $query->latest()->paginate(30);

        return view('admin.command-logs', compact('commandLogs'));
    }
}