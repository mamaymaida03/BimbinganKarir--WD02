<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Poli;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {

        // Seeder Dokter
        User::create([
            'role' => 'dokter',
            'nama' => 'Dr. Budi Santoso, Sp.PD',
            'email' => 'dokterbudi@example.com',
            'password' => bcrypt('password'),
            'alamat' => 'Jl. Kesehatan No. 10',
            'no_ktp' => '1234567890123456',
            'no_hp' => '081234567890',
            'no_rm' => null,
            'id_poli' => 1,
        ]);

        User::create([
            'role' => 'dokter',
            'nama' => 'Dr. Siti Rahayu, Sp.A',
            'email' => 'doktersiti@example.com',
            'password' => bcrypt('password'),
            'alamat' => 'Jl. Anggrek No. 45, Jakarta Pusat',
            'no_ktp' => '3175064610790002',
            'no_hp' => '081234567891',
            'no_rm' => null,
            'id_poli' => 2,
        ]);

        User::create([
            'role' => 'dokter',
            'nama' => 'Dr. Doni Pratama, Sp.THT',
            'email' => 'dokterdoni@example.com',
            'password' => bcrypt('password'),
            'alamat' => 'Jl. Sehat Selalu No. 5',
            'no_ktp' => '2345678901234567',
            'no_hp' => '081298765432',
            'no_rm' => null,
            'id_poli' => 3,
        ]);

        // Seeder Pasien
        $currentYearMonth = date('Ym'); // Misal: 202506 untuk Juni 2025

        User::create([
            'role' => 'pasien',
            'nama' => 'Mamay Maida',
            'email' => 'pasienmamay@example.com',
            'password' => bcrypt('password'),
            'alamat' => 'Jl. Melati No. 3',
            'no_ktp' => '3456789012345678',
            'no_hp' => '082134567890',
            'no_rm' => 'RM' . $currentYearMonth . '-001',
            'id_poli' => null,
        ]);

        User::create([
            'role' => 'pasien',
            'nama' => 'Rina Kartika',
            'email' => 'pasienrina@example.com',
            'password' => bcrypt('password'),
            'alamat' => 'Jl. Mawar No. 7',
            'no_ktp' => '4567890123456789',
            'no_hp' => '083245678901',
            'no_rm' => 'RM' . $currentYearMonth . '-002',
            'id_poli' => null,
        ]);
    }
}
