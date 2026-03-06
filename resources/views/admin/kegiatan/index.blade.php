{{-- resources/views/admin/kegiatan/index.blade.php --}}
@extends('layouts.app')
@section('title','Verifikasi Kegiatan')
@section('page-title','Kegiatan Tri Dharma')

@section('content')
<div class="page-header">
    <div class="page-header-left">
        <h2>Verifikasi Kegiatan</h2>
        <p>Kelola dan verifikasi kegiatan Tri Dharma seluruh dosen</p>
    </div>
</div>

<!-- Filter -->
<div class="card" style="margin-bottom:20px">
    <div class="card-body" style="padding:16px 22px">
        <form method="GET" style="display:flex;gap:12px;align-items:flex-end;flex-wrap:wrap">
            <div>
                <label class="form-label">Status</label>
                <select name="status" class="form-select" style="width:160px">
                    <option value="">Semua Status</option>
                    @foreach(['Pending','Disetujui','Ditolak'] as $s)
                    <option value="{{ $s }}" {{ request('status')===$s?'selected':'' }}>{{ $s }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label">Kategori</label>
                <select name="kategori" class="form-select" style="width:200px">
                    <option value="">Semua Kategori</option>
                    @foreach(['Pendidikan','Penelitian','Pengabdian Masyarakat'] as $k)
                    <option value="{{ $k }}" {{ request('kategori')===$k?'selected':'' }}>{{ $k }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label">Dosen</label>
                <select name="dosen_id" class="form-select" style="width:200px">
                    <option value="">Semua Dosen</option>
                    @foreach($dosens as $d)
                    <option value="{{ $d->id }}" {{ request('dosen_id')==$d->id?'selected':'' }}>{{ $d->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Filter</button>
            <a href="{{ route('admin.kegiatan.index') }}" class="btn btn-outline">Reset</a>
        </form>
    </div>
</div>

<div class="card">
    <div class="table-wrap">
        <table>
            <thead><tr>
                <th>#</th><th>Dosen</th><th>Kegiatan</th><th>Kategori</th>
                <th>Tgl Mulai</th><th>AK</th><th>Status</th><th>Aksi</th>
            </tr></thead>
            <tbody>
                @forelse($kegiatans as $k)
                <tr>
                    <td style="color:var(--text-muted);font-size:0.8rem">{{ $kegiatans->firstItem()+$loop->index }}</td>
                    <td>
                        <div style="font-weight:500">{{ $k->user->name }}</div>
                        <small style="color:var(--text-muted)">{{ $k->user->jabatan_fungsional }}</small>
                    </td>
                    <td>
                        <div style="font-weight:500;max-width:200px">{{ Str::limit($k->nama_kegiatan,40) }}</div>
                        <small style="color:var(--text-muted)">{{ $k->sub_kategori }}</small>
                    </td>
                    <td>
                        <span class="badge badge-maroon">{{ $k->kategori_icon }} {{ $k->kategori }}</span>
                    </td>
                    <td style="font-size:0.83rem">{{ $k->tanggal_mulai->format('d/m/Y') }}</td>
                    <td><strong style="color:var(--maroon)">{{ number_format($k->angka_kredit,1) }}</strong></td>
                    <td><span class="badge badge-{{ $k->badge_color }}">{{ $k->status }}</span></td>
                    <td>
                        <a href="{{ route('admin.kegiatan.show',$k) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-eye"></i> Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8">
                    <div class="empty-state">
                        <i class="fas fa-clipboard-list"></i>
                        <h3>Tidak ada kegiatan ditemukan</h3>
                    </div>
                </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-body">{{ $kegiatans->withQueryString()->links() }}</div>
</div>
@endsection
