<?php

namespace App\Http\Controllers;

use App\Services\FingerspotService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class SettingsController extends Controller
{
    protected $fingerspot;

    public function __construct(FingerspotService $fingerspot)
    {
        $this->fingerspot = $fingerspot;
    }

    public function index()
    {
        // Ambil data dari .env
        $settings = [
            'api_url' => env('FINGERSPOT_API_URL', 'https://developer.fingerspot.io/api'),
            'api_key' => env('FINGERSPOT_API_KEY', ''),
            'webhook_url' => url('/api/webhook/fingerspot'),
        ];

        // Check device connection - use first active device
        $firstDevice = \App\Models\Pin::where('is_active', true)->first();
        $deviceOnline = false;
        
        if ($firstDevice) {
            $connectionStatus = $this->fingerspot->checkConnection($firstDevice->pin);
            $deviceOnline = $connectionStatus['online'] ?? false;
        }

        return view('admin.settings', compact('settings', 'deviceOnline'));
    }

    /**
     * Update the settings.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'api_url' => 'nullable|url',
            'api_key' => 'nullable|string',
        ]);

        $this->updateEnv($validated);

        return redirect()->back()->with('message', '✅ Pengaturan berhasil disimpan!');
    }

    /**
     * Add device to database.
     */
    public function addDevice(Request $request)
    {
        $validated = $request->validate([
            'pin' => 'required|string|max:50',
            'device_name' => 'required|string|max:255',
        ]);

        \App\Models\Pin::create([
            'pin' => $validated['pin'],
            'device_name' => $validated['device_name'],
            'is_active' => true,
        ]);

        return redirect()->back()->with('message', '✅ Perangkat berhasil ditambahkan!');
    }

    private function updateEnv($data)
    {
        $envFile = base_path('.env');
        
        $envContent = File::get($envFile);
        
        $mappings = [
            'api_url' => 'FINGERSPOT_API_URL',
            'api_key' => 'FINGERSPOT_API_KEY',
        ];

        foreach ($mappings as $key => $envKey) {
            if (isset($data[$key])) {
                $value = $data[$key];
                $pattern = "/^{$envKey}=.*/m";
                
                if (preg_match($pattern, $envContent)) {
                    $envContent = preg_replace($pattern, "{$envKey}={$value}", $envContent);
                } else {
                    $envContent .= "\n{$envKey}={$value}";
                }
            }
        }

        File::put($envFile, $envContent);
        
        // Clear config cache
        Artisan::call('config:clear');
    }
}