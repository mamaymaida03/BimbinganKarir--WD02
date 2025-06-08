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

        // Days of the week
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

        // Create schedules for each doctor
        foreach ($dokters as $dokter) {
            // Assign 2 working days per doctor (different for each)
            $doctorDays = array_slice($days, $dokter->id % 5, 2);

            $firstSchedule = true; // Flag to mark only the first schedule as active

            foreach ($doctorDays as $day) {
                // Morning schedule (8:00 - 12:00)
                JadwalPeriksa::create([
                    'id_dokter' => $dokter->id,
                    'hari' => $day,
                    'jam_mulai' => '08:00:00',
                    'jam_selesai' => '12:00:00',
                    'status' => $firstSchedule ? true : false, // Only first schedule is active (true)
                ]);

                $firstSchedule = false; // Mark subsequent schedules as inactive

                // Afternoon schedule (13:00 - 16:00)
                // Only for some doctors (those with even IDs for variety)
                if ($dokter->id % 2 == 0) {
                    JadwalPeriksa::create([
                        'id_dokter' => $dokter->id,
                        'hari' => $day,
                        'jam_mulai' => '13:00:00',
                        'jam_selesai' => '16:00:00',
                        'status' => false, // All afternoon schedules are inactive (false)
                    ]);
                }
            }
        }
    }
}