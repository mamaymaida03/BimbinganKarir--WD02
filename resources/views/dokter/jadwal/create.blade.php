<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Tambah Jadwal Periksa') }}
        </h2>
    </x-slot>

    {{-- Tambahkan Alpine.js --}}
    <script src="//unpkg.com/alpinejs" defer></script>

    <div class="py-12">
        <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
            <div class="p-4 bg-white shadow-sm sm:p-8 sm:rounded-lg">
                <section>
                    <header class="flex items-center justify-between">
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Form Tambah Jadwal Periksa') }}
                        </h2>
                    </header>

                    {{-- Notifikasi error --}}
                    @if ($errors->any())
                        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 1000)" x-show="show"
                            class="mt-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded transition ease-in duration-300">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Notifikasi sukses --}}
                    @if (session('success'))
                        <div 
                            x-data="{ show: true }" 
                            x-init="setTimeout(() => show = false, 500)" 
                            x-show="show"
                            class="mt-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded transition ease-in duration-300"
                        >
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('dokter.jadwal.store') }}" method="POST" class="mt-6 space-y-6">
                        @csrf
                        <div>
                            <label for="hari" class="block text-sm font-medium text-gray-700">Hari</label>
                            <select name="hari" id="hari" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                <option value="Senin">Senin</option>
                                <option value="Selasa">Selasa</option>
                                <option value="Rabu">Rabu</option>
                                <option value="Kamis">Kamis</option>
                                <option value="Jumat">Jumat</option>
                                <option value="Sabtu">Sabtu</option>
                                <option value="Minggu">Minggu</option>
                            </select>
                        </div>

                        <div>
                            <label for="jam_mulai" class="block text-sm font-medium text-gray-700">Jam Mulai</label>
                            <input type="time" name="jam_mulai" id="jam_mulai" value="{{ old('jam_mulai') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        </div>

                        <div>
                            <label for="jam_selesai" class="block text-sm font-medium text-gray-700">Jam Selesai</label>
                            <input type="time" name="jam_selesai" id="jam_selesai" value="{{ old('jam_selesai') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        </div>

                        <button type="submit" class="btn btn-primary mt-4">Simpan</button>
                    </form>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
