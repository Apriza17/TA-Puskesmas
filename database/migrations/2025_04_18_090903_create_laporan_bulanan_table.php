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
        Schema::create('laporan_bulanan_posyandu', function (Blueprint $table) {
            $table->id();
            $table->foreignId('posyandu_id')->constrained('posyandu')->onDelete('cascade');
            $table->date('tanggal_laporan');
            $table->enum('status', ['sudah', 'belum'])->default('belum');
            $table->timestamps();

            $table->unique(['posyandu_id', 'tanggal_laporan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_bulanan');
    }
};
