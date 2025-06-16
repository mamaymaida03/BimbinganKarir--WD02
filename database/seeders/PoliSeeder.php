<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Poli;

class PoliSeeder extends Seeder
{
    public function run(): void
    {
        Poli::insert([
            [
                'nama' => 'Poli Gigi',
                'deskripsi' => 'Pelayanan pemeriksaan dan perawatan kesehatan gigi dan mulut.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Poli Anak',
                'deskripsi' => 'Pelayanan kesehatan khusus untuk anak-anak.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Poli Penyakit Dalam',
                'deskripsi' => 'Menangani berbagai penyakit non-bedah untuk pasien dewasa.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Poli Kandungan',
                'deskripsi' => 'Poli Kandungan memberikan pelayanan pemeriksaan kehamilan, kesehatan reproduksi wanita, dan konsultasi obstetri & ginekologi.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Poli Mata',
                'deskripsi' => 'Poli Mata menangani pemeriksaan dan pengobatan gangguan pada mata, termasuk pemeriksaan minus dan operasi kecil.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

