<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeluhansTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('keluhans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('tanggal');
            $table->integer('bulan');
            $table->integer('tahun');
            $table->enum('jenis_layanan', ['internal', 'eksternal']);
            $table->unsignedBigInteger('layanan_id');
            $table->foreign('layanan_id')->references('id')->on('layanans')->onDelete('cascade');
            $table->string('dari')->nullable();
            $table->foreign('dari')->references('nip')->on('pegawais')->onDelete('set null');
            $table->string('sumber')->nullable();
            $table->string('kepada');
            $table->foreign('kepada')->references('nip')->on('pegawais')->onDelete('cascade');
            $table->enum('jenis_permasalahan', ['internal', 'eksternal']);
            $table->text('deskripsi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keluhans');
    }
};
