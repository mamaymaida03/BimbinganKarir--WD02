<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Periksa extends Model
{
    // Menentukan nama tabel yang digunakan oleh model ini
    protected $table = 'periksas';

    // Menentukan atribut yang boleh diisi secara massal
    protected $fillable = [
        'id_janji_periksa', // Foreign key dari janji pemeriksaan
        'tgl_periksa',      // Tanggal dilakukannya pemeriksaan
        'catatan',          // Catatan tambahan dari dokter
        'biaya_periksa',    // Total biaya dari pemeriksaan (termasuk obat)
    ];

    /**
     * Relasi ke model JanjiPeriksa.
     * Pemeriksaan ini dimiliki oleh satu janji periksa.
     */
    public function janjiPeriksa(): BelongsTo
    {
        return $this->belongsTo(JanjiPeriksa::class, 'id_janji_periksa'); 
    }

    /**
     * Relasi ke model DetailPeriksa.
     * Pemeriksaan ini memiliki banyak entri detail pemeriksaan (obat yang diberikan).
     */
    public function detailPeriksas(): HasMany
    {
        return $this->hasMany(DetailPeriksa::class, 'id_periksa');
    }

    /**
     * Relasi many-to-many ke model Obat melalui tabel pivot `detail_periksas`.
     * Pemeriksaan ini dapat memiliki banyak obat yang diberikan.
     */
    public function obats(): BelongsToMany
    {
        return $this->belongsToMany(Obat::class, 'detail_periksas', 'id_periksa', 'id_obat');
    }
}
