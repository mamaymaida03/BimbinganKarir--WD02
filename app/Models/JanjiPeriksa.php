<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

// Model JanjiPeriksa mewakili tabel janji_periksas di database
class JanjiPeriksa extends Model
{
    // Nama tabel yang digunakan model ini
    protected $table = 'janji_periksas';

    // Kolom-kolom yang boleh diisi secara massal (mass assignment)
    protected $fillable = [
        'id_pasien',
        'id_jadwal',
        'status',
        'keluhan',
        'no_antrian',
    ];

    // Relasi ke model User sebagai pasien (setiap janji dimiliki oleh satu pasien)
    public function pasien()
    {
        return $this->belongsTo(User::class, 'id_pasien');
    }

    // Relasi ke model JadwalPeriksa (setiap janji terhubung ke satu jadwal periksa)
    public function jadwalPeriksa(): BelongsTo
    {
        return $this->belongsTo(JadwalPeriksa::class, 'id_jadwal');  
    }

    // Relasi ke model Periksa (setiap janji bisa memiliki satu data pemeriksaan)
    public function periksa(): HasOne
    {
        return $this->hasOne(Periksa::class, 'id_janji_periksa'); 
    }

    // Relasi ke model Poli (jika janji juga menyimpan informasi poli yang dituju)
    public function poli()
    {
        return $this->belongsTo(Poli::class, 'id_poli');
    }
}
