<?php

namespace App\Http\Controllers\dokter; 
use App\Http\Controllers\Controller;
use App\Models\Obat; 
use Illuminate\Http\Request; 

class ObatController extends Controller
{
    /**
     * Menampilkan daftar semua obat.
     */
    public function index()
    {
        // Mengambil semua data obat dari tabel obats
        $obats = Obat::all();

        // Mengirimkan data obats ke view dokter.obat.index
        return view('dokter.obat.index')->with([
            'obats' => $obats,
        ]);
    }

    /**
     * Menampilkan form untuk membuat data obat baru.
     */
    public function create(){
        // Mengembalikan view untuk create obat
        return view('dokter.obat.create');
    }

    /**
     * Menampilkan form untuk edit data obat.
     */
    public function edit($id)
    {
        // Mencari data obat berdasarkan id
        $obat = Obat::find($id);

        // Mengirimkan data obat ke view edit
        return view('dokter.obat.edit')->with([
            'obat' => $obat,
        ]);
    }

    /**
     * Menyimpan data obat baru.
     */
    public function store(Request $request)
    {
        // Validasi data request
        $request->validate([
            'nama_obat' => 'required|string|max:255',
            'kemasan' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
        ]);

        // Membuat record baru di tabel obats
        Obat::create([
            'nama_obat' => $request->nama_obat,
            'kemasan' => $request->kemasan,
            'harga' => $request->harga,
        ]);

        // Redirect ke index dengan flash message 'obat-created'
        return redirect()->route('dokter.obat.index')->with('status', 'obat-created');
    }

    /**
     * Memperbarui data obat yang sudah ada.
     */
    public function update(Request $request, $id) {
        // Validasi data request
        $request->validate([
            'nama_obat' => 'required|string|max:255',
            'kemasan' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
        ]);

        // Cari data obat berdasarkan id
        $obat = Obat::find($id);

        // Update data obat
        $obat->update([
            'nama_obat' => $request->nama_obat,
            'kemasan' => $request->kemasan,
            'harga' => $request->harga,
        ]);

        // Redirect ke index dengan flash message 'obat-updated'
        return redirect()->route('dokter.obat.index')->with('status', 'obat-updated');
    }

    /**
     * Menghapus data obat.
     */
    public function destroy($id)
    {
        // Cari data obat berdasarkan id
        $obat = Obat::find($id);

        // Hapus data obat
        $obat->delete();

        // Redirect ke index
        return redirect()->route('dokter.obat.index');
    }

    public function showForm($id)
    {
        $janjiPeriksa = JanjiPeriksa::with('pasien')->findOrFail($id);
        $obats = Obat::all(); // Ambil semua data obat

        return view('dokter.memeriksa.detail', compact('janjiPeriksa', 'obats'));
    }

    public function trashed()
    {
        $obats = Obat::onlyTrashed()->get();
        return view('dokter.obat.trashed', compact('obats'));
    }

    public function restore($id)
    {
        $obat = Obat::withTrashed()->findOrFail($id);
        $obat->restore();

        return redirect()->route('dokter.obat.trashed')->with('success', 'Obat berhasil dikembalikan.');
    }

}
