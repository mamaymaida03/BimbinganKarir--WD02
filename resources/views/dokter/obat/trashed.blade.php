<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Obat Terhapus
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Flash message sukses --}}
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded shadow">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Tombol kembali --}}
            <a href="{{ route('dokter.obat.index') }}" class="mb-4 inline-block bg-gray-500 text-white px-4 py-2 rounded">Kembali</a>

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
                                    <td class="border px-4 py-2 text-center">{{ $index + 1 }}</td>
                                    <td class="border px-4 py-2">{{ $obat->nama_obat }}</td>
                                    <td class="border px-4 py-2">{{ $obat->kemasan }}</td>
                                    <td class="border px-4 py-2">Rp{{ number_format($obat->harga, 0, ',', '.') }}</td>
                                    <td class="border px-4 py-2 text-center">
                                        <form action="{{ route('dokter.obat.restore', $obat->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin mengembalikan obat ini?')">
                                            @csrf
                                            @method('PATCH')
                                            <form action="{{ route('dokter.obat.restore', $obat->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin mengembalikan obat ini?')">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-success btn-sm">
                                                    <i class="fas fa-undo-alt"></i> Restore
                                                </button>
                                            </form>
                                        </form>
                                    </td>
                                </tr>
                            @empty
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
