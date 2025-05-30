<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JanjiPeriksa extends Model
{
    protected $table = 'janji_periksas';
    protected $fillable = [
        'id_pasien',
        'id_jadwal',
        'status',
        'tanggal_periksa',
        'keluhan',
    ];

    public function pasien()
    {
        return $this->belongsTo(User::class, 'id_pasien');
    }

    public function jadwal()
    {
        return $this->belongsTo(JadwalPeriksa::class, 'id_jadwal');
    }
    public function periksa()
    {
        return $this->hasOne(Periksa::class, 'id_janji_periksa');
    }

}
