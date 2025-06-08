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
    public function run(): void
    {
        // Get all doctor IDs
        $dokters = User::where('role', 'dokter')->get();

        // Define schedule for specific doctors
        $doctorSchedules = [
            'Dr. Budi Santoso, Sp.PD' => ['Senin', 'Selasa'],
            'Dr. Siti Rahayu, Sp.A' => ['Rabu', 'Kamis'],
            'Dr. Doni Pratama, Sp.THT' => ['Jumat', 'Sabtu'],
        ];

        // Create schedules for each doctor
        foreach ($dokters as $dokter) {
            // Only assign schedules for doctors in our predefined list
            if (isset($doctorSchedules[$dokter->nama])) {
                $doctorDays = $doctorSchedules[$dokter->nama];

                $firstSchedule = true; // Flag to mark only the first schedule as active

                foreach ($doctorDays as $day) {
                    // Morning schedule (8:00 - 12:00)
                    JadwalPeriksa::create([
                        'id_dokter' => $dokter->id,
                        'hari' => $day,
                        'jam_mulai' => '08:00', // Format without seconds
                        'jam_selesai' => '12:00', // Format without seconds
                        'status' => $firstSchedule ? true : false, // Only first schedule is active (true)
                    ]);

                    $firstSchedule = false; // Mark subsequent schedules as inactive

                    // Afternoon schedule (13:00 - 16:00)
                    if ($dokter->id % 2 == 0) {
                        JadwalPeriksa::create([
                            'id_dokter' => $dokter->id,
                            'hari' => $day,
                            'jam_mulai' => '13:00', // Format without seconds
                            'jam_selesai' => '16:00', // Format without seconds
                            'status' => false, // All afternoon schedules are inactive (false)
                        ]);
                    }
                }
            }
        }
    }
}
