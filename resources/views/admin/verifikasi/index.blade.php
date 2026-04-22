@extends('layouts.app')
@section('title', 'Verifikasi Kegiatan Dosen')
@section('page-title', 'Verifikasi Kegiatan Dosen')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Verifikasi Kegiatan</h3>
        <div class="header-actions">
            <span class="badge badge-warning">{{ $kegiatans->where('status', 'Pending')->count() }} Pending</span>
        </div>
    </div>
    
    <div class="card-body">
        <!-- Filters -->
        <form method="GET" class="filter-form mb-3">
            <div class="row">
                <div class="col-md-3">
                    <select name="sumber" class="form-control" onchange="this.form.submit()">
                        <option value="semua" {{ $sumber == 'semua' ? 'selected' : '' }}>Semua Sumber</option>
                        <option value="pendidikan" {{ $sumber == 'pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                        <option value="penelitian" {{ $sumber == 'penelitian' ? 'selected' : '' }}>Penelitian</option>
                        <option value="pengabdian" {{ $sumber == 'pengabdian' ? 'selected' : '' }}>Pengabdian</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-control" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Disetujui" {{ request('status') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                        <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="dosen_id" class="form-control" onchange="this.form.submit()">
                        <option value="">Semua Dosen</option>
                        @foreach($dosens as $dosen)
                            <option value="{{ $dosen->id }}" {{ request('dosen_id') == $dosen->id ? 'selected' : '' }}>
                                {{ $dosen->name }}
                            </option>
                        @endforeach
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
                        <th>Sumber</th>
                        <th>Dosen</th>
                        <th>Detail</th>
                        <th>AK</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kegiatans as $index => $kegiatan)
                    <tr class="{{ $kegiatan->status == 'Pending' ? 'table-warning' : '' }}">
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <span class="badge badge-{{ $kegiatan->sumber_key == 'pendidikan' ? 'danger' : ($kegiatan->sumber_key == 'penelitian' ? 'success' : 'primary') }}">
                                {{ $kegiatan->sumber }}
                            </span>
                        </td>
                        <td>
                            <div style="font-weight: 500;">{{ $kegiatan->user->name ?? '-' }}</div>
                            <small class="text-muted">{{ $kegiatan->user->nip ?? $kegiatan->user->nidn ?? '-' }}</small>
                        </td>
                        <td>
                            @if(isset($kegiatan->mata_kuliah))
                                <div><strong>{{ $kegiatan->mata_kuliah }}</strong></div>
                                <small class="text-muted">{{ $kegiatan->sks }} SKS | {{ $kegiatan->kelas }}</small>
                            @elseif(isset($kegiatan->judul_kegiatan))
                                <div>{{ Str::limit($kegiatan->judul_kegiatan, 40) }}</div>
                                <small class="text-muted">{{ $kegiatan->tahun_pelaksanaan ?? '-' }}</small>
                            @elseif(isset($kegiatan->judul_bimbingan))
                                <div>{{ Str::limit($kegiatan->judul_bimbingan, 40) }}</div>
                                <small class="text-muted">{{ $kegiatan->program_studi ?? '-' }}</small>
                            @elseif(isset($kegiatan->nama_jurnal))
                                <div>{{ $kegiatan->nama_jurnal }}</div>
                                <small class="text-muted">{{ $kegiatan->peran_jurnal ?? '-' }}</small>
                            @elseif(isset($kegiatan->jabatan_struktural))
                                <div>{{ $kegiatan->jabatan_struktural }}</div>
                                <small class="text-muted">SK: {{ $kegiatan->nomor_sk ?? '-' }}</small>
                            @else
                                <div class="text-muted">-</div>
                            @endif
                        </td>
                        <td><strong style="color: var(--maroon);">{{ number_format($kegiatan->angka_kredit ?? 0, 2) }}</strong></td>
                        <td>
                            <span class="badge badge-{{ $kegiatan->status == 'Disetujui' ? 'success' : ($kegiatan->status == 'Ditolak' ? 'danger' : 'warning') }}">
                                {{ $kegiatan->status }}
                            </span>
                        </td>
                        <td><small>{{ $kegiatan->created_at->format('d/m/Y H:i') }}</small></td>
                        <td>
                            <a href="{{ route('admin.verifikasi.show', [$kegiatan->sumber_key, $kegiatan->id]) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4">
                            <div class="empty-state">
                                <i class="fas fa-clipboard-check"></i>
                                <h3>Tidak ada kegiatan untuk diverifikasi</h3>
                                <p>Semua kegiatan sudah terverifikasi</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .empty-state { text-align: center; padding: 40px 20px; color: var(--text-muted); }
    .empty-state i { font-size: 3rem; margin-bottom: 16px; opacity: 0.5; }
    .empty-state h3 { font-size: 1.1rem; margin-bottom: 8px; color: var(--text-dark); }
    .empty-state p { font-size: 0.85rem; }
    .table-warning { background-color: #fff3cd !important; }
    .filter-form { margin-bottom: 16px; }
</style>
@endpush
