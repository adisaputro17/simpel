<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenilaiansTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penilaians', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nip');
            $table->foreign('nip')->references('nip')->on('pegawais')->onDelete('cascade');
            $table->enum('jenis', ['objektif', 'kerja_sama', 'inovasi']);
            $table->string('bulan');
            $table->string('tahun');
            $table->unsignedTinyInteger('nilai');
            $table->text('keterangan')->nullable();
            $table->string('dari')->nullable();
            $table->foreign('dari')->references('nip')->on('pegawais')->onDelete('cascade');
            $table->timestamps();

            // $table->unique(['nip', 'jenis', 'bulan', 'tahun'], 'unique_penilaian_per_bulan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaians');
    }
};
