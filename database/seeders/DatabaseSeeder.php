<?php

namespace Database\Seeders;

use App\Models\KegiatanTriDharma;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
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
        ]);

        // // Kegiatan Dosen 1
        // $kegiatan1 = [
        //     ['kategori' => 'Pendidikan', 'sub_kategori' => 'Mengajar/Membimbing mahasiswa S1', 'nama_kegiatan' => 'Mengajar Pemrograman Web', 'tanggal_mulai' => '2024-02-01', 'tanggal_selesai' => '2024-06-30', 'angka_kredit' => 4.5, 'status' => 'Disetujui'],
        //     ['kategori' => 'Pendidikan', 'sub_kategori' => 'Membimbing Tugas Akhir/Skripsi', 'nama_kegiatan' => 'Bimbingan Skripsi Mahasiswa', 'tanggal_mulai' => '2024-01-15', 'tanggal_selesai' => '2024-05-31', 'angka_kredit' => 3.0, 'status' => 'Disetujui'],
        //     ['kategori' => 'Penelitian', 'sub_kategori' => 'Menghasilkan karya ilmiah (Jurnal Nasional)', 'nama_kegiatan' => 'Jurnal: Implementasi Machine Learning untuk Klasifikasi Data', 'tanggal_mulai' => '2024-03-01', 'tanggal_selesai' => '2024-03-31', 'institusi_penyelenggara' => 'Jurnal IPTEK', 'angka_kredit' => 10.0, 'status' => 'Disetujui'],
        //     ['kategori' => 'Penelitian', 'sub_kategori' => 'Menyajikan makalah (Seminar Nasional)', 'nama_kegiatan' => 'Seminar Nasional Informatika 2024', 'tanggal_mulai' => '2024-04-20', 'tanggal_selesai' => '2024-04-20', 'institusi_penyelenggara' => 'Universitas Gadjah Mada', 'tingkat' => 'Nasional', 'angka_kredit' => 5.0, 'status' => 'Disetujui'],
        //     ['kategori' => 'Pengabdian Masyarakat', 'sub_kategori' => 'Memberikan latihan/penyuluhan/penataran', 'nama_kegiatan' => 'Pelatihan Coding untuk Pelajar SMA', 'tanggal_mulai' => '2024-05-10', 'tanggal_selesai' => '2024-05-12', 'institusi_penyelenggara' => 'SMA Negeri 1 Kota', 'angka_kredit' => 2.0, 'status' => 'Disetujui'],
        //     ['kategori' => 'Penelitian', 'sub_kategori' => 'Menghasilkan karya ilmiah (Jurnal Internasional)', 'nama_kegiatan' => 'Deep Learning for Image Recognition in Healthcare', 'tanggal_mulai' => '2024-06-01', 'tanggal_selesai' => '2024-06-30', 'institusi_penyelenggara' => 'IEEE Access', 'tingkat' => 'Internasional', 'angka_kredit' => 20.0, 'status' => 'Pending'],
        // ];

        // foreach ($kegiatan1 as $k) {
        //     KegiatanTriDharma::create(array_merge($k, ['user_id' => $dosen1->id]));
        // }

    }
}
