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
