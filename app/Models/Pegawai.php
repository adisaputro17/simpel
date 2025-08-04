<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Pegawai extends Authenticatable
{
    protected $primaryKey = 'nip';
    public $incrementing = false; // karena 'nip' bukan auto-increment
    protected $keyType = 'string'; // sesuaikan kalau nip berupa string

    protected $table = 'pegawais';

    protected $fillable = [
        'nip', 'nama', 'password', 'atasan_id', 'role'
    ];

    protected $hidden = [
        'password',
    ];

    public function bawahan()
    {
        return $this->hasMany(Pegawai::class, 'atasan_id', 'nip');
    }

    public function atasan()
    {
        return $this->belongsTo(Pegawai::class, 'atasan_id', 'nip');
    }
}
