<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JadwalPeriksa extends Model
{
    // Mengaktifkan trait HasFactory untuk mendukung factory model (pengujian / seeder)
    use HasFactory;

    // Menentukan field yang boleh diisi secara massal (mass assignment)
    protected $fillable = [
        'id_dokter',    // ID user dokter yang memiliki jadwal ini
        'hari',         // Hari jadwal periksa (misal: Senin, Selasa)
        'jam_mulai',    // Jam mulai praktik
        'jam_selesai',  // Jam selesai praktik
        'status'        // Status jadwal (aktif/nonaktif)
    ];

    /**
     * Relasi ke model User sebagai dokter.
     * Jadwal ini dimiliki oleh satu dokter.
     */
    public function dokter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_dokter');
    }

    /**
     * Relasi ke janji periksa.
     * Satu jadwal periksa bisa memiliki banyak janji dari pasien.
     */
    public function janjiPeriksas(): HasMany
    {
        return $this->hasMany(JanjiPeriksa::class, 'id_jadwal_periksa');
    }
}
