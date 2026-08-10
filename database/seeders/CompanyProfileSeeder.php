<?php

namespace Database\Seeders;

use App\Models\CompanyProfile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanyProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CompanyProfile::firstOrCreate(
            ['id' => 1],
            [
                'company_name' => env('COMPANY_NAME', 'FingerSpot Integration'),
                'company_email' => env('COMPANY_EMAIL', 'admin@fingerspot.com'),
                'company_phone' => env('COMPANY_PHONE', '081234567890'),
                'company_address' => env('COMPANY_ADDRESS', 'Alamat perusahaan...'),
            ]
        );
    }
}
