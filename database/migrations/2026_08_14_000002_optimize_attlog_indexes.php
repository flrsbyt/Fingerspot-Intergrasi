<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('attlogs', function (Blueprint $table) {
            // Add composite index for common queries
            $table->index(['scan_time', 'id'], 'scan_time_id_index');
            $table->index(['pin', 'scan_time'], 'pin_scan_time_index');
            $table->index(['status', 'scan_time'], 'status_scan_time_index');
        });
    }

    public function down(): void
    {
        Schema::table('attlogs', function (Blueprint $table) {
            $table->dropIndex(['scan_time_id_index']);
            $table->dropIndex(['pin_scan_time_index']);
            $table->dropIndex(['status_scan_time_index']);
        });
    }
};
