<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
 public function run()
    {
        // Seeder Dokter
        User::create([
            'role' => 'dokter',
            'nama' => 'Dr. Andi Wijaya',
            'email' => 'andi@klinik.test',
            'password' => bcrypt('password'),
            'alamat' => 'Jl. Kesehatan No. 10',
            'no_ktp' => '1234567890123456',
            'no_hp' => '081234567890',
            'no_rm' => null,
            'poli' => 'Poli Umum'
        ]);

        User::create([
            'role' => 'dokter',
            'nama' => 'Dr. Siti Hidayah',
            'email' => 'siti@klinik.test',
            'password' => bcrypt('password'),
            'alamat' => 'Jl. Sehat Selalu No. 5',
            'no_ktp' => '2345678901234567',
            'no_hp' => '081298765432',
            'no_rm' => null,
            'poli' => 'Poli Anak'
        ]);

        // Seeder Pasien
        User::create([
            'role' => 'pasien',
            'nama' => 'Ahmad Fauzi',
            'email' => 'ahmad@klinik.test',
            'password' => bcrypt('password'),
            'alamat' => 'Jl. Melati No. 3',
            'no_ktp' => '3456789012345678',
            'no_hp' => '082134567890',
            'no_rm' => 'RM001',
            'poli' => null
        ]);

        User::create([
            'role' => 'pasien',
            'nama' => 'Rina Kartika',
            'email' => 'rina@klinik.test',
            'password' => bcrypt('password'),
            'alamat' => 'Jl. Mawar No. 7',
            'no_ktp' => '4567890123456789',
            'no_hp' => '083245678901',
            'no_rm' => 'RM002',
            'poli' => null
        ]);
    }
}
