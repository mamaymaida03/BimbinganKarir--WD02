<!-- Menggunakan komponen layout utama aplikasi -->
<x-app-layout>

    <!-- Slot untuk judul halaman di bagian header -->
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Janji Periksa') }}
        </h2>
    </x-slot>

    <!-- Bagian konten utama halaman -->
    <div class="py-12">
        <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
            <div class="p-4 bg-white shadow-sm sm:p-8 sm:rounded-lg">
                <div class="max-w-xl">

                    <!-- Seksi untuk form janji periksa -->
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Buat Janji Periksa') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('Atur jadwal pertemuan dengan dokter untuk mendapatkan layanan konsultasi dan pemeriksaan kesehatan sesuai kebutuhan Anda.') }}
                            </p>
                        </header>

                        <!-- Form pengajuan janji periksa -->
                        <form class="mt-6" action="{{ route('pasien.janji-periksa.store') }}" method="POST">
                            @csrf <!-- Proteksi CSRF -->

                            <!-- Input nomor rekam medis (readonly) -->
                            <div class="form-group">
                                <label for="formGroupExampleInput">Nomor Rekam Medis</label>
                                <input type="text" class="rounded form-control" id="formGroupExampleInput"
                                    placeholder="Example input" value="{{ $no_rm }}" readonly>
                            </div>

                            <!-- Dropdown pemilihan dokter dan jadwal -->
                            <div class="form-group mt-4">
                                <label for="dokterSelect">Dokter</label>
                                <select class="form-control" name="id_dokter" id="dokterSelect" required>
                                    <option value="">Pilih Dokter</option>
                                    @foreach ($dokters as $dokter)
                                        @foreach ($dokter->jadwalPeriksas as $jadwal)
                                            <option value="{{ $dokter->id }}">
                                                {{ $dokter->nama }} - Spesialis {{ $dokter->spesialis }}
                                                ({{ $dokter->poli->nama }}) |
                                                {{ $jadwal->hari }},
                                                {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H.i') }} -
                                                {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H.i') }}
                                            </option>
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>

                            <!-- Input textarea untuk keluhan pasien -->
                            <div class="form-group mt-4">
                                <label for="keluhan">Keluhan</label>
                                <textarea class="form-control" name="keluhan" id="keluhan" rows="3" required></textarea>
                            </div>

                            <!-- Tombol submit dan notifikasi berhasil -->
                            <div class="flex items-center gap-4 mt-4">
                                <button type="submit" class="btn btn-primary">Submit</button>

                                <!-- Notifikasi sukses jika status 'janji-periksa-created' -->
                                @if (session('status') === 'janji-periksa-created')
                                    <p x-data="{ show: true }" x-show="show" x-transition
                                        x-init="setTimeout(() => show = false, 2000)"
                                        class="text-sm text-gray-600">{{ __('Berhasil Dibuat.') }}</p>
                                @endif
                            </div>
                        </form>
                    </section>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>
