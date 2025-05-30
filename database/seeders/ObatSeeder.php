<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Obat;

class ObatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Obat::insert([
            ['nama_obat' => 'Paracetamol', 'kemasan' => 'Tablet 500mg', 'harga' => 5000],
            ['nama_obat' => 'Amoxicillin', 'kemasan' => 'Kapsul 250mg', 'harga' => 8000],
            ['nama_obat' => 'Vitamin C', 'kemasan' => 'Tablet 100mg', 'harga' => 3000],
        ]);
    }
}
