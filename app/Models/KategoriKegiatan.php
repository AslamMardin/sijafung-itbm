<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriKegiatan extends Model
{
    use HasFactory;

    protected $table = 'kategori_kegiatan';

    protected $fillable = [
        'menu_utama',
        'submenu',
        'nama_kategori',
        'deskripsi',
        'angka_kredit',
        'satuan',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'angka_kredit' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // Scope untuk filter
    public function scopeMenuUtama($query, $menuUtama)
    {
        return $query->where('menu_utama', $menuUtama);
    }

    public function scopeSubmenu($query, $submenu)
    {
        return $query->where('submenu', $submenu);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Helper: Get all menu utama
    public static function getMenuUtama(): array
    {
        return self::where('is_active', true)
            ->distinct()
            ->pluck('menu_utama')
            ->toArray();
    }

    // Helper: Get submenu by menu utama
    public static function getSubmenuByMenuUtama(string $menuUtama): array
    {
        return self::where('menu_utama', $menuUtama)
            ->where('is_active', true)
            ->distinct()
            ->pluck('submenu')
            ->toArray();
    }

    // Helper: Get kategori options by submenu
    public static function getKategoriBySubmenu(string $submenu): array
    {
        return self::where('submenu', $submenu)
            ->where('is_active', true)
            ->orderBy('urutan')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nama_kategori' => $item->nama_kategori,
                    'angka_kredit' => $item->angka_kredit,
                    'satuan' => $item->satuan,
                ];
            })
            ->toArray();
    }

    // Helper: Get struktur menu lengkap
    public static function getStrukturMenu(): array
    {
        $menuUtama = self::getMenuUtama();
        $struktur = [];

        foreach ($menuUtama as $menu) {
            $submenus = self::getSubmenuByMenuUtama($menu);
            $submenuData = [];

            foreach ($submenus as $submenu) {
                $kategori = self::getKategoriBySubmenu($submenu);
                $submenuData[] = [
                    'nama' => $submenu,
                    'kategori' => $kategori,
                ];
            }

            $struktur[] = [
                'menu_utama' => $menu,
                'submenu' => $submenuData,
            ];
        }

        return $struktur;
    }

    public function pelaksanaanPendidikan()
    {
        return $this->hasMany(PelaksanaanPendidikan::class, 'kategori_kegiatan_id');
    }

    public function pelaksanaanPenelitian()
    {
        return $this->hasMany(PelaksanaanPenelitian::class, 'kategori_kegiatan_id');
    }

    public function pelaksanaanPengabdian()
    {
        return $this->hasMany(PelaksanaanPengabdian::class, 'kategori_kegiatan_id');
    }
}
