<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('simulasi_angka_kredit', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nama_simulasi');
            $table->date('periode_mulai');
            $table->date('periode_selesai');
            $table->decimal('ak_pendidikan', 8, 2)->default(0);
            $table->decimal('ak_penelitian', 8, 2)->default(0);
            $table->decimal('ak_pengabdian', 8, 2)->default(0);
            $table->decimal('ak_penunjang', 8, 2)->default(0);
            $table->decimal('ak_total', 8, 2)->default(0);
            $table->decimal('ak_dibutuhkan', 8, 2)->default(0);
            $table->string('jabatan_saat_ini')->nullable();
            $table->string('jabatan_target')->nullable();
            $table->boolean('memenuhi_syarat')->default(false);
            $table->text('keterangan')->nullable();
            $table->json('detail_perhitungan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('simulasi_angka_kredit');
    }
};
