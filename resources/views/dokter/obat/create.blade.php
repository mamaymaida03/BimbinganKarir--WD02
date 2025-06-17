<x-app-layout>
    <!-- Slot header untuk judul halaman -->
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Obat') }} <!-- Teks header utama -->
        </h2>
    </x-slot>

    <!-- Bagian utama konten -->
    <div class="py-12">
        <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
            <div class="p-4 bg-white shadow-sm sm:p-8 sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <!-- Header form -->
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Edit Data Obat') }} <!-- Judul form -->
                            </h2>

                            <!-- Deskripsi singkat -->
                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('Silakan isi form di bawah ini untuk menambahkan data obat ke dalam sistem.') }}
                            </p>
                        </header>

                        <!-- Form untuk menambahkan atau mengedit obat -->
                        <form class="mt-6" id="formObat" action="{{ route('dokter.obat.store') }}" method="POST">
                            @csrf <!-- Token keamanan Laravel -->

                            <!-- Input nama obat -->
                            <div class="mb-3 form-group">
                                <label for="namaObat">Nama Obat</label>
                                <input type="text" class="rounded form-control" id="namaObat" name="nama_obat">
                            </div>

                            <!-- Input kemasan obat -->
                            <div class="mb-3 form-group">
                                <label for="kemasan">Kemasan</label>
                                <input type="text" class="rounded form-control" id="kemasan" name="kemasan">
                            </div>

                            <!-- Input harga obat -->
                            <div class="mb-3 form-group">
                                <label for="harga">Harga</label>
                                <input type="text" class="rounded form-control" id="harga" name="harga">
                            </div>

                            <!-- Tombol Batal yang mengarahkan ke halaman daftar obat -->
                            <a type="button" href="{{ route('dokter.obat.index') }}" class="btn btn-secondary">
                                Batal
                            </a>

                            <!-- Tombol Simpan untuk submit form -->
                            <button type="submit" class="btn btn-primary">
                                Simpan
                            </button>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
