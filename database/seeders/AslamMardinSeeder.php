<?php

namespace Database\Seeders;

use App\Models\KategoriKegiatan;
use App\Models\PelaksanaanPendidikan;
use App\Models\PelaksanaanPenelitian;
use App\Models\PelaksanaanPengabdian;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Data percobaan untuk Aslam Mardin (Asisten Ahli → Lektor)
 *
 * Syarat naik ke Lektor (dari AK.md / syaratJabatan):
 *   - AK Total    : minimal 150 (kumulatif sejak CPNS)
 *   - Pendidikan  : minimal 90
 *   - Penelitian  : minimal 25
 *   - Pengabdian  : minimal 10
 *
 * Data yang diseed di sini akan menghasilkan AK yang mendekati / melampaui syarat tersebut
 * agar fitur Simulasi dapat memperlihatkan notifikasi "Memenuhi Syarat".
 */
class AslamMardinSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil user Aslam (sudah ada di DatabaseSeeder)
        $aslam = User::where('email', 'aslam@itbmpolman.ac.id')->first();

        if (!$aslam) {
            $this->command->warn('User Aslam Mardin tidak ditemukan. Pastikan DatabaseSeeder sudah dijalankan.');
            return;
        }

        // Ambil ID kategori dari database
        $katMengajar      = KategoriKegiatan::where('nama_kategori', 'Mengajar Mata Kuliah')->first();
        $katSkripsi       = KategoriKegiatan::where('nama_kategori', 'Membimbing Skripsi')->first();
        $katBahanAjar     = KategoriKegiatan::where('nama_kategori', 'Buku Ajar')->first();
        $katModul         = KategoriKegiatan::where('nama_kategori', 'Modul, diktat, atau petunjuk praktikum')->first();
        $katPenelitian    = KategoriKegiatan::where('nama_kategori', 'Penelitian Mandiri')->first();
        $katJurnalNasAkr  = KategoriKegiatan::where('nama_kategori', 'Jurnal Nasional Terakreditasi')->first();
        $katJurnalNasTdk  = KategoriKegiatan::where('nama_kategori', 'Jurnal Nasional Tidak Terakreditasi')->first();
        $katProsidingNas  = KategoriKegiatan::where('nama_kategori', 'Prosiding Seminar Nasional')->first();
        $katPengabdian    = KategoriKegiatan::where('nama_kategori', 'Kegiatan Pengabdian (Pelatihan/Penyuluhan)')->first();
        $katPembicara     = KategoriKegiatan::where('nama_kategori', 'Pembicara Utama')->first();

        // ================================================================
        // PELAKSANAAN PENDIDIKAN
        // Target: ~90–100 AK
        // ================================================================

        // Pengajaran: Asisten Ahli dengan 12 SKS = 5.5 AK/semester
        // 8 semester × 5.5 = 44 AK
        $pengajaranSemesters = [
            ['semester' => '2021/2022 Gasal', 'sks' => 12, 'mata_kuliah' => 'Pemrograman Web', 'kelas' => 'TI-1A'],
            ['semester' => '2021/2022 Genap', 'sks' => 12, 'mata_kuliah' => 'Basis Data', 'kelas' => 'TI-1B'],
            ['semester' => '2022/2023 Gasal', 'sks' => 12, 'mata_kuliah' => 'Pemrograman Web Lanjut', 'kelas' => 'TI-2A'],
            ['semester' => '2022/2023 Genap', 'sks' => 12, 'mata_kuliah' => 'Rekayasa Perangkat Lunak', 'kelas' => 'TI-2B'],
            ['semester' => '2023/2024 Gasal', 'sks' => 12, 'mata_kuliah' => 'Sistem Informasi', 'kelas' => 'TI-3A'],
            ['semester' => '2023/2024 Genap', 'sks' => 12, 'mata_kuliah' => 'Keamanan Jaringan', 'kelas' => 'TI-3B'],
            ['semester' => '2024/2025 Gasal', 'sks' => 12, 'mata_kuliah' => 'Pengembangan Aplikasi Mobile', 'kelas' => 'TI-4A'],
            ['semester' => '2024/2025 Genap', 'sks' => 12, 'mata_kuliah' => 'Proyek Akhir (Pembimbing)', 'kelas' => 'TI-4B'],
        ];

        foreach ($pengajaranSemesters as $p) {
            PelaksanaanPendidikan::create([
                'user_id'          => $aslam->id,
                'jenis_kegiatan'   => 'pengajaran',
                'mata_kuliah'      => $p['mata_kuliah'],
                'jenis_mata_kuliah'=> 'Wajib',
                'bidang_keilmuan'  => 'Teknik Informatika',
                'kelas'            => $p['kelas'],
                'jumlah_mahasiswa' => rand(25, 35),
                'sks'              => $p['sks'],
                'semester'         => $p['semester'],
                'link_dokumen'     => 'https://drive.google.com/sample-pengajaran',
                'status'           => 'Disetujui',
                'angka_kredit'     => 5.50, // (5.5/12)*12 = 5.5
                'tahun_pelaksanaan'=> (int) substr($p['semester'], 0, 4),
            ]);
        }

        // Bimbingan Skripsi: 12 mahasiswa × 1 AK = 12 AK
        for ($i = 1; $i <= 12; $i++) {
            PelaksanaanPendidikan::create([
                'user_id'            => $aslam->id,
                'jenis_kegiatan'     => 'bimbingan',
                'kategori_kegiatan_id' => $katSkripsi?->id,
                'judul_bimbingan'    => "Pengembangan Sistem Informasi #{$i}",
                'jenis_bimbingan'    => 'Skripsi',
                'program_studi'      => 'Teknik Informatika',
                'semester'           => ($i <= 6) ? '2022/2023 Genap' : '2023/2024 Genap',
                'bidang_keilmuan'    => 'Rekayasa Perangkat Lunak',
                'link_dokumen'       => 'https://drive.google.com/sample-bimbingan',
                'status'             => 'Disetujui',
                'angka_kredit'       => 1.00,
                'tahun_pelaksanaan'  => ($i <= 6) ? 2023 : 2024,
            ]);
        }

        // Buku Ajar: 1 buku = 20 AK
        PelaksanaanPendidikan::create([
            'user_id'             => $aslam->id,
            'jenis_kegiatan'      => 'bahan_ajar',
            'kategori_kegiatan_id'=> $katBahanAjar?->id,
            'judul_bahan_ajar'    => 'Pemrograman Web Modern dengan Laravel',
            'isbn'                => '978-602-1234-00-1',
            'tanggal_terbit'      => '2023-03-01',
            'penerbit'            => 'Penerbit ITBM',
            'status_penulis'      => 'penulis_utama',
            'jumlah_anggota'      => 1,
            'link_dokumen'        => 'https://drive.google.com/sample-bukuajar',
            'status'              => 'Disetujui',
            'angka_kredit'        => 20.00,
            'tahun_pelaksanaan'   => 2023,
        ]);

        // Modul/Diktat: 2 modul × 5 AK = 10 AK
        $moduls = ['Modul Praktikum Basis Data', 'Modul Pemrograman Berorientasi Objek'];
        foreach ($moduls as $judul) {
            PelaksanaanPendidikan::create([
                'user_id'             => $aslam->id,
                'jenis_kegiatan'      => 'bahan_ajar',
                'kategori_kegiatan_id'=> $katModul?->id,
                'judul_bahan_ajar'    => $judul,
                'isbn'                => '-',
                'tanggal_terbit'      => '2022-09-01',
                'penerbit'            => 'Prodi Teknik Informatika ITBM',
                'status_penulis'      => 'penulis_utama',
                'jumlah_anggota'      => 1,
                'link_dokumen'        => 'https://drive.google.com/sample-modul',
                'status'              => 'Disetujui',
                'angka_kredit'        => 5.00,
                'tahun_pelaksanaan'   => 2022,
            ]);
        }

        // TOTAL PENDIDIKAN: 44 + 12 + 20 + 10 = 86 AK ✓ (mendekati 90)

        // ================================================================
        // PELAKSANAAN PENELITIAN
        // Target: ~30–35 AK
        // ================================================================

        // Penelitian Mandiri: 2 × 10 AK = 20 AK (sebagai Ketua, 100% karena mandiri)
        $penelitianJudul = [
            'Optimasi Algoritma Machine Learning untuk Prediksi Nilai Mahasiswa',
            'Pengembangan Sistem E-Learning Adaptif Berbasis Web',
        ];
        foreach ($penelitianJudul as $judul) {
            PelaksanaanPenelitian::create([
                'user_id'             => $aslam->id,
                'jenis_kegiatan'      => 'penelitian',
                'kategori_kegiatan_id'=> $katPenelitian?->id,
                'judul_kegiatan'      => $judul,
                'afiliasi'            => 'ITBM Polman',
                'tahun_pelaksanaan'   => 2023,
                'lama_kegiatan_tahun' => 1,
                'peran'               => 'ketua',
                'jumlah_anggota'      => 1,
                'link_dokumen'        => 'https://drive.google.com/sample-penelitian',
                'status'              => 'Disetujui',
                'angka_kredit'        => 10.00,
            ]);
        }

        // Jurnal Nasional Terakreditasi: 1 artikel = 25 AK (utama, single author)
        PelaksanaanPenelitian::create([
            'user_id'             => $aslam->id,
            'jenis_kegiatan'      => 'publikasi_karya',
            'kategori_kegiatan_id'=> $katJurnalNasAkr?->id,
            'judul_kegiatan'      => 'Implementasi Framework Laravel untuk Sistem Informasi Akademik',
            'afiliasi'            => 'ITBM Polman',
            'tahun_pelaksanaan'   => 2023,
            'peran'               => 'ketua',
            'peran_penulis'       => 'penulis',
            'jumlah_anggota'      => 1,
            'jenis_publikasi'     => 'Jurnal Nasional Terakreditasi',
            'link_dokumen'        => 'https://drive.google.com/sample-jurnal-nasional',
            'status'              => 'Disetujui',
            'angka_kredit'        => 25.00,
        ]);

        // Jurnal Nasional Tidak Terakreditasi: 1 artikel = 10 AK
        PelaksanaanPenelitian::create([
            'user_id'             => $aslam->id,
            'jenis_kegiatan'      => 'publikasi_karya',
            'kategori_kegiatan_id'=> $katJurnalNasTdk?->id,
            'judul_kegiatan'      => 'Penerapan Metode Agile dalam Pengembangan Perangkat Lunak Skala Kecil',
            'afiliasi'            => 'ITBM Polman',
            'tahun_pelaksanaan'   => 2022,
            'peran'               => 'ketua',
            'peran_penulis'       => 'penulis',
            'jumlah_anggota'      => 1,
            'jenis_publikasi'     => 'Jurnal Nasional Tidak Terakreditasi',
            'link_dokumen'        => 'https://drive.google.com/sample-jurnal-tidak-akreditasi',
            'status'              => 'Disetujui',
            'angka_kredit'        => 10.00,
        ]);

        // Prosiding Seminar Nasional: 1 artikel = 10 AK
        PelaksanaanPenelitian::create([
            'user_id'             => $aslam->id,
            'jenis_kegiatan'      => 'publikasi_karya',
            'kategori_kegiatan_id'=> $katProsidingNas?->id,
            'judul_kegiatan'      => 'Analisis Performa Aplikasi Web Berbasis MVC: Studi Kasus Sistem KRS Online',
            'afiliasi'            => 'ITBM Polman',
            'tahun_pelaksanaan'   => 2022,
            'peran'               => 'ketua',
            'peran_penulis'       => 'penulis',
            'jumlah_anggota'      => 1,
            'jenis_publikasi'     => 'Prosiding Seminar Nasional',
            'link_dokumen'        => 'https://drive.google.com/sample-prosiding',
            'status'              => 'Disetujui',
            'angka_kredit'        => 10.00,
        ]);

        // TOTAL PENELITIAN: 20 + 25 + 10 + 10 = 65 AK ✓ (melampaui syarat 25)

        // ================================================================
        // PELAKSANAAN PENGABDIAN
        // Target: ~15–20 AK
        // ================================================================

        // Kegiatan Pengabdian/Pelatihan: 3 × 5 AK = 15 AK
        $pengabdianKegiatan = [
            ['judul' => 'Pelatihan Pemrograman Web untuk Siswa SMK Polman', 'tahun' => 2022],
            ['judul' => 'Workshop Literasi Digital untuk Umkm di Kabupaten Polewali Mandar', 'tahun' => 2023],
            ['judul' => 'Sosialisasi Keamanan Data Pribadi di Era Digital', 'tahun' => 2024],
        ];

        foreach ($pengabdianKegiatan as $keg) {
            PelaksanaanPengabdian::create([
                'user_id'             => $aslam->id,
                'jenis_kegiatan'      => 'pengabdian',
                'kategori_kegiatan_id'=> $katPengabdian?->id,
                'judul_kegiatan'      => $keg['judul'],
                'afiliasi'            => 'ITBM Polman',
                'tahun_pelaksanaan'   => $keg['tahun'],
                'peran'               => 'ketua',
                'jumlah_anggota'      => 3,
                'link_dokumen'        => 'https://drive.google.com/sample-pengabdian',
                'status'              => 'Disetujui',
                'angka_kredit'        => 5.00,
            ]);
        }

        // Pembicara Utama: 2 × 3 AK = 6 AK
        $pembicaraKegiatan = [
            ['judul' => 'Seminar Nasional Teknologi Informasi 2023 – Implementasi AI di Pendidikan', 'tahun' => 2023],
            ['judul' => 'Workshop Pengembangan Karir Dosen – Digitalisasi Pengajaran', 'tahun' => 2024],
        ];

        foreach ($pembicaraKegiatan as $pb) {
            PelaksanaanPengabdian::create([
                'user_id'             => $aslam->id,
                'jenis_kegiatan'      => 'pembicara',
                'kategori_kegiatan_id'=> $katPembicara?->id,
                'judul_kegiatan'      => $pb['judul'],
                'judul_makalah'       => $pb['judul'],
                'afiliasi'            => 'ITBM Polman',
                'tahun_pelaksanaan'   => $pb['tahun'],
                'peran'               => 'ketua',
                'link_dokumen'        => 'https://drive.google.com/sample-pembicara',
                'status'              => 'Disetujui',
                'angka_kredit'        => 3.00,
            ]);
        }

        // TOTAL PENGABDIAN: 15 + 6 = 21 AK ✓ (melampaui syarat 10)

        // ================================================================
        // UPDATE ANGKA KREDIT KUMULATIF USER
        // ================================================================
        $totalAK = $aslam->totalAngkaKreditDisetujui();
        $aslam->update(['angka_kredit_kumulatif' => $totalAK]);

        $this->command->info("✅ Data Aslam Mardin berhasil di-seed.");
        $this->command->info("   - Pendidikan : ~86 AK (Pengajaran 44 + Bimbingan 12 + Buku Ajar 20 + Modul 10)");
        $this->command->info("   - Penelitian : ~65 AK (Mandiri 20 + Jurnal Nas Akr 25 + Jurnal Tidak Akr 10 + Prosiding 10)");
        $this->command->info("   - Pengabdian : ~21 AK (Pengabdian 15 + Pembicara 6)");
        $this->command->info("   - Total AK   : ~{$totalAK} AK (Syarat Lektor: 150 AK)");
        $this->command->newLine();
        $this->command->info("💡 Jalankan Simulasi dari dashboard untuk melihat proyeksi naik jabatan ke Lektor.");
    }
}
