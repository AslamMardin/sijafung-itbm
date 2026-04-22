<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kategori_kegiatan', function (Blueprint $table) {
            $table->id();
            $table->string('menu_utama'); // Pelaksanaan Pendidikan, Pelaksanaan Penelitian, Pelaksanaan Pengabdian
            $table->string('submenu'); // Pengajaran, Bimbingan Mahasiswa, Penelitian, dll
            $table->string('nama_kategori'); // Nama kategori lengkap
            $table->text('deskripsi')->nullable();
            $table->decimal('angka_kredit', 8, 2)->default(0); // AK default
            $table->string('satuan')->nullable(); // SKS, Tahun, Buah, dll
            $table->integer('urutan')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index(['menu_utama', 'submenu']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kategori_kegiatan');
    }
};
