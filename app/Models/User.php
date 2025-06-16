<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'nama',
        'role',
        'alamat',
        'no_hp',
        'no_ktp',
        'no_rm',
        'poli', 
        'email',
        'password',
    ];

    public function jadwalPeriksas()
    {
        return $this->hasMany(JadwalPeriksa::class, 'id_dokter');
    }

    public function janjiPeriksas()
    {
        return $this->hasMany(JanjiPeriksa::class, 'id_pasien');
    }

    public function poli()
    {
        return $this->belongsTo(Poli::class, 'id_poli');
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
