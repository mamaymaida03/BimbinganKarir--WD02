<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Memeriksa Pasien') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
            <div class="p-4 bg-white shadow-sm sm:p-8 sm:rounded-lg">
                <section>
                    <header class="flex items-center justify-between">
                        <h2 class="font-bold text-base">
                            Daftar Periksa Pasien
                        </h2>
                    </header>

                    <table class="table mt-6 overflow-hidden rounded table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">No Urut</th>
                                <th scope="col">Nama Pasien</th>
                                <th scope="col">Keluhan</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pasien as $p)  {{-- Menggunakan $pasien yang dikirim dari controller --}}
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $p->pasien->nama }}</td>
                                    <td>{{ $p->keluhan }}</td>
                                    <td>
                                        <a href="{{ route('dokter.memeriksa.show', $p->id) }}" class="btn btn-primary">
                                            Periksa
                                        </a>
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
