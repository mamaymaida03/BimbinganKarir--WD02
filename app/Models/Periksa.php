<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Periksa extends Model
{
    protected $table = 'periksas';
    protected $fillable = [
        'id_janji_periksa',
        'id_obat',
        'diagnosa',
        'tindakan',
        'resep',
        'biaya',
    ];

    public function janjiPeriksa():BelongsTo
    {
        return $this->belongsTo(JanjiPeriksa::class, 'id_janji_periksa');
    }

    public function detailPeriksas():HasMany
    {
        return $this->hasMany(DetailPeriksa::class, 'id_periksa');
    }

    public function obat():BelongsTo
    {
        return $this->belongsTo(Obat::class, 'id_obat');
    }

}