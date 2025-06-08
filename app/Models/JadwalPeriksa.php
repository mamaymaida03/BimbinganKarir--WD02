<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JadwalPeriksa extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_dokter',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'status'
    ];

    public function dokter() :BelongsTo
    {
        return $this->belongsTo(User::class, 'id_dokter');
    }

    public function janjiPeriksas() :HasMany
    {
        return $this->hasMany(JanjiPeriksa::class, 'id_jadwal_periksa');
    }
}