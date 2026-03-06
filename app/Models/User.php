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

    public function totalAngkaKreditDisetujui(): float
    {
        return $this->kegiatanTriDharma()
            ->where('status', 'Disetujui')
            ->sum('angka_kredit');
    }

    public function angkaKreditPerKategori(): array
    {
        return $this->kegiatanTriDharma()
            ->where('status', 'Disetujui')
            ->groupBy('kategori')
            ->selectRaw('kategori, SUM(angka_kredit) as total')
            ->pluck('total', 'kategori')
            ->toArray();
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
}
