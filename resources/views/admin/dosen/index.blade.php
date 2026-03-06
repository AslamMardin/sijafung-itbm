{{-- resources/views/admin/dosen/index.blade.php --}}
@extends('layouts.app')
@section('title','Manajemen Dosen')
@section('page-title','Manajemen Dosen')

@section('content')
<div class="page-header">
    <div class="page-header-left">
        <h2>Data Dosen</h2>
        <p>Kelola data seluruh dosen</p>
    </div>
    <a href="{{ route('admin.dosen.create') }}" class="btn btn-primary">
        <i class="fas fa-user-plus"></i> Tambah Dosen
    </a>
</div>

<div class="card">
    <div class="table-wrap">
        <table>
            <thead><tr>
                <th>#</th><th>Nama Dosen</th><th>NIP/NIDN</th><th>Prodi</th>
                <th>Jabatan</th><th>AK Kumulatif</th><th>Kegiatan</th><th>Aksi</th>
            </tr></thead>
            <tbody>
                @forelse($dosens as $d)
                <tr>
                    <td style="color:var(--text-muted);font-size:0.8rem">{{ $dosens->firstItem()+$loop->index }}</td>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px">
                            <div style="width:36px;height:36px;background:var(--maroon);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:0.8rem;font-weight:700;flex-shrink:0">
                                {{ strtoupper(substr($d->name,0,2)) }}
                            </div>
                            <div>
                                <div style="font-weight:500">{{ $d->name }}</div>
                                <small style="color:var(--text-muted)">{{ $d->email }}</small>
                            </div>
                        </div>
                    </td>
                    <td style="font-size:0.82rem">
                        <div>{{ $d->nip ?? '-' }}</div>
                        <small style="color:var(--text-muted)">{{ $d->nidn ?? '' }}</small>
                    </td>
                    <td style="font-size:0.83rem">
                        <div>{{ $d->prodi ?? '-' }}</div>
                        <small style="color:var(--text-muted)">{{ $d->fakultas ?? '' }}</small>
                    </td>
                    <td>
                        @if($d->jabatan_fungsional)
                        <span class="badge badge-maroon">{{ $d->jabatan_fungsional }}</span>
                        <div style="font-size:0.72rem;color:var(--text-muted);margin-top:2px">{{ $d->pangkat_golongan }}</div>
                        @else
                        <span style="color:var(--text-muted)">—</span>
                        @endif
                    </td>
                    <td>
                        <strong style="color:var(--maroon);font-size:1.05rem">{{ number_format($d->angka_kredit_kumulatif,1) }}</strong>
                    </td>
                    <td>
                        <span class="badge badge-info">{{ $d->kegiatan_count }} kegiatan</span>
                    </td>
                    <td>
                        <div style="display:flex;gap:5px">
                            <a href="{{ route('admin.dosen.edit',$d) }}" class="btn btn-outline btn-sm" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.dosen.destroy',$d) }}"
                                onsubmit="return confirm('Hapus dosen {{ $d->name }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8">
                    <div class="empty-state">
                        <i class="fas fa-user-tie"></i>
                        <h3>Belum ada dosen terdaftar</h3>
                    </div>
                </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($dosens->hasPages())
    <div class="card-body">{{ $dosens->links() }}</div>
    @endif
</div>
@endsection
