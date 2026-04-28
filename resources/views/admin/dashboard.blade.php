@extends('layouts.app')
@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')
@section('breadcrumb')
    <i class="fas fa-chevron-right" style="font-size:0.7rem;opacity:0.5"></i> Admin
@endsection

@push('styles')
<style>
.welcome-banner {
    background: linear-gradient(135deg, var(--maroon-dark) 0%, var(--maroon-mid) 60%, #2a0a10 100%);
    border-radius: var(--radius);
    padding: 28px 32px;
    color: #fff;
    margin-bottom: 24px;
    display: flex; align-items: center; justify-content: space-between;
    position: relative; overflow: hidden;
}
.welcome-banner::before {
    content: '🏛️';
    position: absolute;
    right: 28px; top: 50%; transform: translateY(-50%);
    font-size: 6rem; opacity: 0.08;
}
.welcome-banner h2 { font-family:'Playfair Display',serif; font-size:1.6rem; margin-bottom:6px; }
.welcome-banner p { color: rgba(255,255,255,0.7); font-size:0.9rem; }
.welcome-gold { color: var(--gold); font-weight:600; }
.grid-2 { display:grid; grid-template-columns:1fr 1fr; gap:20px; }
.grid-3 { display:grid; grid-template-columns:2fr 1fr; gap:20px; }
.jabatan-item {
    display:flex; align-items:center; justify-content:space-between;
    padding:12px 0; border-bottom:1px solid rgba(107,15,26,0.07);
}
.jabatan-item:last-child { border:none; }
.jabatan-name { font-size:0.88rem; font-weight:500; }
.jabatan-bar-wrap { flex:1; margin:0 14px; }
.dosen-rank { display:flex; align-items:center; gap:12px; padding:11px 0; border-bottom:1px solid rgba(107,15,26,0.06); }
.dosen-rank:last-child { border:none; }
.rank-num { width:26px;height:26px;border-radius:50%;background:var(--maroon-pale);color:var(--maroon);font-size:0.75rem;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0; }
.rank-num.top1 { background:var(--gold);color:var(--maroon-dark); }
.rank-info { flex:1;min-width:0; }
.rank-info strong { font-size:0.85rem;display:block;white-space:nowrap;overflow:hidden;text-overflow:ellipsis; }
.rank-info small { font-size:0.75rem;color:var(--text-muted); }
.rank-ak { font-size:0.85rem;font-weight:600;color:var(--maroon); }
</style>
@endpush

@section('content')
<!-- Welcome Banner -->
<div class="welcome-banner">
    <div>
        <h2>Selamat datang, <span class="welcome-gold">{{ auth()->user()->name }}</span>!</h2>
        <p>{{ now()->translatedFormat('l, d F Y') }} — Panel Administrasi SIJAFUNG</p>
    </div>
</div>

<!-- Stats -->
<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-icon maroon"><i class="fas fa-user-tie"></i></div>
        <div class="stat-info">
            <div class="stat-value">{{ $stats['total_dosen'] }}</div>
            <div class="stat-label">Total Dosen</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon gold"><i class="fas fa-clipboard-list"></i></div>
        <div class="stat-info">
            <div class="stat-value">{{ $stats['total_kegiatan'] }}</div>
            <div class="stat-label">Total Kegiatan</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange"><i class="fas fa-clock"></i></div>
        <div class="stat-info">
            <div class="stat-value">{{ $stats['pending'] }}</div>
            <div class="stat-label">Menunggu Verifikasi</div>
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
        <div class="stat-icon blue"><i class="fas fa-calculator"></i></div>
        <div class="stat-info">
            <div class="stat-value">{{ $stats['total_simulasi'] }}</div>
            <div class="stat-label">Simulasi Dibuat</div>
        </div>
    </div>
</div>

<div class="grid-3" style="margin-bottom:20px">
    <!-- Kegiatan Terbaru -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Kegiatan Terbaru</h3>
            <a href="{{ route('admin.verifikasi.index') }}" class="btn btn-outline btn-sm">Lihat Semua</a>
        </div>
        <div class="card-body" style="padding:0">
            <div class="table-wrap">
                <table>
                    <thead><tr>
                        <th>Dosen</th><th>Kegiatan</th><th>Kategori</th><th>AK</th><th>Status</th>
                    </tr></thead>
                    <tbody>
                        @forelse($kegiatan_terbaru as $k)
                        <tr>
                            <td>
                                <div style="font-weight:500;font-size:0.83rem">{{ Str::limit($k->user->name, 20) }}</div>
                                <small style="color:var(--text-muted)">{{ $k->user->prodi }}</small>
                            </td>
                            <td style="max-width:160px">
                                <div style="font-size:0.83rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $k->nama_kegiatan }}</div>
                            </td>
                            <td>
                                <span style="font-size:1.1rem">{{ $k->kategori_icon }}</span>
                                <span style="font-size:0.75rem">{{ Str::limit($k->kategori, 14) }}</span>
                            </td>
                            <td><strong style="color:var(--maroon)">{{ $k->angka_kredit }}</strong></td>
                            <td>
                                <span class="badge badge-{{ $k->badge_color }}">{{ $k->status }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="empty-state"><i class="fas fa-inbox"></i><p>Belum ada kegiatan</p></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div>
        <!-- Distribusi Jabatan -->
        <div class="card" style="margin-bottom:20px">
            <div class="card-header"><h3 class="card-title">Distribusi Jabatan</h3></div>
            <div class="card-body">
                @php
                $jabatan_list = ['Asisten Ahli','Lektor','Lektor Kepala','Profesor'];
                $total_d = $stats['total_dosen'] ?: 1;
                @endphp
                @foreach($jabatan_list as $jab)
                <div class="jabatan-item">
                    <span class="jabatan-name" style="width:110px;font-size:0.8rem">{{ $jab }}</span>
                    <div class="jabatan-bar-wrap">
                        @php $cnt = $per_jabatan[$jab] ?? 0; $pct = round($cnt/$total_d*100) @endphp
                        <div class="progress-bar-wrap"><div class="progress-bar-fill" style="width:{{ $pct }}%"></div></div>
                    </div>
                    <strong style="font-size:0.82rem;color:var(--maroon);width:20px;text-align:right">{{ $cnt }}</strong>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Top Dosen Aktif -->
        <div class="card">
            <div class="card-header"><h3 class="card-title">Dosen Teraktif</h3></div>
            <div class="card-body">
                @foreach($dosen_aktif as $i => $d)
                <div class="dosen-rank">
                    <div class="rank-num {{ $i===0 ? 'top1' : '' }}">{{ $i+1 }}</div>
                    <div class="rank-info">
                        <strong>{{ Str::limit($d->name, 22) }}</strong>
                        <small>{{ $d->jabatan_fungsional }}</small>
                    </div>
                    <span class="rank-ak">{{ $d->kegiatan_count }}<small style="font-weight:400;color:var(--text-muted)"> keg</small></span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection
