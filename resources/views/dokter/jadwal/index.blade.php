<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Jadwal Periksa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
            <div class="p-4 bg-white shadow-sm sm:p-8 sm:rounded-lg">
                <header class="flex items-center justify-between">
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Daftar Jadwal Periksa') }}
                    </h2>

                    <div class="flex-col items-center justify-center text-center">
                        <a href="{{ route('dokter.jadwal.create') }}" class="btn btn-primary">Tambah Jadwal</a>

                        @if (session('status') === 'jadwal-created')
                            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">{{ __('Jadwal berhasil dibuat.') }}</p>
                        @endif
                    </div>
                </header>

                <table class="table mt-6 overflow-hidden rounded table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Hari</th>
                            <th scope="col">Mulai</th>
                            <th scope="col">Selesai</th>
                            <th scope="col">Status</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($jadwals as $jadwal)
                            <tr>
                                <th scope="row" class="align-middle text-start">{{ $loop->iteration }}</th>
                                <td class="align-middle text-start">{{ $jadwal->hari }}</td>
                                <td class="align-middle text-start">{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}</td>
                                <td class="align-middle text-start">{{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</td>
                                <td class="align-middle text-start">
                                    <span class="badge {{ $jadwal->status ? 'bg-success' : 'bg-danger' }} text-white fw-bold fs-5">
                                        {{ $jadwal->status ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>

                                <td class="flex items-center gap-3">
                                    {{-- Button untuk mengubah status --}}
                                    <form action="{{ route('dokter.jadwal.status', $jadwal->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn {{ $jadwal->status ? 'btn-warning' : 'btn-success' }} btn-sm">
                                            {{ $jadwal->status ? 'Nonaktifkan' : 'Aktifkan' }}
                                        </button>
                                    </form>

                                    {{-- Button Hapus
                                    <form action="{{ route('dokter.jadwal.destroy', $jadwal->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form> --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
