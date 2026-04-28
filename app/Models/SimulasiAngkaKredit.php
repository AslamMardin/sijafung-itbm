<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimulasiAngkaKredit extends Model
{
    use HasFactory;

    protected $table = 'simulasi_angka_kredit';

    protected $fillable = [
        'user_id', 'nama_simulasi', 'periode_mulai', 'periode_selesai',
        'ak_pendidikan', 'ak_penelitian', 'ak_pengabdian', 'ak_penunjang',
        'ak_total', 'ak_dibutuhkan', 'jabatan_saat_ini', 'jabatan_target',
        'memenuhi_syarat', 'keterangan', 'detail_perhitungan',
    ];

    protected $casts = [
        'periode_mulai'       => 'date',
        'periode_selesai'     => 'date',
        'ak_pendidikan'       => 'decimal:2',
        'ak_penelitian'       => 'decimal:2',
        'ak_pengabdian'       => 'decimal:2',
        'ak_penunjang'        => 'decimal:2',
        'ak_total'            => 'decimal:2',
        'ak_dibutuhkan'       => 'decimal:2',
        'memenuhi_syarat'     => 'boolean',
        'detail_perhitungan'  => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Syarat angka kredit minimal per jabatan
    public static function syaratJabatan(): array
    {
        return [
            'Asisten Ahli' => [
                'ak_minimal'     => 150,
                'ak_pendidikan'  => ['min' => 90, 'max' => null],
                'ak_penelitian'  => ['min' => 25, 'max' => null],
                'ak_pengabdian'  => ['min' => 10, 'max' => null],
                'ak_penunjang'   => ['min' => 5, 'max' => 15],
            ],
            'Lektor' => [
                'ak_minimal'     => 200,
                'ak_pendidikan'  => ['min' => 90, 'max' => null],
                'ak_penelitian'  => ['min' => 45, 'max' => null],
                'ak_pengabdian'  => ['min' => 10, 'max' => null],
                'ak_penunjang'   => ['min' => 5, 'max' => 25],
            ],
            'Lektor Kepala' => [
                'ak_minimal'     => 400,
                'ak_pendidikan'  => ['min' => 90, 'max' => null],
                'ak_penelitian'  => ['min' => 155, 'max' => null],
                'ak_pengabdian'  => ['min' => 10, 'max' => null],
                'ak_penunjang'   => ['min' => 10, 'max' => 50],
            ],
            'Profesor' => [
                'ak_minimal'     => 850,
                'ak_pendidikan'  => ['min' => 90, 'max' => null],
                'ak_penelitian'  => ['min' => 550, 'max' => null],
                'ak_pengabdian'  => ['min' => 10, 'max' => null],
                'ak_penunjang'   => ['min' => 10, 'max' => 75],
            ],
        ];
    }

    public static function hitungSimulasi(User $user, string $periode_mulai, string $periode_selesai): array
    {
        $startYear = date('Y', strtotime($periode_mulai));
        $endYear = date('Y', strtotime($periode_selesai));

        // Ambil kegiatan yang disetujui dalam rentang tahun pelaksanaan ATAU tanggal input
        $p = $user->pelaksanaanPendidikan()->where('status', 'Disetujui')
            ->where(function($q) use ($startYear, $endYear, $periode_mulai, $periode_selesai) {
                $q->whereBetween('tahun_pelaksanaan', [$startYear, $endYear])
                  ->orWhereBetween('created_at', [$periode_mulai, $periode_selesai]);
            })->get();

        $r = $user->pelaksanaanPenelitian()->where('status', 'Disetujui')
            ->where(function($q) use ($startYear, $endYear, $periode_mulai, $periode_selesai) {
                $q->whereBetween('tahun_pelaksanaan', [$startYear, $endYear])
                  ->orWhereBetween('created_at', [$periode_mulai, $periode_selesai]);
            })->get();

        $m = $user->pelaksanaanPengabdian()->where('status', 'Disetujui')
            ->where(function($q) use ($startYear, $endYear, $periode_mulai, $periode_selesai) {
                $q->whereBetween('tahun_pelaksanaan', [$startYear, $endYear])
                  ->orWhereBetween('created_at', [$periode_mulai, $periode_selesai]);
            })->get();

        $ak_pendidikan  = $p->sum('angka_kredit');
        $ak_penelitian  = $r->sum('angka_kredit');
        $ak_pengabdian  = $m->sum('angka_kredit');
        $ak_total       = $ak_pendidikan + $ak_penelitian + $ak_pengabdian;

        $kegiatan = $p->concat($r)->concat($m);

        $jabatan_target  = $user->jabatanBerikutnya();
        $ak_dibutuhkan   = $user->angkaKreditDibutuhkan();
        $syarat          = self::syaratJabatan();
        $memenuhi_syarat = false;
        $keterangan      = [];

        if ($jabatan_target && isset($syarat[$jabatan_target])) {
            $s = $syarat[$jabatan_target];
            $memenuhi_syarat = ($ak_total >= $s['ak_minimal'])
                && ($ak_pendidikan >= $s['ak_pendidikan']['min'])
                && ($ak_penelitian >= $s['ak_penelitian']['min'])
                && ($ak_pengabdian >= $s['ak_pengabdian']['min']);

            if ($ak_total < $s['ak_minimal'])
                $keterangan[] = "Total AK kurang: butuh {$s['ak_minimal']}, diperoleh {$ak_total}";
            if ($ak_pendidikan < $s['ak_pendidikan']['min'])
                $keterangan[] = "AK Pendidikan kurang: min {$s['ak_pendidikan']['min']}, diperoleh {$ak_pendidikan}";
            if ($ak_penelitian < $s['ak_penelitian']['min'])
                $keterangan[] = "AK Penelitian kurang: min {$s['ak_penelitian']['min']}, diperoleh {$ak_penelitian}";
            if ($ak_pengabdian < $s['ak_pengabdian']['min'])
                $keterangan[] = "AK Pengabdian kurang: min {$s['ak_pengabdian']['min']}, diperoleh {$ak_pengabdian}";
        }

        return compact(
            'ak_pendidikan', 'ak_penelitian', 'ak_pengabdian',
            'ak_total', 'ak_dibutuhkan', 'jabatan_target',
            'memenuhi_syarat', 'keterangan', 'kegiatan'
        );
    }

    public function getProgressPersenAttribute(): float
    {
        if ($this->ak_dibutuhkan <= 0) return 100;
        return min(100, round(($this->ak_total / $this->ak_dibutuhkan) * 100, 1));
    }
}
