<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLayanansTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('layanans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama');
            $table->enum('jenis', ['internal', 'eksternal']);
            $table->unsignedInteger('tahun');

            // Bulan 01 sampai 12
            for ($i = 1; $i <= 12; $i++) {
                $bulan = str_pad($i, 2, '0', STR_PAD_LEFT);
                $table->unsignedInteger("bulan_$bulan")->default(0);
            }
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('layanans');
    }
};
