@extends('layouts.app')
@section('title', 'Detail Verifikasi Kegiatan')
@section('page-title', 'Detail Verifikasi Kegiatan')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Detail Kegiatan</h3>
                    <div>
                        @php
                            $color = match ($sumberKey) {
                                'pendidikan' => 'danger',
                                'penelitian' => 'success',
                                'pengabdian' => 'primary',
                                default => 'secondary',
                            };
                            $icon = match ($sumberKey) {
                                'pendidikan' => 'fa-graduation-cap',
                                'penelitian' => 'fa-microscope',
                                'pengabdian' => 'fa-hands-helping',
                                default => 'fa-file',
                            };
                        @endphp
                        <span class="badge badge-{{ $color }} me-2 px-3 py-2" style="font-size: 0.85rem;">
                            <i class="fas {{ $icon }} me-1"></i> {{ $triDharma ?? 'Kegiatan' }}
                        </span>
                        <a href="{{ route('admin.verifikasi.index') }}" class="btn btn-outline btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Info Dosen -->
                    <div class="info-section mb-4">
                        <h4 class="section-title">Informasi Dosen</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-row">
                                    <span class="info-label">Nama:</span>
                                    <span class="info-value">{{ $kegiatan->user->name }}</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">NIP:</span>
                                    <span class="info-value">{{ $kegiatan->user->nip ?? '-' }}</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">NIDN:</span>
                                    <span class="info-value">{{ $kegiatan->user->nidn ?? '-' }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-row">
                                    <span class="info-label">Prodi:</span>
                                    <span class="info-value">{{ $kegiatan->user->prodi ?? '-' }}</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Fakultas:</span>
                                    <span class="info-value">{{ $kegiatan->user->fakultas ?? '-' }}</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Jabatan:</span>
                                    <span class="info-value">{{ $kegiatan->user->jabatan_fungsional ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Detail Kegiatan -->
                    <div class="info-section mb-4">
                        <h4 class="section-title">Detail Kegiatan</h4>

                        @if ($kegiatan->mata_kuliah)
                            {{-- Pendidikan - Pengajaran --}}
                            <div class="detail-grid">
                                <div class="detail-row"><span class="detail-label">Mata Kuliah:</span><span
                                        class="detail-value">{{ $kegiatan->mata_kuliah }}</span></div>
                                <div class="detail-row"><span class="detail-label">Jenis:</span><span
                                        class="detail-value">{{ $kegiatan->jenis_mata_kuliah ?? '-' }}</span></div>
                                <div class="detail-row"><span class="detail-label">Bidang Keilmuan:</span><span
                                        class="detail-value">{{ $kegiatan->bidang_keilmuan ?? '-' }}</span></div>
                                <div class="detail-row"><span class="detail-label">Kelas:</span><span
                                        class="detail-value">{{ $kegiatan->kelas ?? '-' }}</span></div>
                                <div class="detail-row"><span class="detail-label">Jumlah Mahasiswa:</span><span
                                        class="detail-value">{{ $kegiatan->jumlah_mahasiswa ?? '-' }}</span></div>
                                <div class="detail-row"><span class="detail-label">SKS:</span><span
                                        class="detail-value">{{ $kegiatan->sks ?? '-' }}</span></div>
                                <div class="detail-row"><span class="detail-label">Semester:</span><span
                                        class="detail-value">{{ $kegiatan->semester ?? '-' }}</span></div>
                            </div>
                        @elseif($kegiatan->judul_bimbingan)
                            {{-- Pendidikan - Bimbingan --}}
                            <div class="detail-grid">
                                <div class="detail-row"><span class="detail-label">Kategori:</span><span
                                        class="detail-value">{{ $kegiatan->kategori->nama_kategori ?? '-' }}</span></div>
                                <div class="detail-row"><span class="detail-label">Judul:</span><span
                                        class="detail-value">{{ $kegiatan->judul_bimbingan }}</span></div>
                                <div class="detail-row"><span class="detail-label">Bidang Keilmuan:</span><span
                                        class="detail-value">{{ $kegiatan->bidang_keilmuan ?? '-' }}</span></div>
                                <div class="detail-row"><span class="detail-label">Jenis:</span><span
                                        class="detail-value">{{ $kegiatan->jenis_bimbingan ?? '-' }}</span></div>
                                <div class="detail-row"><span class="detail-label">Prodi:</span><span
                                        class="detail-value">{{ $kegiatan->program_studi ?? '-' }}</span></div>
                                <div class="detail-row"><span class="detail-label">Semester:</span><span
                                        class="detail-value">{{ $kegiatan->semester ?? '-' }}</span></div>
                            </div>
                        @elseif($kegiatan->judul_kegiatan)
                            {{-- Penelitian/Pengabdian --}}
                            <div class="detail-grid">
                                <div class="detail-row"><span class="detail-label">Judul:</span><span
                                        class="detail-value">{{ $kegiatan->judul_kegiatan }}</span></div>
                                <div class="detail-row"><span class="detail-label">Afiliasi:</span><span
                                        class="detail-value">{{ $kegiatan->afiliasi ?? '-' }}</span></div>
                                <div class="detail-row"><span class="detail-label">Tahun:</span><span
                                        class="detail-value">{{ $kegiatan->tahun_pelaksanaan ?? '-' }}</span></div>
                                <div class="detail-row"><span class="detail-label">Peran:</span><span
                                        class="detail-value">{{ ucwords($kegiatan->peran ?? '-') }}</span></div>
                                <div class="detail-row"><span class="detail-label">Jumlah Anggota:</span><span
                                        class="detail-value">{{ $kegiatan->jumlah_anggota ?? '-' }}</span></div>
                            </div>
                        @elseif($kegiatan->nama_jurnal)
                            {{-- Pengelola Jurnal --}}
                            <div class="detail-grid">
                                <div class="detail-row"><span class="detail-label">Nama Jurnal:</span><span
                                        class="detail-value">{{ $kegiatan->nama_jurnal }}</span></div>
                                <div class="detail-row"><span class="detail-label">No SK:</span><span
                                        class="detail-value">{{ $kegiatan->no_sk_penugasan ?? '-' }}</span></div>
                                <div class="detail-row"><span class="detail-label">Peran:</span><span
                                        class="detail-value">{{ $kegiatan->peran_jurnal ?? '-' }}</span></div>
                                <div class="detail-row"><span class="detail-label">Mulai:</span><span
                                        class="detail-value">{{ $kegiatan->terhitung_mulai?->format('d/m/Y') ?? '-' }}</span>
                                </div>
                                <div class="detail-row"><span class="detail-label">Selesai:</span><span
                                        class="detail-value">{{ $kegiatan->tanggal_selesai?->format('d/m/Y') ?? 'Masih Aktif' }}</span>
                                </div>
                                <div class="detail-row"><span class="detail-label">Status:</span><span
                                        class="detail-value">{{ $kegiatan->status_aktif ? 'Aktif' : 'Tidak Aktif' }}</span>
                                </div>
                            </div>
                        @elseif($kegiatan->jabatan_struktural)
                            {{-- Jabatan Struktural --}}
                            <div class="detail-grid">
                                <div class="detail-row"><span class="detail-label">Jabatan:</span><span
                                        class="detail-value">{{ $kegiatan->jabatan_struktural }}</span></div>
                                <div class="detail-row"><span class="detail-label">No SK:</span><span
                                        class="detail-value">{{ $kegiatan->nomor_sk ?? '-' }}</span></div>
                                <div class="detail-row"><span class="detail-label">Mulai:</span><span
                                        class="detail-value">{{ $kegiatan->tanggal_mulai?->format('d/m/Y') ?? '-' }}</span>
                                </div>
                                <div class="detail-row"><span class="detail-label">Selesai:</span><span
                                        class="detail-value">{{ $kegiatan->terhitung_tanggal_selesai?->format('d/m/Y') ?? 'Masih Menjabat' }}</span>
                                </div>
                            </div>
                        @else
                            <p class="text-muted">Detail tidak tersedia</p>
                        @endif
                    </div>

                    <hr>

                    <!-- Dokumen -->
                    <div class="info-section mb-4">
                        <h4 class="section-title">Dokumen Pendukung</h4>
                        <div class="d-flex gap-3 flex-wrap">
                            @if ($kegiatan->bukti_dokumen)
                                <div class="document-card">
                                    <div class="document-icon text-danger">
                                        <i class="fas fa-file-pdf"></i>
                                    </div>
                                    <div class="document-info">
                                        <div class="document-name">File Upload</div>
                                        <div class="document-actions mt-2">
                                            <a href="{{ asset('storage/' . $kegiatan->bukti_dokumen) }}" target="_blank"
                                                class="btn btn-sm btn-primary">Lihat</a>
                                            <a href="{{ asset('storage/' . $kegiatan->bukti_dokumen) }}" download
                                                class="btn btn-sm btn-outline">Unduh</a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if ($kegiatan->link_dokumen)
                                <div class="document-card">
                                    <div class="document-icon text-primary">
                                        <i class="fas fa-link"></i>
                                    </div>
                                    <div class="document-info">
                                        <div class="document-name">Tautan Eksternal</div>
                                        <div class="document-actions mt-2">
                                            <a href="{{ $kegiatan->link_dokumen }}" target="_blank"
                                                class="btn btn-sm btn-outline w-100">
                                                Buka Tautan <i class="fas fa-external-link-alt ms-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if (!$kegiatan->bukti_dokumen && !$kegiatan->link_dokumen)
                                <div class="alert alert-warning w-100 mb-0">
                                    <i class="fas fa-exclamation-triangle me-2"></i> Tidak ada dokumen pendukung yang
                                    dilampirkan.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar: Approval Form -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Verifikasi</h3>
                </div>

                <form action="{{ route('admin.verifikasi.approve', [$sumberKey, $kegiatan->id]) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label class="form-label">Status Saat Ini</label>
                            <div>
                                <span
                                    class="badge badge-{{ $kegiatan->status == 'Disetujui' ? 'success' : ($kegiatan->status == 'Ditolak' ? 'danger' : 'warning') }}"
                                    style="font-size: 1rem; padding: 8px 12px;">
                                    {{ $kegiatan->status }}
                                </span>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="angka_kredit" class="form-label">Angka Kredit</label>
                            <input type="number" name="angka_kredit" id="angka_kredit" class="form-control"
                                value="{{ old('angka_kredit', $kegiatan->angka_kredit) }}" step="0.01"
                                min="0">
                            <small class="text-muted">Auto-calculated, bisa diubah</small>
                        </div>

                        <div class="form-group mb-3">
                            <label for="status" class="form-label">Status Verifikasi <span
                                    class="text-danger">*</span></label>
                            <select name="status" id="status"
                                class="form-control @error('status') is-invalid @enderror" required>
                                <option value="">Pilih Status</option>
                                <option value="Disetujui"
                                    {{ old('status', $kegiatan->status) == 'Disetujui' ? 'selected' : '' }}>✅ Disetujui
                                </option>
                                <option value="Ditolak"
                                    {{ old('status', $kegiatan->status) == 'Ditolak' ? 'selected' : '' }}>❌ Ditolak
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="catatan_admin" class="form-label">Catatan Admin</label>
                            <textarea name="catatan_admin" id="catatan_admin" class="form-control" rows="4"
                                placeholder="Tambahkan catatan...">{{ old('catatan_admin', $kegiatan->catatan_admin) }}</textarea>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-check-circle"></i> Simpan Verifikasi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .info-section h4.section-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--maroon-dark);
            margin-bottom: 16px;
            padding-bottom: 8px;
            border-bottom: 2px solid rgba(178, 34, 52, 0.2);
        }

        .info-row {
            margin-bottom: 12px;
            display: flex;
            align-items: baseline;
        }

        .info-label {
            width: 100px;
            font-weight: 500;
            color: var(--text-muted);
            font-size: 0.85rem;
            flex-shrink: 0;
        }

        .info-value {
            font-weight: 600;
            color: var(--text-dark);
        }

        .detail-grid {
            display: flex;
            flex-direction: column;
            gap: 0;
            border: 1px solid #eaeaea;
            border-radius: 8px;
            overflow: hidden;
        }

        .detail-row {
            display: flex;
            padding: 12px 16px;
            border-bottom: 1px solid #eaeaea;
            background: #fff;
            align-items: center;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-row:nth-child(even) {
            background: #fcfafb;
        }

        .detail-label {
            width: 180px;
            font-weight: 500;
            color: var(--text-muted);
            flex-shrink: 0;
        }

        .detail-value {
            flex: 1;
            font-weight: 600;
            color: var(--maroon-dark);
        }

        .document-card {
            display: flex;
            align-items: center;
            border: 1px solid #eaeaea;
            border-radius: 8px;
            padding: 16px;
            background: #fff;
            min-width: 250px;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .document-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .document-icon {
            font-size: 2.5rem;
            margin-right: 16px;
        }

        .document-name {
            font-weight: 600;
            font-size: 0.95rem;
            color: var(--text-dark);
        }

        .card-footer {
            background: transparent;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            padding: 16px;
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
