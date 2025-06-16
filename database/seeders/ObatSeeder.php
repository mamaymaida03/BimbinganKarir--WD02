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
            ['nama_obat' => 'Ibuprofen', 'kemasan' => 'Tablet 200mg', 'harga' => 6000],
            ['nama_obat' => 'Cetirizine', 'kemasan' => 'Tablet 10mg', 'harga' => 4000],
            ['nama_obat' => 'Ranitidine', 'kemasan' => 'Tablet 150mg', 'harga' => 7000],
            ['nama_obat' => 'Salbutamol', 'kemasan' => 'Tablet 2mg', 'harga' => 4500],
            ['nama_obat' => 'Metronidazole', 'kemasan' => 'Tablet 500mg', 'harga' => 5500],
            ['nama_obat' => 'Loperamide', 'kemasan' => 'Tablet 2mg', 'harga' => 3000],
            ['nama_obat' => 'Antasida', 'kemasan' => 'Tablet Kunyah', 'harga' => 2000],
            ['nama_obat' => 'Dextromethorphan', 'kemasan' => 'Sirup 60ml', 'harga' => 7000],
            ['nama_obat' => 'Chlorpheniramine Maleate', 'kemasan' => 'Tablet 4mg', 'harga' => 2500],
            ['nama_obat' => 'Asam Mefenamat', 'kemasan' => 'Kapsul 500mg', 'harga' => 6500],
            ['nama_obat' => 'Omeprazole', 'kemasan' => 'Kapsul 20mg', 'harga' => 8500],
            ['nama_obat' => 'Prednison', 'kemasan' => 'Tablet 5mg', 'harga' => 4000],
            ['nama_obat' => 'Amlodipine', 'kemasan' => 'Tablet 5mg', 'harga' => 5000],
            ['nama_obat' => 'Simvastatin', 'kemasan' => 'Tablet 10mg', 'harga' => 6000],
            ['nama_obat' => 'Captopril', 'kemasan' => 'Tablet 25mg', 'harga' => 3000],
            ['nama_obat' => 'Diazepam', 'kemasan' => 'Tablet 5mg', 'harga' => 5000],
            ['nama_obat' => 'Lansoprazole', 'kemasan' => 'Kapsul 30mg', 'harga' => 9000],
        ]);
    }
}
