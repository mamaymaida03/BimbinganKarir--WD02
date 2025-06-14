<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Periksa extends Model
{
    protected $table = 'periksas';
    protected $fillable = [
        'id_janji_periksa',
        'tgl_periksa',
        'catatan',
        'biaya_periksa',
    ];

    public function janjiPeriksa(): BelongsTo
    {
        return $this->belongsTo(JanjiPeriksa::class, 'id_janji_periksa'); 
    }

    public function detailPeriksa(): HasMany
    {
        return $this->hasMany(DetailPeriksa::class, 'id_periksa');
    }

    public function obats(): BelongsToMany
    {
        return $this->belongsToMany(Obat::class, 'detail_periksas', 'id_periksa', 'id_obat');
    }
}
