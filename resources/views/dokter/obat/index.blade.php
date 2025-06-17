<x-app-layout>
    <!-- Bagian header halaman -->
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Obat') }} <!-- Judul utama halaman -->
        </h2>
    </x-slot>

    <!-- Konten utama halaman -->
    <div class="py-12">
        <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
        
            <!-- Wrapper kotak putih untuk isi utama -->
            <div class="p-4 bg-white shadow-sm sm:p-8 sm:rounded-lg" 
            <!--->
            <section> 
                <!-- Header section tabel dan tombol -->
                <header class="flex items-center justify-between">
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Daftar Obat') }} <!-- Judul tabel -->
                    </h2>

                    <!-- Tombol aksi di kanan atas -->
                    <div class="flex-col items-center justify-center text-center">
                        <!-- Tombol menuju halaman daftar obat terhapus (soft delete) -->
                        <a href="{{ route('dokter.obat.trashed') }}" class="btn btn-warning me-2">Obat Terhapus</a>
                        <!-- Tombol tambah obat -->
                        <a href="{{route('dokter.obat.create')}}" class="btn btn-primary">Tambah Obat</a>

                        <!-- Menampilkan pesan sukses jika obat berhasil dibuat -->
                        @if (session('status') === 'obat-created')
                            <p x-data="{ show: true }" 
                               x-show="show" 
                               x-transition 
                               x-init="setTimeout(() => show = false, 2000)"
                               class="text-sm text-gray-600">
                                {{ __('Created.') }}
                            </p>
                        @endif
                    </div>
                </header>

                <!-- Tabel daftar obat -->
                <table class="table mt-6 overflow-hidden rounded table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama Obat</th>
                            <th scope="col">Kemasan</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($obats as $obat)
                            <tr>
                                <!-- Nomor urut -->
                                <th scope="row" class="align-middle text-start">{{ $loop->iteration }}</th>
                                <!-- Nama obat -->
                                <td class="align-middle text-start">{{ $obat->nama_obat }}</td>
                                <!-- Kemasan obat -->
                                <td class="align-middle text-start">{{ $obat->kemasan }}</td>
                                <!-- Harga obat (diformat rupiah) -->
                                <td class="align-middle text-start">
                                    {{ 'Rp' . number_format($obat->harga, 0, ',', '.') }}
                                </td>
                                <!-- Tombol aksi -->
                                <td class="flex items-center gap-3">
                                    {{-- Tombol Edit --}}
                                    <a href="{{route('dokter.obat.edit', $obat->id)}}" class="btn btn-secondary btn-sm">Edit</a>

                                    {{-- Form Delete --}}
                                    <form action="{{ route('dokter.obat.destroy', $obat->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </section> <!--  Penutup tag section (perlu perbaikan posisi) -->
            </div>
        </div>
</x-app-layout>
