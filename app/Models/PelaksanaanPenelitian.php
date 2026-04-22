<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelaksanaanPenelitian extends Model
{
    use HasFactory;

    protected $table = 'pelaksanaan_penelitian';

    protected $fillable = [
        'user_id', 'jenis_kegiatan', 'kategori_kegiatan_id', 'sub_kategori',
        'judul_kegiatan', 'afiliasi', 'tahun_pelaksanaan', 'lama_kegiatan_tahun',
        'peran', 'jumlah_anggota', 'jenis_publikasi', 'tanggal_terbit',
        'peran_penulis', 'jenis_hki', 'nomor_paten',
        'link_dokumen', 'bukti_dokumen', 'status', 'catatan_admin', 'angka_kredit',
    ];

    protected $casts = [
        'tanggal_terbit' => 'date',
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
            'penelitian' => '🔬',
            'publikasi_karya' => '📄',
            'paten_hki' => '©️',
            default => '📋',
        };
    }

    public function getKategoriIconAttribute(): string
    {
        return '🔬';
    }

    public function getKategoriAttribute(): string
    {
        return 'Penelitian';
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
            'penelitian' => 'Penelitian',
            'publikasi_karya' => 'Publikasi Karya',
            'paten_hki' => 'Paten/HKI',
        ];
    }

    // Helper: Calculate AK based on role
    public function calculateAngkaKredit(?User $user = null): float
    {
        $service = app(\App\Services\AngkaKreditService::class);
        $user = $user ?? $this->user;
        return $service->calculate('Pelaksanaan Penelitian', $this->toArray(), $user);
    }
}
