<?php

namespace App\Http\Controllers\dokter;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\JadwalPeriksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class JadwalPeriksaController extends Controller
{
    // Menampilkan halaman untuk membuat jadwal
    public function create()
    {
        $dokter = Auth::user(); // Ambil data dokter yang sedang login
        
        // Menentukan hari yang sesuai berdasarkan dokter yang login
        if ($dokter->nama == 'Dr. Budi Santoso, Sp.PD') {
            $hariJadwal = ['Senin', 'Selasa']; // Poli Penyakit Dalam
        } elseif ($dokter->nama == 'Dr. Siti Rahayu, Sp.A') {
            $hariJadwal = ['Rabu', 'Kamis']; // Poli Anak
        } elseif ($dokter->nama == 'Dr. Doni Pratama, Sp.THT') {
            $hariJadwal = ['Jumat', 'Sabtu']; // Poli THT
        } else {
            $hariJadwal = []; // Jika dokter lain, tidak ada jadwal
        }

        return view('dokter.jadwal.create', compact('hariJadwal'));
    }

    // Menyimpan jadwal pemeriksaan
    public function store(Request $request)
    {
        $request->validate([
            'hari' => 'required|string',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        ]);

        // Cek apakah ada jadwal yang bentrok (tidak harus sama persis jamnya)
        $hasConflict = JadwalPeriksa::where('id_dokter', Auth::id())
            ->where('hari', $request->hari)
            ->where(function ($query) use ($request) {
                $query->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                    ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                    ->orWhere(function ($query) use ($request) {
                        $query->where('jam_mulai', '<=', $request->jam_mulai)
                              ->where('jam_selesai', '>=', $request->jam_selesai);
                    });
            })
            ->exists();

        if ($hasConflict) {
            return back()->withErrors(['jam_mulai' => 'Jadwal periksa bentrok dengan jadwal lain!'])->withInput();
        }

        // Cek apakah dokter sudah memiliki jadwal yang sama persis
        $existingSchedule = JadwalPeriksa::where('id_dokter', Auth::id())
            ->where('hari', $request->hari)
            ->where('jam_mulai', $request->jam_mulai)
            ->where('jam_selesai', $request->jam_selesai)
            ->exists();

        if ($existingSchedule) {
            throw ValidationException::withMessages([
                'hari' => 'Jadwal yang sama sudah ada.',
            ]);
        }

        // Simpan jadwal
        JadwalPeriksa::create([
            'id_dokter' => Auth::id(),
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'status' => true, // Jadwal baru langsung diaktifkan
        ]);

        return redirect()->route('dokter.jadwal.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    // Menampilkan daftar jadwal pemeriksaan
    public function index()
    {
        $jadwals = JadwalPeriksa::where('id_dokter', Auth::id())->get();

        return view('dokter.jadwal.index', compact('jadwals'));
    }

    // Mengubah status jadwal
    public function toggleStatus($id)
    {
        $jadwal = JadwalPeriksa::findOrFail($id);

        if (!$jadwal->status) {
            // Nonaktifkan jadwal aktif lain untuk dokter yang sama
            JadwalPeriksa::where('id_dokter', $jadwal->id_dokter)
                ->where('status', true)
                ->update(['status' => false]);

            // Aktifkan jadwal ini
            $jadwal->status = true;
        } else {
            // Kalau sedang aktif, jadikan nonaktif
            $jadwal->status = false;
        }

        $jadwal->save();

        return back()->with('success', 'Status jadwal berhasil diubah.');
    }

    // Menghapus jadwal
    public function destroy($id)
    {
        $jadwal = JadwalPeriksa::findOrFail($id);
        $jadwal->delete();

        return back()->with('success', 'Jadwal berhasil dihapus.');
    }

    public function memeriksaPasien()
    {
        $pasien = User::where('role', 'pasien')
                    ->whereNull('no_rm')  // Status pasien yang belum diperiksa
                    ->get();

        return view('dokter.memeriksa', compact('pasien'));
    }


    public function periksaPasien(Request $request, $id)
    {
        // Validasi dan proses pemeriksaan
        $request->validate([
            'catatan' => 'required|string|max:255',
        ]);

        // Simpan hasil pemeriksaan
        $pasien = User::findOrFail($id);
        $pasien->catatan = $request->catatan;  // Simpan catatan pemeriksaan
        $pasien->save();

        return view('dokter.memeriksa', compact('pasien'));

    }

}
