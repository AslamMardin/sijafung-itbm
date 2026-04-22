@extends('layouts.app')
@section('title', 'Edit Pembimbing Dosen')
@section('page-title', 'Edit Pembimbing Dosen')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form Edit Pembimbing Dosen</h3>
        <a href="{{ route('dosen.pendidikan.index') }}" class="btn btn-outline btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <form action="{{ route('dosen.pendidikan.update', ['pembimbing_dosen', $pendidikan]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="kategori_kegiatan_id" class="form-label">Kategori Kegiatan <span class="text-danger">*</span></label>
                        <select name="kategori_kegiatan_id" id="kategori_kegiatan_id" class="form-control @error('kategori_kegiatan_id') is-invalid @enderror" required onchange="updateAKPreview()">
                            <option value="">Pilih Kategori</option>
                            @foreach($kategoriOptions as $kat)
                                <option value="{{ $kat['id'] }}" data-ak="{{ $kat['angka_kredit'] }}" {{ old('kategori_kegiatan_id', $pendidikan->kategori_kegiatan_id) == $kat['id'] ? 'selected' : '' }}>
                                    {{ $kat['nama_kategori'] }} ({{ $kat['angka_kredit'] }} AK/{{ $kat['satuan'] }})
                                </option>
                            @endforeach
                        </select>
                        @error('kategori_kegiatan_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="tanggal_mulai" class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control @error('tanggal_mulai') is-invalid @enderror"
                               value="{{ old('tanggal_mulai', $pendidikan->tanggal_mulai?->format('Y-m-d')) }}" required>
                        @error('tanggal_mulai')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="program_studi" class="form-label">Program Studi</label>
                        <input type="text" name="program_studi" id="program_studi" class="form-control"
                               value="{{ old('program_studi', $pendidikan->program_studi) }}" placeholder="Nama program studi">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control"
                               value="{{ old('tanggal_selesai', $pendidikan->tanggal_selesai?->format('Y-m-d')) }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="jenis_bimbingan" class="form-label">Jenis Bimbingan</label>
                        <input type="text" name="jenis_bimbingan" id="jenis_bimbingan" class="form-control"
                               value="{{ old('jenis_bimbingan', $pendidikan->jenis_bimbingan) }}" placeholder="Jenis bimbingan">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="bidang_ahli_pembimbing" class="form-label">Bidang Ahli Pembimbing</label>
                        <input type="text" name="bidang_ahli_pembimbing" id="bidang_ahli_pembimbing" class="form-control"
                               value="{{ old('bidang_ahli_pembimbing', $pendidikan->bidang_ahli_pembimbing) }}" placeholder="Bidang keahlian pembimbing">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="jabatan_fungsional_pembimbing" class="form-label">Jabatan Fungsional Pembimbing</label>
                        <input type="text" name="jabatan_fungsional_pembimbing" id="jabatan_fungsional_pembimbing" class="form-control"
                               value="{{ old('jabatan_fungsional_pembimbing', $pendidikan->jabatan_fungsional_pembimbing) }}" placeholder="Jabatan fungsional pembimbing">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="dosen_bimbingan" class="form-label">Dosen Bimbingan</label>
                        <input type="text" name="dosen_bimbingan" id="dosen_bimbingan" class="form-control"
                               value="{{ old('dosen_bimbingan', $pendidikan->dosen_bimbingan) }}" placeholder="Nama dosen bimbingan">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="jabatan_fungsional_bimbingan" class="form-label">Jabatan Fungsional Bimbingan</label>
                        <input type="text" name="jabatan_fungsional_bimbingan" id="jabatan_fungsional_bimbingan" class="form-control"
                               value="{{ old('jabatan_fungsional_bimbingan', $pendidikan->jabatan_fungsional_bimbingan) }}" placeholder="Jabatan fungsional dosen bimbingan">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="no_sk_tugas" class="form-label">No SK Tugas</label>
                        <input type="text" name="no_sk_tugas" id="no_sk_tugas" class="form-control"
                               value="{{ old('no_sk_tugas', $pendidikan->no_sk_tugas) }}" placeholder="Nomor SK penugasan">
                    </div>
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="tanggal_sk_tugas" class="form-label">Tanggal SK Tugas</label>
                <input type="date" name="tanggal_sk_tugas" id="tanggal_sk_tugas" class="form-control"
                       value="{{ old('tanggal_sk_tugas', $pendidikan->tanggal_sk_tugas?->format('Y-m-d')) }}">
            </div>

            <div class="alert alert-warning">
                <i class="fas fa-info-circle"></i> <strong>Status:</strong> <span class="badge badge-{{ $pendidikan->badge_color }}">{{ $pendidikan->status }}</span>
                @if($pendidikan->catatan_admin)
                    <br><strong>Catatan Admin:</strong> {{ $pendidikan->catatan_admin }}
                @endif
            </div>
                    <div class="form-group mb-3">
                <label for="link_dokumen" class="form-label">Link Dokumen (Bukti Fisik)</label>
                <input type="url" name="link_dokumen" id="link_dokumen" class="form-control @error('link_dokumen') is-invalid @enderror" 
                       value="{{ old('link_dokumen', $pendidikan->link_dokumen) }}" placeholder="https://drive.google.com/...">
                @error('link_dokumen')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update Kegiatan
            </button>
            <a href="{{ route('dosen.pendidikan.index') }}" class="btn btn-outline">
                <i class="fas fa-times"></i> Batal
            </a>
        </div>
    </form>
</div>
@endsection

@push('styles')
<style>
    .form-label .text-danger { color: #dc3545; }
    .card-footer { background: transparent; border-top: 1px solid rgba(0,0,0,0.1); padding: 16px; }
    .alert-warning { background: #fff3cd; border: 1px solid #ffeaa7; color: #856404; padding: 12px; border-radius: 6px; }
</style>
@endpush

@push('scripts')
<script>
function updateAKPreview() {
    const select = document.getElementById('kategori_kegiatan_id');
    const selectedOption = select.options[select.selectedIndex];
    const ak = selectedOption.getAttribute('data-ak') || 0;
    document.getElementById('ak-preview').textContent = parseFloat(ak).toFixed(2);
}
document.addEventListener('DOMContentLoaded', updateAKPreview);
</script>
@endpush
