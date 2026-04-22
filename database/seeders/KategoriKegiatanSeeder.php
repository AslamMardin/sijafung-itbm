<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriKegiatanSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            // ==========================================
            // PELAKSANAAN PENDIDIKAN
            // ==========================================
            
            // 1. Pengajaran
            [
                'menu_utama' => 'Pelaksanaan Pendidikan',
                'submenu' => 'Pengajaran',
                'nama_kategori' => 'Mengajar Mata Kuliah',
                'angka_kredit' => 11.0, // Base value for Lektor+, logic handled in Service
                'satuan' => 'Semester',
                'urutan' => 1,
            ],
            
            // 2. Bimbingan Mahasiswa
            [
                'menu_utama' => 'Pelaksanaan Pendidikan',
                'submenu' => 'Bimbingan Mahasiswa',
                'nama_kategori' => 'Membimbing Skripsi',
                'angka_kredit' => 1.0,
                'satuan' => 'Mahasiswa',
                'urutan' => 2,
            ],
            [
                'menu_utama' => 'Pelaksanaan Pendidikan',
                'submenu' => 'Bimbingan Mahasiswa',
                'nama_kategori' => 'Membimbing Tesis',
                'angka_kredit' => 3.0,
                'satuan' => 'Mahasiswa',
                'urutan' => 3,
            ],
            [
                'menu_utama' => 'Pelaksanaan Pendidikan',
                'submenu' => 'Bimbingan Mahasiswa',
                'nama_kategori' => 'Membimbing Disertasi',
                'angka_kredit' => 8.0,
                'satuan' => 'Mahasiswa',
                'urutan' => 4,
            ],
            
            // 3. Pengujian Mahasiswa
            [
                'menu_utama' => 'Pelaksanaan Pendidikan',
                'submenu' => 'Pengujian Mahasiswa',
                'nama_kategori' => 'Menguji Mahasiswa (Ketua)',
                'angka_kredit' => 1.0,
                'satuan' => 'Kegiatan',
                'urutan' => 5,
            ],
            
            // 4. Bahan Ajar
            [
                'menu_utama' => 'Pelaksanaan Pendidikan',
                'submenu' => 'Bahan Ajar',
                'nama_kategori' => 'Buku Ajar',
                'angka_kredit' => 20.0,
                'satuan' => 'Buku',
                'urutan' => 8,
            ],
            [
                'menu_utama' => 'Pelaksanaan Pendidikan',
                'submenu' => 'Bahan Ajar',
                'nama_kategori' => 'Modul, diktat, atau petunjuk praktikum',
                'angka_kredit' => 5.0,
                'satuan' => 'Modul',
                'urutan' => 9,
            ],
            
            // 5. Pembinaan Mahasiswa
            [
                'menu_utama' => 'Pelaksanaan Pendidikan',
                'submenu' => 'Pembinaan Mahasiswa',
                'nama_kategori' => 'Membina kegiatan mahasiswa',
                'angka_kredit' => 2.0,
                'satuan' => 'Semester',
                'urutan' => 11,
            ],
            
            // 6. Visiting Scientist
            [
                'menu_utama' => 'Pelaksanaan Pendidikan',
                'submenu' => 'Visiting Scientist',
                'nama_kategori' => 'Menjadi dosen tamu (Visiting Scientist)',
                'angka_kredit' => 5.0,
                'satuan' => 'Kegiatan',
                'urutan' => 12,
            ],
            
            // 7. Detasering
            [
                'menu_utama' => 'Pelaksanaan Pendidikan',
                'submenu' => 'Detasering',
                'nama_kategori' => 'Detasering (Penugasan khusus kementerian)',
                'angka_kredit' => 4.0,
                'satuan' => 'Semester',
                'urutan' => 19,
            ],
            
            // 8. Orasi Ilmiah
            [
                'menu_utama' => 'Pelaksanaan Pendidikan',
                'submenu' => 'Orasi Ilmiah',
                'nama_kategori' => 'Orasi ilmiah',
                'angka_kredit' => 5.0,
                'satuan' => 'Kegiatan',
                'urutan' => 23,
            ],
            
            // 9. Pembimbing Dosen
            [
                'menu_utama' => 'Pelaksanaan Pendidikan',
                'submenu' => 'Pembimbing Dosen',
                'nama_kategori' => 'Pembimbing pencangkokan',
                'angka_kredit' => 3.0,
                'satuan' => 'Semester',
                'urutan' => 24,
            ],
            [
                'menu_utama' => 'Pelaksanaan Pendidikan',
                'submenu' => 'Pembimbing Dosen',
                'nama_kategori' => 'Pembimbing Reguler',
                'angka_kredit' => 1.0,
                'satuan' => 'Kegiatan',
                'urutan' => 25,
            ],
            
            // 10. Tugas Tambahan
            [
                'menu_utama' => 'Pelaksanaan Pendidikan',
                'submenu' => 'Tugas Tambahan',
                'nama_kategori' => 'Tugas Tambahan (Rektor/Dekan/Kajur/dll)',
                'angka_kredit' => 10.0, // Variable logic in service
                'satuan' => 'Semester',
                'urutan' => 26,
            ],
            
            // ==========================================
            // PELAKSANAAN PENELITIAN
            // ==========================================
            
            // 1. Penelitian
            [
                'menu_utama' => 'Pelaksanaan Penelitian',
                'submenu' => 'Penelitian',
                'nama_kategori' => 'Penelitian Mandiri',
                'angka_kredit' => 10.0,
                'satuan' => 'Kegiatan',
                'urutan' => 28,
            ],
            
            // 2. Publikasi Karya
            [
                'menu_utama' => 'Pelaksanaan Penelitian',
                'submenu' => 'Publikasi Karya',
                'nama_kategori' => 'Jurnal Internasional Bereputasi',
                'angka_kredit' => 40.0,
                'satuan' => 'Karya',
                'urutan' => 32,
            ],
            [
                'menu_utama' => 'Pelaksanaan Penelitian',
                'submenu' => 'Publikasi Karya',
                'nama_kategori' => 'Jurnal Nasional Terakreditasi',
                'angka_kredit' => 25.0,
                'satuan' => 'Karya',
                'urutan' => 33,
            ],
            [
                'menu_utama' => 'Pelaksanaan Penelitian',
                'submenu' => 'Publikasi Karya',
                'nama_kategori' => 'Jurnal Nasional Tidak Terakreditasi',
                'angka_kredit' => 10.0,
                'satuan' => 'Karya',
                'urutan' => 34,
            ],
            [
                'menu_utama' => 'Pelaksanaan Penelitian',
                'submenu' => 'Publikasi Karya',
                'nama_kategori' => 'Prosiding Seminar Internasional',
                'angka_kredit' => 15.0,
                'satuan' => 'Karya',
                'urutan' => 35,
            ],
            [
                'menu_utama' => 'Pelaksanaan Penelitian',
                'submenu' => 'Publikasi Karya',
                'nama_kategori' => 'Prosiding Seminar Nasional',
                'angka_kredit' => 10.0,
                'satuan' => 'Karya',
                'urutan' => 36,
            ],
            [
                'menu_utama' => 'Pelaksanaan Penelitian',
                'submenu' => 'Publikasi Karya',
                'nama_kategori' => 'Karya Ilmiah Populer',
                'angka_kredit' => 5.0,
                'satuan' => 'Karya',
                'urutan' => 37,
            ],
            
            // 3. Paten/HKI
            [
                'menu_utama' => 'Pelaksanaan Penelitian',
                'submenu' => 'Paten/HKI',
                'nama_kategori' => 'Paten Internasional',
                'angka_kredit' => 60.0,
                'satuan' => 'Paten',
                'urutan' => 38,
            ],
            [
                'menu_utama' => 'Pelaksanaan Penelitian',
                'submenu' => 'Paten/HKI',
                'nama_kategori' => 'Paten Nasional',
                'angka_kredit' => 40.0,
                'satuan' => 'Paten',
                'urutan' => 39,
            ],
            [
                'menu_utama' => 'Pelaksanaan Penelitian',
                'submenu' => 'Paten/HKI',
                'nama_kategori' => 'Hak Cipta atau Desain Industri',
                'angka_kredit' => 20.0,
                'satuan' => 'Karya',
                'urutan' => 40,
            ],
            [
                'menu_utama' => 'Pelaksanaan Penelitian',
                'submenu' => 'Paten/HKI',
                'nama_kategori' => 'HKI Sederhana',
                'angka_kredit' => 15.0,
                'satuan' => 'Karya',
                'urutan' => 41,
            ],
            
            // ==========================================
            // PELAKSANAAN PENGABDIAN
            // ==========================================
            
            // 1. Pengabdian
            [
                'menu_utama' => 'Pelaksanaan Pengabdian',
                'submenu' => 'Pengabdian',
                'nama_kategori' => 'Kegiatan Pengabdian (Pelatihan/Penyuluhan)',
                'angka_kredit' => 5.0,
                'satuan' => 'Kegiatan',
                'urutan' => 42,
            ],
            
            // 2. Pembicara
            [
                'menu_utama' => 'Pelaksanaan Pengabdian',
                'submenu' => 'Pembicara',
                'nama_kategori' => 'Pembicara Utama',
                'angka_kredit' => 3.0,
                'satuan' => 'Kegiatan',
                'urutan' => 43,
            ],
            [
                'menu_utama' => 'Pelaksanaan Pengabdian',
                'submenu' => 'Pembicara',
                'nama_kategori' => 'Pembicara Pendamping/Moderator',
                'angka_kredit' => 2.0,
                'satuan' => 'Kegiatan',
                'urutan' => 44,
            ],
            
            // 3. Pengelola Jurnal
            [
                'menu_utama' => 'Pelaksanaan Pengabdian',
                'submenu' => 'Pengelola Jurnal',
                'nama_kategori' => 'Editor Utama',
                'angka_kredit' => 10.0,
                'satuan' => 'Tahun',
                'urutan' => 45,
            ],
            [
                'menu_utama' => 'Pelaksanaan Pengabdian',
                'submenu' => 'Pengelola Jurnal',
                'nama_kategori' => 'Reviewer atau Anggota Editor',
                'angka_kredit' => 5.0,
                'satuan' => 'Tahun',
                'urutan' => 46,
            ],
            
            // 4. Jabatan Struktural di Luar Pendidikan
            [
                'menu_utama' => 'Pelaksanaan Pengabdian',
                'submenu' => 'Jabatan Struktural',
                'nama_kategori' => 'Ketua Organisasi Nasional',
                'angka_kredit' => 10.0,
                'satuan' => 'Tahun',
                'urutan' => 47,
            ],
            [
                'menu_utama' => 'Pelaksanaan Pengabdian',
                'submenu' => 'Jabatan Struktural',
                'nama_kategori' => 'Pengurus Daerah',
                'angka_kredit' => 5.0,
                'satuan' => 'Tahun',
                'urutan' => 48,
            ],
            [
                'menu_utama' => 'Pelaksanaan Pengabdian',
                'submenu' => 'Jabatan Struktural',
                'nama_kategori' => 'Anggota Aktif',
                'angka_kredit' => 2.0,
                'satuan' => 'Tahun',
                'urutan' => 49,
            ],
        ];

        foreach ($categories as $category) {
            $category['is_active'] = true;
            $category['created_at'] = now();
            $category['updated_at'] = now();
            DB::table('kategori_kegiatan')->insert($category);
        }
    }
}
