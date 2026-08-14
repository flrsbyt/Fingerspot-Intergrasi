<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class ChangelogController extends Controller
{
    /**
     * Display the changelog page.
     */
    public function index(): View
    {
        $changelogs = [
            [
                'version' => '1.3.0',
                'date' => '2024-08-14',
                'changes' => [
                    '📊 Perbaikan dan peningkatan fitur Dashboard',
                    '📡 Penambahan status Online/Offline untuk setiap mesin absensi di dashboard',
                    '🔍 Penambahan statistik metode verifikasi (sidik jari, wajah, kartu, dll)',
                    '📷 Penambahan link foto absensi pada tabel data terbaru',
                    '⚡ Implementasi caching untuk optimasi performa dashboard',
                    '🔄 Penambahan realtime indicator dan auto-update stats setiap 30 detik',
                    '🎨 Perbaikan tampilan tabel absensi dengan metode verifikasi',
                    '📈 Optimasi chart data generation untuk 7 hari terakhir',
                ]
            ],
            [
                'version' => '1.2.0',
                'date' => '2024-08-14',
                'changes' => [
                    '🔄 Implementasi sistem monitoring realtime untuk data absensi',
                    '📡 Penambahan status Online/Offline untuk setiap mesin absensi dengan indikator visual',
                    '⚡ Optimasi polling data dengan interval 10 detik untuk data absensi dan 30 detik untuk status mesin',
                    '🚀 Implementasi caching untuk mengurangi beban database dan API calls',
                    '📊 Penambahan database indexes untuk optimasi query performance',
                    '🎨 Perbaikan tampilan data absensi dengan metode verifikasi (sidik jari, wajah, kartu, dll)',
                    '📷 Penambahan link foto absensi pada data scan',
                    '🔔 Notifikasi toast otomatis saat data absensi baru masuk',
                    '🔧 Perbaikan format API Fingerspot sesuai dokumentasi resmi',
                    '🛡️ Exclude webhook route dari CSRF protection',
                    '📊 Perbaikan sistem filter data absensi dengan lebih banyak opsi',
                    '⏸️ Otomatis pause polling saat tab tidak aktif untuk hemat resource',
                ]
            ],
            [
                'version' => '1.1.0',
                'date' => '2024-08-13',
                'changes' => [
                    '🔧 Perbaiki Fingerspot API integration format',
                    '✅ Tambahkan support untuk cloud_id dan trans_id di request body',
                    '🔄 Update checkConnection method untuk menggunakan endpoint yang benar',
                    '🐛 Perbaiki method addDevice untuk handle semua field yang diperlukan',
                ]
            ],
            [
                'version' => '1.0.0',
                'date' => '2024-01-01',
                'changes' => [
                    'Initial release',
                    'Integrasi dengan Fingerspot API',
                    'Fitur manajemen karyawan',
                    'Fitur manajemen perangkat',
                    'Dashboard monitoring',
                ]
            ],
        ];

        return view('admin.changelog', compact('changelogs'));
    }
}
