<?php

use App\Http\Controllers\Dokter\JadwalPeriksaController;
use App\Http\Controllers\dokter\ObatController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\pasien\JanjiPeriksaController;
use App\Http\Controllers\pasien\RiwayatPeriksaController;
use App\Http\Controllers\dokter\MemeriksaController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Dokter 
Route::middleware(['auth', 'role:dokter'])->prefix('dokter')->group(function () {
    Route::get('/dashboard', function () {
        return view('dokter.dashboard');
    })->name('dokter.dashboard');

    Route::prefix('obat')->group(function () {
        Route::get('/', [ObatController::class, 'index'])->name('dokter.obat.index');
        Route::get('/create', [ObatController::class, 'create'])->name('dokter.obat.create');
        Route::post('/', [ObatController::class, 'store'])->name('dokter.obat.store');
        Route::get('/{id}/edit', [ObatController::class, 'edit'])->name('dokter.obat.edit');
        Route::patch('/{id}', [ObatController::class, 'update'])->name('dokter.obat.update');
        Route::delete('/{id}', [ObatController::class, 'destroy'])->name('dokter.obat.destroy');
    });

    Route::prefix('jadwal')->group(function () {
        Route::get('/create', [JadwalPeriksaController::class, 'create'])->name('dokter.jadwal.create');
        Route::post('/', [JadwalPeriksaController::class, 'store'])->name('dokter.jadwal.store');
        Route::get('/', [JadwalPeriksaController::class, 'index'])->name('dokter.jadwal.index');
        Route::post('/{id}/status', [JadwalPeriksaController::class, 'toggleStatus'])->name('dokter.jadwal.status');
        //Route::delete('/{id}', [JadwalPeriksaController::class, 'destroy'])->name('dokter.jadwal.destroy');
    });

    Route::prefix('memeriksa')->name('dokter.memeriksa.')->group(function () {
        Route::get('/', [MemeriksaController::class, 'index'])->name('index');
        Route::get('/{janji}', [MemeriksaController::class, 'show'])->name('show');
        Route::post('/{janji}', [MemeriksaController::class, 'store'])->name('store');
        Route::get('/{periksa}/edit', [MemeriksaController::class, 'edit'])->name('edit');
        Route::put('/{periksa}', [MemeriksaController::class, 'update'])->name('update');
    });

});


//Pasien
Route::middleware(['auth', 'role:pasien'])->prefix('pasien')->group(function () {
    Route::get('/dashboard', function () {
        return view('pasien.dashboard');
    })->name('pasien.dashboard');
    Route::prefix('janji-periksa')->group(function(){
        Route::get('/', [JanjiPeriksaController::class, 'index'])->name('pasien.janji-periksa.index');
        Route::post('/', [JanjiPeriksaController::class, 'store'])->name('pasien.janji-periksa.store');
    });
    Route::prefix('riwayat-periksa')->group(function(){
        Route::get('/', [RiwayatPeriksaController::class, 'index'])->name('pasien.riwayat-periksa.index');
        Route::get('/{id}/detail', [RiwayatPeriksaController::class, 'detail'])->name('pasien.riwayat-periksa.detail');
        Route::get('/{id}/riwayat', [RiwayatPeriksaController::class, 'riwayat'])->name('pasien.riwayat-periksa.riwayat');
    });
});

require __DIR__.'/auth.php';
