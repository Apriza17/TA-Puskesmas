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
        Schema::create('anak', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('posyandu_id');
            $table->string('nama');
            $table->string('nik', 16)->unique();
            $table->enum('kelamin',['L','P']);
            $table->date('tanggal_lahir');
            $table->float('berat_lahir');
            $table->float('tinggi_lahir');
            $table->timestamps();

            $table->foreign('posyandu_id')->references('id')->on('posyandu')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anak');
    }
};
