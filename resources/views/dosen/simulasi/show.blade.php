{{-- resources/views/dosen/simulasi/show.blade.php --}}
@extends('layouts.app')
@section('title','Hasil Simulasi')
@section('page-title','Hasil Simulasi AK')

@push('styles')
<style>
.result-banner {
    border-radius: var(--radius);
    padding: 28px 32px;
    margin-bottom: 24px;
    color: #fff;
    display: flex; align-items: center; justify-content: space-between;
}
.result-banner.lulus { background: linear-gradient(135deg, #0d4f2e, #1a7a45); }
.result-banner.gagal { background: linear-gradient(135deg, var(--maroon-dark), var(--maroon-mid)); }
.result-icon { font-size: 4rem; }
.result-main h2 { font-family:'Playfair Display',serif; font-size:1.6rem; margin-bottom:6px; }
.result-main p { opacity:0.8; }

.ak-breakdown {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 14px;
    margin-bottom: 24px;
}
.ak-box {
    background: var(--card);
    border-radius: 10px;
    padding: 18px;
    text-align: center;
    box-shadow: var(--shadow);
    border: 1px solid rgba(107,15,26,0.07);
}
.ak-box .icon { font-size: 1.6rem; margin-bottom: 8px; }
.ak-box .val { font-size: 1.5rem; font-weight: 700; color: var(--maroon); }
.ak-box .lbl { font-size: 0.75rem; color: var(--text-muted); margin-top: 4px; }
.ak-box .req { font-size: 0.72rem; color: var(--text-muted); margin-top: 2px; }

.check-item {
    display: flex; align-items: center; gap: 12px;
    padding: 12px 0;
    border-bottom: 1px solid rgba(107,15,26,0.07);
}
.check-item:last-child { border: none; }
.check-icon { width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.85rem; flex-shrink: 0; }
.check-icon.ok { background: #edfaf3; color: #1a7a45; }
.check-icon.fail { background: #fdf0ef; color: #a82010; }
</style>
@endpush

@section('content')
<div class="page-header">
    <div class="page-header-left">
        <h2>{{ $simulasi->nama_simulasi }}</h2>
        <p>{{ $simulasi->periode_mulai->format('d M Y') }} — {{ $simulasi->periode_selesai->format('d M Y') }}</p>
    </div>
    <a href="{{ route('dosen.simulasi.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>

<!-- Result Banner -->
<div class="result-banner {{ $simulasi->memenuhi_syarat ? 'lulus' : 'gagal' }}">
    <div class="result-main">
        <h2>
            @if($simulasi->memenuhi_syarat)
                🎉 Selamat! Anda Memenuhi Syarat
            @else
                ⚠️ Belum Memenuhi Syarat
            @endif
        </h2>
        <p>
            @if($simulasi->memenuhi_syarat)
                Berdasarkan simulasi ini, Anda layak mengajukan kenaikan ke jabatan <strong>{{ $simulasi->jabatan_target }}</strong>
            @else
                Anda masih perlu menambah angka kredit untuk kenaikan ke <strong>{{ $simulasi->jabatan_target }}</strong>
            @endif
        </p>
    </div>
    <div class="result-icon">{{ $simulasi->memenuhi_syarat ? '🏆' : '📈' }}</div>
</div>

<!-- AK Breakdown -->
<div class="ak-breakdown">
    <div class="ak-box">
        <div class="icon">📊</div>
        <div class="val">{{ number_format($simulasi->ak_total,1) }}</div>
        <div class="lbl">Total AK</div>
        <div class="req">Butuh: {{ $simulasi->ak_dibutuhkan }}</div>
    </div>
    <div class="ak-box">
        <div class="icon">🎓</div>
        <div class="val" style="color:#6B0F1A">{{ number_format($simulasi->ak_pendidikan,1) }}</div>
        <div class="lbl">AK Pendidikan</div>
        @if($simulasi->jabatan_target && isset($syarat[$simulasi->jabatan_target]))
        <div class="req">Min: {{ $syarat[$simulasi->jabatan_target]['ak_pendidikan']['min'] }}</div>
        @endif
    </div>
    <div class="ak-box">
        <div class="icon">🔬</div>
        <div class="val" style="color:#1a7a45">{{ number_format($simulasi->ak_penelitian,1) }}</div>
        <div class="lbl">AK Penelitian</div>
        @if($simulasi->jabatan_target && isset($syarat[$simulasi->jabatan_target]))
        <div class="req">Min: {{ $syarat[$simulasi->jabatan_target]['ak_penelitian']['min'] }}</div>
        @endif
    </div>
    <div class="ak-box">
        <div class="icon">🤝</div>
        <div class="val" style="color:#1a3a7a">{{ number_format($simulasi->ak_pengabdian,1) }}</div>
        <div class="lbl">AK Pengabdian</div>
        @if($simulasi->jabatan_target && isset($syarat[$simulasi->jabatan_target]))
        <div class="req">Min: {{ $syarat[$simulasi->jabatan_target]['ak_pengabdian']['min'] }}</div>
        @endif
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px">
    <!-- Progress -->
    <div class="card">
        <div class="card-header"><h3 class="card-title">Progress Kenaikan Jabatan</h3></div>
        <div class="card-body">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px">
                <span style="font-size:0.85rem;color:var(--text-muted)">{{ $simulasi->jabatan_saat_ini }}</span>
                <span style="font-size:0.85rem;font-weight:600;color:var(--maroon)">{{ $simulasi->jabatan_target }}</span>
            </div>
            <div class="progress-bar-wrap" style="height:16px;margin-bottom:8px">
                <div class="progress-bar-fill" style="width:{{ $simulasi->progress_persen }}%"></div>
            </div>
            <div style="text-align:center;font-size:1.1rem;font-weight:700;color:var(--maroon)">
                {{ $simulasi->progress_persen }}%
            </div>

            @if($simulasi->jabatan_target && isset($syarat[$simulasi->jabatan_target]))
            <div style="margin-top:18px">
                <div style="font-size:0.8rem;font-weight:600;color:var(--maroon-dark);margin-bottom:10px;text-transform:uppercase;letter-spacing:0.05em">Checklist Syarat</div>
                @php $s = $syarat[$simulasi->jabatan_target] @endphp
                @foreach([
                    ['Total AK ≥ '.$s['ak_minimal'], $simulasi->ak_total >= $s['ak_minimal']],
                    ['Pendidikan ≥ '.$s['ak_pendidikan']['min'], $simulasi->ak_pendidikan >= $s['ak_pendidikan']['min']],
                    ['Penelitian ≥ '.$s['ak_penelitian']['min'], $simulasi->ak_penelitian >= $s['ak_penelitian']['min']],
                    ['Pengabdian ≥ '.$s['ak_pengabdian']['min'], $simulasi->ak_pengabdian >= $s['ak_pengabdian']['min']],
                ] as [$label, $ok])
                <div class="check-item">
                    <div class="check-icon {{ $ok ? 'ok' : 'fail' }}">
                        <i class="fas fa-{{ $ok ? 'check' : 'times' }}"></i>
                    </div>
                    <div style="font-size:0.85rem">{{ $label }}</div>
                    <div style="margin-left:auto;font-size:0.8rem;font-weight:600;color:{{ $ok ? '#1a7a45' : '#a82010' }}">
                        {{ $ok ? 'Terpenuhi' : 'Belum' }}
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>

    <!-- Keterangan -->
    <div class="card">
        <div class="card-header"><h3 class="card-title">Analisis & Rekomendasi</h3></div>
        <div class="card-body">
            @if($simulasi->memenuhi_syarat)
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                Semua persyaratan terpenuhi! Anda dapat mengajukan kenaikan jabatan.
            </div>
            <p style="font-size:0.88rem;color:var(--text-muted)">Langkah selanjutnya:</p>
            <ol style="font-size:0.85rem;padding-left:18px;line-height:2;color:#444">
                <li>Lengkapi berkas administrasi</li>
                <li>Ajukan permohonan ke Fakultas</li>
                <li>Tunggu proses verifikasi</li>
                <li>Penilaian oleh tim penilai</li>
            </ol>
            @else
            @if($simulasi->keterangan)
            <div class="alert alert-warning"><i class="fas fa-exclamation-triangle"></i> Kekurangan ditemukan</div>
            @foreach(explode('; ', $simulasi->keterangan) as $ket)
            <div style="display:flex;gap:8px;margin-bottom:8px;font-size:0.85rem">
                <span style="color:#a82010;flex-shrink:0">•</span>
                <span>{{ $ket }}</span>
            </div>
            @endforeach
            @endif
            <div style="margin-top:16px;padding:14px;background:var(--maroon-pale);border-radius:8px">
                <p style="font-size:0.82rem;color:var(--maroon)">
                    <i class="fas fa-lightbulb"></i> <strong>Saran:</strong>
                    Tingkatkan kegiatan penelitian, khususnya publikasi di jurnal bereputasi untuk memenuhi syarat angka kredit.
                </p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
