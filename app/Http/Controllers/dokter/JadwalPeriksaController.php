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
    /**
     * Menampilkan form untuk membuat jadwal pemeriksaan.
     * Jadwal ditentukan berdasarkan nama dokter yang login.
     * View: dokter.jadwal.create
     */
    public function create()
    {
        $dokter = Auth::user(); // Ambil user login

        // Tentukan hari sesuai nama dokter (hardcoded)
        if ($dokter->nama == 'Dr. Budi Santoso, Sp.PD') {
            $hariJadwal = ['Senin', 'Selasa'];
        } elseif ($dokter->nama == 'Dr. Siti Rahayu, Sp.A') {
            $hariJadwal = ['Rabu', 'Kamis'];
        } elseif ($dokter->nama == 'Dr. Doni Pratama, Sp.THT') {
            $hariJadwal = ['Jumat', 'Sabtu'];
        } else {
            $hariJadwal = [];
        }

        return view('dokter.jadwal.create', compact('hariJadwal'));
    }

    /**
     * Menyimpan data jadwal periksa baru ke database.
     * Validasi dilakukan untuk mencegah bentrok waktu dan duplikasi.
     */
    public function store(Request $request)
    {
        // Validasi inputan form
        $request->validate([
            'hari' => 'required|string',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        ]);

        // Cek bentrok dengan jadwal lain (overlapping time)
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

        // Cek jika jadwal persis sudah ada
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

        // Simpan jadwal baru
        JadwalPeriksa::create([
            'id_dokter' => Auth::id(),
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'status' => true,
        ]);

        return redirect()->route('dokter.jadwal.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    /**
     * Menampilkan semua jadwal pemeriksaan milik dokter yang sedang login.
     * View: dokter.jadwal.index
     */
    public function index()
    {
        $jadwals = JadwalPeriksa::where('id_dokter', Auth::id())->get();
        return view('dokter.jadwal.index', compact('jadwals'));
    }

    /**
     * Mengubah status aktif/tidak aktif dari jadwal periksa.
     * Hanya satu jadwal yang bisa aktif pada satu waktu untuk satu dokter.
     */
    public function toggleStatus($id)
    {
        $jadwal = JadwalPeriksa::findOrFail($id);

        if (!$jadwal->status) {
            // Jika ingin mengaktifkan, matikan jadwal aktif lain
            JadwalPeriksa::where('id_dokter', $jadwal->id_dokter)
                ->where('status', true)
                ->update(['status' => false]);

            $jadwal->status = true;
        } else {
            // Jika sedang aktif, nonaktifkan
            $jadwal->status = false;
        }

        $jadwal->save();

        return back()->with('success', 'Status jadwal berhasil diubah.');
    }

    /**
     * Menghapus jadwal periksa berdasarkan ID.
     */
    public function destroy($id)
    {
        $jadwal = JadwalPeriksa::findOrFail($id);
        $jadwal->delete();

        return back()->with('success', 'Jadwal berhasil dihapus.');
    }

    /**
     * Menampilkan daftar pasien yang belum diperiksa (belum memiliki nomor rekam medis).
     * View: dokter.memeriksa
     */
    public function memeriksaPasien()
    {
        $pasien = User::where('role', 'pasien')
                    ->whereNull('no_rm') // Belum diperiksa
                    ->get();

        return view('dokter.memeriksa', compact('pasien'));
    }

    /**
     * Menyimpan catatan hasil pemeriksaan pasien.
     * View setelah simpan: dokter.memeriksa
     */
    public function periksaPasien(Request $request, $id)
    {
        // Validasi input catatan
        $request->validate([
            'catatan' => 'required|string|max:255',
        ]);

        // Simpan catatan ke data pasien
        $pasien = User::findOrFail($id);
        $pasien->catatan = $request->catatan;
        $pasien->save();

        return view('dokter.memeriksa', compact('pasien'));
    }
}
