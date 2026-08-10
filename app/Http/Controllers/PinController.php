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

        // Filter by PIN
        if ($request->filled('pin')) {
            $query->where('pin', $request->pin);
        }

        $pins = $query->paginate(20)->withQueryString();

        // Check device connection - use first active device
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
}