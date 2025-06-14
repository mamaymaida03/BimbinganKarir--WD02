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
    public function index()
    {
        $jadwals = JadwalPeriksa::where('id_dokter', Auth::id())->get();

        $pasien = JanjiPeriksa::with(['pasien', 'periksa']) // tambahkan relasi 'periksa'
            ->whereIn('id_jadwal', $jadwals->pluck('id'))
            ->get();

        return view('dokter.memeriksa.index', compact('pasien'));
    }

    // Menampilkan form pemeriksaan pasien
    public function show($id)
    {
        $janjiPeriksa = JanjiPeriksa::with('pasien')->findOrFail($id);
        $obats = Obat::all(); // Tambahkan list obat untuk ditampilkan di form

        return view('dokter.memeriksa.show', compact('janjiPeriksa', 'obats'));
    }

    // Menyimpan hasil pemeriksaan
    public function store(Request $request)
    {
        $request->validate([
            'id_janji_periksa' => 'required|exists:janji_periksas,id', 
            'catatan' => 'nullable|string',
            'tgl_periksa' => 'required|date',
            'obat_id' => 'nullable|array',
        ]);

        $biayaPeriksa = 150000; // biaya dasar pemeriksaan

        $totalHargaObat = 0;
        if ($request->has('obat_id')) {
            $obatList = Obat::whereIn('id', $request->obat_id)->get();
            $totalHargaObat = $obatList->sum('harga');
        }

        $totalBiaya = $biayaPeriksa + $totalHargaObat;

        // Siapkan data yang akan disimpan
        $dataPeriksa = [
            'id_janji_periksa' => $request->id_janji_periksa,
            'catatan' => $request->catatan,
            'tgl_periksa' => $request->tgl_periksa,
            'biaya_periksa' => $totalBiaya,
        ];

        // Simpan data pemeriksaan
        $periksa = Periksa::create($dataPeriksa);

        // Simpan detail obat
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

    public function edit($id)
    {
        $periksa = Periksa::with(['janjiPeriksa.pasien', 'detailPeriksa'])->findOrFail($id);
        $obats = Obat::all();

        // Ambil id obat yang sudah dipilih sebelumnya
        $selectedObatIds = $periksa->detailPeriksa->pluck('id_obat')->toArray();

        return view('dokter.memeriksa.edit', compact('periksa', 'obats', 'selectedObatIds'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'catatan' => 'nullable|string',
            'tgl_periksa' => 'required|date',
            'obat_id' => 'nullable|array',
        ]);

        $periksa = Periksa::findOrFail($id);

        $biayaPeriksa = 150000;

        $totalHargaObat = 0;
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

        // Hapus data detail obat lama
        DetailPeriksa::where('id_periksa', $periksa->id)->delete();

        // Simpan ulang detail obat baru
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
