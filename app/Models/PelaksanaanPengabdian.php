<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelaksanaanPengabdian extends Model
{
    use HasFactory;

    protected $table = 'pelaksanaan_pengabdian';

    protected $fillable = [
        'user_id', 'jenis_kegiatan', 'kategori_kegiatan_id', 'sub_kategori',
        'judul_kegiatan', 'afiliasi', 'tahun_pelaksanaan', 'lama_kegiatan_tahun',
        'peran', 'jumlah_anggota', 'kategori_capaian_luaran', 'kategori_pembicara',
        'judul_makalah', 'nama_temu_ilmiah', 'penyelenggara', 'tanggal_pelaksanaan',
        'nama_jurnal', 'no_sk_penugasan', 'terhitung_mulai', 'tanggal_selesai',
        'status_aktif', 'peran_jurnal', 'jabatan_struktural', 'nomor_sk',
        'terhitung', 'tanggal_mulai', 'terhitung_tanggal_selesai',
        'link_dokumen', 'bukti_dokumen', 'status', 'catatan_admin', 'angka_kredit',
    ];

    protected $casts = [
        'tanggal_pelaksanaan' => 'date',
        'terhitung_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'terhitung' => 'date',
        'tanggal_mulai' => 'date',
        'terhitung_tanggal_selesai' => 'date',
        'angka_kredit' => 'decimal:2',
        'status_aktif' => 'boolean',
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
            'pengabdian' => '🤝',
            'pembicara' => '🎤',
            'pengelola_jurnal' => '📰',
            'jabatan_struktural' => '🏛️',
            default => '📋',
        };
    }

    public function getKategoriIconAttribute(): string
    {
        return '🤝';
    }

    public function getKategoriAttribute(): string
    {
        return 'Pengabdian';
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
            'pengabdian' => 'Pengabdian',
            'pembicara' => 'Pembicara',
            'pengelola_jurnal' => 'Pengelola Jurnal',
            'jabatan_struktural' => 'Jabatan Struktural',
        ];
    }

    // Helper: Calculate AK based on role
    public function calculateAngkaKredit(?User $user = null): float
    {
        $service = app(\App\Services\AngkaKreditService::class);
        $user = $user ?? $this->user;
        return $service->calculate('Pelaksanaan Pengabdian', $this->toArray(), $user);
    }
}
