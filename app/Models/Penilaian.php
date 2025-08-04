<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    protected $fillable = [
        'nip', 'dari', 'jenis', 'bulan', 'tahun', 'nilai', 'keterangan'
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'nip', 'nip');
    }

    public function penilai()
    {
        return $this->belongsTo(Pegawai::class, 'dari', 'nip');
    }
}
