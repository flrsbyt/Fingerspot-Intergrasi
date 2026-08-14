<?php

namespace App\Http\Controllers;

use App\Services\FingerspotService;
use App\Models\Pin;
use Illuminate\Http\Request;

class PinController extends Controller
{
    protected $fingerspot;

    public function __construct(FingerspotService $fingerspot)
    {
        $this->fingerspot = $fingerspot;
    }

    public function index(Request $request)
    {
        $query = Pin::query();

        // Filter by PIN (Cloud ID) - supports partial match
        if ($request->filled('pin')) {
            $query->where('pin', 'like', '%' . $request->pin . '%');
        }

        // Filter by specific device (using PIN field)
        if ($request->filled('device')) {
            $query->where('pin', $request->device);
        }

        // Filter by active status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $pins = $query->paginate(20)->withQueryString();

        // Check connection status for first device
        $firstDevice = $pins->first();
        $deviceOnline = false;
        
        if ($firstDevice) {
            $connectionStatus = $this->fingerspot->checkConnection($firstDevice->pin);
            $deviceOnline = $connectionStatus['online'] ?? false;
        }

        return view('admin.pins', compact('pins', 'deviceOnline'));
    }

    public function destroy($id)
    {
        Pin::destroy($id);
        return redirect()->back()->with('message', 'PIN berhasil dihapus');
    }

    /**
     * Test connection to a specific device
     */
    public function testConnection(Request $request)
    {
        $cloudId = $request->input('cloud_id');

        if (empty($cloudId)) {
            return response()->json([
                'success' => false,
                'message' => '❌ Cloud ID wajib diisi'
            ]);
        }

        $connectionStatus = $this->fingerspot->checkConnection($cloudId);

        return response()->json([
            'success' => $connectionStatus['online'],
            'message' => $connectionStatus['online'] ? '✅ Mesin terhubung dan online' : '❌ Mesin tidak terhubung atau offline',
            'data' => $connectionStatus
        ]);
    }

    /**
     * Debug API request - untuk melihat detail error
     */
    public function debugApiRequest(Request $request)
    {
        $cloudId = $request->input('cloud_id');

        if (empty($cloudId)) {
            return response()->json([
                'success' => false,
                'message' => '❌ Cloud ID wajib diisi'
            ]);
        }

        // Cek API request terakhir untuk command ini
        $lastRequest = \App\Models\ApiRequest::where('command', 'Get All PIN')
            ->where('payload->cloud_id', $cloudId)
            ->latest()
            ->first();

        // Test langsung ke API
        $result = $this->fingerspot->getAllPin($cloudId);

        return response()->json([
            'cloud_id' => $cloudId,
            'api_config' => [
                'url' => config('services.fingerspot.api_url'),
                'api_key' => substr(config('services.fingerspot.api_key'), 0, 8) . '...' // Hidden sebagian
            ],
            'last_db_request' => $lastRequest,
            'live_api_result' => $result,
        ]);
    }
}