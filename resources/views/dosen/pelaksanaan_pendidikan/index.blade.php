@extends('layouts.app')
@section('title', 'Pelaksanaan Pendidikan')
@section('page-title', 'Pelaksanaan Pendidikan')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Kegiatan Pendidikan</h3>
        <div class="header-actions">
            @if($jenisKegiatan)
                <a href="{{ route('dosen.pendidikan.index') }}" class="btn btn-outline btn-sm">
                    <i class="fas fa-list"></i> Semua Kegiatan
                </a>
            @endif
        </div>
    </div>
    
    <div class="card-body">
        <!-- Filter -->
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

        <!-- Table -->
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jenis Kegiatan</th>
                        <th>Detail</th>
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
                            @if($kegiatan->mata_kuliah)
                                <div>{{ $kegiatan->mata_kuliah }}</div>
                                <small class="text-muted">{{ $kegiatan->sks }} SKS | {{ $kegiatan->kelas }}</small>
                            @elseif($kegiatan->judul_bimbingan)
                                <div>{{ Str::limit($kegiatan->judul_bimbingan, 40) }}</div>
                                <small class="text-muted">{{ $kegiatan->program_studi }}</small>
                            @elseif($kegiatan->judul_bahan_ajar)
                                <div>{{ Str::limit($kegiatan->judul_bahan_ajar, 40) }}</div>
                                <small class="text-muted">ISBN: {{ $kegiatan->isbn ?? '-' }}</small>
                            @else
                                <div class="text-muted">-</div>
                            @endif
                        </td>
                        <td><strong style="color: var(--maroon);">{{ number_format($kegiatan->angka_kredit, 2) }}</strong></td>
                        <td>
                            <span class="badge badge-{{ $kegiatan->badge_color }}">{{ $kegiatan->status }}</span>
                            @if($kegiatan->catatan_admin)
                                <div class="text-muted" style="font-size: 0.75rem; margin-top: 4px;">
                                    <i class="fas fa-comment"></i> {{ Str::limit($kegiatan->catatan_admin, 30) }}
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group">
                                @if($kegiatan->status == 'Pending')
                                    <a href="{{ route('dosen.pendidikan.edit', [$kegiatan->jenis_kegiatan, $kegiatan]) }}" class="btn btn-sm btn-outline">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endif
                                <form action="{{ route('dosen.pendidikan.destroy', $kegiatan) }}" method="POST" class="d-inline">
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
                        <td colspan="6" class="text-center py-4">
                            <div class="empty-state">
                                <i class="fas fa-clipboard-list"></i>
                                <h3>Belum ada kegiatan pendidikan</h3>
                                <p>Mulai input kegiatan pendidikan Anda</p>
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
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: var(--text-muted);
    }
    .empty-state i {
        font-size: 3rem;
        margin-bottom: 16px;
        opacity: 0.5;
    }
    .empty-state h3 {
        font-size: 1.1rem;
        margin-bottom: 8px;
        color: var(--text-dark);
    }
    .empty-state p {
        font-size: 0.85rem;
    }
    .filter-form {
        margin-bottom: 16px;
    }
</style>
@endpush
