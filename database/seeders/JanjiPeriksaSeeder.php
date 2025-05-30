<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JanjiPeriksa;
use App\Models\User;
use App\Models\JadwalPeriksa;

class JanjiPeriksaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $pasien = User::where('role', 'pasien')->first();
        $jadwal = JadwalPeriksa::first();

        JanjiPeriksa::create([
            'id_pasien' => $pasien->id,
            'id_jadwal' => $jadwal->id,
            'keluhan' => 'Sakit kepala dan demam',
            'no_antrian' => 1,
        ]);
    }
}
