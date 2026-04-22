<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pelaksanaan_pengabdian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Kategori
            $table->string('jenis_kegiatan'); // pengabdian, pembicara, pengelola_jurnal, jabatan_struktural
            $table->string('kategori_kegiatan_id')->nullable();
            $table->string('sub_kategori')->nullable();
            
            // Fields untuk Pengabdian
            $table->string('judul_kegiatan')->nullable();
            $table->string('afiliasi')->nullable();
            $table->integer('tahun_pelaksanaan')->nullable();
            $table->integer('lama_kegiatan_tahun')->nullable();
            $table->enum('peran', ['ketua', 'anggota'])->nullable();
            $table->integer('jumlah_anggota')->nullable();
            
            // Fields untuk Pembicara
            $table->string('kategori_capaian_luaran')->nullable();
            $table->string('kategori_pembicara')->nullable(); // Terjadwal/Insidental x Internasional/Nasional/Lokal
            $table->string('judul_makalah')->nullable();
            $table->string('nama_temu_ilmiah')->nullable();
            $table->string('penyelenggara')->nullable();
            $table->date('tanggal_pelaksanaan')->nullable();
            
            // Fields untuk Pengelola Jurnal
            $table->string('nama_jurnal')->nullable();
            $table->string('no_sk_penugasan')->nullable();
            $table->date('terhitung_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->boolean('status_aktif')->default(true);
            $table->string('peran_jurnal')->nullable(); // Editor, Dewan Penyunting, Dewan Redaksi
            
            // Fields untuk Jabatan Struktural
            $table->string('jabatan_struktural')->nullable();
            $table->string('nomor_sk')->nullable();
            $table->date('terhitung')->nullable();
            $table->date('tanggal_mulai')->nullable();
            $table->date('terhitung_tanggal_selesai')->nullable();
            
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
        Schema::dropIfExists('pelaksanaan_pengabdian');
    }
};
