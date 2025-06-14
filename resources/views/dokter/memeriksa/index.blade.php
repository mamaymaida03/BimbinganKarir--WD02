<x-app-layout> 
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Memeriksa Pasien') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
            <div class="p-4 bg-white shadow sm-sm:p-8 sm:rounded-lg">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Daftar Periksa Pasien') }}
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
                            @foreach ($pasien as $janjiPeriksa)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $janjiPeriksa->pasien->nama ?? '-' }}</td>
                                    <td>{{ $janjiPeriksa->keluhan }}</td>
                                    <td>
                                        @if ($janjiPeriksa->periksa)
                                            <span class="badge bg-success">Sudah Diperiksa</span>
                                            <a href="{{ route('dokter.memeriksa.edit', $janjiPeriksa->periksa->id) }}" class="btn btn-sm btn-secondary mt-1">Edit</a>
                                        @else
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
