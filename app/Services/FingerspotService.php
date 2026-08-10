<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FingerspotService
{
    protected $apiUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->apiUrl = config('services.fingerspot.api_url');
        $this->apiKey = config('services.fingerspot.api_key');
    }

    /**
     * 1. Get Attlog - Ambil data absensi dari mesin
     */
    public function getAttlog($cloudId, $params = [])
    {
        $defaultParams = [
            'pin' => 'all',
            'start_date' => date('Y-m-d'),
            'end_date' => date('Y-m-d'),
        ];

        $params = array_merge($defaultParams, $params);

        return $this->sendRequest($cloudId, 'get_attlog', $params);
    }

    /**
     * 2. Get Userinfo - Ambil data user dari mesin
     */
    public function getUserinfo($cloudId, $params = [])
    {
        $defaultParams = [
            'pin' => 'all',
        ];

        $params = array_merge($defaultParams, $params);

        return $this->sendRequest($cloudId, 'get_userinfo', $params);
    }

    /**
     * 3. Set Userinfo - Kirim data user ke mesin
     */
    public function setUserinfo($cloudId, $data)
    {
        $requiredFields = ['pin', 'name'];
        foreach ($requiredFields as $field) {
            if (!isset($data[$field])) {
                return [
                    'success' => false,
                    'message' => "Field '$field' wajib diisi"
                ];
            }
        }

        return $this->sendRequest($cloudId, 'set_userinfo', $data);
    }

    /**
     * 4. Delete Userinfo - Hapus data user dari mesin
     */
    public function deleteUserinfo($cloudId, $pin)
    {
        if (empty($pin)) {
            return [
                'success' => false,
                'message' => 'PIN wajib diisi'
            ];
        }

        return $this->sendRequest($cloudId, 'delete_userinfo', ['pin' => $pin]);
    }

    /**
     * 5. Get All PIN - Ambil semua User ID dari mesin
     */
    public function getAllPin($cloudId)
    {
        return $this->sendRequest($cloudId, 'get_all_pin', []);
    }

    /**
     * 6. Set Time - Ubah waktu/timezone mesin
     */
    public function setTime($cloudId, $timezone = null)
    {
        if (empty($timezone)) {
            $timezone = date('Y-m-d H:i:s');
        }

        return $this->sendRequest($cloudId, 'set_time', ['time' => $timezone]);
    }

    /**
     * 7. Register Online - Registrasi user ke mesin
     */
    public function registerOnline($cloudId, $data)
    {
        $requiredFields = ['pin', 'name'];
        foreach ($requiredFields as $field) {
            if (!isset($data[$field])) {
                return [
                    'success' => false,
                    'message' => "Field '$field' wajib diisi"
                ];
            }
        }

        return $this->sendRequest($cloudId, 'register_online', $data);
    }

    /**
     * 8. Restart Mesin - Restart mesin
     */
    public function restartMesin($cloudId)
    {
        return $this->sendRequest($cloudId, 'restart', []);
    }

    /**
     * 9. Check Connection - Cek koneksi ke mesin
     */
    public function checkConnection($cloudId)
    {
        try {
            $url = "{$this->apiUrl}/{$cloudId}/get_all_pin";
            $response = Http::timeout(5)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                ])
                ->get($url);

            return [
                'success' => $response->successful(),
                'status_code' => $response->status(),
                'online' => $response->successful(),
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'online' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Method utama untuk mengirim request ke API Fingerspot
     */
    private function sendRequest($cloudId, $command, $params = [])
    {
        try {
            $url = "{$this->apiUrl}/{$cloudId}/{$command}";

            Log::info('Fingerspot API Request', [
                'url' => $url,
                'cloud_id' => $cloudId,
                'command' => $command,
                'params' => $params,
            ]);

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($url, $params);

            $result = [
                'success' => $response->successful(),
                'status_code' => $response->status(),
                'data' => $response->json(),
                'raw' => $response->body(),
                'request_id' => uniqid('req_'),
            ];

            Log::info('Fingerspot API Response', [
                'command' => $command,
                'success' => $result['success'],
                'status_code' => $result['status_code'],
                'response' => $result['data'],
            ]);

            return $result;
        } catch (\Exception $e) {
            Log::error('Fingerspot API Error', [
                'command' => $command,
                'message' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }
}