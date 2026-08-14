<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('attlogs', function (Blueprint $table) {
            $table->integer('verify')->nullable()->after('status');
            $table->string('photo_url')->nullable()->after('verify');
        });
    }

    public function down(): void
    {
        Schema::table('attlogs', function (Blueprint $table) {
            $table->dropColumn(['verify', 'photo_url']);
        });
    }
};
