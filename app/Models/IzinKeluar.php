<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IzinKeluar extends Model
{
    protected $fillable = [
        'nip', 'tanggal', 'bulan', 'tahun', 'jam_keluar', 'jam_kembali', 'keterangan'
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'nip', 'nip');
    }
}
