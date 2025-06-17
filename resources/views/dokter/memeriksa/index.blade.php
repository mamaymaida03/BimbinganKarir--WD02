<x-app-layout>
    <!-- Slot header untuk judul halaman -->
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Memeriksa Pasien') }} <!-- Judul halaman -->
        </h2>
    </x-slot>

    <!-- Kontainer utama dengan padding -->
    <div class="py-12">
        <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
            <!-- Card putih berbayang untuk menampilkan daftar -->
            <div class="p-4 bg-white shadow sm-sm:p-8 sm:rounded-lg">
                <section>
                    <!-- Header bagian konten -->
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Daftar Periksa Pasien') }} <!-- Subjudul -->
                        </h2>
                    </header>

                    {{-- Tabel Daftar Pasien --}}
                    <table class="table mt-6 overflow-hidden rounded table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>No Urut</th>
                                <th>Nama Pasien</th>
                                <th>Keluhan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Loop untuk menampilkan setiap pasien yang punya janji periksa -->
                            @foreach ($pasien as $janjiPeriksa)
                                <tr>
                                    <td>{{ $loop->iteration }}</td> <!-- Nomor urut otomatis -->
                                    
                                    <!-- Nama pasien (jika ada relasi pasien) -->
                                    <td>{{ $janjiPeriksa->pasien->nama ?? '-' }}</td>
                                    
                                    <!-- Keluhan dari janji periksa -->
                                    <td>{{ $janjiPeriksa->keluhan }}</td>
                                    
                                    <!-- Kolom aksi -->
                                    <td>
                                        @if ($janjiPeriksa->periksa)
                                            <!-- Jika sudah diperiksa, tampilkan badge dan tombol edit -->
                                            <span class="badge bg-success">Sudah Diperiksa</span>
                                            <a href="{{ route('dokter.memeriksa.edit', $janjiPeriksa->periksa->id) }}" class="btn btn-sm btn-secondary mt-1">Edit</a>
                                        @else
                                            <!-- Jika belum diperiksa, tampilkan tombol periksa -->
                                            <a href="{{ route('dokter.memeriksa.show', $janjiPeriksa->id) }}" class="btn btn-primary">Periksa</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
