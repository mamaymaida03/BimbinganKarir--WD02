<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DetailPeriksa;
use App\Models\Periksa;
use App\Models\Obat;

class DetailPeriksaSeeder extends Seeder
{
    /**
     * Menjalankan proses seeding data ke tabel detail_periksas
     */
    public function run()
    {
        // Mengambil satu data pertama dari tabel periksa
        $periksa = Periksa::first();

        // Mengambil satu data pertama dari tabel obat
        $obat = Obat::first();

        // Membuat satu data detail periksa (relasi antara periksa dan obat)
        DetailPeriksa::create([
            'id_periksa' => $periksa->id, // ID pemeriksaan yang dipakai
            'id_obat' => $obat->id        // ID obat yang diresepkan
        ]);
    }
}
