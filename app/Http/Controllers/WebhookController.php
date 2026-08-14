<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WebhookLog;
use App\Models\Attlog;
use App\Models\Userinfo;
use App\Models\Pin;
use App\Models\ApiRequest;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function handle(Request $request)
    {
        try {
            $payload = $request->all();
            // Fingerspot uses 'type' parameter, not 'event'
            $eventType = $request->input('type', $request->input('event', 'unknown'));

            Log::info('Webhook diterima', [
                'event' => $eventType,
                'payload' => $payload
            ]);

            // Simpan log webhook
            $webhookLog = WebhookLog::create([
                'event_type' => $eventType,
                'payload' => $payload,
                'status' => 'received',
            ]);

            // Proses berdasarkan event type
            $processedData = $this->processWebhook($eventType, $payload);

            // Update log dengan data yang sudah diproses
            $webhookLog->update([
                'processed_data' => $processedData,
                'status' => 'processed',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Webhook processed successfully',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Webhook error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    private function processWebhook($eventType, $payload)
    {
        $processed = [];

        switch ($eventType) {
            case 'attlog':
            case 'realtime_attlog':
                $processed = $this->processAttlog($payload);
                break;

            case 'userinfo':
            case 'get_userinfo':
                $processed = $this->processUserinfo($payload);
                break;

            case 'set_userinfo':
                $processed = $this->processSetUserinfo($payload);
                break;

            case 'delete_userinfo':
                $processed = $this->processDeleteUserinfo($payload);
                break;

            case 'get_all_pin':
                $processed = $this->processGetAllPin($payload);
                break;

            case 'set_time':
                $processed = $this->processSetTime($payload);
                break;

            case 'register_online':
                $processed = $this->processRegisterOnline($payload);
                break;

            default:
                $processed = ['message' => 'Event type tidak dikenali'];
        }

        return $processed;
    }

    private function processAttlog($payload)
    {
        // Handle structure Fingerspot: { "type": "attlog", "data": { "pin": "...", "scan": "..." } }
        $attlogData = $payload['data'] ?? $payload;
        
        // Extract data dari payload
        $pin = $attlogData['pin'] ?? $attlogData['user_id'] ?? null;
        $scanTime = $attlogData['scan'] ?? $attlogData['scan_time'] ?? $attlogData['timestamp'] ?? now();
        $verify = $attlogData['verify'] ?? $attlogData['verification'] ?? null;
        $statusScan = $attlogData['status_scan'] ?? $attlogData['status'] ?? 0;
        $photoUrl = $attlogData['photo_url'] ?? null;
        
        // Convert status_scan ke human-readable status
        // Jika status_scan tidak dikirim atau 0, gunakan default check-in
        $status = match($statusScan) {
            0 => 'check-in',
            1 => 'check-out', 
            2 => 'break-in',
            3 => 'break-out',
            default => 'check-in'
        };

        // Log untuk debugging
        Log::info('Attlog Processing', [
            'pin' => $pin,
            'verify' => $verify,
            'status_scan' => $statusScan,
            'determined_status' => $status,
            'scan_time' => $scanTime,
        ]);

        if ($pin) {
            Attlog::create([
                'pin' => $pin,
                'scan_time' => $scanTime,
                'status' => $status,
                'verify' => $verify,
                'photo_url' => $photoUrl,
                'raw_payload' => $payload,
            ]);
        }

        return [
            'type' => 'attlog',
            'pin' => $pin,
            'scan_time' => $scanTime,
            'status' => $status,
            'verify' => $verify,
            'photo_url' => $photoUrl,
        ];
    }

    private function processUserinfo($payload)
    {
        // Extract data user
        $pin = $payload['pin'] ?? $payload['user_id'] ?? null;
        $name = $payload['name'] ?? $payload['fullname'] ?? null;
        $department = $payload['department'] ?? null;
        $position = $payload['position'] ?? null;
        $cardNumber = $payload['card_number'] ?? null;

        if ($pin && $name) {
            Userinfo::updateOrCreate(
                ['pin' => $pin],
                [
                    'name' => $name,
                    'department' => $department,
                    'position' => $position,
                    'card_number' => $cardNumber,
                    'raw_payload' => $payload,
                ]
            );
        }

        return [
            'type' => 'userinfo',
            'pin' => $pin,
            'name' => $name,
        ];
    }

    private function processSetUserinfo($payload)
    {
        $pin = $payload['pin'] ?? null;
        $status = $payload['status'] ?? 'success';

        // Cari API request yang pending
        $apiRequest = ApiRequest::where('command', 'Set Userinfo')
            ->where('status', 'pending')
            ->where('payload->pin', $pin)
            ->latest()
            ->first();

        if ($apiRequest) {
            $apiRequest->update([
                'status' => $status === 'success' ? 'success' : 'failed',
                'response' => $payload,
            ]);
        }

        return [
            'type' => 'set_userinfo',
            'pin' => $pin,
            'status' => $status,
        ];
    }

    private function processDeleteUserinfo($payload)
    {
        $pin = $payload['pin'] ?? null;
        $status = $payload['status'] ?? 'success';

        if ($status === 'success' && $pin) {
            Userinfo::where('pin', $pin)->delete();
            Attlog::where('pin', $pin)->delete();
        }

        // Cari API request yang pending
        $apiRequest = ApiRequest::where('command', 'Delete Userinfo')
            ->where('status', 'pending')
            ->where('payload->pin', $pin)
            ->latest()
            ->first();

        if ($apiRequest) {
            $apiRequest->update([
                'status' => $status === 'success' ? 'success' : 'failed',
                'response' => $payload,
            ]);
        }

        return [
            'type' => 'delete_userinfo',
            'pin' => $pin,
            'status' => $status,
        ];
    }

    private function processGetAllPin($payload)
    {
        $pins = $payload['pins'] ?? $payload['data'] ?? [];

        if (!empty($pins)) {
            // Hapus semua PIN lama, lalu simpan yang baru
            Pin::truncate();

            foreach ($pins as $pinData) {
                // Handle different response formats from Fingerspot
                if (is_array($pinData)) {
                    $pin = $pinData['pin'] ?? $pinData['user_id'] ?? $pinData['cloud_id'] ?? null;
                    $deviceName = $pinData['device_name'] ?? $pinData['name'] ?? null;
                    $deviceSn = $pinData['device_sn'] ?? $pinData['sn'] ?? null;
                } else {
                    // If pinData is just a string/number, treat it as the PIN
                    $pin = $pinData;
                    $deviceName = null;
                    $deviceSn = null;
                }

                if ($pin) {
                    Pin::create([
                        'pin' => $pin,
                        'device_name' => $deviceName,
                        'device_sn' => $deviceSn,
                        'is_active' => true,
                        'raw_payload' => $pinData,
                    ]);
                }
            }
        }

        // Cari API request yang pending
        $apiRequest = ApiRequest::where('command', 'Get All PIN')
            ->where('status', 'pending')
            ->latest()
            ->first();

        if ($apiRequest) {
            $apiRequest->update([
                'status' => 'success',
                'response' => $payload,
            ]);
        }

        return [
            'type' => 'get_all_pin',
            'total_pins' => count($pins),
        ];
    }

    private function processSetTime($payload)
    {
        $status = $payload['status'] ?? 'success';

        // Cari API request yang pending
        $apiRequest = ApiRequest::where('command', 'Set Time')
            ->where('status', 'pending')
            ->latest()
            ->first();

        if ($apiRequest) {
            $apiRequest->update([
                'status' => $status === 'success' ? 'success' : 'failed',
                'response' => $payload,
            ]);
        }

        return [
            'type' => 'set_time',
            'status' => $status,
        ];
    }

    private function processRegisterOnline($payload)
    {
        $pin = $payload['pin'] ?? null;
        $status = $payload['status'] ?? 'success';

        // Cari API request yang pending
        $apiRequest = ApiRequest::where('command', 'Register Online')
            ->where('status', 'pending')
            ->where('payload->pin', $pin)
            ->latest()
            ->first();

        if ($apiRequest) {
            $apiRequest->update([
                'status' => $status === 'success' ? 'success' : 'failed',
                'response' => $payload,
            ]);
        }

        return [
            'type' => 'register_online',
            'pin' => $pin,
            'status' => $status,
        ];
    }
}