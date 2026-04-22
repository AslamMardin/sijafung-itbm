<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tambah kolom period/semester ke tabel users
        Schema::table('users', function (Blueprint $table) {
            $table->string('periode_aktif')->nullable()->after('angka_kredit_kumulatif');
            $table->string('sister_id')->nullable()->after('periode_aktif')->comment('ID referensi dari SISTER');
        });

        // Tambah tabel simulasi_angka_kredit baru jika belum ada
        if (!Schema::hasTable('simulasi_angka_kredit_new')) {
            Schema::create('simulasi_angka_kredit_new', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->string('nama_simulasi');
                $table->string('periode'); // Contoh: 2024/2025 Genap
                $table->date('tanggal_simulasi');
                
                // Breakdown AK per kategori
                $table->decimal('ak_pendidikan', 8, 2)->default(0);
                $table->decimal('ak_penelitian', 8, 2)->default(0);
                $table->decimal('ak_pengabdian', 8, 2)->default(0);
                $table->decimal('ak_penunjang', 8, 2)->default(0);
                $table->decimal('ak_total', 8, 2)->default(0);
                
                // Kebutuhan kenaikan jabatan
                $table->decimal('ak_dibutuhkan', 8, 2)->default(0);
                $table->decimal('ak_sisa', 8, 2)->default(0);
                $table->string('jabatan_saat_ini')->nullable();
                $table->string('jabatan_target')->nullable();
                $table->boolean('memenuhi_syarat')->default(false);
                
                // Detail
                $table->text('keterangan')->nullable();
                $table->json('detail_perhitungan')->nullable();
                
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['periode_aktif', 'sister_id']);
        });
        
        Schema::dropIfExists('simulasi_angka_kredit_new');
    }
};
