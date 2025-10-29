<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('antrian', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_antrian', 10);
            $table->integer('loket_id');
            $table->enum('status', ['menunggu', 'dipanggil', 'selesai'])->default('menunggu');
            $table->string('nama_pasien')->nullable();
            $table->string('jenis_layanan')->nullable();
            $table->timestamp('waktu_panggil')->nullable();
            $table->timestamps();

            $table->index(['loket_id', 'status']);
            $table->index('nomor_antrian');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('antrian');
    }
};
