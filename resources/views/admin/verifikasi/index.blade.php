@extends('layouts.app')
@section('title', 'Verifikasi Kegiatan Dosen')
@section('page-title', 'Verifikasi Kegiatan Dosen')

@section('content')
    <div class="page-header mb-4">
        <div class="page-header-left">
            <h2>Verifikasi Kegiatan</h2>
            <p>Tinjau dan validasi kegiatan Tri Dharma yang diajukan oleh dosen</p>
        </div>
    </div>

    <div class="stat-grid mb-4">
        <div class="stat-card">
            <div class="stat-icon maroon">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value">{{ $kegiatans->count() }}</div>
                <div class="stat-label">Total Pengajuan</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon orange">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value">{{ $kegiatans->where('status', 'Pending')->count() }}</div>
                <div class="stat-label">Menunggu Verifikasi</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value">{{ $kegiatans->where('status', 'Disetujui')->count() }}</div>
                <div class="stat-label">Telah Disetujui</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value">{{ $dosens->count() }}</div>
                <div class="stat-label">Dosen Aktif</div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-filter me-2"></i> Filter Pengajuan</h3>
        </div>
        <div class="card-body bg-light-soft py-3">
            <form method="GET" class="filter-form mb-0">
                <div class="d-flex flex-wrap align-items-center gap-3">
                    <div class="d-flex align-items-center gap-2">
                        <label class="form-label small fw-bold mb-0 text-nowrap">Tri Dharma:</label>
                        <select name="sumber" class="form-select form-select-sm shadow-sm" style="min-width: 150px;"
                            onchange="this.form.submit()">
                            <option value="semua" {{ $sumber == 'semua' ? 'selected' : '' }}>Semua Kategori</option>
                            <option value="pendidikan" {{ $sumber == 'pendidikan' ? 'selected' : '' }}>📚 Pendidikan
                            </option>
                            <option value="penelitian" {{ $sumber == 'penelitian' ? 'selected' : '' }}>🔬 Penelitian
                            </option>
                            <option value="pengabdian" {{ $sumber == 'pengabdian' ? 'selected' : '' }}>🤝 Pengabdian
                            </option>
                        </select>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <label class="form-label small fw-bold mb-0 text-nowrap">Status:</label>
                        <select name="status" class="form-select form-select-sm shadow-sm" style="min-width: 130px;"
                            onchange="this.form.submit()">
                            <option value="">Semua Status</option>
                            <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>⏳ Pending
                            </option>
                            <option value="Disetujui" {{ request('status') == 'Disetujui' ? 'selected' : '' }}>✅ Disetujui
                            </option>
                            <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>❌ Ditolak
                            </option>
                        </select>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <label class="form-label small fw-bold mb-0 text-nowrap">Dosen:</label>
                        <select name="dosen_id" class="form-select form-select-sm shadow-sm" style="min-width: 200px;"
                            onchange="this.form.submit()">
                            <option value="">Semua Dosen</option>
                            @foreach ($dosens as $dosen)
                                <option value="{{ $dosen->id }}"
                                    {{ request('dosen_id') == $dosen->id ? 'selected' : '' }}>
                                    {{ $dosen->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="ms-auto">
                        <a href="{{ route('admin.verifikasi.index') }}" class="btn btn-sm btn-outline shadow-sm">
                            <i class="fas fa-undo"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">No</th>
                            <th>Tri Dharma</th>
                            <th>Dosen</th>
                            <th>Detail Kegiatan</th>
                            <th class="text-center">AK</th>
                            <th class="text-center">Status</th>
                            <th>Tanggal</th>
                            <th class="text-center pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kegiatans as $index => $kegiatan)
                            <tr class="{{ $kegiatan->status == 'Pending' ? 'bg-warning-soft' : '' }}">
                                <td class="ps-4 text-muted">{{ $index + 1 }}</td>
                                <td>
                                    @php
                                        $color = match ($kegiatan->sumber_key) {
                                            'pendidikan' => 'danger',
                                            'penelitian' => 'success',
                                            'pengabdian' => 'primary',
                                            default => 'secondary',
                                        };
                                        $icon = match ($kegiatan->sumber_key) {
                                            'pendidikan' => 'fa-graduation-cap',
                                            'penelitian' => 'fa-microscope',
                                            'pengabdian' => 'fa-hands-helping',
                                            default => 'fa-file',
                                        };
                                    @endphp
                                    <span class="badge badge-{{ $color }} d-inline-flex align-items-center">
                                        <i class="fas {{ $icon }} me-1"></i> {{ $kegiatan->sumber }}
                                    </span>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $kegiatan->user->name ?? '-' }}</div>
                                    <small
                                        class="text-muted d-block">{{ $kegiatan->user->nidn ?? ($kegiatan->user->nip ?? '-') }}</small>
                                </td>
                                <td>
                                    <div class="text-truncate" style="max-width: 300px;">
                                        <strong class="text-maroon">{{ $kegiatan->nama_kegiatan }}</strong>
                                    </div>
                                    <div class="small text-muted">
                                        @if (isset($kegiatan->sks))
                                            <span class="me-2"><i class="fas fa-book-open me-1"></i>{{ $kegiatan->sks }}
                                                SKS</span>
                                        @endif
                                        @if (isset($kegiatan->tahun_pelaksanaan))
                                            <span><i
                                                    class="fas fa-calendar-alt me-1"></i>{{ $kegiatan->tahun_pelaksanaan }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="fw-bold text-maroon"
                                        style="font-size: 1.1rem;">{{ number_format($kegiatan->angka_kredit ?? 0, 2) }}</span>
                                </td>
                                <td class="text-center">
                                    @php
                                        $statusClass = match ($kegiatan->status) {
                                            'Disetujui' => 'badge-success',
                                            'Ditolak' => 'badge-danger',
                                            default => 'badge-warning',
                                        };
                                        $statusIcon = match ($kegiatan->status) {
                                            'Disetujui' => 'fa-check-circle',
                                            'Ditolak' => 'fa-times-circle',
                                            default => 'fa-hourglass-half',
                                        };
                                    @endphp
                                    <span class="badge {{ $statusClass }} rounded-pill px-3">
                                        <i class="fas {{ $statusIcon }} me-1"></i> {{ $kegiatan->status }}
                                    </span>
                                </td>
                                <td>
                                    <div class="small fw-500">{{ $kegiatan->created_at->format('d M Y') }}</div>
                                    <div class="small text-muted">{{ $kegiatan->created_at->format('H:i') }}</div>
                                </td>
                                <td class="text-center pe-4">
                                    <a href="{{ route('admin.verifikasi.show', [$kegiatan->sumber_key, $kegiatan->id]) }}"
                                        class="btn btn-sm btn-primary rounded-pill px-3 shadow-sm">
                                        <i class="fas fa-search me-1"></i> Periksa
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div class="empty-state">
                                        <i class="fas fa-clipboard-check mb-3"></i>
                                        <h3>Semua Beres!</h3>
                                        <p class="mb-0">Tidak ada pengajuan kegiatan yang perlu diverifikasi saat ini.
                                        </p>
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
        .bg-light-soft {
            background-color: #fcfafb;
        }

        .bg-warning-soft {
            background-color: rgba(255, 243, 205, 0.4) !important;
        }

        .text-maroon {
            color: var(--maroon);
        }

        .fw-500 {
            font-weight: 500;
        }

        .table thead th {
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            padding: 15px 12px;
        }

        .table tbody td {
            padding: 16px 12px;
        }

        .badge-danger {
            background: rgba(178, 34, 52, 0.1);
            color: #B22234;
        }

        .badge-success {
            background: rgba(26, 122, 69, 0.1);
            color: #1a7a45;
        }

        .badge-primary {
            background: rgba(26, 58, 122, 0.1);
            color: #1a3a7a;
        }

        .badge-warning {
            background: rgba(154, 111, 0, 0.1);
            color: #9a6f00;
        }
    </style>
@endpush
