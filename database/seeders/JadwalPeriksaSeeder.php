<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\JadwalPeriksa;


class JadwalPeriksaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $dokter1 = User::where('role', 'dokter')->first();

        JadwalPeriksa::insert([
            [
                'id_dokter' => $dokter1->id,
                'hari' => 'Senin',
                'jam_mulai' => '08:00:00',
                'jam_selesai' => '12:00:00',
            ],
            [
                'id_dokter' => $dokter1->id,
                'hari' => 'Rabu',
                'jam_mulai' => '13:00:00',
                'jam_selesai' => '17:00:00',
            ]
        ]);
    }
}
