@extends('layouts.app')
@section('title','Kegiatan Saya')
@section('page-title','Kegiatan Tri Dharma')

@section('content')
<div class="page-header">
    <div class="page-header-left">
        <h2>Kegiatan Tri Dharma Saya</h2>
        <p>Daftar seluruh kegiatan yang telah Anda input</p>
    </div>
    <a href="{{ route('dosen.kegiatan.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Input Kegiatan Baru
    </a>
</div>

<!-- Filter -->
<div class="card" style="margin-bottom:18px">
    <div class="card-body" style="padding:14px 20px">
        <form method="GET" style="display:flex;gap:12px;align-items:flex-end;flex-wrap:wrap">
            <div>
                <label class="form-label">Status</label>
                <select name="status" class="form-select" style="width:150px">
                    <option value="">Semua</option>
                    @foreach(['Pending','Disetujui','Ditolak'] as $s)
                    <option value="{{ $s }}" {{ request('status')===$s?'selected':'' }}>{{ $s }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label">Kategori</label>
                <select name="kategori" class="form-select" style="width:190px">
                    <option value="">Semua</option>
                    @foreach(['Pendidikan','Penelitian','Pengabdian Masyarakat'] as $k)
                    <option value="{{ $k }}" {{ request('kategori')===$k?'selected':'' }}>{{ $k }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Filter</button>
            <a href="{{ route('dosen.kegiatan.index') }}" class="btn btn-outline">Reset</a>
        </form>
    </div>
</div>

<div class="card">
    <div class="table-wrap">
        <table>
            <thead><tr>
                <th>#</th><th>Nama Kegiatan</th><th>Kategori</th>
                <th>Tanggal</th><th>AK</th><th>Status</th><th>Aksi</th>
            </tr></thead>
            <tbody>
                @forelse($kegiatans as $k)
                <tr>
                    <td style="color:var(--text-muted);font-size:0.8rem">{{ $kegiatans->firstItem()+$loop->index }}</td>
                    <td>
                        <div style="font-weight:500">{{ Str::limit($k->nama_kegiatan,45) }}</div>
                        <small style="color:var(--text-muted)">{{ $k->sub_kategori }}</small>
                    </td>
                    <td>
                        <span style="font-size:1.1rem">{{ $k->kategori_icon }}</span>
                        <span style="font-size:0.82rem">{{ $k->kategori }}</span>
                    </td>
                    <td style="font-size:0.83rem">
                        {{ $k->tanggal_mulai->format('d/m/Y') }}
                        @if($k->tanggal_selesai)<br><small style="color:var(--text-muted)">s/d {{ $k->tanggal_selesai->format('d/m/Y') }}</small>@endif
                    </td>
                    <td><strong style="color:var(--maroon);font-size:1.05rem">{{ number_format($k->angka_kredit,1) }}</strong></td>
                    <td>
                        <span class="badge badge-{{ $k->badge_color }}">
                            {{ $k->status === 'Disetujui' ? '✅' : ($k->status === 'Ditolak' ? '❌' : '⏳') }}
                            {{ $k->status }}
                        </span>
                        @if($k->status === 'Ditolak' && $k->catatan_admin)
                        <div style="font-size:0.72rem;color:#a82010;margin-top:3px">{{ Str::limit($k->catatan_admin,40) }}</div>
                        @endif
                    </td>
                    <td>
                        @if($k->status === 'Pending')
                        <div style="display:flex;gap:6px">
                            <a href="{{ route('dosen.kegiatan.edit',$k) }}" class="btn btn-outline btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('dosen.kegiatan.destroy',$k) }}"
                                onsubmit="return confirm('Hapus kegiatan ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                        @else
                        <span style="font-size:0.78rem;color:var(--text-muted)">—</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="7">
                    <div class="empty-state">
                        <i class="fas fa-clipboard-list"></i>
                        <h3>Belum ada kegiatan</h3>
                        <p>Mulai input kegiatan Tri Dharma pertama Anda</p>
                        <a href="{{ route('dosen.kegiatan.create') }}" class="btn btn-primary" style="margin-top:14px">
                            <i class="fas fa-plus"></i> Input Kegiatan
                        </a>
                    </div>
                </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($kegiatans->hasPages())
    <div class="card-body">{{ $kegiatans->withQueryString()->links() }}</div>
    @endif
</div>
@endsection
