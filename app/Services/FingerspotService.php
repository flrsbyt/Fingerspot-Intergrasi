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

        // Handle empty or 'all' pin parameter
        $pin = $params['pin'] ?? 'all';

        if (empty($pin) || $pin === 'all') {
            $pin = 'all';
        }

        Log::info('FingerspotService getUserinfo', [
            'cloud_id' => $cloudId,
            'pin' => $pin,
            'original_params' => $params,
        ]);

        $result = $this->sendRequest($cloudId, 'get_userinfo', ['pin' => $pin]);
        
        // Log detailed response for debugging
        Log::info('Get Userinfo Raw Response', [
            'cloud_id' => $cloudId,
            'pin' => $pin,
            'result' => $result,
        ]);
        
        return $result;

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
        $requiredFields = ['pin', 'verification'];

        foreach ($requiredFields as $field) {
            if (!isset($data[$field])) {
                return [
                    'success' => false,
                    'message' => "Field '$field' wajib diisi"
                ];
            }
        }

        $result = $this->sendRequest($cloudId, 'register_online', $data);
        
        // Log raw response untuk debugging
        \Log::info('Register Online Raw Response', [
            'cloud_id' => $cloudId,
            'data' => $data,
            'result' => $result,
        ]);
        
        return $result;
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

            // Gunakan get_device untuk cek koneksi sesuai dokumentasi

            $url = "{$this->apiUrl}/get_device";

            $response = Http::timeout(5)

                ->withHeaders([

                    'Authorization' => 'Bearer ' . $this->apiKey,

                    'Content-Type' => 'application/json',

                ])

                ->post($url, [

                    'cloud_id' => $cloudId,

                    'trans_id' => uniqid(),

                ]);



            return [

                'success' => $response->successful(),

                'status_code' => $response->status(),

                'online' => $response->successful(),

                'data' => $response->json(),

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

     * 10. Check Multiple Connections - Cek koneksi ke multiple mesin sekaligus

     */

    public function checkMultipleConnections($cloudIds)

    {

        $results = [];



        foreach ($cloudIds as $cloudId) {

            $results[$cloudId] = $this->checkConnection($cloudId);

        }



        return $results;

    }



    /**

     * Method utama untuk mengirim request ke API Fingerspot

     */

    private function sendRequest($cloudId, $command, $params = [])

    {

        try {

            // Format URL yang benar sesuai dokumentasi: https://developer.fingerspot.io/api/{command}

            $url = "{$this->apiUrl}/{$command}";



            // Tambahkan cloud_id dan trans_id ke params

            $requestParams = array_merge($params, [

                'cloud_id' => $cloudId,

                'trans_id' => uniqid(),

            ]);



            Log::info('Fingerspot API Request', [

                'url' => $url,

                'cloud_id' => $cloudId,

                'command' => $command,

                'params' => $requestParams,

            ]);



            $response = Http::withHeaders([

                'Authorization' => 'Bearer ' . $this->apiKey,

                'Content-Type' => 'application/json',

            ])->post($url, $requestParams);



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