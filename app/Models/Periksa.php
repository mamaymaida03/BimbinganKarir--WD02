<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function janjiPeriksa(): BelongsTo
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

    /**
     * Menghitung biaya periksa pasien termasuk biaya obat
     * @param array $obatIds
     * @return float
     */
    public function hitungBiayaPeriksa(array $obatIds)
    {
        // Menghitung biaya obat
        $biayaObat = Obat::whereIn('id', $obatIds)->sum('harga');

        // Biaya dokter tetap (misalnya Rp. 150.000)
        $biayaDokter = 150000;

        // Total biaya adalah biaya obat ditambah biaya dokter
        $totalBiaya = $biayaDokter + $biayaObat;

        return $totalBiaya;
    }

}