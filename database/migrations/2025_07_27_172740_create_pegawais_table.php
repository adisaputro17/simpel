<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePegawaisTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pegawais', function (Blueprint $table) {
            $table->string('nip')->primary();
            $table->string('nama');
            $table->string('password');
            $table->string('role');
            $table->string('atasan_id')->nullable();
            $table->timestamps();
        });

        // Tambahkan foreign key setelah tabel selesai dibuat
        Schema::table('pegawais', function (Blueprint $table) {
            $table->foreign('atasan_id')->references('nip')->on('pegawais')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawais');
    }
};
