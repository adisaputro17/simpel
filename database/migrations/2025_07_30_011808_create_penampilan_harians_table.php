<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenampilanHariansTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penampilan_harians', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nip');
            $table->foreign('nip')->references('nip')->on('pegawais')->onDelete('cascade');
            $table->date('tanggal');
            $table->string('bulan');
            $table->string('tahun');
            $table->unsignedTinyInteger('atribut_lengkap')->nullable();
            $table->unsignedTinyInteger('seragam_sesuai_jadwal')->nullable();
            $table->unsignedTinyInteger('seragam_sesuai_aturan')->nullable();
            $table->unsignedTinyInteger('rapi')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penampilan_harians');
    }
};
