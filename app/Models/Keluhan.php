<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keluhan extends Model
{
    protected $fillable = [
        'tanggal', 'bulan', 'tahun',
        'jenis_layanan', 'layanan_id',
        'dari', 'sumber', 'kepada',
        'jenis_permasalahan', 'deskripsi'
    ];

    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }

    public function dariPegawai()
    {
        return $this->belongsTo(Pegawai::class, 'dari', 'nip');
    }

    public function kepadaPegawai()
    {
        return $this->belongsTo(Pegawai::class, 'kepada', 'nip');
    }
}
