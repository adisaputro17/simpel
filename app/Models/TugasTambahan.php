<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TugasTambahan extends Model
{
    protected $fillable = [
        'nip', 'tanggal', 'bulan', 'tahun', 'jam_mulai', 'jam_selesai', 'keterangan'
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'nip', 'nip');
    }
}
