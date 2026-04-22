@extends('layouts.app')
@section('title', 'Input Pembimbing Dosen')
@section('page-title', 'Input Pembimbing Dosen')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form Input Pembimbing Dosen</h3>
        <a href="{{ route('dosen.pendidikan.index') }}" class="btn btn-outline btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <form action="{{ route('dosen.pendidikan.store', 'pembimbing_dosen') }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="kategori_kegiatan_id" class="form-label">Kategori Kegiatan <span class="text-danger">*</span></label>
                        <select name="kategori_kegiatan_id" id="kategori_kegiatan_id" class="form-control @error('kategori_kegiatan_id') is-invalid @enderror" required onchange="updateAKPreview()">
                            <option value="">Pilih Kategori</option>
                            @foreach($kategoriOptions as $kat)
                                <option value="{{ $kat['id'] }}" data-ak="{{ $kat['angka_kredit'] }}" {{ old('kategori_kegiatan_id') == $kat['id'] ? 'selected' : '' }}>
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
                               value="{{ old('tanggal_mulai') }}" required>
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
                               value="{{ old('program_studi') }}" placeholder="Nama program studi">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control"
                               value="{{ old('tanggal_selesai') }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="jenis_bimbingan" class="form-label">Jenis Bimbingan</label>
                        <input type="text" name="jenis_bimbingan" id="jenis_bimbingan" class="form-control"
                               value="{{ old('jenis_bimbingan') }}" placeholder="Jenis bimbingan">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="bidang_ahli_pembimbing" class="form-label">Bidang Ahli Pembimbing</label>
                        <input type="text" name="bidang_ahli_pembimbing" id="bidang_ahli_pembimbing" class="form-control"
                               value="{{ old('bidang_ahli_pembimbing') }}" placeholder="Bidang keahlian pembimbing">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="jabatan_fungsional_pembimbing" class="form-label">Jabatan Fungsional Pembimbing</label>
                        <input type="text" name="jabatan_fungsional_pembimbing" id="jabatan_fungsional_pembimbing" class="form-control"
                               value="{{ old('jabatan_fungsional_pembimbing') }}" placeholder="Jabatan fungsional pembimbing">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="dosen_bimbingan" class="form-label">Dosen Bimbingan</label>
                        <input type="text" name="dosen_bimbingan" id="dosen_bimbingan" class="form-control"
                               value="{{ old('dosen_bimbingan') }}" placeholder="Nama dosen bimbingan">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="jabatan_fungsional_bimbingan" class="form-label">Jabatan Fungsional Bimbingan</label>
                        <input type="text" name="jabatan_fungsional_bimbingan" id="jabatan_fungsional_bimbingan" class="form-control"
                               value="{{ old('jabatan_fungsional_bimbingan') }}" placeholder="Jabatan fungsional dosen bimbingan">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="no_sk_tugas" class="form-label">No SK Tugas</label>
                        <input type="text" name="no_sk_tugas" id="no_sk_tugas" class="form-control"
                               value="{{ old('no_sk_tugas') }}" placeholder="Nomor SK penugasan">
                    </div>
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="tanggal_sk_tugas" class="form-label">Tanggal SK Tugas</label>
                <input type="date" name="tanggal_sk_tugas" id="tanggal_sk_tugas" class="form-control"
                       value="{{ old('tanggal_sk_tugas') }}">
            </div>

            <div class="alert alert-info">
                <strong>Preview Angka Kredit:</strong> <span id="ak-preview">0.00</span> AK
                <br><small>AK akan dihitung ulang saat verifikasi admin</small>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan Kegiatan
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
    .alert-info { background: #e7f3ff; border: 1px solid #b3d9ff; color: #004085; padding: 12px; border-radius: 6px; }
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
