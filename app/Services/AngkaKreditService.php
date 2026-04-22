<?php

namespace App\Services;

use App\Models\KategoriKegiatan;
use App\Models\User;

class AngkaKreditService
{
    /**
     * Calculate Angka Kredit (AK) for a given activity.
     * 
     * @param string $menuUtama Pelaksanaan Pendidikan, Pelaksanaan Penelitian, Pelaksanaan Pengabdian
     * @param array $data Activity data
     * @param User $user The lecturer
     * @return float
     */
    public function calculate(string $menuUtama, array $data, User $user): float
    {
        return match ($menuUtama) {
            'Pelaksanaan Pendidikan' => $this->calculatePendidikan($data, $user),
            'Pelaksanaan Penelitian' => $this->calculatePenelitian($data, $user),
            'Pelaksanaan Pengabdian' => $this->calculatePengabdian($data, $user),
            default => 0.0,
        };
    }

    /**
     * Logic for Pendidikan
     */
    private function calculatePendidikan(array $data, User $user): float
    {
        $jenis = $data['jenis_kegiatan'] ?? '';
        $kategoriId = $data['kategori_kegiatan_id'] ?? null;
        $kategori = $kategoriId ? KategoriKegiatan::find($kategoriId) : null;
        
        $baseAk = $kategori ? $kategori->angka_kredit : 0.0;

        switch ($jenis) {
            case 'pengajaran':
                // Max 12 SKS
                $sks = min($data['sks'] ?? 0, 12);
                
                // Based on AK.md: Asisten Ahli (5.5), Lektor+ (11)
                // If we assume 11 is for 12 SKS, then 11/12 per SKS
                $rank = $user->jabatan_fungsional;
                $multiplier = ($rank === 'Asisten Ahli') ? 5.5 : 11.0;
                
                // Usually it's (multiplier / 12) * SKS
                return round(($multiplier / 12) * $sks, 2);

            case 'bimbingan':
                // Skripsi: 1 (Main), 0.5 (Co)
                // Tesis: 3 (Main), 2 (Co)
                // Disertasi: 8 (Main), 5 (Co)
                // We use the category from database as the primary source, 
                // but we can apply multiplier if it's "pendamping"
                $ak = $baseAk;
                if (isset($data['peran']) && $data['peran'] === 'pendamping') {
                    // Logic for pendamping usually 50-60%
                    if (str_contains(strtolower($kategori->nama_kategori ?? ''), 'skripsi')) $ak = 0.5;
                    if (str_contains(strtolower($kategori->nama_kategori ?? ''), 'tesis')) $ak = 2.0;
                    if (str_contains(strtolower($kategori->nama_kategori ?? ''), 'disertasi')) $ak = 5.0;
                }
                return $ak;

            case 'pengujian':
                // Ketua: 1, Anggota: 0.5
                return (isset($data['peran']) && $data['peran'] === 'ketua') ? 1.0 : 0.5;

            case 'tugas_tambahan':
                // Rektor: 15, Dekan: 13, Kajur: 10, Sekjur/Lab: 6
                $tugas = strtolower($data['tugas_tambahan'] ?? '');
                if (str_contains($tugas, 'rektor') && !str_contains($tugas, 'wakil')) return 15.0;
                if (str_contains($tugas, 'dekan') || str_contains($tugas, 'wakil rektor')) return 13.0;
                if (str_contains($tugas, 'ketua jurusan') || str_contains($tugas, 'kajur')) return 10.0;
                if (str_contains($tugas, 'sekretaris jurusan') || str_contains($tugas, 'kepala laboratorium')) return 6.0;
                return $baseAk;

            case 'orasi_ilmiah':
                // Max 2 times per semester (handled by controller or assumed this is single entry)
                return 5.0;

            default:
                return $baseAk;
        }
    }

    /**
     * Logic for Penelitian
     */
    private function calculatePenelitian(array $data, User $user): float
    {
        $kategoriId = $data['kategori_kegiatan_id'] ?? null;
        $kategori = $kategoriId ? KategoriKegiatan::find($kategoriId) : null;
        $baseAk = $kategori ? $kategori->angka_kredit : 0.0;

        $peran = $data['peran'] ?? $data['peran_penulis'] ?? 'ketua';
        $jumlahAnggota = $data['jumlah_anggota'] ?? 1;

        // Based on AK.md: Chairman (60-70%), Members (30-40%)
        // If single author, 100%
        if ($jumlahAnggota <= 1) return $baseAk;

        if ($peran === 'ketua' || $peran === 'penulis_utama') {
            return round($baseAk * 0.6, 2); // Taking conservative 60%
        } else {
            // Members share the remaining 40%
            return round(($baseAk * 0.4) / ($jumlahAnggota - 1), 2);
        }
    }

    /**
     * Logic for Pengabdian
     */
    private function calculatePengabdian(array $data, User $user): float
    {
        $jenis = $data['jenis_kegiatan'] ?? '';
        $kategoriId = $data['kategori_kegiatan_id'] ?? null;
        $kategori = $kategoriId ? KategoriKegiatan::find($kategoriId) : null;
        $baseAk = $kategori ? $kategori->angka_kredit : 0.0;

        switch ($jenis) {
            case 'pembicara':
                // Utama: 3, Pendamping/Moderator: 2
                return (isset($data['peran']) && $data['peran'] === 'utama') ? 3.0 : 2.0;
            
            case 'pengelola_jurnal':
                // Editor Utama: 10, Reviewer/Member: 5
                $peran = $data['peran_jurnal'] ?? $data['peran'] ?? '';
                return str_contains(strtolower($peran), 'utama') ? 10.0 : 5.0;

            default:
                return $baseAk;
        }
    }
}
