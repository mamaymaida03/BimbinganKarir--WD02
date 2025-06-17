<x-app-layout>
    <!-- Slot untuk bagian header halaman -->
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Obat') }} <!-- Menampilkan judul utama halaman -->
        </h2>
    </x-slot>

    <!-- Konten utama -->
    <div class="py-12">
        <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
            <!-- Kotak putih sebagai wadah form -->
            <div class="p-4 bg-white shadow-sm sm:p-8 sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <!-- Header section -->
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Edit Data Obat') }} <!-- Judul bagian edit -->
                            </h2>

                            <!-- Deskripsi singkat -->
                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('Silakan perbarui informasi obat sesuai dengan nama, kemasan, dan harga terbaru.') }}
                            </p>
                        </header>

                        <!-- Form untuk mengupdate data obat -->
                        <form class="mt-6" action="{{ route('dokter.obat.update', $obat->id) }}" method="POST">
                            @csrf <!-- CSRF token untuk keamanan -->
                            @method('PATCH') <!-- Override method menjadi PATCH sesuai RESTful -->

                            <!-- Input nama obat -->
                            <div class="mb-3 form-group">
                                <label for="editNamaObatInput">Nama</label>
                                <input type="text" class="rounded form-control" id="editNamaObatInput"
                                    value="{{ $obat->nama_obat }}" name="nama_obat">
                            </div>

                            <!-- Input kemasan obat -->
                            <div class="mb-3 form-group">
                                <label for="editKemasanInput">Kemasan</label>
                                <input type="text" class="rounded form-control" id="editKemasanInput"
                                    value="{{ $obat->kemasan }}" name="kemasan">
                            </div>

                            <!-- Input harga obat -->
                            <div class="mb-3 form-group">
                                <label for="editHargaInput">Harga</label>
                                <input type="text" class="rounded form-control" id="editHargaInput"
                                    value="{{ $obat->harga }}" name="harga">
                            </div>

                            <!-- Tombol untuk kembali ke halaman daftar obat -->
                            <a type="button" href="{{ route('dokter.obat.index') }}" class="btn btn-secondary">
                                Batal
                            </a>

                            <!-- Tombol untuk menyimpan perubahan -->
                            <button type="submit" class="btn btn-primary">
                                Update
                            </button>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
