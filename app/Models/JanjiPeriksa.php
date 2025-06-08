<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JanjiPeriksa extends Model
{
    protected $table = 'janji_periksas';
    protected $fillable = [
        'id_pasien',
        'id_jadwal_periksa',
        'status',
        'keluhan',
        'no_antrian',
    ];

    public function index()
    {
        $janjiPeriksas = auth()->user()->pasien->janjiPeriksas()->with('jadwalPeriksa.dokter')->get();
        dd($janjiPeriksas); // Debugging
        return view('pasien.riwayat-periksa.index', compact('janjiPeriksas'));
    }

    public function pasien():BelongsTo
    {
        return $this->belongsTo(User::class, 'id_pasien');
    }

    public function jadwalPeriksa():BelongsTo
    {
        return $this->belongsTo(JadwalPeriksa::class, 'id_jadwal_periksa');
    }

    public function periksa():HasOne
    {
        return $this->hasOne(Periksa::class, 'id_janji_periksa');
    }

}