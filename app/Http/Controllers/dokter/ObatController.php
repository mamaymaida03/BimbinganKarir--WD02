<?php

namespace App\Http\Controllers\dokter; 

use App\Http\Controllers\Controller;
use App\Models\Obat; 
use Illuminate\Http\Request; 

class ObatController extends Controller
{
    /**
     * Fungsi: Menampilkan semua data obat.
     * Route terkait: GET /dokter/obat
     */
    public function index()
    {
        $obats = Obat::all(); // Ambil semua data obat dari database
        return view('dokter.obat.index')->with([
            'obats' => $obats, // Kirim data ke view
        ]);
    }

    /**
     * Fungsi: Menampilkan form untuk input data obat baru.
     * Route terkait: GET /dokter/obat/create
     */
    public function create(){
        return view('dokter.obat.create'); // Tampilkan form tambah obat
    }

    /**
     * Fungsi: Menampilkan form untuk mengedit data obat berdasarkan ID.
     * Route terkait: GET /dokter/obat/{id}/edit
     */
    public function edit($id)
    {
        $obat = Obat::find($id); // Cari obat berdasarkan ID
        return view('dokter.obat.edit')->with([
            'obat' => $obat, // Kirim data obat ke form edit
        ]);
    }

    /**
     * Fungsi: Menyimpan data obat baru ke database.
     * Route terkait: POST /dokter/obat
     */
    public function store(Request $request)
    {
        // Validasi inputan dari form
        $request->validate([
            'nama_obat' => 'required|string|max:255',
            'kemasan' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
        ]);

        // Simpan data obat ke database
        Obat::create([
            'nama_obat' => $request->nama_obat,
            'kemasan' => $request->kemasan,
            'harga' => $request->harga,
        ]);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('dokter.obat.index')->with('status', 'obat-created');
    }

    /**
     * Fungsi: Memperbarui data obat yang sudah ada berdasarkan ID.
     * Route terkait: PUT /dokter/obat/{id}
     */
    public function update(Request $request, $id) {
        // Validasi input
        $request->validate([
            'nama_obat' => 'required|string|max:255',
            'kemasan' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
        ]);

        // Cari dan update data
        $obat = Obat::find($id);
        $obat->update([
            'nama_obat' => $request->nama_obat,
            'kemasan' => $request->kemasan,
            'harga' => $request->harga,
        ]);

        // Redirect ke index dengan pesan sukses
        return redirect()->route('dokter.obat.index')->with('status', 'obat-updated');
    }

    /**
     * Fungsi: Menghapus data obat (soft delete jika model mendukung).
     * Route terkait: DELETE /dokter/obat/{id}
     */
    public function destroy($id)
    {
        $obat = Obat::find($id); // Cari obat
        $obat->delete(); // Hapus (soft delete)
        return redirect()->route('dokter.obat.index'); // Kembali ke daftar obat
    }

    /**
     * Fungsi: Menampilkan form detail pemeriksaan dan daftar obat yang tersedia.
     * Route terkait: GET /dokter/periksa/{id}/form
     */
    public function showForm($id)
    {
        $janjiPeriksa = JanjiPeriksa::with('pasien')->findOrFail($id); // Data janji dan pasien
        $obats = Obat::all(); // Semua obat tersedia
        return view('dokter.memeriksa.detail', compact('janjiPeriksa', 'obats'));
    }

    /**
     * Fungsi: Menampilkan daftar obat yang telah dihapus (soft delete).
     * Route terkait: GET /dokter/obat/trashed
     */
    public function trashed()
    {
        $obats = Obat::onlyTrashed()->get(); // Ambil hanya data yang terhapus
        return view('dokter.obat.trashed', compact('obats'));
    }

    /**
     * Fungsi: Mengembalikan (restore) data obat yang telah dihapus.
     * Route terkait: PATCH /dokter/obat/{id}/restore
     */
    public function restore($id)
    {
        $obat = Obat::withTrashed()->findOrFail($id); // Cari termasuk yang soft deleted
        $obat->restore(); // Restore data

        return redirect()->route('dokter.obat.trashed')->with('success', 'Obat berhasil dikembalikan.');
    }
}
