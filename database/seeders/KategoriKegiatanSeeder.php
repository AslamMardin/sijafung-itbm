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
                'angka_kredit' => 0.125, // per SKS per semester
                'satuan' => 'SKS',
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
                'angka_kredit' => 2.0,
                'satuan' => 'Mahasiswa',
                'urutan' => 3,
            ],
            [
                'menu_utama' => 'Pelaksanaan Pendidikan',
                'submenu' => 'Bimbingan Mahasiswa',
                'nama_kategori' => 'Membimbing Disertasi',
                'angka_kredit' => 3.0,
                'satuan' => 'Mahasiswa',
                'urutan' => 4,
            ],
            
            // 3. Pengujian Mahasiswa
            [
                'menu_utama' => 'Pelaksanaan Pendidikan',
                'submenu' => 'Pengujian Mahasiswa',
                'nama_kategori' => 'Menguji Skripsi',
                'angka_kredit' => 0.5,
                'satuan' => 'Kegiatan',
                'urutan' => 5,
            ],
            [
                'menu_utama' => 'Pelaksanaan Pendidikan',
                'submenu' => 'Pengujian Mahasiswa',
                'nama_kategori' => 'Menguji Tesis',
                'angka_kredit' => 1.0,
                'satuan' => 'Kegiatan',
                'urutan' => 6,
            ],
            [
                'menu_utama' => 'Pelaksanaan Pendidikan',
                'submenu' => 'Pengujian Mahasiswa',
                'nama_kategori' => 'Menguji Disertasi',
                'angka_kredit' => 2.0,
                'satuan' => 'Kegiatan',
                'urutan' => 7,
            ],
            
            // 4. Bahan Ajar
            [
                'menu_utama' => 'Pelaksanaan Pendidikan',
                'submenu' => 'Bahan Ajar',
                'nama_kategori' => 'Buku Ajar (cetak atau elektronik)',
                'angka_kredit' => 6.0,
                'satuan' => 'Buku',
                'urutan' => 8,
            ],
            [
                'menu_utama' => 'Pelaksanaan Pendidikan',
                'submenu' => 'Bahan Ajar',
                'nama_kategori' => 'Mengembangkan bahan pengajaran/modul',
                'angka_kredit' => 1.5,
                'satuan' => 'Modul',
                'urutan' => 9,
            ],
            [
                'menu_utama' => 'Pelaksanaan Pendidikan',
                'submenu' => 'Bahan Ajar',
                'nama_kategori' => 'Buku referensi ber-ISBN',
                'angka_kredit' => 4.0,
                'satuan' => 'Buku',
                'urutan' => 10,
            ],
            
            // 5. Pembinaan Mahasiswa
            [
                'menu_utama' => 'Pelaksanaan Pendidikan',
                'submenu' => 'Pembinaan Mahasiswa',
                'nama_kategori' => 'Membina kegiatan mahasiswa',
                'angka_kredit' => 0.5,
                'satuan' => 'Kegiatan',
                'urutan' => 11,
            ],
            
            // 6. Visiting Scientist
            [
                'menu_utama' => 'Pelaksanaan Pendidikan',
                'submenu' => 'Visiting Scientist',
                'nama_kategori' => 'Visiting Scientist (>960 jam)',
                'angka_kredit' => 7.0,
                'satuan' => 'Kegiatan',
                'urutan' => 12,
            ],
            [
                'menu_utama' => 'Pelaksanaan Pendidikan',
                'submenu' => 'Visiting Scientist',
                'nama_kategori' => 'Visiting Scientist (641-960 jam)',
                'angka_kredit' => 6.5,
                'satuan' => 'Kegiatan',
                'urutan' => 13,
            ],
            [
                'menu_utama' => 'Pelaksanaan Pendidikan',
                'submenu' => 'Visiting Scientist',
                'nama_kategori' => 'Visiting Scientist (481-640 jam)',
                'angka_kredit' => 6.0,
                'satuan' => 'Kegiatan',
                'urutan' => 14,
            ],
            [
                'menu_utama' => 'Pelaksanaan Pendidikan',
                'submenu' => 'Visiting Scientist',
                'nama_kategori' => 'Visiting Scientist (161-480 jam)',
                'angka_kredit' => 5.0,
                'satuan' => 'Kegiatan',
                'urutan' => 15,
            ],
            [
                'menu_utama' => 'Pelaksanaan Pendidikan',
                'submenu' => 'Visiting Scientist',
                'nama_kategori' => 'Visiting Scientist (81-160 jam)',
                'angka_kredit' => 3.0,
                'satuan' => 'Kegiatan',
                'urutan' => 16,
            ],
            [
                'menu_utama' => 'Pelaksanaan Pendidikan',
                'submenu' => 'Visiting Scientist',
                'nama_kategori' => 'Visiting Scientist (31-80 jam)',
                'angka_kredit' => 1.5,
                'satuan' => 'Kegiatan',
                'urutan' => 17,
            ],
            [
                'menu_utama' => 'Pelaksanaan Pendidikan',
                'submenu' => 'Visiting Scientist',
                'nama_kategori' => 'Visiting Scientist (10-30 jam)',
                'angka_kredit' => 0.5,
                'satuan' => 'Kegiatan',
                'urutan' => 18,
            ],
            
            // 7. Detasering
            [
                'menu_utama' => 'Pelaksanaan Pendidikan',
                'submenu' => 'Detasering',
                'nama_kategori' => 'Detasering Dosen berkegiatan pada institusi QS 100',
                'angka_kredit' => 7.0,
                'satuan' => 'Tahun',
                'urutan' => 19,
            ],
            [
                'menu_utama' => 'Pelaksanaan Pendidikan',
                'submenu' => 'Detasering',
                'nama_kategori' => 'Detasering Dosen berkegiatan pada institusi nasional',
                'angka_kredit' => 6.0,
                'satuan' => 'Tahun',
                'urutan' => 20,
            ],
            [
                'menu_utama' => 'Pelaksanaan Pendidikan',
                'submenu' => 'Detasering',
                'nama_kategori' => 'Pencangkokan Dosen berkegiatan pada institusi QS 100',
                'angka_kredit' => 7.0,
                'satuan' => 'Tahun',
                'urutan' => 21,
            ],
            [
                'menu_utama' => 'Pelaksanaan Pendidikan',
                'submenu' => 'Detasering',
                'nama_kategori' => 'Pencangkokan Dosen berkegiatan pada institusi nasional',
                'angka_kredit' => 6.0,
                'satuan' => 'Tahun',
                'urutan' => 22,
            ],
            
            // 8. Orasi Ilmiah
            [
                'menu_utama' => 'Pelaksanaan Pendidikan',
                'submenu' => 'Orasi Ilmiah',
                'nama_kategori' => 'Orasi ilmiah pada perguruan tinggi',
                'angka_kredit' => 3.0,
                'satuan' => 'Kegiatan',
                'urutan' => 23,
            ],
            
            // 9. Pembimbing Dosen
            [
                'menu_utama' => 'Pelaksanaan Pendidikan',
                'submenu' => 'Pembimbing Dosen',
                'nama_kategori' => 'Pembimbing pencangkokan',
                'angka_kredit' => 2.0,
                'satuan' => 'Dosen',
                'urutan' => 24,
            ],
            [
                'menu_utama' => 'Pelaksanaan Pendidikan',
                'submenu' => 'Pembimbing Dosen',
                'nama_kategori' => 'Pembimbing Reguler',
                'angka_kredit' => 1.5,
                'satuan' => 'Dosen',
                'urutan' => 25,
            ],
            
            // 10. Tugas Tambahan
            [
                'menu_utama' => 'Pelaksanaan Pendidikan',
                'submenu' => 'Tugas Tambahan',
                'nama_kategori' => 'Ketua Program Studi',
                'angka_kredit' => 4.0,
                'satuan' => 'Tahun',
                'urutan' => 26,
            ],
            [
                'menu_utama' => 'Pelaksanaan Pendidikan',
                'submenu' => 'Tugas Tambahan',
                'nama_kategori' => 'Sekretaris Program Studi',
                'angka_kredit' => 3.0,
                'satuan' => 'Tahun',
                'urutan' => 27,
            ],
            
            // ==========================================
            // PELAKSANAAN PENELITIAN
            // ==========================================
            
            // 1. Penelitian
            [
                'menu_utama' => 'Pelaksanaan Penelitian',
                'submenu' => 'Penelitian',
                'nama_kategori' => 'Penelitian Nasional (Ketua)',
                'angka_kredit' => 10.0,
                'satuan' => 'Kegiatan',
                'urutan' => 28,
            ],
            [
                'menu_utama' => 'Pelaksanaan Penelitian',
                'submenu' => 'Penelitian',
                'nama_kategori' => 'Penelitian Nasional (Anggota)',
                'angka_kredit' => 5.0,
                'satuan' => 'Kegiatan',
                'urutan' => 29,
            ],
            [
                'menu_utama' => 'Pelaksanaan Penelitian',
                'submenu' => 'Penelitian',
                'nama_kategori' => 'Penelitian Internasional (Ketua)',
                'angka_kredit' => 20.0,
                'satuan' => 'Kegiatan',
                'urutan' => 30,
            ],
            [
                'menu_utama' => 'Pelaksanaan Penelitian',
                'submenu' => 'Penelitian',
                'nama_kategori' => 'Penelitian Internasional (Anggota)',
                'angka_kredit' => 10.0,
                'satuan' => 'Kegiatan',
                'urutan' => 31,
            ],
            
            // 2. Publikasi Karya
            [
                'menu_utama' => 'Pelaksanaan Penelitian',
                'submenu' => 'Publikasi Karya',
                'nama_kategori' => 'Jurnal Nasional Terakreditasi',
                'angka_kredit' => 10.0,
                'satuan' => 'Karya',
                'urutan' => 32,
            ],
            [
                'menu_utama' => 'Pelaksanaan Penelitian',
                'submenu' => 'Publikasi Karya',
                'nama_kategori' => 'Jurnal Internasional',
                'angka_kredit' => 20.0,
                'satuan' => 'Karya',
                'urutan' => 33,
            ],
            [
                'menu_utama' => 'Pelaksanaan Penelitian',
                'submenu' => 'Publikasi Karya',
                'nama_kategori' => 'Jurnal Internasional Bereputasi',
                'angka_kredit' => 40.0,
                'satuan' => 'Karya',
                'urutan' => 34,
            ],
            [
                'menu_utama' => 'Pelaksanaan Penelitian',
                'submenu' => 'Publikasi Karya',
                'nama_kategori' => 'Prosiding Seminar Nasional',
                'angka_kredit' => 5.0,
                'satuan' => 'Karya',
                'urutan' => 35,
            ],
            [
                'menu_utama' => 'Pelaksanaan Penelitian',
                'submenu' => 'Publikasi Karya',
                'nama_kategori' => 'Prosiding Seminar Internasional',
                'angka_kredit' => 10.0,
                'satuan' => 'Karya',
                'urutan' => 36,
            ],
            [
                'menu_utama' => 'Pelaksanaan Penelitian',
                'submenu' => 'Publikasi Karya',
                'nama_kategori' => 'Buku Referensi Ber-ISBN',
                'angka_kredit' => 8.0,
                'satuan' => 'Buku',
                'urutan' => 37,
            ],
            
            // 3. Paten/HKI
            [
                'menu_utama' => 'Pelaksanaan Penelitian',
                'submenu' => 'Paten/HKI',
                'nama_kategori' => 'Paten',
                'angka_kredit' => 15.0,
                'satuan' => 'Paten',
                'urutan' => 38,
            ],
            [
                'menu_utama' => 'Pelaksanaan Penelitian',
                'submenu' => 'Paten/HKI',
                'nama_kategori' => 'Hak Cipta',
                'angka_kredit' => 5.0,
                'satuan' => 'Karya',
                'urutan' => 39,
            ],
            
            // ==========================================
            // PELAKSANAAN PENGABDIAN
            // ==========================================
            
            // 1. Pengabdian
            [
                'menu_utama' => 'Pelaksanaan Pengabdian',
                'submenu' => 'Pengabdian',
                'nama_kategori' => 'Pengabdian Nasional (Ketua)',
                'angka_kredit' => 7.0,
                'satuan' => 'Kegiatan',
                'urutan' => 40,
            ],
            [
                'menu_utama' => 'Pelaksanaan Pengabdian',
                'submenu' => 'Pengabdian',
                'nama_kategori' => 'Pengabdian Nasional (Anggota)',
                'angka_kredit' => 3.5,
                'satuan' => 'Kegiatan',
                'urutan' => 41,
            ],
            [
                'menu_utama' => 'Pelaksanaan Pengabdian',
                'submenu' => 'Pengabdian',
                'nama_kategori' => 'Pengabdian Internasional (Ketua)',
                'angka_kredit' => 14.0,
                'satuan' => 'Kegiatan',
                'urutan' => 42,
            ],
            [
                'menu_utama' => 'Pelaksanaan Pengabdian',
                'submenu' => 'Pengabdian',
                'nama_kategori' => 'Pengabdian Internasional (Anggota)',
                'angka_kredit' => 7.0,
                'satuan' => 'Kegiatan',
                'urutan' => 43,
            ],
            
            // 2. Pembicara
            [
                'menu_utama' => 'Pelaksanaan Pengabdian',
                'submenu' => 'Pembicara',
                'nama_kategori' => 'Pembicara Seminar Internasional',
                'angka_kredit' => 10.0,
                'satuan' => 'Kegiatan',
                'urutan' => 44,
            ],
            [
                'menu_utama' => 'Pelaksanaan Pengabdian',
                'submenu' => 'Pembicara',
                'nama_kategori' => 'Pembicara Seminar Nasional',
                'angka_kredit' => 5.0,
                'satuan' => 'Kegiatan',
                'urutan' => 45,
            ],
            [
                'menu_utama' => 'Pelaksanaan Pengabdian',
                'submenu' => 'Pembicara',
                'nama_kategori' => 'Pembicara Seminar Lokal',
                'angka_kredit' => 2.0,
                'satuan' => 'Kegiatan',
                'urutan' => 46,
            ],
            
            // 3. Pengelola Jurnal
            [
                'menu_utama' => 'Pelaksanaan Pengabdian',
                'submenu' => 'Pengelola Jurnal',
                'nama_kategori' => 'Editor/Dewan Penyunting Jurnal Internasional',
                'angka_kredit' => 6.0,
                'satuan' => 'Tahun',
                'urutan' => 47,
            ],
            [
                'menu_utama' => 'Pelaksanaan Pengabdian',
                'submenu' => 'Pengelola Jurnal',
                'nama_kategori' => 'Editor/Dewan Penyunting Jurnal Nasional',
                'angka_kredit' => 4.0,
                'satuan' => 'Tahun',
                'urutan' => 48,
            ],
            
            // 4. Jabatan Struktural
            [
                'menu_utama' => 'Pelaksanaan Pengabdian',
                'submenu' => 'Jabatan Struktural',
                'nama_kategori' => 'Ketua Lembaga Peneltian',
                'angka_kredit' => 6.0,
                'satuan' => 'Tahun',
                'urutan' => 49,
            ],
            [
                'menu_utama' => 'Pelaksanaan Pengabdian',
                'submenu' => 'Jabatan Struktural',
                'nama_kategori' => 'Sekretaris Lembaga',
                'angka_kredit' => 4.0,
                'satuan' => 'Tahun',
                'urutan' => 50,
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
