<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FingerspotService;
use App\Models\ApiRequest;
use App\Models\CommandLog;

class CommandPanelController extends Controller
{
    protected $fingerspot;

    // ✅ TAMBAHKAN INI!
    public function __construct(FingerspotService $fingerspot)
    {
        $this->fingerspot = $fingerspot;
    }

    // 1. Get Attlog
    public function getAttlog(Request $request)
    {
        $cloudId = $request->input('device');
        $params = [
            'pin' => $request->input('pin', 'all'),
            'start_date' => $request->input('start_date', date('Y-m-d')),
            'end_date' => $request->input('end_date', date('Y-m-d')),
        ];

        if (empty($cloudId)) {
            return response()->json([
                'success' => false,
                'message' => '❌ Mesin absensi wajib dipilih'
            ]);
        }

        $apiRequest = ApiRequest::create([
            'command' => 'Get Attlog',
            'payload' => array_merge(['cloud_id' => $cloudId], $params),
            'status' => 'pending',
            'request_id' => 'req_' . uniqid(),
        ]);

        $result = $this->fingerspot->getAttlog($cloudId, $params);

        $apiRequest->update([
            'status' => $result['success'] ? 'success' : 'failed',
            'response' => $result,
        ]);

        CommandLog::create([
            'command' => 'Get Attlog',
            'parameters' => array_merge(['cloud_id' => $cloudId], $params),
            'status' => $result['success'] ? 'executed' : 'failed',
            'message' => $result['success'] ? 'Berhasil mengambil data absensi' : 'Gagal mengambil data absensi',
        ]);

        return response()->json([
            'success' => $result['success'],
            'message' => $result['success'] ? '✅ Data absensi berhasil diambil' : '❌ Gagal mengambil data absensi',
            'data' => $result
        ]);
    }

    // 2. Get Userinfo
    public function getUserinfo(Request $request)
    {
        $cloudId = $request->input('device');
        $params = [
            'pin' => $request->input('pin', 'all'),
        ];

        if (empty($cloudId)) {
            return response()->json([
                'success' => false,
                'message' => '❌ Mesin absensi wajib dipilih'
            ]);
        }

        $apiRequest = ApiRequest::create([
            'command' => 'Get Userinfo',
            'payload' => array_merge(['cloud_id' => $cloudId], $params),
            'status' => 'pending',
            'request_id' => 'req_' . uniqid(),
        ]);

        $result = $this->fingerspot->getUserinfo($cloudId, $params);

        $apiRequest->update([
            'status' => $result['success'] ? 'success' : 'failed',
            'response' => $result,
        ]);

        // Log detailed response for debugging
        \Log::info('Get Userinfo Result', [
            'cloud_id' => $cloudId,
            'success' => $result['success'] ?? false,
            'status_code' => $result['status_code'] ?? null,
            'data' => $result['data'] ?? null,
            'raw' => $result['raw'] ?? null,
        ]);

        // API mengembalikan success tapi data dikirim via webhook
        if ($result['success']) {
            CommandLog::create([
                'command' => 'Get Userinfo',
                'parameters' => array_merge(['cloud_id' => $cloudId], $params),
                'status' => 'executed',
                'message' => 'Permintaan berhasil dikirim. Data user akan dikirim via webhook.',
            ]);

            return response()->json([
                'success' => true,
                'message' => '✅ Permintaan berhasil dikirim. Data user akan dikirim via webhook ke sistem secara otomatis.',
                'data' => $result,
                'note' => 'Data akan muncul di halaman Data Userinfo setelah diterima via webhook.',
            ]);
        }

        CommandLog::create([
            'command' => 'Get Userinfo',
            'parameters' => array_merge(['cloud_id' => $cloudId], $params),
            'status' => 'failed',
            'message' => 'Gagal mengirim permintaan: ' . ($result['message'] ?? 'Unknown error'),
        ]);

        return response()->json([
            'success' => false,
            'message' => '❌ Gagal mengirim permintaan: ' . ($result['message'] ?? 'Unknown error'),
            'data' => $result
        ]);
    }

    // 3. Set Userinfo
    public function setUserinfo(Request $request)
    {
        $cloudId = $request->input('device');
        $data = [
            'pin' => $request->input('pin'),
            'name' => $request->input('name'),
        ];

        if (empty($cloudId)) {
            return response()->json([
                'success' => false,
                'message' => '❌ Mesin absensi wajib dipilih'
            ]);
        }

        $apiRequest = ApiRequest::create([
            'command' => 'Set Userinfo',
            'payload' => array_merge(['cloud_id' => $cloudId], $data),
            'status' => 'pending',
            'request_id' => 'req_' . uniqid(),
        ]);

        $result = $this->fingerspot->setUserinfo($cloudId, $data);

        $apiRequest->update([
            'status' => $result['success'] ? 'success' : 'failed',
            'response' => $result,
        ]);

        CommandLog::create([
            'command' => 'Set Userinfo',
            'parameters' => array_merge(['cloud_id' => $cloudId], $data),
            'status' => $result['success'] ? 'executed' : 'failed',
            'message' => $result['success'] ? 'Berhasil mengirim data user' : 'Gagal mengirim data user',
        ]);

        // Simpan ke database lokal jika berhasil
        if ($result['success']) {
            \App\Models\Userinfo::updateOrCreate(
                ['pin' => $data['pin']],
                [
                    'name' => $data['name'],
                    'department' => null,
                    'position' => null,
                    'card_number' => null,
                ]
            );
        }

        return response()->json([
            'success' => $result['success'],
            'message' => $result['success'] ? '✅ Data user berhasil dikirim dan disimpan' : '❌ Gagal mengirim data user',
            'data' => $result
        ]);
    }

    // 4. Delete Userinfo
    public function deleteUserinfo(Request $request)
    {
        $cloudId = $request->input('device');
        $pin = $request->input('pin');

        if (empty($cloudId)) {
            return response()->json([
                'success' => false,
                'message' => '❌ Mesin absensi wajib dipilih'
            ]);
        }

        $apiRequest = ApiRequest::create([
            'command' => 'Delete Userinfo',
            'payload' => ['cloud_id' => $cloudId, 'pin' => $pin],
            'status' => 'pending',
            'request_id' => 'req_' . uniqid(),
        ]);

        $result = $this->fingerspot->deleteUserinfo($cloudId, $pin);

        $apiRequest->update([
            'status' => $result['success'] ? 'success' : 'failed',
            'response' => $result,
        ]);

        CommandLog::create([
            'command' => 'Delete Userinfo',
            'parameters' => ['cloud_id' => $cloudId, 'pin' => $pin],
            'status' => $result['success'] ? 'executed' : 'failed',
            'message' => $result['success'] ? 'Berhasil menghapus user' : 'Gagal menghapus user',
        ]);

        // Hapus dari database lokal jika berhasil
        if ($result['success']) {
            \App\Models\Userinfo::where('pin', $pin)->delete();
        }

        return response()->json([
            'success' => $result['success'],
            'message' => $result['success'] ? '✅ User berhasil dihapus dari mesin dan database' : '❌ Gagal menghapus user',
            'data' => $result
        ]);
    }

    // 5. Get All PIN
    public function getAllPin(Request $request)
    {
        $cloudId = $request->input('device');

        if (empty($cloudId)) {
            return response()->json([
                'success' => false,
                'message' => '❌ Mesin absensi wajib dipilih'
            ]);
        }

        $apiRequest = ApiRequest::create([
            'command' => 'Get All PIN',
            'payload' => ['cloud_id' => $cloudId],
            'status' => 'pending',
            'request_id' => 'req_' . uniqid(),
        ]);

        $result = $this->fingerspot->getAllPin($cloudId);

        $apiRequest->update([
            'status' => $result['success'] ? 'success' : 'failed',
            'response' => $result,
        ]);

        // Log detailed response for debugging
        \Log::info('Get All PIN Result', [
            'cloud_id' => $cloudId,
            'success' => $result['success'] ?? false,
            'status_code' => $result['status_code'] ?? null,
            'data' => $result['data'] ?? null,
            'raw' => $result['raw'] ?? null,
        ]);

        // API mengembalikan success tapi data dikirim via webhook
        if ($result['success']) {
            CommandLog::create([
                'command' => 'Get All PIN',
                'parameters' => ['cloud_id' => $cloudId],
                'status' => 'executed',
                'message' => 'Permintaan berhasil dikirim. Data PIN akan dikirim via webhook.',
            ]);

            return response()->json([
                'success' => true,
                'message' => '✅ Permintaan berhasil dikirim. Data PIN akan dikirim via webhook ke sistem secara otomatis.',
                'data' => $result,
                'note' => 'Data akan muncul di halaman Data Userinfo setelah diterima via webhook.',
            ]);
        }

        CommandLog::create([
            'command' => 'Get All PIN',
            'parameters' => ['cloud_id' => $cloudId],
            'status' => 'failed',
            'message' => 'Gagal mengirim permintaan: ' . ($result['message'] ?? 'Unknown error'),
        ]);

        return response()->json([
            'success' => false,
            'message' => '❌ Gagal mengirim permintaan: ' . ($result['message'] ?? 'Unknown error'),
            'data' => $result,
        ]);
    }

    // 6. Set Time
    public function setTime(Request $request)
    {
        $cloudId = $request->input('device');
        $timezone = $request->input('timezone', date('Y-m-d H:i:s'));

        if (empty($cloudId)) {
            return response()->json([
                'success' => false,
                'message' => '❌ Mesin absensi wajib dipilih'
            ]);
        }

        $apiRequest = ApiRequest::create([
            'command' => 'Set Time',
            'payload' => ['cloud_id' => $cloudId, 'time' => $timezone],
            'status' => 'pending',
            'request_id' => 'req_' . uniqid(),
        ]);

        $result = $this->fingerspot->setTime($cloudId, $timezone);

        $apiRequest->update([
            'status' => $result['success'] ? 'success' : 'failed',
            'response' => $result,
        ]);

        CommandLog::create([
            'command' => 'Set Time',
            'parameters' => ['cloud_id' => $cloudId, 'time' => $timezone],
            'status' => $result['success'] ? 'executed' : 'failed',
            'message' => $result['success'] ? 'Berhasil mengatur waktu mesin' : 'Gagal mengatur waktu mesin',
        ]);

        return response()->json([
            'success' => $result['success'],
            'message' => $result['success'] ? '✅ Waktu mesin berhasil diatur' : '❌ Gagal mengatur waktu mesin',
            'data' => $result
        ]);
    }

    // 7. Register Online
    public function registerOnline(Request $request)
    {
        $cloudId = $request->input('device');
        $data = [
            'pin' => $request->input('pin'),
        ];

        if (empty($cloudId)) {
            return response()->json([
                'success' => false,
                'message' => '❌ Mesin absensi wajib dipilih'
            ]);
        }

        if (empty($data['pin'])) {
            return response()->json([
                'success' => false,
                'message' => '❌ PIN wajib diisi'
            ]);
        }

        $apiRequest = ApiRequest::create([
            'command' => 'Register Online',
            'payload' => array_merge(['cloud_id' => $cloudId], $data),
            'status' => 'pending',
            'request_id' => 'req_' . uniqid(),
        ]);

        $result = $this->fingerspot->registerOnline($cloudId, $data);

        $apiRequest->update([
            'status' => $result['success'] ? 'success' : 'failed',
            'response' => $result,
        ]);

        // Log detailed response for debugging
        \Log::info('Register Online Result', [
            'cloud_id' => $cloudId,
            'success' => $result['success'] ?? false,
            'status_code' => $result['status_code'] ?? null,
            'data' => $result['data'] ?? null,
            'raw' => $result['raw'] ?? null,
        ]);

        // API mengembalikan success tapi data dikirim via webhook
        if ($result['success']) {
            CommandLog::create([
                'command' => 'Register Online',
                'parameters' => array_merge(['cloud_id' => $cloudId], $data),
                'status' => 'executed',
                'message' => 'Permintaan register berhasil dikirim. Data akan dikirim via webhook.',
            ]);

            return response()->json([
                'success' => true,
                'message' => '✅ Permintaan register berhasil dikirim. Data akan dikirim via webhook ke sistem secara otomatis.',
                'data' => $result,
                'note' => 'Data user akan muncul di halaman Data Userinfo setelah diterima via webhook.',
            ]);
        }

        CommandLog::create([
            'command' => 'Register Online',
            'parameters' => array_merge(['cloud_id' => $cloudId], $data),
            'status' => 'failed',
            'message' => 'Gagal mengirim permintaan register: ' . ($result['message'] ?? 'Unknown error'),
        ]);

        return response()->json([
            'success' => false,
            'message' => '❌ Gagal mengirim permintaan register: ' . ($result['message'] ?? 'Unknown error'),
            'data' => $result
        ]);
    }

    // 8. Restart Mesin
    public function restartMesin(Request $request)
    {
        $cloudId = $request->input('device');

        if (empty($cloudId)) {
            return response()->json([
                'success' => false,
                'message' => '❌ Mesin absensi wajib dipilih'
            ]);
        }

        $apiRequest = ApiRequest::create([
            'command' => 'Restart Mesin',
            'payload' => ['cloud_id' => $cloudId],
            'status' => 'pending',
            'request_id' => 'req_' . uniqid(),
        ]);

        $result = $this->fingerspot->restartMesin($cloudId);

        $apiRequest->update([
            'status' => $result['success'] ? 'success' : 'failed',
            'response' => $result,
        ]);

        CommandLog::create([
            'command' => 'Restart Mesin',
            'parameters' => ['cloud_id' => $cloudId],
            'status' => $result['success'] ? 'executed' : 'failed',
            'message' => $result['success'] ? 'Berhasil restart mesin' : 'Gagal restart mesin',
        ]);

        return response()->json([
            'success' => $result['success'],
            'message' => $result['success'] ? '✅ Mesin berhasil direstart' : '❌ Gagal restart mesin',
            'data' => $result
        ]);
    }
}