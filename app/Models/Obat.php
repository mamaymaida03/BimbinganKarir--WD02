<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Obat extends Model
{
    // Menggunakan trait SoftDeletes agar data tidak langsung dihapus permanen dari database
    use SoftDeletes;

    // Menentukan nama tabel yang digunakan oleh model ini (opsional jika nama tabel tidak mengikuti konvensi Laravel)
    protected $table = 'obats';

    // Menentukan atribut yang dapat diisi secara massal menggunakan create() atau update()
    protected $fillable = [
        'nama_obat',   // Nama dari obat
        'kemasan',     // Jenis kemasan (misal: strip, botol, tablet)
        'harga',       // Harga satuan obat
    ];

    /**
     * Relasi One-to-Many ke tabel detail_periksas.
     * Obat bisa digunakan di banyak detail pemeriksaan.
     */
    public function detailPeriksas(): HasMany
    {
        return $this->hasMany(DetailPeriksa::class, 'id_obat');
    }
}
