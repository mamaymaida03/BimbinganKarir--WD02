<?php

namespace App\Http\Controllers\dokter;

use App\Http\Controllers\Controller;
use App\Models\JanjiPeriksa; 
use App\Models\JadwalPeriksa; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemeriksaController extends Controller
{
    public function index()
    {
        $jadwals = JadwalPeriksa::where('id_dokter', Auth::id())->get();

        $pasien = JanjiPeriksa::with('pasien')
        ->whereIn('id_jadwal', $jadwals->pluck('id'))
        ->whereDoesntHave('periksa')
        ->get();
        
        return view('dokter.memeriksa.index', compact('pasien'));
    }

    // Menampilkan detail pasien yang akan diperiksa
    public function show($id)
    {
        $janjiPeriksa = JanjiPeriksa::findOrFail($id);
        return view('dokter.memeriksa.show', compact('janjiPeriksa'));
    }

    // Menyimpan hasil pemeriksaan
   public function store(Request $request, $id)
    {
        $request->validate([
            'catatan' => 'required|string',
            'biaya_periksa' => 'required|numeric',
            'obat_id' => 'required|array', // Pastikan ada input obat_id yang dipilih
        ]);

        $janjiPeriksa = JanjiPeriksa::findOrFail($id);

        // Hitung biaya obat
        $biayaObat = Obat::whereIn('id', $request->obat_id)->sum('harga');
        
        // Biaya total = biaya dokter + biaya obat
        $totalBiaya = 150000 + $biayaObat;

        // Update status pemeriksaan dan data lainnya
        $janjiPeriksa->update([
            'tgl_periksa' => now(),  // Menandai pasien sudah diperiksa
            'catatan' => $request->catatan,
            'biaya_periksa' => $totalBiaya,  // Menyimpan biaya total pemeriksaan
        ]);

        // Simpan detail obat yang diberikan (jika ada)
        foreach ($request->obat_id as $obatId) {
            // Simpan detail obat yang diberikan kepada pasien
            Periksa::findOrFail($janjiPeriksa->periksa->id)->detailPeriksas()->create([
                'id_obat' => $obatId,
            ]);
        }

        return redirect()->route('dokter.memeriksa.index')->with('success', 'Pemeriksaan pasien berhasil.');
    }

}
