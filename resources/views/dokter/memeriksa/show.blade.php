<x-app-layout>
    <!-- Container utama dengan padding -->
    <div class="container py-4">
        <!-- Judul halaman -->
        <h3 class="mb-4">Pemeriksaan Pasien</h3>

        <!-- Form untuk menyimpan data pemeriksaan -->
        <form method="POST" action="{{ route('dokter.memeriksa.store', $janjiPeriksa->id) }}">
            @csrf <!-- Token keamanan Laravel -->

            <!-- Hidden input untuk menyimpan id janji periksa -->
            <input type="hidden" name="id_janji_periksa" value="{{ $janjiPeriksa->id }}">
            
            <!-- Field nama pasien (readonly karena tidak bisa diedit) -->
            <div class="mb-3">
                <label>Nama Pasien</label>
                <input type="text" class="form-control" value="{{ $janjiPeriksa->pasien->nama }}" readonly>
            </div>

            <!-- Field keluhan pasien (readonly) -->
            <div class="mb-3">
                <label>Keluhan</label>
                <input type="text" class="form-control" value="{{ $janjiPeriksa->keluhan }}" readonly>
            </div>

            <!-- Field tanggal pemeriksaan, default diisi dengan waktu sekarang -->
            <div class="mb-3">
                <label for="tanggal_periksa">Tanggal Periksa</label>
                <input type="datetime-local" name="tgl_periksa" class="form-control"
                       value="{{ \Carbon\Carbon::now()->format('Y-m-d\TH:i') }}" required>
            </div>

            <!-- Textarea untuk menulis catatan pemeriksaan -->
            <div class="mb-3">
                <label for="catatan">Catatan</label>
                <textarea name="catatan" class="form-control" rows="3" placeholder="Tulis catatan..." required></textarea>
            </div>

            <!-- Dropdown multiple untuk memilih obat yang diresepkan -->
            <div class="mb-3">
                <label for="obat_id">Obat</label>
                <select name="obat_id[]" id="obat" class="form-control" multiple required>
                    @foreach ($obats as $obat)
                        <option value="{{ $obat->id }}" data-price="{{ $obat->harga }}">
                            {{ $obat->nama_obat }} - {{ $obat->kemasan }} (Rp{{ number_format($obat->harga, 0, ',', '.') }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Biaya pemeriksaan otomatis + harga total obat -->
            <div class="mb-3">
                <label for="biaya_periksa">Biaya Pemeriksaan (Rp)</label>
                <input type="number" name="biaya_periksa" id="biaya_periksa" class="form-control" value="150000" readonly>
            </div>

            <!-- Tombol untuk submit form -->
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>

    <!-- Script untuk menghitung total biaya pemeriksaan + obat -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const baseCost = 150000; // Biaya dasar pemeriksaan
            const obatSelect = document.getElementById('obat');
            const biayaInput = document.getElementById('biaya_periksa');

            function updateBiaya() {
                let totalHargaObat = 0;
                const selectedOptions = obatSelect.selectedOptions;

                // Hitung total harga semua obat yang dipilih
                for (let option of selectedOptions) {
                    const harga = parseInt(option.dataset.price);
                    if (!isNaN(harga)) {
                        totalHargaObat += harga;
                    }
                }

                // Update nilai input biaya dengan total
                biayaInput.value = baseCost + totalHargaObat;
            }

            // Perbarui biaya saat pilihan obat berubah
            obatSelect.addEventListener('change', updateBiaya);
        });
    </script>
</x-app-layout>
