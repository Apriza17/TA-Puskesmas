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
        Schema::create('tb_stunting_standar', function (Blueprint $table) {
            $table->id();
            $table->enum('jenis_kelamin', ['L', 'P']); // Laki-laki / Perempuan
            $table->unsignedTinyInteger('umur_bulan'); // usia dalam bulan
            $table->float('sd_min_3');
            $table->float('sd_min_2');
            $table->float('sd_min_1');
            $table->float('median');
            $table->float('sd_plus_1');
            $table->float('sd_plus_2');
            $table->float('sd_plus_3');
            $table->timestamps();

            $table->unique(['jenis_kelamin', 'umur_bulan']); // tidak boleh duplikat kombinasi
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_stunting_standar');
    }
};
