<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attlog;
use App\Models\Userinfo;
use App\Models\Pin;
use App\Models\ApiRequest;
use App\Models\WebhookLog;
use App\Models\CommandLog;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik
        $totalKaryawan = Userinfo::count();
        $totalAbsensi = Attlog::count();
        $totalPin = Pin::count();
        $totalApiRequests = ApiRequest::count();
        $totalWebhookLogs = WebhookLog::count();
        $totalCommandLogs = CommandLog::count();

        // Absensi hari ini
        $today = Carbon::today();
        $absensiHariIni = Attlog::whereDate('scan_time', $today)->count();

        // Absensi 7 hari terakhir (untuk grafik)
        $chartLabels = [];
        $chartData = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartLabels[] = $date->format('d M');
            $chartData[] = Attlog::whereDate('scan_time', $date)->count();
        }

        // Data terbaru
        $latestAttlogs = Attlog::latest()->take(10)->get();
        $latestApiRequests = ApiRequest::latest()->take(10)->get();

        return view('dashboard', compact(
            'totalKaryawan',
            'totalAbsensi',
            'totalPin',
            'totalApiRequests',
            'totalWebhookLogs',
            'totalCommandLogs',
            'absensiHariIni',
            'chartLabels',
            'chartData',
            'latestAttlogs',
            'latestApiRequests'
        ));
    }
}