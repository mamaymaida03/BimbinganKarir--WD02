<?php

namespace App\Http\Controllers\Dokter;
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
        return view('dokter.jadwal.create');
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

        if ($jadwal->status !== 'aktif') {
            // Nonaktifkan jadwal aktif lain untuk dokter yang sama
            JadwalPeriksa::where('id_dokter', $jadwal->id_dokter)
                ->where('status', 'aktif')
                ->update(['status' => 'nonaktif']);

            // Aktifkan jadwal ini
            $jadwal->status = 'aktif';
        } else {
            // Kalau sedang aktif, jadikan nonaktif
            $jadwal->status = 'nonaktif';
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
}
