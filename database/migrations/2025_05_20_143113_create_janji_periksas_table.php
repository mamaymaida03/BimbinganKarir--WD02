<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Mengembalikan instance migration anonim (fitur Laravel)
return new class extends Migration
{
    /**
     * Menjalankan migration untuk membuat tabel janji_periksas
     */
    public function up(): void
    {
        // Membuat tabel 'janji_periksas'
        Schema::create('janji_periksas', function (Blueprint $table) {
            $table->id(); // Primary key otomatis (auto increment)

            // Kolom id_pasien, relasi ke tabel users, jika user dihapus maka janji juga ikut dihapus
            $table->foreignId('id_pasien')->constrained('users')->onDelete('cascade');

            // Kolom id_jadwal, relasi ke tabel jadwal_periksas, ikut terhapus jika jadwal dihapus
            $table->foreignId('id_jadwal')->constrained('jadwal_periksas')->onDelete('cascade');

            // Kolom keluhan, untuk menyimpan keluhan pasien saat membuat janji
            $table->text('keluhan');

            // Kolom no_antrian, maksimal 10 karakter (menyimpan nomor antrian pasien)
            $table->string('no_antrian', 10);

            // Kolom created_at dan updated_at otomatis
            $table->timestamps();
        });
    }

    /**
     * Membatalkan migration (menghapus tabel janji_periksas)
     */
    public function down(): void
    {
        // Menghapus tabel jika rollback
        Schema::dropIfExists('janji_periksas');
    }
};
