<x-app-layout>
    <!-- Slot untuk header halaman -->
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Riwayat Periksa') }} <!-- Judul utama halaman -->
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
            <!-- Card utama -->
            <div class="p-4 bg-white shadow sm-sm:p-8 sm:rounded-lg">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Riwayat Janji Periksa') }} <!-- Subjudul -->
                        </h2>
                    </header>

                    {{-- Tabel daftar janji periksa --}}
                    <table class="table mt-6 overflow-hidden rounded table-hover">
                        <thead class="thead-light">
                            <tr>
                                <!-- Header kolom tabel -->
                                <th scope="col">No</th>
                                <th scope="col">Poliklinik</th>
                                <th scope="col">Dokter</th>
                                <th scope="col">Hari</th>
                                <th scope="col">Mulai</th>
                                <th scope="col">Selesai</th>
                                <th scope="col">Antrian</th>
                                <th scope="col">Status</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Iterasi setiap janji periksa -->
                            @foreach ($janjiPeriksas as $janjiPeriksa)
                                <tr>
                                    <!-- Nomor urut -->
                                    <th scope="row" class="align-middle text-start">{{ $loop->iteration }}</th>

                                    <!-- Nama poliklinik -->
                                    <td class="align-middle text-start">
                                        {{ $janjiPeriksa->jadwalPeriksa->dokter->poli->nama }}
                                    </td>

                                    <!-- Nama dokter -->
                                    <td class="align-middle text-start">
                                        {{ $janjiPeriksa->jadwalPeriksa->dokter->nama }}
                                    </td>

                                    <!-- Hari pemeriksaan -->
                                    <td class="align-middle text-start">
                                        {{ $janjiPeriksa->jadwalPeriksa->hari }}
                                    </td>

                                    <!-- Jam mulai pemeriksaan -->
                                    <td class="align-middle text-start">
                                        {{ \Carbon\Carbon::parse($janjiPeriksa->jadwalPeriksa->jam_mulai)->format('H.i') }}
                                    </td>

                                    <!-- Jam selesai pemeriksaan -->
                                    <td class="align-middle text-start">
                                        {{ \Carbon\Carbon::parse($janjiPeriksa->jadwalPeriksa->jam_selesai)->format('H.i') }}
                                    </td>

                                    <!-- Nomor antrian -->
                                    <td class="align-middle text-start">
                                        {{ $janjiPeriksa->no_antrian }}
                                    </td>

                                    <!-- Status apakah sudah diperiksa atau belum -->
                                    <td class="align-middle text-start">
                                        @if (is_null($janjiPeriksa->periksa))
                                            <span class="badge badge-pill badge-warning">Belum Diperiksa</span>
                                        @else
                                            <span class="badge badge-pill badge-success">Sudah Diperiksa</span>
                                        @endif
                                    </td>

                                    <!-- Aksi tombol: detail atau riwayat -->
                                    <td class="align-middle text-start">
                                        @if (is_null($janjiPeriksa->periksa))
                                            <a href="{{ route('pasien.riwayat-periksa.detail', $janjiPeriksa->id) }}" class="btn btn-info">Detail</a>
                                        @else
                                            <a href="{{ route('pasien.riwayat-periksa.riwayat', $janjiPeriksa->id) }}" class="btn btn-secondary">Riwayat</a>
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
