<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KegiatanTriDharma extends Model
{
    use HasFactory;

    protected $table = 'kegiatan_tri_dharma';

    protected $fillable = [
        'user_id', 'kategori', 'sub_kategori', 'nama_kegiatan',
        'deskripsi', 'tanggal_mulai', 'tanggal_selesai',
        'institusi_penyelenggara', 'tingkat', 'peran',
        'angka_kredit', 'bukti_dokumen', 'status', 'catatan_admin',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'angka_kredit' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Sub-kategori berdasarkan kategori Tri Dharma
    public static function subKategoriOptions(): array
    {
        return [
            'Pendidikan' => [
                'Mengajar/Membimbing mahasiswa S1',
                'Mengajar/Membimbing mahasiswa S2',
                'Mengajar/Membimbing mahasiswa S3',
                'Membimbing KKN/PKL/PPL',
                'Membimbing Tugas Akhir/Skripsi',
                'Membimbing Tesis',
                'Membimbing Disertasi',
                'Menguji pada ujian akhir',
                'Membina kegiatan mahasiswa',
                'Mengembangkan program kuliah',
                'Menulis buku ajar/teks',
            ],
            'Penelitian' => [
                'Menghasilkan karya ilmiah (Jurnal Nasional)',
                'Menghasilkan karya ilmiah (Jurnal Internasional)',
                'Menghasilkan karya ilmiah (Jurnal Internasional Bereputasi)',
                'Menyajikan makalah (Seminar Nasional)',
                'Menyajikan makalah (Seminar Internasional)',
                'Menulis buku yang diterbitkan',
                'Menerjemahkan/menyadur buku',
                'Mendapatkan HKI/Paten',
                'Membuat rancangan dan karya teknologi',
                'Penelitian mandiri/kelompok',
            ],
            'Pengabdian Masyarakat' => [
                'Menduduki jabatan pimpinan',
                'Melaksanakan pengembangan hasil pendidikan/penelitian',
                'Memberikan latihan/penyuluhan/penataran',
                'Memberikan pelayanan kepada masyarakat',
                'Membuat karya pengabdian',
                'Kegiatan PKM/KKN Tematik',
                'Kerjasama dengan instansi/industri',
            ],
        ];
    }

    // Angka kredit standar
    public static function angkaKreditStandar(): array
    {
        return [
            'Mengajar/Membimbing mahasiswa S1' => 0.5,
            'Mengajar/Membimbing mahasiswa S2' => 1.0,
            'Mengajar/Membimbing mahasiswa S3' => 1.5,
            'Membimbing Tugas Akhir/Skripsi' => 1.0,
            'Membimbing Tesis' => 2.0,
            'Membimbing Disertasi' => 3.0,
            'Menghasilkan karya ilmiah (Jurnal Nasional)' => 10.0,
            'Menghasilkan karya ilmiah (Jurnal Internasional)' => 20.0,
            'Menghasilkan karya ilmiah (Jurnal Internasional Bereputasi)' => 40.0,
            'Menyajikan makalah (Seminar Nasional)' => 5.0,
            'Menyajikan makalah (Seminar Internasional)' => 10.0,
            'Menulis buku yang diterbitkan' => 20.0,
            'Mendapatkan HKI/Paten' => 15.0,
            'Memberikan latihan/penyuluhan/penataran' => 2.0,
            'Memberikan pelayanan kepada masyarakat' => 1.5,
            'Kegiatan PKM/KKN Tematik' => 3.0,
        ];
    }

    public function getBadgeColorAttribute(): string
    {
        return match($this->status) {
            'Disetujui' => 'success',
            'Ditolak'   => 'danger',
            default     => 'warning',
        };
    }

    public function getKategoriIconAttribute(): string
    {
        return match($this->kategori) {
            'Pendidikan'            => '🎓',
            'Penelitian'            => '🔬',
            'Pengabdian Masyarakat' => '🤝',
            default                 => '📋',
        };
    }

    public function getKategoriColorAttribute(): string
    {
        return match($this->kategori) {
            'Pendidikan'            => '#8B0000',
            'Penelitian'            => '#1a472a',
            'Pengabdian Masyarakat' => '#1a237e',
            default                 => '#555',
        };
    }
}
