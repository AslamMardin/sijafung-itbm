<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pelaksanaan_penelitian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Kategori
            $table->string('jenis_kegiatan'); // penelitian, publikasi_karya, paten_hki
            $table->string('kategori_kegiatan_id')->nullable();
            $table->string('sub_kategori')->nullable();
            
            // Fields untuk Penelitian
            $table->string('judul_kegiatan')->nullable();
            $table->string('afiliasi')->nullable();
            $table->integer('tahun_pelaksanaan')->nullable();
            $table->integer('lama_kegiatan_tahun')->nullable();
            $table->enum('peran', ['ketua', 'anggota'])->nullable();
            $table->integer('jumlah_anggota')->nullable();
            
            // Fields untuk Publikasi Karya
            $table->string('jenis_publikasi')->nullable(); // Jurnal nasional terakreditasi, buku referensi, prosiding, dll
            $table->date('tanggal_terbit')->nullable();
            $table->enum('peran_penulis', ['penulis', 'editor', 'penerjemah'])->nullable();
            
            // Fields untuk Paten/HKI
            $table->string('jenis_hki')->nullable(); // Paten, Hak Cipta, dll
            $table->string('nomor_paten')->nullable();
            
            // Dokumen & Status
            $table->string('link_dokumen')->nullable();
            $table->string('bukti_dokumen')->nullable();
            $table->enum('status', ['Pending', 'Disetujui', 'Ditolak'])->default('Pending');
            $table->text('catatan_admin')->nullable();
            $table->decimal('angka_kredit', 8, 2)->default(0);
            
            $table->timestamps();
            
            $table->index(['user_id', 'jenis_kegiatan', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pelaksanaan_penelitian');
    }
};
