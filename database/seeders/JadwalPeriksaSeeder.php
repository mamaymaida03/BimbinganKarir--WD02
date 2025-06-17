<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\JadwalPeriksa;

class JadwalPeriksaSeeder extends Seeder
{
    /**
     * Menjalankan seeder untuk mengisi tabel jadwal_periksas.
     * Seeder ini akan membuat jadwal periksa untuk setiap dokter
     * berdasarkan nama dan jadwal tetap yang sudah ditentukan.
     */
    public function run(): void
    {
        // Mengambil semua user yang berperan sebagai dokter
        $dokters = User::where('role', 'dokter')->get();

        // Daftar jadwal tetap berdasarkan nama dokter
        $doctorSchedules = [
            'Dr. Budi Santoso, Sp.PD' => ['Senin', 'Selasa'],
            'Dr. Siti Rahayu, Sp.A' => ['Rabu', 'Kamis'],
            'Dr. Doni Pratama, Sp.THT' => ['Jumat', 'Sabtu'],
        ];

        // Loop setiap dokter untuk membuat jadwal jika ada dalam daftar jadwal tetap
        foreach ($dokters as $dokter) {
            // Mengecek apakah nama dokter ada dalam daftar jadwal
            if (isset($doctorSchedules[$dokter->nama])) {
                $doctorDays = $doctorSchedules[$dokter->nama];

                $firstSchedule = true; // Penanda agar hanya jadwal pertama yang aktif

                // Loop setiap hari yang ditentukan untuk dokter ini
                foreach ($doctorDays as $day) {
                    // Membuat jadwal pagi (08:00 - 12:00)
                    JadwalPeriksa::create([
                        'id_dokter' => $dokter->id,
                        'hari' => $day,
                        'jam_mulai' => '08:00',
                        'jam_selesai' => '12:00',
                        'status' => $firstSchedule ? true : false, // Hanya jadwal pertama yang aktif
                    ]);

                    // Setelah membuat jadwal pertama, tandai sisanya sebagai tidak aktif
                    $firstSchedule = false;

                    // Membuat jadwal sore (13:00 - 16:00) hanya untuk dokter dengan ID genap
                    if ($dokter->id % 2 == 0) {
                        JadwalPeriksa::create([
                            'id_dokter' => $dokter->id,
                            'hari' => $day,
                            'jam_mulai' => '13:00',
                            'jam_selesai' => '16:00',
                            'status' => false, // Jadwal sore selalu nonaktif awalnya
                        ]);
                    }
                }
            }
        }
    }
}
