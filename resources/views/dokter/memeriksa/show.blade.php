<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Detail Pasien') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-4 bg-white shadow sm:rounded-lg">
                <h3 class="text-lg font-medium">Nama Pasien: {{ $janjiPeriksa->pasien->nama }}</h3>
                <p><strong>Keluhan:</strong> {{ $janjiPeriksa->keluhan }}</p>

                <form action="{{ route('dokter.memeriksa.store', $janjiPeriksa->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="catatan">Catatan Pemeriksaan</label>
                        <textarea id="catatan" name="catatan" class="form-control" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="biaya_periksa">Biaya Pemeriksaan</label>
                        <input type="number" id="biaya_periksa" name="biaya_periksa" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary mt-4">Selesai Memeriksa</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
