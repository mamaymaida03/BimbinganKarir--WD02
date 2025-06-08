<?php

namespace App\Http\Controllers\pasien;

use App\Http\Controllers\Controller;
use App\Models\JanjiPeriksa;
use Illuminate\Http\Request;

class RiwayatPeriksaController extends Controller
{
    public function index()
    {
        // Mengambil data janji periksa untuk pasien yang sedang login
        $janjiPeriksas = auth()->user()->janjiPeriksas()->with('jadwalPeriksa.dokter')->get();

        // Mengirim data ke view
        return view('pasien.riwayat-periksa.index', compact('janjiPeriksas'));
    }

    public function detail($id)
    {
        $janjiPeriksa = JanjiPeriksa::with('periksa')->findOrFail($id);
        return view('pasien.riwayat-periksa.detail', compact('janjiPeriksa'));
    }

    public function riwayat($id)
    {
        $janjiPeriksa = JanjiPeriksa::with('periksa.detailPeriksas.obat')->findOrFail($id);
        return view('pasien.riwayat-periksa.riwayat', compact('janjiPeriksa'));
    }
}
