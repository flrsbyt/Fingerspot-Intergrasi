<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attlog;

class AttlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Attlog::query();

        // Filter by device
        if ($request->filled('device')) {
            $query->where('pin', $request->device);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->filled('start_date')) {
            $query->whereDate('scan_time', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('scan_time', '<=', $request->end_date);
        }

        $attlogs = $query->latest('scan_time')->paginate(10)->withQueryString();

        return view('admin.attlogs', compact('attlogs'));
    }

    public function show($id)
    {
        $attlog = Attlog::findOrFail($id);
        return view('admin.attlog-detail', compact('attlog'));
    }

    public function destroy($id)
    {
        Attlog::destroy($id);
        return redirect()->back()->with('message', 'Data absensi berhasil dihapus');
    }
}