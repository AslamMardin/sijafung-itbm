<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Jalankan seeder kategori kegiatan
        $this->call([
            KategoriKegiatanSeeder::class,
        ]);

        // ── Admin ──────────────────────────────────────────────
        $admin = User::create([
            'name'     => 'Administrator SIJAFUNG',
            'email'    => 'admin@itbmpolman.ac.id',
            'password' => Hash::make('admin'),
            'role'     => 'admin',
            'nip'      => '198001012010011001',
        ]);

        // ── Dosen 1 ────────────────────────────────────────────
        $dosen1 = User::create([
            'name'                  => 'Aslam Mardin, S.Kom., M.Kom., Gr.',
            'email'                 => 'aslam@itbmpolman.ac.id',
            'password'              => Hash::make('123456'),
            'role'                  => 'dosen',
            'nip'                   => '198503152010011002',
            'nidn'                  => '0015038501',
            'prodi'                 => 'Teknik Informatika',
            'fakultas'              => 'Fakultas Teknik',
            'jabatan_fungsional'    => 'Asisten Ahli',
            'pangkat_golongan'      => 'Penata / III-c',
            'angka_kredit_kumulatif'=> 0,
            'periode_aktif'         => '2024/2025 Genap',
        ]);

        // ── Dosen 2 (Sample) ───────────────────────────────────
        $dosen2 = User::create([
            'name'                  => 'Dr. Budi Santoso, M.T.',
            'email'                 => 'budi@itbmpolman.ac.id',
            'password'              => Hash::make('123456'),
            'role'                  => 'dosen',
            'nip'                   => '197805102005011003',
            'nidn'                  => '0010057802',
            'prodi'                 => 'Sistem Informasi',
            'fakultas'              => 'Fakultas Teknik',
            'jabatan_fungsional'    => 'Lektor',
            'pangkat_golongan'      => 'Penata Tk.I / III-d',
            'angka_kredit_kumulatif'=> 0,
            'periode_aktif'         => '2024/2025 Genap',
        ]);
    }
}
