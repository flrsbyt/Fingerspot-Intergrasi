<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attlog;
use App\Models\Userinfo;
use App\Models\Pin;
use App\Models\ApiRequest;
use App\Models\WebhookLog;
use App\Models\CommandLog;
use App\Services\FingerspotService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    protected $fingerspot;

    public function __construct(FingerspotService $fingerspot)
    {
        $this->fingerspot = $fingerspot;
    }

    public function index()
    {
        // Statistik utama dengan caching
        $stats = Cache::remember('dashboard_stats', 60, function() {
            return [
                'totalKaryawan' => Userinfo::count(),
                'totalAbsensi' => Attlog::count(),
                'totalPin' => Pin::where('is_active', true)->count(),
                'totalApiRequests' => ApiRequest::count(),
                'totalWebhookLogs' => WebhookLog::count(),
                'totalCommandLogs' => CommandLog::count(),
            ];
        });

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

        // Data terbaru dengan informasi lengkap
        $latestAttlogs = Attlog::select(['id', 'pin', 'scan_time', 'status', 'verify', 'photo_url'])
            ->latest()
            ->take(10)
            ->get();
        
        $latestApiRequests = ApiRequest::latest()->take(5)->get();

        // Device status dengan caching
        $deviceStatus = Cache::remember('device_status_dashboard', 30, function() {
            $devices = Pin::where('is_active', true)->get(['id', 'pin', 'device_name']);
            $statusData = [];

            foreach ($devices as $device) {
                $connectionStatus = $this->fingerspot->checkConnection($device->pin);
                
                $statusData[] = [
                    'id' => $device->id,
                    'pin' => $device->pin,
                    'device_name' => $device->device_name,
                    'online' => $connectionStatus['online'] ?? false,
                    'status_code' => $connectionStatus['status_code'] ?? null,
                    'last_checked' => now()->format('H:i:s'),
                ];
            }

            return $statusData;
        });

        // Statistik verifikasi methods
        $verifyStats = Cache::remember('verify_stats', 120, function() {
            return [
                'fingerprint' => Attlog::where('verify', 1)->count(),
                'password' => Attlog::where('verify', 2)->count(),
                'card' => Attlog::where('verify', 3)->count(),
                'face' => Attlog::where('verify', 4)->count(),
                'palm' => Attlog::where('verify', 6)->count(),
            ];
        });

        return view('dashboard', array_merge($stats, [
            'absensiHariIni' => $absensiHariIni,
            'chartLabels' => $chartLabels,
            'chartData' => $chartData,
            'latestAttlogs' => $latestAttlogs,
            'latestApiRequests' => $latestApiRequests,
            'deviceStatus' => $deviceStatus,
            'verifyStats' => $verifyStats,
        ]));
    }
}