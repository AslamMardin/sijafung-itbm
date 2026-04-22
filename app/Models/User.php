<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'nip', 'nidn',
        'prodi', 'fakultas', 'jabatan_fungsional', 'pangkat_golongan',
        'angka_kredit_kumulatif',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'angka_kredit_kumulatif' => 'decimal:2',
    ];

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isDosen(): bool
    {
        return $this->role === 'dosen';
    }

    public function kegiatanTriDharma()
    {
        return $this->hasMany(KegiatanTriDharma::class);
    }

    public function simulasiAngkaKredit()
    {
        return $this->hasMany(SimulasiAngkaKredit::class);
    }

    // Relasi ke tabel baru
    public function pelaksanaanPendidikan()
    {
        return $this->hasMany(PelaksanaanPendidikan::class);
    }

    public function pelaksanaanPenelitian()
    {
        return $this->hasMany(PelaksanaanPenelitian::class);
    }

    public function pelaksanaanPengabdian()
    {
        return $this->hasMany(PelaksanaanPengabdian::class);
    }

    // Helper: Total AK dari semua kegiatan yang disetujui
    public function totalAngkaKreditDisetujui(): float
    {
        $akPendidikan = $this->pelaksanaanPendidikan()
            ->where('status', 'Disetujui')
            ->sum('angka_kredit');
            
        $akPenelitian = $this->pelaksanaanPenelitian()
            ->where('status', 'Disetujui')
            ->sum('angka_kredit');
            
        $akPengabdian = $this->pelaksanaanPengabdian()
            ->where('status', 'Disetujui')
            ->sum('angka_kredit');
        
        return round($akPendidikan + $akPenelitian + $akPengabdian, 2);
    }

    public function totalAngkaKreditPending(): float
    {
        $akPendidikan = $this->pelaksanaanPendidikan()
            ->where('status', 'Pending')
            ->sum('angka_kredit');
            
        $akPenelitian = $this->pelaksanaanPenelitian()
            ->where('status', 'Pending')
            ->sum('angka_kredit');
            
        $akPengabdian = $this->pelaksanaanPengabdian()
            ->where('status', 'Pending')
            ->sum('angka_kredit');
        
        return round($akPendidikan + $akPenelitian + $akPengabdian, 2);
    }

    public function angkaKreditPerKategori(): array
    {
        return [
            'Pendidikan' => $this->pelaksanaanPendidikan()
                ->where('status', 'Disetujui')
                ->sum('angka_kredit'),
            'Penelitian' => $this->pelaksanaanPenelitian()
                ->where('status', 'Disetujui')
                ->sum('angka_kredit'),
            'Pengabdian' => $this->pelaksanaanPengabdian()
                ->where('status', 'Disetujui')
                ->sum('angka_kredit'),
        ];
    }

    public function jabatanBerikutnya(): ?string
    {
        $urutan = ['Asisten Ahli', 'Lektor', 'Lektor Kepala', 'Profesor'];
        $idx = array_search($this->jabatan_fungsional, $urutan);
        return ($idx !== false && $idx < count($urutan) - 1) ? $urutan[$idx + 1] : null;
    }

    public function angkaKreditDibutuhkan(): float
    {
        $syarat = [
            'Asisten Ahli' => ['target' => 'Lektor', 'ak' => 200],
            'Lektor'       => ['target' => 'Lektor Kepala', 'ak' => 400],
            'Lektor Kepala'=> ['target' => 'Profesor', 'ak' => 850],
            'Profesor'     => ['target' => null, 'ak' => 0],
        ];
        return $syarat[$this->jabatan_fungsional]['ak'] ?? 0;
    }

    // Helper: Get count of pending activities per category
    public function getPendingCounts(): array
    {
        return [
            'pendidikan' => $this->pelaksanaanPendidikan()->where('status', 'Pending')->count(),
            'penelitian' => $this->pelaksanaanPenelitian()->where('status', 'Pending')->count(),
            'pengabdian' => $this->pelaksanaanPengabdian()->where('status', 'Pending')->count(),
        ];
    }

    // Helper: Get total count of approved activities per category
    public function getApprovedCounts(): array
    {
        return [
            'pendidikan' => $this->pelaksanaanPendidikan()->where('status', 'Disetujui')->count(),
            'penelitian' => $this->pelaksanaanPenelitian()->where('status', 'Disetujui')->count(),
            'pengabdian' => $this->pelaksanaanPengabdian()->where('status', 'Disetujui')->count(),
        ];
    }
}
