@extends('layouts.app')
@section('title', 'Detail Verifikasi Kegiatan')
@section('page-title', 'Detail Verifikasi Kegiatan')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Detail Kegiatan</h3>
                <a href="{{ route('admin.verifikasi.index') }}" class="btn btn-outline btn-sm">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
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
                    
                    @if($kegiatan->mata_kuliah)
                        {{-- Pendidikan - Pengajaran --}}
                        <div class="detail-grid">
                            <div class="detail-row"><span class="detail-label">Mata Kuliah:</span><span class="detail-value">{{ $kegiatan->mata_kuliah }}</span></div>
                            <div class="detail-row"><span class="detail-label">Jenis:</span><span class="detail-value">{{ $kegiatan->jenis_mata_kuliah ?? '-' }}</span></div>
                            <div class="detail-row"><span class="detail-label">Bidang Keilmuan:</span><span class="detail-value">{{ $kegiatan->bidang_keilmuan ?? '-' }}</span></div>
                            <div class="detail-row"><span class="detail-label">Kelas:</span><span class="detail-value">{{ $kegiatan->kelas ?? '-' }}</span></div>
                            <div class="detail-row"><span class="detail-label">Jumlah Mahasiswa:</span><span class="detail-value">{{ $kegiatan->jumlah_mahasiswa ?? '-' }}</span></div>
                            <div class="detail-row"><span class="detail-label">SKS:</span><span class="detail-value">{{ $kegiatan->sks ?? '-' }}</span></div>
                            <div class="detail-row"><span class="detail-label">Semester:</span><span class="detail-value">{{ $kegiatan->semester ?? '-' }}</span></div>
                        </div>
                    @elseif($kegiatan->judul_bimbingan)
                        {{-- Pendidikan - Bimbingan --}}
                        <div class="detail-grid">
                            <div class="detail-row"><span class="detail-label">Kategori:</span><span class="detail-value">{{ $kegiatan->kategori->nama_kategori ?? '-' }}</span></div>
                            <div class="detail-row"><span class="detail-label">Judul:</span><span class="detail-value">{{ $kegiatan->judul_bimbingan }}</span></div>
                            <div class="detail-row"><span class="detail-label">Bidang Keilmuan:</span><span class="detail-value">{{ $kegiatan->bidang_keilmuan ?? '-' }}</span></div>
                            <div class="detail-row"><span class="detail-label">Jenis:</span><span class="detail-value">{{ $kegiatan->jenis_bimbingan ?? '-' }}</span></div>
                            <div class="detail-row"><span class="detail-label">Prodi:</span><span class="detail-value">{{ $kegiatan->program_studi ?? '-' }}</span></div>
                            <div class="detail-row"><span class="detail-label">Semester:</span><span class="detail-value">{{ $kegiatan->semester ?? '-' }}</span></div>
                        </div>
                    @elseif($kegiatan->judul_kegiatan)
                        {{-- Penelitian/Pengabdian --}}
                        <div class="detail-grid">
                            <div class="detail-row"><span class="detail-label">Judul:</span><span class="detail-value">{{ $kegiatan->judul_kegiatan }}</span></div>
                            <div class="detail-row"><span class="detail-label">Afiliasi:</span><span class="detail-value">{{ $kegiatan->afiliasi ?? '-' }}</span></div>
                            <div class="detail-row"><span class="detail-label">Tahun:</span><span class="detail-value">{{ $kegiatan->tahun_pelaksanaan ?? '-' }}</span></div>
                            <div class="detail-row"><span class="detail-label">Peran:</span><span class="detail-value">{{ ucwords($kegiatan->peran ?? '-') }}</span></div>
                            <div class="detail-row"><span class="detail-label">Jumlah Anggota:</span><span class="detail-value">{{ $kegiatan->jumlah_anggota ?? '-' }}</span></div>
                        </div>
                    @elseif($kegiatan->nama_jurnal)
                        {{-- Pengelola Jurnal --}}
                        <div class="detail-grid">
                            <div class="detail-row"><span class="detail-label">Nama Jurnal:</span><span class="detail-value">{{ $kegiatan->nama_jurnal }}</span></div>
                            <div class="detail-row"><span class="detail-label">No SK:</span><span class="detail-value">{{ $kegiatan->no_sk_penugasan ?? '-' }}</span></div>
                            <div class="detail-row"><span class="detail-label">Peran:</span><span class="detail-value">{{ $kegiatan->peran_jurnal ?? '-' }}</span></div>
                            <div class="detail-row"><span class="detail-label">Mulai:</span><span class="detail-value">{{ $kegiatan->terhitung_mulai?->format('d/m/Y') ?? '-' }}</span></div>
                            <div class="detail-row"><span class="detail-label">Selesai:</span><span class="detail-value">{{ $kegiatan->tanggal_selesai?->format('d/m/Y') ?? 'Masih Aktif' }}</span></div>
                            <div class="detail-row"><span class="detail-label">Status:</span><span class="detail-value">{{ $kegiatan->status_aktif ? 'Aktif' : 'Tidak Aktif' }}</span></div>
                        </div>
                    @elseif($kegiatan->jabatan_struktural)
                        {{-- Jabatan Struktural --}}
                        <div class="detail-grid">
                            <div class="detail-row"><span class="detail-label">Jabatan:</span><span class="detail-value">{{ $kegiatan->jabatan_struktural }}</span></div>
                            <div class="detail-row"><span class="detail-label">No SK:</span><span class="detail-value">{{ $kegiatan->nomor_sk ?? '-' }}</span></div>
                            <div class="detail-row"><span class="detail-label">Mulai:</span><span class="detail-value">{{ $kegiatan->tanggal_mulai?->format('d/m/Y') ?? '-' }}</span></div>
                            <div class="detail-row"><span class="detail-label">Selesai:</span><span class="detail-value">{{ $kegiatan->terhitung_tanggal_selesai?->format('d/m/Y') ?? 'Masih Menjabat' }}</span></div>
                        </div>
                    @else
                        <p class="text-muted">Detail tidak tersedia</p>
                    @endif
                </div>

                <hr>

                <!-- Dokumen -->
                <div class="info-section mb-4">
                    <h4 class="section-title">Dokumen Pendukung</h4>
                    @if($kegiatan->bukti_dokumen)
                        <div class="mb-3">
                            <a href="{{ asset('storage/' . $kegiatan->bukti_dokumen) }}" target="_blank" class="btn btn-primary">
                                <i class="fas fa-file-pdf"></i> Lihat Dokumen
                            </a>
                            <a href="{{ asset('storage/' . $kegiatan->bukti_dokumen) }}" download class="btn btn-outline">
                                <i class="fas fa-download"></i> Download
                            </a>
                        </div>
                    @endif
                    @if($kegiatan->link_dokumen)
                        <div>
                            <a href="{{ $kegiatan->link_dokumen }}" target="_blank" class="btn btn-outline">
                                <i class="fas fa-link"></i> Buka Link Dokumen
                            </a>
                            <br><small class="text-muted">{{ $kegiatan->link_dokumen }}</small>
                        </div>
                    @endif
                    @if(!$kegiatan->bukti_dokumen && !$kegiatan->link_dokumen)
                        <p class="text-muted">Tidak ada dokumen</p>
                    @endif
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
                            <span class="badge badge-{{ $kegiatan->status == 'Disetujui' ? 'success' : ($kegiatan->status == 'Ditolak' ? 'danger' : 'warning') }}" style="font-size: 1rem; padding: 8px 12px;">
                                {{ $kegiatan->status }}
                            </span>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="angka_kredit" class="form-label">Angka Kredit</label>
                        <input type="number" name="angka_kredit" id="angka_kredit" class="form-control" 
                               value="{{ old('angka_kredit', $kegiatan->angka_kredit) }}" step="0.01" min="0">
                        <small class="text-muted">Auto-calculated, bisa diubah</small>
                    </div>

                    <div class="form-group mb-3">
                        <label for="status" class="form-label">Status Verifikasi <span class="text-danger">*</span></label>
                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                            <option value="">Pilih Status</option>
                            <option value="Disetujui" {{ old('status', $kegiatan->status) == 'Disetujui' ? 'selected' : '' }}>✅ Disetujui</option>
                            <option value="Ditolak" {{ old('status', $kegiatan->status) == 'Ditolak' ? 'selected' : '' }}>❌ Ditolak</option>
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
        margin-bottom: 12px;
        padding-bottom: 8px;
        border-bottom: 2px solid var(--maroon);
    }
    .info-row { margin-bottom: 8px; }
    .info-label { font-weight: 500; color: var(--text-muted); font-size: 0.85rem; }
    .info-value { font-weight: 500; margin-left: 8px; }
    
    .detail-grid { display: grid; gap: 12px; }
    .detail-row { display: flex; padding: 8px 0; border-bottom: 1px solid #eee; }
    .detail-label { min-width: 180px; font-weight: 500; color: var(--text-muted); }
    .detail-value { flex: 1; }
    
    .card-footer {
        background: transparent;
        border-top: 1px solid rgba(0,0,0,0.1);
        padding: 16px;
    }
</style>
@endpush
