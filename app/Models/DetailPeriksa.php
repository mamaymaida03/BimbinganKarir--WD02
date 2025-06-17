<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DetailPeriksa extends Model
{
    use HasFactory; // Mengaktifkan fitur factory untuk keperluan seeding/data dummy

    // Kolom yang boleh diisi secara massal (mass assignment)
    protected $fillable = [
        'id_periksa', // ID relasi ke tabel periksa
        'id_obat',    // ID relasi ke tabel obat
    ];

    /**
     * Relasi ke model Periksa
     * Setiap detail periksa dimiliki oleh satu data periksa
     */
    public function periksa(): BelongsTo
    {
        return $this->belongsTo(Periksa::class, 'id_periksa');
    }

    /**
     * Relasi ke model Obat
     * Setiap detail periksa memiliki satu obat
     */
    public function obat(): BelongsTo
    {
        return $this->belongsTo(Obat::class, 'id_obat');
    }
}
