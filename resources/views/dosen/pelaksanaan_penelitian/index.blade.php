@extends('layouts.app')
@section('title', 'Pelaksanaan Penelitian')
@section('page-title', 'Pelaksanaan Penelitian')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Kegiatan Penelitian</h3>
        @if($jenisKegiatan)
            <a href="{{ route('dosen.penelitian.index') }}" class="btn btn-outline btn-sm">
                <i class="fas fa-list"></i> Semua Kegiatan
            </a>
        @endif
    </div>
    
    <div class="card-body">
        <form method="GET" class="filter-form mb-3">
            <div class="row">
                <div class="col-md-4">
                    <select name="status" class="form-control" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Disetujui" {{ request('status') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                        <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jenis</th>
                        <th>Detail</th>
                        <th>Peran</th>
                        <th>AK</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kegiatans as $index => $kegiatan)
                    <tr>
                        <td>{{ $kegiatans->firstItem() + $index }}</td>
                        <td>
                            <div style="font-size: 1.5rem; margin-bottom: 4px;">{{ $kegiatan->jenis_icon }}</div>
                            <strong>{{ ucwords(str_replace('_', ' ', $kegiatan->jenis_kegiatan)) }}</strong>
                        </td>
                        <td>
                            <div>{{ Str::limit($kegiatan->judul_kegiatan ?? '-', 40) }}</div>
                            <small class="text-muted">{{ $kegiatan->tahun_pelaksanaan ?? '-' }}</small>
                        </td>
                        <td>{{ ucwords($kegiatan->peran ?? '-') }}</td>
                        <td><strong style="color: var(--maroon);">{{ number_format($kegiatan->angka_kredit, 2) }}</strong></td>
                        <td>
                            <span class="badge badge-{{ $kegiatan->badge_color }}">{{ $kegiatan->status }}</span>
                        </td>
                        <td>
                            <div class="btn-group">
                                @if($kegiatan->status == 'Pending')
                                    <a href="{{ route('dosen.penelitian.edit', [$kegiatan->jenis_kegiatan, $kegiatan]) }}" class="btn btn-sm btn-outline">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endif
                                <form action="{{ route('dosen.penelitian.destroy', $kegiatan) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <div class="empty-state">
                                <i class="fas fa-flask"></i>
                                <h3>Belum ada kegiatan penelitian</h3>
                                <p>Mulai input kegiatan penelitian Anda melalui menu di sidebar</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $kegiatans->links() }}
    </div>
</div>
@endsection

@push('styles')
<style>
    .empty-state { text-align: center; padding: 40px 20px; color: var(--text-muted); }
    .empty-state i { font-size: 3rem; margin-bottom: 16px; opacity: 0.5; }
    .empty-state h3 { font-size: 1.1rem; margin-bottom: 8px; color: var(--text-dark); }
    .empty-state p { font-size: 0.85rem; }
</style>
@endpush
