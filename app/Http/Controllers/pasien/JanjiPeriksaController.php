<?php

namespace App\Http\Controllers\pasien;

use App\Http\Controllers\Controller;
use App\Models\JadwalPeriksa;
use App\Models\JanjiPeriksa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class JanjiPeriksaController extends Controller
{
    // Menampilkan halaman daftar dokter dan jadwal yang tersedia
    public function index()
    {
        // Ambil nomor rekam medis pasien yang sedang login
        $no_rm = Auth::user()->no_rm;

        // Ambil daftar dokter beserta jadwal periksa yang aktif (status = true)
        $dokters = User::with([
            'jadwalPeriksas' => function ($query) {
                $query->where('status', true); // hanya ambil jadwal aktif
            },
        ])
            ->where('role', 'dokter') // hanya user dengan role dokter
            ->get();

        // Tampilkan view dengan data nomor RM dan daftar dokter
        return view('pasien.janji-periksa.index')->with([
            'no_rm' => $no_rm,
            'dokters' => $dokters,
        ]);
    }

    // Menyimpan data janji periksa yang dibuat pasien
    public function store(Request $request)
    {
        // Validasi input dari form: ID dokter harus ada di tabel users, dan keluhan tidak boleh kosong
        $request->validate([
            'id_dokter' => 'required|exists:users,id',
            'keluhan' => 'required',
        ]);

        // Ambil jadwal periksa dari dokter yang dipilih dan hanya yang aktif
        $jadwalPeriksa = JadwalPeriksa::where('id_dokter', $request->id_dokter)
            ->where('status', true)
            ->first();

        // Hitung jumlah janji periksa yang sudah ada pada jadwal tersebut
        $jumlahJanji = JanjiPeriksa::where('id_jadwal', $jadwalPeriksa->id)->count();

        // Tentukan nomor antrian berikutnya
        $noAntrian = $jumlahJanji + 1;

        // Simpan janji periksa baru ke database
        JanjiPeriksa::create([
            'id_pasien' => Auth::user()->id,         // ID pasien yang login
            'id_jadwal' => $jadwalPeriksa->id,       // ID jadwal periksa
            'keluhan' => $request->keluhan,          // Keluhan dari pasien
            'no_antrian' => $noAntrian,              // Nomor antrian berdasarkan urutan
        ]);

        // Redirect kembali ke halaman janji periksa dengan pesan sukses
        return Redirect::route('pasien.janji-periksa.index')->with('status', 'janji-periksa-created');
    }
}
