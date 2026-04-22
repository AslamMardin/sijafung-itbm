<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelaksanaanPendidikan extends Model
{
    use HasFactory;

    protected $table = 'pelaksanaan_pendidikan';

    protected $fillable = [
        'user_id', 'jenis_kegiatan', 'kategori_kegiatan_id', 'sub_kategori',
        'mata_kuliah', 'jenis_mata_kuliah', 'bidang_keilmuan', 'kelas',
        'jumlah_mahasiswa', 'sks', 'semester', 'judul_bimbingan',
        'jenis_bimbingan', 'program_studi', 'judul_pengujian', 'jenis_pengujian',
        'judul_bahan_ajar', 'isbn', 'tanggal_terbit', 'penerbit',
        'status_penulis', 'jumlah_anggota', 'perguruan_tinggi_pengundang',
        'lama_kegiatan_hari', 'kategori_jam', 'perguruan_tinggi_sasaran',
        'deskripsi_kegiatan', 'metode_pelaksanaan', 'nomor_sk_penugasan',
        'tanggal_sk_penugasan', 'kategori_pembicara', 'judul_makalah',
        'nama_pertemuan_ilmiah', 'penyelenggara', 'tanggal_mulai', 'tanggal_selesai',
        'bidang_ahli_pembimbing', 'jabatan_fungsional_pembimbing', 'dosen_bimbingan',
        'jabatan_fungsional_bimbingan', 'no_sk_tugas', 'tanggal_sk_tugas',
        'tugas_tambahan', 'unit_kerja', 'instansi', 'tingkat', 'peran',
        'afiliasi', 'tahun_pelaksanaan', 'lama_kegiatan_tahun',
        'link_dokumen', 'bukti_dokumen', 'status', 'catatan_admin', 'angka_kredit',
    ];

    protected $casts = [
        'tanggal_terbit' => 'date',
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'tanggal_sk_penugasan' => 'date',
        'angka_kredit' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriKegiatan::class, 'kategori_kegiatan_id');
    }

    // Badge color untuk status
    public function getBadgeColorAttribute(): string
    {
        return match($this->status) {
            'Disetujui' => 'success',
            'Ditolak'   => 'danger',
            default     => 'warning',
        };
    }

    // Icon untuk jenis kegiatan
    public function getJenisIconAttribute(): string
    {
        return match($this->jenis_kegiatan) {
            'pengajaran' => '📚',
            'bimbingan' => '🎓',
            'pengujian' => '📝',
            'bahan_ajar' => '📖',
            'pembinaan' => '👥',
            'visiting_scientist' => '✈️',
            'detasering' => '🔄',
            'orasi_ilmiah' => '🎤',
            'pembimbing_dosen' => '👨‍🏫',
            'tugas_tambahan' => '💼',
            default => '📋',
        };
    }

    public function getKategoriIconAttribute(): string
    {
        return '🎓';
    }

    public function getKategoriAttribute(): string
    {
        return 'Pendidikan';
    }

    // Scope untuk filter
    public function scopeJenisKegiatan($query, $jenis)
    {
        return $query->where('jenis_kegiatan', $jenis);
    }

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Helper: Get jenis kegiatan options
    public static function jenisKegiatanOptions(): array
    {
        return [
            'pengajaran' => 'Pengajaran',
            'bimbingan' => 'Bimbingan Mahasiswa',
            'pengujian' => 'Pengujian Mahasiswa',
            'bahan_ajar' => 'Bahan Ajar',
            'pembinaan' => 'Pembinaan Mahasiswa',
            'visiting_scientist' => 'Visiting Scientist',
            'detasering' => 'Detasering',
            'orasi_ilmiah' => 'Orasi Ilmiah',
            'pembimbing_dosen' => 'Pembimbing Dosen',
            'tugas_tambahan' => 'Tugas Tambahan',
        ];
    }

    // Helper: Calculate AK based on SKS and role
    public function calculateAngkaKredit(?User $user = null): float
    {
        $service = app(\App\Services\AngkaKreditService::class);
        $user = $user ?? $this->user;
        return $service->calculate('Pelaksanaan Pendidikan', $this->toArray(), $user);
    }
}
