<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pelaksanaan_pendidikan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Kategori
            $table->string('jenis_kegiatan'); // pengajaran, bimbingan, pengujian, bahan_ajar, pembinaan, visiting_scientist, detasering, orasi_ilmiah, pembimbing_dosen, tugas_tambahan
            $table->string('kategori_kegiatan_id')->nullable(); // relasi ke kategori_kegiatan
            $table->string('sub_kategori')->nullable(); // Sub kategori tambahan
            
            // Fields untuk Pengajaran
            $table->string('mata_kuliah')->nullable();
            $table->string('jenis_mata_kuliah')->nullable(); // Wajib, Pilihan, dll
            $table->string('bidang_keilmuan')->nullable();
            $table->string('kelas')->nullable();
            $table->integer('jumlah_mahasiswa')->nullable();
            $table->integer('sks')->nullable();
            
            // Fields untuk Bimbingan/Pengujian/Pembinaan
            $table->string('semester')->nullable();
            $table->string('judul_bimbingan')->nullable();
            $table->string('jenis_bimbingan')->nullable(); // Skripsi, Tesis, Disertasi, PKL, PPL, dll
            $table->string('program_studi')->nullable();
            $table->string('judul_pengujian')->nullable();
            $table->string('jenis_pengujian')->nullable();
            
            // Fields untuk Bahan Ajar
            $table->string('judul_bahan_ajar')->nullable();
            $table->string('isbn')->nullable();
            $table->date('tanggal_terbit')->nullable();
            $table->string('penerbit')->nullable();
            $table->string('status_penulis')->nullable(); // Penulis Utama, Penulis Pendamping, dll
            $table->integer('jumlah_anggota')->nullable();
            
            // Fields untuk Visiting Scientist
            $table->string('perguruan_tinggi_pengundang')->nullable();
            $table->integer('lama_kegiatan_hari')->nullable();
            $table->string('kategori_jam')->nullable(); // >960 jam, 641-960 jam, dll
            
            // Fields untuk Detasering
            $table->string('perguruan_tinggi_sasaran')->nullable();
            $table->text('deskripsi_kegiatan')->nullable();
            $table->string('metode_pelaksanaan')->nullable();
            $table->string('nomor_sk_penugasan')->nullable();
            $table->date('tanggal_sk_penugasan')->nullable();
            
            // Fields untuk Orasi Ilmiah
            $table->string('kategori_pembicara')->nullable();
            $table->string('judul_makalah')->nullable();
            $table->string('nama_pertemuan_ilmiah')->nullable();
            $table->string('penyelenggara')->nullable();
            
            // Fields untuk Pembimbing Dosen
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->string('bidang_ahli_pembimbing')->nullable();
            $table->string('jabatan_fungsional_pembimbing')->nullable();
            $table->string('dosen_bimbingan')->nullable();
            $table->string('jabatan_fungsional_bimbingan')->nullable();
            $table->string('no_sk_tugas')->nullable();
            $table->date('tanggal_sk_tugas')->nullable();
            
            // Fields untuk Tugas Tambahan
            $table->string('tugas_tambahan')->nullable();
            $table->string('unit_kerja')->nullable();
            $table->string('instansi')->nullable();
            
            // Fields umum
            $table->string('tingkat')->nullable(); // Internasional, Nasional, Lokal
            $table->enum('peran', ['ketua', 'anggota', 'pembimbing', 'penguji', 'penulis_utama', 'anggota_kelompok'])->nullable();
            $table->string('afiliasi')->nullable();
            $table->integer('tahun_pelaksanaan')->nullable();
            $table->integer('lama_kegiatan_tahun')->nullable();
            
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
        Schema::dropIfExists('pelaksanaan_pendidikan');
    }
};
