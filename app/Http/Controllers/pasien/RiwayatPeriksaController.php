<?php

namespace App\Http\Controllers\pasien;

use App\Http\Controllers\Controller;
use App\Models\JanjiPeriksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatPeriksaController extends Controller
{
    /**
     * Menampilkan halaman daftar riwayat janji periksa untuk pasien yang sedang login
     */
    public function index()
    {
        // Ambil nomor rekam medis dari pasien yang login
        $no_rm = Auth::user()->no_rm;

        // Ambil semua data janji periksa berdasarkan ID pasien yang sedang login
        $janjiPeriksas = JanjiPeriksa::where('id_pasien', Auth::user()->id)->get();

        // Tampilkan halaman 'index' riwayat periksa pasien dengan data yang diperlukan
        return view('pasien.riwayat-periksa.index')->with([
            'no_rm' => $no_rm,
            'janjiPeriksas' => $janjiPeriksas,
        ]);
    }

    /**
     * Menampilkan detail satu janji periksa berdasarkan ID
     */
    public function detail($id)
    {
        // Cari janji periksa berdasarkan ID, sekaligus ambil data dokter dari relasi jadwalPeriksa
        $janjiPeriksa = JanjiPeriksa::with(['jadwalPeriksa.dokter'])->findOrFail($id);

        // Tampilkan halaman detail dengan data janji periksa
        return view('pasien.riwayat-periksa.detail')->with([
            'janjiPeriksa' => $janjiPeriksa,
        ]);
    }

    /**
     * Menampilkan detail riwayat pemeriksaan (hasil periksa) dari sebuah janji
     */
    public function riwayat($id)
    {
        // Ambil data janji periksa beserta relasi dokter
        $janjiPeriksa = JanjiPeriksa::with(['jadwalPeriksa.dokter'])->findOrFail($id);

        // Ambil data riwayat periksa dari relasi (asumsi ada relasi 'riwayatPeriksa' di model JanjiPeriksa)
        $riwayat = $janjiPeriksa->riwayatPeriksa;

        // Tampilkan halaman riwayat periksa pasien
        return view('pasien.riwayat-periksa.riwayat')->with([
            'riwayat' => $riwayat,
            'janjiPeriksa' => $janjiPeriksa,
        ]);
    }
}
