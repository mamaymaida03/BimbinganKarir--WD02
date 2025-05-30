<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Periksa;
use App\Models\JanjiPeriksa;

class PeriksaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run()
    {
        $janji = JanjiPeriksa::first();

        Periksa::create([
            'id_janji_periksa' => $janji->id,
            'tgl_periksa' => now(),
            'catatan' => 'Diagnosa: flu ringan. Disarankan istirahat & minum obat.',
            'biaya_periksa' => 25000
        ]);
    }
}
