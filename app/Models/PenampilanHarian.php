<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenampilanHarian extends Model
{
    protected $fillable = [
        'nip', 'tanggal', 'bulan', 'tahun',
        'atribut_lengkap', 'seragam_sesuai_jadwal', 'seragam_sesuai_aturan', 'rapi', 'keterangan',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'nip', 'nip');
    }
}
