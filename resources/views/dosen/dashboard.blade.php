@extends('layouts.app')
@section('title','Dashboard Dosen')
@section('page-title','Dashboard')

@push('styles')
<style>
.profile-banner {
    background: linear-gradient(135deg, var(--maroon-dark) 0%, var(--maroon-mid) 100%);
    border-radius: var(--radius);
    padding: 26px 30px;
    color: #fff;
    margin-bottom: 22px;
    display: flex; align-items: center; gap: 24px;
    position: relative; overflow: hidden;
}
.profile-banner::after {
    content: '🎓';
    position: absolute;
    right: 24px; font-size: 7rem; opacity: 0.07;
}
.profile-avatar {
    width: 68px; height: 68px;
    background: var(--gold);
    border-radius: 18px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.8rem; font-weight: 700;
    color: var(--maroon-dark);
    flex-shrink: 0;
    box-shadow: 0 6px 20px rgba(201,168,76,0.4);
}
.profile-info h2 { font-family:'Playfair Display',serif; font-size:1.4rem; margin-bottom:4px; }
.profile-info p { color:rgba(255,255,255,0.7); font-size:0.85rem; }
.profile-meta { margin-left:auto; text-align:right; }
.profile-meta .jab {
    background: rgba(255,255,255,0.15);
    border: 1px solid rgba(255,255,255,0.25);
    padding: 6px 14px; border-radius: 20px;
    font-size: 0.83rem;
}
.profile-meta .nip { font-size: 0.78rem; color: rgba(255,255,255,0.6); margin-top: 6px; }

.ak-progress-card {
    background: var(--card);
    border-radius: var(--radius);
    padding: 22px 24px;
    box-shadow: var(--shadow);
    border: 1px solid rgba(107,15,26,0.07);
    margin-bottom: 22px;
}
.ak-progress-header { display:flex;align-items:center;justify-content:space-between;margin-bottom:16px; }
.ak-progress-header h3 { font-family:'Playfair Display',serif;color:var(--maroon-dark); }
.ak-values { display:flex;gap:28px;margin-bottom:14px;flex-wrap:wrap; }
.ak-val-item { }
.ak-val-item .val { font-size:1.8rem;font-weight:700;color:var(--maroon);line-height:1; }
.ak-val-item .lbl { font-size:0.75rem;color:var(--text-muted);margin-top:3px; }
.ak-persen { font-size:0.85rem;color:var(--text-muted);margin-top:6px; }

.tri-dharma-bars { display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-top:18px; }
.tdb-card {
    padding: 16px;
    border-radius: 10px;
    text-align: center;
}
.tdb-card.pendidikan { background: #fdf4f5; border:1px solid rgba(107,15,26,0.12); }
.tdb-card.penelitian { background: #f0f7f3; border:1px solid rgba(26,74,42,0.12); }
.tdb-card.pengabdian { background: #f0f2f9; border:1px solid rgba(26,37,110,0.12); }
.tdb-icon { font-size:1.6rem;margin-bottom:6px; }
.tdb-val { font-size:1.4rem;font-weight:700; }
.tdb-val.p { color:var(--maroon); }
.tdb-val.r { color:#1a7a45; }
.tdb-val.m { color:#1a3a7a; }
.tdb-lbl { font-size:0.73rem;color:var(--text-muted);margin-top:2px; }
</style>
@endpush

@section('content')
<!-- Profile Banner -->
<div class="profile-banner">
    <div class="profile-avatar">{{ strtoupper(substr(auth()->user()->name,0,2)) }}</div>
    <div class="profile-info">
        <h2>{{ auth()->user()->name }}</h2>
        <p>{{ auth()->user()->prodi }} — {{ auth()->user()->fakultas }}</p>
        <p style="margin-top:4px">NIP: {{ auth()->user()->nip ?? '-' }} | NIDN/NUPTK: {{ auth()->user()->nidn ?? '-' }}</p>
    </div>
    <div class="profile-meta">
        <div class="jab">{{ auth()->user()->jabatan_fungsional ?? 'Belum ditetapkan' }}</div>
        <div class="nip">{{ auth()->user()->pangkat_golongan ?? '' }}</div>
    </div>
</div>

<!-- Stats -->
<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-icon maroon"><i class="fas fa-clipboard-list"></i></div>
        <div class="stat-info">
            <div class="stat-value">{{ $stats['total_kegiatan'] }}</div>
            <div class="stat-label">Total Kegiatan</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green"><i class="fas fa-check-circle"></i></div>
        <div class="stat-info">
            <div class="stat-value">{{ $stats['disetujui'] }}</div>
            <div class="stat-label">Disetujui</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange"><i class="fas fa-clock"></i></div>
        <div class="stat-info">
            <div class="stat-value">{{ $stats['pending'] }}</div>
            <div class="stat-label">Menunggu</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon blue"><i class="fas fa-calculator"></i></div>
        <div class="stat-info">
            <div class="stat-value">{{ number_format($stats['ak_total'],1) }}</div>
            <div class="stat-label">Total AK Disetujui</div>
        </div>
    </div>
</div>

<!-- AK Progress -->
<div class="ak-progress-card">
    <div class="ak-progress-header">
        <h3>Progress Kenaikan Jabatan</h3>
        @if($stats['jabatan_target'])
        <span class="badge badge-maroon">Target: {{ $stats['jabatan_target'] }}</span>
        @endif
    </div>

    <div class="ak-values">
        <div class="ak-val-item">
            <div class="val">{{ number_format($stats['ak_total'],1) }}</div>
            <div class="lbl">AK Terkumpul</div>
        </div>
        <div style="color:var(--text-muted);align-self:center;font-size:1.3rem">/</div>
        <div class="ak-val-item">
            <div class="val" style="color:var(--text-muted)">{{ number_format($stats['ak_dibutuhkan'],0) }}</div>
            <div class="lbl">AK Dibutuhkan</div>
        </div>
        @if($stats['ak_dibutuhkan'] > 0)
        <div class="ak-val-item" style="margin-left:auto">
            @php $pct = min(100,round($stats['ak_total']/$stats['ak_dibutuhkan']*100,1)) @endphp
            <div class="val" style="color:{{ $pct>=100?'#1a7a45':($pct>=70?'#9a6f00':'var(--maroon)') }}">{{ $pct }}%</div>
            <div class="lbl">Progress</div>
        </div>
        @endif
    </div>

    @if($stats['ak_dibutuhkan'] > 0)
    <div class="progress-bar-wrap" style="height:14px">
        @php $pct = min(100,round($stats['ak_total']/$stats['ak_dibutuhkan']*100,1)) @endphp
        <div class="progress-bar-fill" style="width:{{ $pct }}%"></div>
    </div>
    <div class="ak-persen">Sisa {{ number_format(max(0,$stats['ak_dibutuhkan']-$stats['ak_total']),1) }} AK lagi untuk mencapai jabatan {{ $stats['jabatan_target'] }}</div>
    @endif

    <div class="tri-dharma-bars">
        <div class="tdb-card pendidikan">
            <div class="tdb-icon">🎓</div>
            <div class="tdb-val p">{{ number_format($stats['ak_pendidikan'],1) }}</div>
            <div class="tdb-lbl">AK Pendidikan</div>
        </div>
        <div class="tdb-card penelitian">
            <div class="tdb-icon">🔬</div>
            <div class="tdb-val r">{{ number_format($stats['ak_penelitian'],1) }}</div>
            <div class="tdb-lbl">AK Penelitian</div>
        </div>
        <div class="tdb-card pengabdian">
            <div class="tdb-icon">🤝</div>
            <div class="tdb-val m">{{ number_format($stats['ak_pengabdian'],1) }}</div>
            <div class="tdb-lbl">AK Pengabdian</div>
        </div>
    </div>
</div>

<!-- Kegiatan Terbaru + Quick Links -->
<div style="display:grid;grid-template-columns:1fr 280px;gap:20px">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Kegiatan Terbaru</h3>
            <a href="{{ route('dosen.kegiatan.index') }}" class="btn btn-outline btn-sm">Lihat Semua</a>
        </div>
        <div class="table-wrap">
            <table>
                <thead><tr><th>Kegiatan</th><th>Kategori</th><th>AK</th><th>Status</th></tr></thead>
                <tbody>
                    @forelse($kegiatan_terbaru as $k)
                    <tr>
                        <td>
                            <div style="font-weight:500">{{ Str::limit($k->nama_kegiatan,40) }}</div>
                            <small style="color:var(--text-muted)">{{ $k->tanggal_mulai->format('d/m/Y') }}</small>
                        </td>
                        <td><span style="font-size:1rem">{{ $k->kategori_icon }}</span> {{ Str::limit($k->kategori,14) }}</td>
                        <td><strong style="color:var(--maroon)">{{ $k->angka_kredit }}</strong></td>
                        <td><span class="badge badge-{{ $k->badge_color }}">{{ $k->status }}</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="4">
                        <div class="empty-state">
                            <i class="fas fa-clipboard-list"></i>
                            <h3>Belum ada kegiatan</h3>
                            <p>Mulai input kegiatan Tri Dharma Anda</p>
                        </div>
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Quick Action -->
    <div style="display:flex;flex-direction:column;gap:14px">
        <div class="card">
            <div class="card-body" style="text-align:center;padding:22px">
                <div style="font-size:2rem;margin-bottom:10px">➕</div>
                <h4 style="color:var(--maroon-dark);margin-bottom:8px;font-family:'Playfair Display',serif">Input Kegiatan</h4>
                <p style="font-size:0.82rem;color:var(--text-muted);margin-bottom:14px">Tambah kegiatan Tri Dharma baru</p>
                <a href="{{ route('dosen.kegiatan.create') }}" class="btn btn-primary" style="width:100%">
                    <i class="fas fa-plus"></i> Input Sekarang
                </a>
            </div>
        </div>
        <div class="card">
            <div class="card-body" style="text-align:center;padding:22px">
                <div style="font-size:2rem;margin-bottom:10px">🧮</div>
                <h4 style="color:var(--maroon-dark);margin-bottom:8px;font-family:'Playfair Display',serif">Simulasi AK</h4>
                <p style="font-size:0.82rem;color:var(--text-muted);margin-bottom:14px">Hitung angka kredit Anda</p>
                <a href="{{ route('dosen.simulasi.create') }}" class="btn btn-gold" style="width:100%">
                    <i class="fas fa-calculator"></i> Buat Simulasi
                </a>
            </div>
        </div>
        @if($simulasi_terakhir)
        <div class="card">
            <div class="card-header"><h3 class="card-title" style="font-size:0.9rem">Simulasi Terakhir</h3></div>
            <div class="card-body" style="padding:14px 18px">
                <div style="font-weight:500;font-size:0.88rem;margin-bottom:6px">{{ $simulasi_terakhir->nama_simulasi }}</div>
                <div style="font-size:1.3rem;font-weight:700;color:var(--maroon)">{{ number_format($simulasi_terakhir->ak_total,1) }} AK</div>
                <div style="font-size:0.78rem;color:var(--text-muted);margin:4px 0 10px">{{ $simulasi_terakhir->created_at->diffForHumans() }}</div>
                <span class="badge badge-{{ $simulasi_terakhir->memenuhi_syarat ? 'success' : 'danger' }}">
                    {{ $simulasi_terakhir->memenuhi_syarat ? '✅ Memenuhi Syarat' : '❌ Belum Memenuhi' }}
                </span>
                <a href="{{ route('dosen.simulasi.show',$simulasi_terakhir) }}" class="btn btn-outline btn-sm" style="margin-top:10px;width:100%">Detail</a>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
