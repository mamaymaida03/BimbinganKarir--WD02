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
     * Menjalankan seeder untuk mengisi data awal ke tabel janji_periksas
     */
    public function run()
    {
        // Ambil satu user pertama yang memiliki role 'pasien'
        $pasien = User::where('role', 'pasien')->first();

        // Ambil satu data pertama dari jadwal periksa
        $jadwal = JadwalPeriksa::first();

        // Buat satu data janji periksa secara manual
        JanjiPeriksa::create([
            'id_pasien' => $pasien->id,                   // Relasi ke user pasien
            'id_jadwal' => $jadwal->id,                   // Relasi ke jadwal periksa
            'keluhan' => 'Sakit kepala dan demam',        // Contoh keluhan
            'no_antrian' => 1,                            // Nomor antrian pertama
        ]);
    }
}
