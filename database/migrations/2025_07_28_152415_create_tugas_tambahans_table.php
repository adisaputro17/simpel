<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTugasTambahansTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tugas_tambahans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nip');
            $table->foreign('nip')->references('nip')->on('pegawais')->onDelete('cascade');
            $table->date('tanggal');
            $table->string('bulan');
            $table->string('tahun');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->string('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tugas_tambahans');
    }
};
