<x-app-layout>
    <!-- Container utama halaman -->
    <div class="container py-4">
        <h3 class="mb-4">Edit Pemeriksaan Pasien</h3>

        <!-- Form untuk update data pemeriksaan -->
        <form method="POST" action="{{ route('dokter.memeriksa.update', $periksa->id) }}">
            @csrf
            @method('PUT')

            <!-- Input tersembunyi: menyimpan ID janji periksa yang sedang diperiksa -->
            <input type="hidden" name="id_janji_periksa" value="{{ $periksa->id_janji_periksa }}">

            <!-- Menampilkan nama pasien (readonly) -->
            <div class="mb-3">
                <label>Nama Pasien</label>
                <input type="text" class="form-control" value="{{ $periksa->janjiPeriksa->pasien->nama }}" readonly>
            </div>

            <!-- Menampilkan keluhan pasien (readonly) -->
            <div class="mb-3">
                <label>Keluhan</label>
                <input type="text" class="form-control" value="{{ $periksa->janjiPeriksa->keluhan }}" readonly>
            </div>

            <!-- Input tanggal & jam pemeriksaan -->
            <div class="mb-3">
                <label for="tgl_periksa">Tanggal Periksa</label>
                <input type="datetime-local" name="tgl_periksa" class="form-control"
                       value="{{ \Carbon\Carbon::parse($periksa->tgl_periksa)->format('Y-m-d\TH:i') }}" required>
            </div>

            <!-- Input catatan dokter -->
            <div class="mb-3">
                <label for="catatan">Catatan</label>
                <textarea name="catatan" class="form-control" rows="3" placeholder="Tulis catatan..." required>{{ $periksa->catatan }}</textarea>
            </div>

            <!-- Dropdown multiple select untuk memilih obat -->
            <div class="mb-3">
                <label for="obat_id">Obat</label>
                <select name="obat_id[]" id="obat" class="form-control" multiple required>
                    @foreach ($obats as $obat)
                        <option value="{{ $obat->id }}" data-price="{{ $obat->harga }}"
                            {{ $periksa->obats->contains($obat->id) ? 'selected' : '' }}>
                            {{ $obat->nama_obat }} - {{ $obat->kemasan }} (Rp{{ number_format($obat->harga, 0, ',', '.') }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Input biaya pemeriksaan (otomatis dihitung, tidak bisa diedit) -->
            <div class="mb-3">
                <label for="biaya_periksa">Biaya Pemeriksaan (Rp)</label>
                <input type="number" name="biaya_periksa" id="biaya_periksa" class="form-control"
                       value="{{ $periksa->biaya_periksa }}" readonly>
            </div>

            <!-- Tombol submit untuk menyimpan perubahan -->
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>

    <!-- Script untuk menghitung total biaya berdasarkan obat yang dipilih -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const baseCost = 150000; // Biaya dasar periksa
            const obatSelect = document.getElementById('obat'); // Element select obat
            const biayaInput = document.getElementById('biaya_periksa'); // Input biaya

            // Fungsi menghitung total biaya dari obat terpilih
            function updateBiaya() {
                let totalHargaObat = 0;
                const selectedOptions = obatSelect.selectedOptions;

                for (let option of selectedOptions) {
                    const harga = parseInt(option.dataset.price); // Ambil harga dari data attribute
                    if (!isNaN(harga)) {
                        totalHargaObat += harga;
                    }
                }

                // Total biaya = biaya dasar + total harga obat
                biayaInput.value = baseCost + totalHargaObat;
            }

            // Event listener: jika obat berubah, biaya akan diperbarui
            obatSelect.addEventListener('change', updateBiaya);

            // Hitung biaya awal saat halaman dimuat
            updateBiaya();
        });
    </script>
</x-app-layout>
