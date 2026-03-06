<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kegiatan_tri_dharma', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('kategori', ['Pendidikan', 'Penelitian', 'Pengabdian Masyarakat'])->index();
            $table->string('sub_kategori');
            $table->string('nama_kegiatan');
            $table->text('deskripsi')->nullable();
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai')->nullable();
            $table->string('institusi_penyelenggara')->nullable();
            $table->string('tingkat')->nullable(); // Lokal, Nasional, Internasional
            $table->string('peran')->nullable(); // Ketua, Anggota, Pemakalah, dll
            $table->decimal('angka_kredit', 6, 2)->default(0);
            $table->string('bukti_dokumen')->nullable();
            $table->enum('status', ['Pending', 'Disetujui', 'Ditolak'])->default('Pending');
            $table->text('catatan_admin')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kegiatan_tri_dharma');
    }
};
