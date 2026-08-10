<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Userinfo, Attlog, Pin, ApiRequest, WebhookLog, CommandLog};
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat 1 device PIN
        Pin::create([
            'pin' => '123456',
            'device_name' => 'Mesin Absensi Kantor',
            'device_sn' => 'FS-2024-001',
            'is_active' => true,
        ]);

        // 2. Buat 5 karyawan (bukan 20)
        $employees = [];
        $departments = ['IT', 'HR', 'Finance', 'Marketing', 'Operations'];
        $positions = ['Staff', 'Senior Staff', 'Supervisor', 'Manager'];

        for ($i = 1; $i <= 5; $i++) {
            $employees[] = Userinfo::create([
                'pin' => str_pad($i, 6, '0', STR_PAD_LEFT),
                'name' => "Karyawan {$i}",
                'department' => $departments[array_rand($departments)],
                'position' => $positions[array_rand($positions)],
            ]);
        }

        // 3. Buat data absensi 5 hari (bukan 7)
        $now = Carbon::now();
        foreach ($employees as $emp) {
            for ($day = 0; $day < 5; $day++) {
                $date = $now->copy()->subDays($day);
                
                // Check-in
                Attlog::create([
                    'pin' => $emp->pin,
                    'scan_time' => $date->copy()->setTime(rand(7, 9), rand(0, 59)),
                    'status' => 'check-in',
                ]);
                
                // Check-out
                Attlog::create([
                    'pin' => $emp->pin,
                    'scan_time' => $date->copy()->setTime(rand(16, 18), rand(0, 59)),
                    'status' => 'check-out',
                ]);
            }
        }

        // 4. Log API contoh
        ApiRequest::create([
            'command' => 'Get Attlog',
            'payload' => ['start_date' => '2026-01-01', 'end_date' => '2026-01-07'],
            'status' => 'success',
            'request_id' => 'req_' . uniqid(),
            'response' => ['message' => 'Data berhasil diambil', 'total' => 50],
        ]);

        // 5. Log Webhook contoh
        WebhookLog::create([
            'event_type' => 'attlog',
            'payload' => [
                'pin' => '000001',
                'scan_time' => Carbon::now()->toISOString(),
                'status' => 'check-in'
            ],
            'status' => 'received',
            'processed_data' => ['pin' => '000001', 'scan_time' => Carbon::now()->toISOString()],
        ]);

        // 6. Log Command contoh
        CommandLog::create([
            'command' => 'Get All PIN',
            'parameters' => ['device_id' => 1],
            'status' => 'executed',
            'message' => 'Berhasil mengambil 1 PIN',
        ]);

        $this->command->info('✅ Seeder berhasil dijalankan!');
        $this->command->info('📊 5 karyawan, 50 data absensi, 1 PIN, dan log contoh telah dibuat.');
    }
}