<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attlogs', function (Blueprint $table) {
            $table->id();
            $table->string('pin');
            $table->timestamp('scan_time');
            $table->string('status')->nullable();
            $table->json('raw_payload')->nullable();
            $table->timestamps();
            
            $table->index('pin');
            $table->index('scan_time');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attlogs');
    }
};