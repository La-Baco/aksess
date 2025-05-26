<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('setting_absensi', function (Blueprint $table) {
            $table->id();
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->decimal('lokasi_lat', 10, 8)->nullable();
            $table->decimal('lokasi_long', 11, 8)->nullable();
            $table->float('radius_meter')->default(100); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('setting_absensi');
    }
};
