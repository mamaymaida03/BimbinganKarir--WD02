<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;

class Poli extends Model
{
    use HasFactory;

    // Menentukan atribut yang dapat diisi secara massal
    protected $fillable = ['nama', 'deskripsi'];

    /**
     * Relasi one-to-many ke model User.
     * Mengambil semua user yang berperan sebagai dokter dan memiliki id_poli ini.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dokters(): HasMany
    {
        return $this->hasMany(User::class, 'id_poli')->where('role', 'dokter');
    }
}
