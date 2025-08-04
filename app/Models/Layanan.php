<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    protected $fillable = [
        'nama', 'jenis', 'tahun',
        'bulan_01', 'bulan_02', 'bulan_03',
        'bulan_04', 'bulan_05', 'bulan_06',
        'bulan_07', 'bulan_08', 'bulan_09',
        'bulan_10', 'bulan_11', 'bulan_12',
    ];
}
