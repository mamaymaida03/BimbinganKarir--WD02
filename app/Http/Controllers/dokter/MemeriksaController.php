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
        // Ambil jadwal dokter yang sedang login
        $jadwals = JadwalPeriksa::where('id_dokter', Auth::id())->get();  // Menampilkan semua jadwal dokter yang sedang login

        // Ambil pasien berdasarkan id_jadwal yang ada pada jadwal dokter
        $pasien = JanjiPeriksa::whereIn('id_jadwal', $jadwals->pluck('id'))  
                              // Menghindari penggunaan 'tgl_periksa' jika kolom tidak ada
                              ->whereNull('id_jadwal')  // Bisa disesuaikan untuk filter pasien yang belum diperiksa
                              ->get();  // Ambil pasien yang sesuai dengan jadwal

        return view('dokter.memeriksa.index', compact('pasien'));  // Kirim data pasien ke view
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
        ]);

        $janjiPeriksa = JanjiPeriksa::findOrFail($id);

        // Update status pemeriksaan dan data lainnya
        $janjiPeriksa->update([
            'tgl_periksa' => now(),  // Menandai pasien sudah diperiksa, jika tidak ada kolom ini, bisa dihapus
            'catatan' => $request->catatan,
            'biaya_periksa' => $request->biaya_periksa,
        ]);

        return redirect()->route('dokter.memeriksa.index')->with('success', 'Pemeriksaan pasien berhasil.');
    }
}
