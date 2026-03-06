<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['admin', 'dosen'])->default('dosen');
            $table->string('nip')->nullable()->unique();
            $table->string('nidn')->nullable()->unique();
            $table->string('prodi')->nullable();
            $table->string('fakultas')->nullable();
            $table->enum('jabatan_fungsional', [
                'Asisten Ahli',
                'Lektor',
                'Lektor Kepala',
                'Profesor'
            ])->nullable();
            $table->string('pangkat_golongan')->nullable();
            $table->decimal('angka_kredit_kumulatif', 8, 2)->default(0);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
