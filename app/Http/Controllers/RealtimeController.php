<?php

namespace App\Http\Controllers;

use App\Models\Attlog;
use App\Models\Pin;
use App\Services\FingerspotService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class RealtimeController extends Controller
{
    protected $fingerspot;

    public function __construct(FingerspotService $fingerspot)
    {
        $this->fingerspot = $fingerspot;
    }

    /**
     * Get latest attlog data for realtime updates
     */
    public function latestAttlogs(Request $request)
    {
        $lastId = $request->input('last_id', 0);
        $limit = min($request->input('limit', 10), 20); // Max 20 records per poll

        // Use cache for device status to reduce API calls
        $cacheKey = 'attlogs_latest_' . $lastId . '_' . md5(json_encode($request->except(['last_id', 'limit'])));
        
        $attlogs = Cache::remember($cacheKey, 3, function() use ($request, $lastId, $limit) {
            $query = Attlog::where('id', '>', $lastId)
                ->select(['id', 'pin', 'scan_time', 'status', 'verify', 'photo_url']) // Only select needed columns
                ->orderBy('id', 'desc') // Use id for faster sorting
                ->limit($limit);

            // Apply same filters as main attlog page
            if ($request->filled('pin')) {
                $query->where('pin', 'like', '%' . $request->pin . '%');
            }

            if ($request->filled('verify')) {
                $query->where('verify', $request->verify);
            }

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            if ($request->filled('start_date')) {
                $query->whereDate('scan_time', '>=', $request->start_date);
            }

            if ($request->filled('end_date')) {
                $query->whereDate('scan_time', '<=', $request->end_date);
            }

            return $query->get();
        });

        return response()->json([
            'success' => true,
            'data' => $attlogs,
            'last_id' => $attlogs->max('id') ?? $lastId,
            'count' => $attlogs->count(),
        ]);
    }

    /**
     * Get device status for all active devices
     */
    public function deviceStatus()
    {
        // Cache device status for 30 seconds to reduce API calls
        $deviceStatuses = Cache::remember('device_status_all', 30, function() {
            $devices = Pin::where('is_active', true)->get(['id', 'pin', 'device_name']);
            $statuses = [];

            foreach ($devices as $device) {
                $connectionStatus = $this->fingerspot->checkConnection($device->pin);
                
                $statuses[] = [
                    'id' => $device->id,
                    'pin' => $device->pin,
                    'device_name' => $device->device_name,
                    'online' => $connectionStatus['online'] ?? false,
                    'last_checked' => now()->format('H:i:s'),
                    'status_code' => $connectionStatus['status_code'] ?? null,
                ];
            }

            return $statuses;
        });

        return response()->json([
            'success' => true,
            'devices' => $deviceStatuses,
            'total_online' => collect($deviceStatuses)->where('online', true)->count(),
            'total_offline' => collect($deviceStatuses)->where('online', false)->count(),
        ]);
    }

    /**
     * Get system stats for dashboard
     */
    public function systemStats()
    {
        // Cache stats for 60 seconds
        $stats = Cache::remember('system_stats', 60, function() {
            $totalAttlogs = Attlog::count();
            $todayAttlogs = Attlog::whereDate('scan_time', today())->count();
            $devices = Pin::where('is_active', true)->count();
            
            // Get cached device status instead of checking each device
            $deviceStatuses = Cache::get('device_status_all', []);
            $onlineDevices = collect($deviceStatuses)->where('online', true)->count();

            return [
                'total_attlogs' => $totalAttlogs,
                'today_attlogs' => $todayAttlogs,
                'total_devices' => $devices,
                'online_devices' => $onlineDevices,
                'offline_devices' => $devices - $onlineDevices,
            ];
        });

        return response()->json([
            'success' => true,
            'stats' => $stats,
            'last_updated' => now()->format('H:i:s'),
        ]);
    }
}
