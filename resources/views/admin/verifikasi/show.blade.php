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
                        <span class="badge badge-{{ $color }} badge-lg me-2">
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
                            <div class="col-md-8">
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
                            <div class="col-md-4">
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
                                    class="badge badge-{{ $kegiatan->status == 'Disetujui' ? 'success' : ($kegiatan->status == 'Ditolak' ? 'danger' : 'warning') }} badge-lg">
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
        /* Missing Grid & Utility Systems */
        .row {
            display: flex;
            flex-wrap: wrap;
            margin-right: -12px;
            margin-left: -12px;
            gap: 24px 0;
        }

        .col-md-8 {
            flex: 0 0 66.666667%;
            max-width: 66.666667%;
            padding: 0 12px;
        }

        .col-md-4 {
            flex: 0 0 33.333333%;
            max-width: 33.333333%;
            padding: 0 12px;
        }

        .d-flex {
            display: flex !important;
        }

        .justify-content-between {
            justify-content-between !important;
        }

        .align-items-center {
            align-items: center !important;
        }

        .flex-wrap {
            flex-wrap: wrap !important;
        }

        .gap-3 {
            gap: 1rem !important;
        }

        .mb-0 {
            margin-bottom: 0 !important;
        }

        .mb-3 {
            margin-bottom: 1rem !important;
        }

        .mb-4 {
            margin-bottom: 1.5rem !important;
        }

        .me-1 {
            margin-right: 0.25rem !important;
        }

        .me-2 {
            margin-right: 0.5rem !important;
        }

        .ms-1 {
            margin-left: 0.25rem !important;
        }

        .mt-2 {
            margin-top: 0.5rem !important;
        }

        .w-100 {
            width: 100% !important;
        }

        @media (max-width: 992px) {

            .col-md-8,
            .col-md-4 {
                flex: 0 0 100%;
                max-width: 100%;
            }
        }

        /* Enhanced Info Section */
        .info-section {
            margin-bottom: 2rem;
        }

        .info-section h4.section-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--maroon-dark);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--maroon-pale);
            display: flex;
            align-items: center;
        }

        .info-section h4.section-title::before {
            content: '';
            width: 4px;
            height: 18px;
            background: var(--maroon);
            margin-right: 12px;
            border-radius: 4px;
        }

        .info-row {
            margin-bottom: 15px;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .info-label {
            font-weight: 500;
            color: var(--text-muted);
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-value {
            font-weight: 600;
            color: var(--text-dark);
            font-size: 1rem;
        }

        .detail-grid {
            display: flex;
            flex-direction: column;
            gap: 0;
            border: 1px solid rgba(107, 15, 26, 0.08);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
        }

        .detail-row {
            display: flex;
            padding: 16px 20px;
            border-bottom: 1px solid rgba(107, 15, 26, 0.05);
            background: #fff;
            align-items: center;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-row:nth-child(even) {
            background: #fdfafb;
        }

        .detail-label {
            width: 200px;
            font-weight: 500;
            color: var(--text-muted);
            font-size: 0.9rem;
            flex-shrink: 0;
        }

        .detail-value {
            flex: 1;
            font-weight: 600;
            color: var(--maroon-dark);
            font-size: 0.95rem;
        }

        .document-card {
            display: flex;
            align-items: center;
            border: 1px solid rgba(107, 15, 26, 0.1);
            border-radius: 12px;
            padding: 20px;
            background: #fff;
            min-width: 280px;
            transition: all 0.3s ease;
        }

        .document-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(107, 15, 26, 0.1);
            border-color: var(--maroon-light);
        }

        .document-icon {
            font-size: 2.8rem;
            margin-right: 20px;
        }

        .document-name {
            font-weight: 700;
            font-size: 1rem;
            color: var(--maroon-dark);
        }

        .card-footer {
            background: var(--maroon-pale);
            border-top: 1px solid rgba(107, 15, 26, 0.1);
            padding: 20px;
        }

        .badge-lg {
            padding: 8px 16px;
            font-size: 0.85rem;
            border-radius: 8px;
        }

        .badge-danger {
            background: #fdf0ef;
            color: #a82010;
            border: 1px solid rgba(168, 32, 16, 0.1);
        }

        .badge-success {
            background: #edfaf3;
            color: #1a7a45;
            border: 1px solid rgba(26, 122, 69, 0.1);
        }

        .badge-primary {
            background: #edf0fb;
            color: #1a3a7a;
            border: 1px solid rgba(26, 58, 122, 0.1);
        }

        .badge-warning {
            background: #fff8e1;
            color: #9a6f00;
            border: 1px solid rgba(154, 111, 0, 0.1);
        }
    </style>
@endpush
