<x-app-layout>
    <!-- Slot untuk judul halaman -->
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Tambah Jadwal Periksa') }}
        </h2>
    </x-slot>

    {{-- Memuat Alpine.js untuk animasi notifikasi --}}
    <script src="//unpkg.com/alpinejs" defer></script>

    <div class="py-12">
        <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
            <div class="p-4 bg-white shadow-sm sm:p-8 sm:rounded-lg">
                <section>
                    <!-- Header form -->
                    <header class="flex items-center justify-between">
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Form Tambah Jadwal Periksa') }}
                        </h2>
                    </header>

                    {{-- Notifikasi jika ada error validasi --}}
                    @if ($errors->any())
                        <div 
                            x-data="{ show: true }" 
                            x-init="setTimeout(() => show = false, 1000)" 
                            x-show="show"
                            class="mt-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded transition ease-in duration-300"
                        >
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li> <!-- Menampilkan setiap error -->
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Notifikasi sukses saat data berhasil disimpan --}}
                    @if (session('success'))
                        <div 
                            x-data="{ show: true }" 
                            x-init="setTimeout(() => show = false, 500)" 
                            x-show="show"
                            class="mt-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded transition ease-in duration-300"
                        >
                            {{ session('success') }} <!-- Menampilkan pesan sukses -->
                        </div>
                    @endif

                    <!-- Form Tambah Jadwal -->
                    <form action="{{ route('dokter.jadwal.store') }}" method="POST" class="mt-6 space-y-6">
                        @csrf

                        @php
                            // Menentukan daftar hari sesuai nama dokter yang login
                            $dokter = Auth::user(); // Ambil data user login (dokter)
                            if ($dokter->nama == 'Dr. Budi Santoso, Sp.PD') {
                                $hariJadwal = ['Senin', 'Selasa']; // Poli Penyakit Dalam
                            } elseif ($dokter->nama == 'Dr. Siti Rahayu, Sp.A') {
                                $hariJadwal = ['Rabu', 'Kamis']; // Poli Anak
                            } elseif ($dokter->nama == 'Dr. Doni Pratama, Sp.THT') {
                                $hariJadwal = ['Jumat', 'Sabtu']; // Poli THT
                            } else {
                                $hariJadwal = []; // Tidak ada jadwal jika bukan salah satu dari tiga dokter tersebut
                            }
                        @endphp

                        <!-- Dropdown pemilihan hari -->
                        <div class="form-group">
                            <label for="hari">Hari</label>
                            <select class="form-control" id="hari" name="hari" required>
                                <option value="">Pilih Hari</option>
                                @foreach ($hariJadwal as $hari)
                                    <option value="{{ $hari }}">{{ $hari }}</option> <!-- Menampilkan pilihan hari -->
                                @endforeach
                            </select>
                        </div>

                        <!-- Input jam mulai -->
                        <div class="form-group">
                            <label for="jam_mulai">Jam Mulai</label>
                            <input type="time" class="form-control" id="jam_mulai" name="jam_mulai" required>
                        </div>

                        <!-- Input jam selesai -->
                        <div class="form-group">
                            <label for="jam_selesai">Jam Selesai</label>
                            <input type="time" class="form-control" id="jam_selesai" name="jam_selesai" required>
                        </div>

                        <!-- Tombol submit -->
                        <button type="submit" class="btn btn-primary mt-4">Simpan</button>
                    </form>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
