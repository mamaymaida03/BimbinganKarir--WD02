<x-app-layout>
    <!-- Slot header, menampilkan judul halaman -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Obat Terhapus
        </h2>
    </x-slot>

    <!-- Kontainer utama -->
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Menampilkan pesan sukses jika ada --}}
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded shadow">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Tombol kembali ke daftar obat --}}
            <a href="{{ route('dokter.obat.index') }}" 
               class="mb-4 inline-block bg-gray-500 text-white px-4 py-2 rounded">Kembali</a>

            <!-- Wrapper tabel -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="overflow-x-auto">
                    <table class="table-auto w-full border border-gray-300 text-sm">
                        <thead>
                            <tr class="bg-gray-100 text-gray-800 font-semibold">
                                <th class="px-4 py-2 border">No</th>
                                <th class="px-4 py-2 border">Nama Obat</th>
                                <th class="px-4 py-2 border">Kemasan</th>
                                <th class="px-4 py-2 border">Harga</th>
                                <th class="px-4 py-2 border text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($obats as $index => $obat)
                                <tr class="hover:bg-gray-50">
                                    <!-- Nomor urut -->
                                    <td class="border px-4 py-2 text-center">{{ $index + 1 }}</td>
                                    <!-- Nama obat -->
                                    <td class="border px-4 py-2">{{ $obat->nama_obat }}</td>
                                    <!-- Kemasan -->
                                    <td class="border px-4 py-2">{{ $obat->kemasan }}</td>
                                    <!-- Harga dalam format rupiah -->
                                    <td class="border px-4 py-2">Rp{{ number_format($obat->harga, 0, ',', '.') }}</td>
                                    <!-- Tombol Restore -->
                                    <td class="border px-4 py-2 text-center">

                                        <!-- untuk mengembalikan obat yang sudah dihapus -->
                                        <form action="{{ route('dokter.obat.restore', $obat->id) }}" method="POST"
                                              onsubmit="return confirm('Yakin ingin mengembalikan obat ini?')">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-success btn-sm">
                                                <i class="fas fa-undo-alt"></i> Restore
                                            </button>
                                        </form>

                                    </td>
                                </tr>
                            @empty
                                <!-- Jika tidak ada data obat terhapus -->
                                <tr>
                                    <td colspan="5"
                                        class="text-center py-6 text-gray-500 bg-gray-50 italic border">
                                        Tidak ada obat yang terhapus.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
