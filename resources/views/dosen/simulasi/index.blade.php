{{-- resources/views/dosen/simulasi/index.blade.php --}}
@extends('layouts.app')
@section('title','Riwayat Simulasi')
@section('page-title','Simulasi Angka Kredit')

@section('content')
<div class="page-header">
    <div class="page-header-left">
        <h2>Riwayat Simulasi Angka Kredit</h2>
        <p>Semua simulasi yang pernah Anda buat</p>
    </div>
    <a href="{{ route('dosen.simulasi.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Buat Simulasi Baru
    </a>
</div>

@if($simulasis->isEmpty())
<div class="card">
    <div class="card-body">
        <div class="empty-state">
            <i class="fas fa-calculator"></i>
            <h3>Belum ada simulasi</h3>
            <p>Buat simulasi pertama untuk mengetahui kelayakan kenaikan jabatan Anda</p>
            <a href="{{ route('dosen.simulasi.create') }}" class="btn btn-primary" style="margin-top:16px">
                <i class="fas fa-plus"></i> Buat Simulasi
            </a>
        </div>
    </div>
</div>
@else
<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:18px">
    @foreach($simulasis as $s)
    <div class="card" style="transition:transform 0.2s;cursor:pointer" onclick="window.location='{{ route('dosen.simulasi.show',$s) }}'">
        <div class="card-body">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:14px">
                <div>
                    <div style="font-weight:600;font-size:0.95rem;margin-bottom:3px">{{ $s->nama_simulasi }}</div>
                    <div style="font-size:0.78rem;color:var(--text-muted)">
                        {{ $s->periode_mulai->format('d M Y') }} — {{ $s->periode_selesai->format('d M Y') }}
                    </div>
                </div>
                <span class="badge badge-{{ $s->memenuhi_syarat ? 'success' : 'danger' }}" style="flex-shrink:0">
                    {{ $s->memenuhi_syarat ? '✅ Lulus' : '❌ Belum' }}
                </span>
            </div>

            <div style="display:flex;gap:16px;margin-bottom:14px">
                <div style="text-align:center">
                    <div style="font-size:1.5rem;font-weight:700;color:var(--maroon)">{{ number_format($s->ak_total,1) }}</div>
                    <div style="font-size:0.72rem;color:var(--text-muted)">Total AK</div>
                </div>
                <div style="flex:1">
                    <div style="font-size:0.75rem;color:var(--text-muted);margin-bottom:4px">
                        Progress ke {{ $s->jabatan_target ?? 'Puncak' }}
                    </div>
                    <div class="progress-bar-wrap">
                        <div class="progress-bar-fill" style="width:{{ $s->progress_persen }}%"></div>
                    </div>
                    <div style="font-size:0.72rem;color:var(--text-muted);margin-top:3px">{{ $s->progress_persen }}%</div>
                </div>
            </div>

            <div style="display:flex;gap:10px;font-size:0.78rem;color:var(--text-muted)">
                <span>🎓 {{ number_format($s->ak_pendidikan,1) }}</span>
                <span>🔬 {{ number_format($s->ak_penelitian,1) }}</span>
                <span>🤝 {{ number_format($s->ak_pengabdian,1) }}</span>
                <span style="margin-left:auto">{{ $s->created_at->diffForHumans() }}</span>
            </div>

            <a href="{{ route('dosen.simulasi.show',$s) }}" class="btn btn-outline btn-sm" style="width:100%;margin-top:12px;justify-content:center">
                Lihat Detail <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
    @endforeach
</div>

@if($simulasis->hasPages())
<div class="card-body">{{ $simulasis->links() }}</div>
@endif
@endif
@endsection
