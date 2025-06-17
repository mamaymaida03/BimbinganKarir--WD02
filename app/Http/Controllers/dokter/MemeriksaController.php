<?php

namespace App\Http\Controllers\dokter;

use App\Http\Controllers\Controller;
use App\Models\JanjiPeriksa; 
use App\Models\JadwalPeriksa; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Periksa;
use App\Models\Obat;
use App\Models\DetailPeriksa;

class MemeriksaController extends Controller
{
    /**
     * Menampilkan daftar pasien yang memiliki janji periksa
     * berdasarkan jadwal dokter yang sedang login.
     * View: dokter.memeriksa.index
     */
    public function index()
    {
        // Ambil semua jadwal milik dokter login
        $jadwals = JadwalPeriksa::where('id_dokter', Auth::id())->get();

        // Ambil janji periksa yang terkait dengan jadwal dokter
        // serta memuat relasi pasien dan periksa (hasil pemeriksaan)
        $pasien = JanjiPeriksa::with(['pasien', 'periksa'])
            ->whereIn('id_jadwal', $jadwals->pluck('id'))
            ->get();

        return view('dokter.memeriksa.index', compact('pasien'));
    }

    /**
     * Menampilkan form input pemeriksaan untuk pasien
     * berdasarkan janji periksa yang dipilih.
     * View: dokter.memeriksa.show
     */
    public function show($id)
    {
        // Ambil data janji periksa dan relasi pasien
        $janjiPeriksa = JanjiPeriksa::with('pasien')->findOrFail($id);

        // Ambil semua data obat yang tersedia
        $obats = Obat::all();

        return view('dokter.memeriksa.show', compact('janjiPeriksa', 'obats'));
    }

    /**
     * Menyimpan hasil pemeriksaan pasien dan obat yang digunakan.
     * Akan menghitung total biaya dari pemeriksaan + obat.
     */
    public function store(Request $request)
    {
        // Validasi input form
        $request->validate([
            'id_janji_periksa' => 'required|exists:janji_periksas,id',
            'catatan' => 'nullable|string',
            'tgl_periksa' => 'required|date',
            'obat_id' => 'nullable|array',
        ]);

        $biayaPeriksa = 150000; // Biaya tetap pemeriksaan
        $totalHargaObat = 0;

        // Hitung total harga obat jika ada
        if ($request->has('obat_id')) {
            $obatList = Obat::whereIn('id', $request->obat_id)->get();
            $totalHargaObat = $obatList->sum('harga');
        }

        $totalBiaya = $biayaPeriksa + $totalHargaObat;

        // Simpan data pemeriksaan
        $periksa = Periksa::create([
            'id_janji_periksa' => $request->id_janji_periksa,
            'catatan' => $request->catatan,
            'tgl_periksa' => $request->tgl_periksa,
            'biaya_periksa' => $totalBiaya,
        ]);

        // Simpan relasi obat yang diberikan (detail periksa)
        if ($request->has('obat_id')) {
            foreach ($request->obat_id as $obatId) {
                DetailPeriksa::create([
                    'id_periksa' => $periksa->id,
                    'id_obat' => $obatId,
                ]);
            }
        }

        return redirect()->route('dokter.memeriksa.index')->with('success', 'Pemeriksaan dan obat berhasil disimpan.');
    }

    /**
     * Menampilkan form edit hasil pemeriksaan dan obat yang digunakan.
     * View: dokter.memeriksa.edit
     */
    public function edit($id)
    {
        // Ambil data pemeriksaan dan relasi janji periksa, pasien, detail obat
        $periksa = Periksa::with(['janjiPeriksa.pasien', 'detailPeriksas', 'obats'])->findOrFail($id);
        $obats = Obat::all();

        // Ambil ID obat yang sudah digunakan sebelumnya
        $selectedObatIds = $periksa->detailPeriksas->pluck('id_obat')->toArray();

        return view('dokter.memeriksa.edit', compact('periksa', 'obats', 'selectedObatIds'));
    }

    /**
     * Memperbarui hasil pemeriksaan dan daftar obat yang digunakan.
     * Data lama akan dihapus lalu diganti dengan yang baru.
     */
    public function update(Request $request, $id)
    {
        // Validasi data
        $request->validate([
            'catatan' => 'nullable|string',
            'tgl_periksa' => 'required|date',
            'obat_id' => 'nullable|array',
        ]);

        // Ambil data pemeriksaan berdasarkan ID
        $periksa = Periksa::findOrFail($id);

        $biayaPeriksa = 150000;
        $totalHargaObat = 0;

        // Hitung ulang harga total obat jika diubah
        if ($request->has('obat_id')) {
            $obatList = Obat::whereIn('id', $request->obat_id)->get();
            $totalHargaObat = $obatList->sum('harga');
        }

        $totalBiaya = $biayaPeriksa + $totalHargaObat;

        // Update data pemeriksaan
        $periksa->update([
            'catatan' => $request->catatan,
            'tgl_periksa' => $request->tgl_periksa,
            'biaya_periksa' => $totalBiaya,
        ]);

        // Hapus semua detail obat lama
        DetailPeriksa::where('id_periksa', $periksa->id)->delete();

        // Simpan detail obat baru
        if ($request->has('obat_id')) {
            foreach ($request->obat_id as $obatId) {
                DetailPeriksa::create([
                    'id_periksa' => $periksa->id,
                    'id_obat' => $obatId,
                ]);
            }
        }

        return redirect()->route('dokter.memeriksa.index')->with('success', 'Data pemeriksaan berhasil diperbarui.');
    }
}
