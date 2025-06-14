<x-app-layout>
    <div class="container py-4">
        <h3 class="mb-4">Edit Pemeriksaan Pasien</h3>

        <form method="POST" action="{{ route('dokter.memeriksa.update', $periksa->id) }}">
            @csrf
            @method('PUT')

            <!-- Hidden input untuk id_janji_periksa -->
            <input type="hidden" name="id_janji_periksa" value="{{ $periksa->id_janji_periksa }}">

            <div class="mb-3">
                <label>Nama Pasien</label>
                <input type="text" class="form-control" value="{{ $periksa->janjiPeriksa->pasien->nama }}" readonly>
            </div>

            <div class="mb-3">
                <label>Keluhan</label>
                <input type="text" class="form-control" value="{{ $periksa->janjiPeriksa->keluhan }}" readonly>
            </div>

            <div class="mb-3">
                <label for="tgl_periksa">Tanggal Periksa</label>
                <input type="datetime-local" name="tgl_periksa" class="form-control"
                       value="{{ \Carbon\Carbon::parse($periksa->tgl_periksa)->format('Y-m-d\TH:i') }}" required>
            </div>

            <div class="mb-3">
                <label for="catatan">Catatan</label>
                <textarea name="catatan" class="form-control" rows="3" placeholder="Tulis catatan..." required>{{ $periksa->catatan }}</textarea>
            </div>

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

            <div class="mb-3">
                <label for="biaya_periksa">Biaya Pemeriksaan (Rp)</label>
                <input type="number" name="biaya_periksa" id="biaya_periksa" class="form-control"
                       value="{{ $periksa->biaya_periksa }}" readonly>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const baseCost = 150000;
            const obatSelect = document.getElementById('obat');
            const biayaInput = document.getElementById('biaya_periksa');

            function updateBiaya() {
                let totalHargaObat = 0;
                const selectedOptions = obatSelect.selectedOptions;

                for (let option of selectedOptions) {
                    const harga = parseInt(option.dataset.price);
                    if (!isNaN(harga)) {
                        totalHargaObat += harga;
                    }
                }

                biayaInput.value = baseCost + totalHargaObat;
            }

            obatSelect.addEventListener('change', updateBiaya);

            updateBiaya();
        });
    </script>
</x-app-layout>
