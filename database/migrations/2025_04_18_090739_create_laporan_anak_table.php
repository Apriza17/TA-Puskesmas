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
        Schema::create('laporan_anak_bulanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anak_id')->constrained('anak')->onDelete('cascade');
            $table->date('tanggal_pemeriksaan');
            $table->float('berat_badan');
            $table->float('tinggi_badan');
            $table->float('lingkar_kepala');
            $table->float('lingkar_lengan_atas');
            $table->enum('status', ['Normal', 'Stunting'])->nullable(); // bisa di-set otomatis
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_anak');
    }
};
