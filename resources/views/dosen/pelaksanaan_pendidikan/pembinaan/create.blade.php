@extends('layouts.app')
@section('title', 'Input Pembinaan Mahasiswa')
@section('page-title', 'Input Pembinaan Mahasiswa')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form Input Pembinaan Mahasiswa</h3>
        <a href="{{ route('dosen.pendidikan.index') }}" class="btn btn-outline btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <form action="{{ route('dosen.pendidikan.store', 'pembinaan') }}" method="POST">
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
                        <label for="semester" class="form-label">Semester <span class="text-danger">*</span></label>
                        <input type="text" name="semester" id="semester" class="form-control @error('semester') is-invalid @enderror"
                               value="{{ old('semester') }}" required placeholder="Contoh: 2024/2025 Genap">
                        @error('semester')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="judul_bimbingan" class="form-label">Judul Bimbingan <span class="text-danger">*</span></label>
                <input type="text" name="judul_bimbingan" id="judul_bimbingan" class="form-control @error('judul_bimbingan') is-invalid @enderror"
                       value="{{ old('judul_bimbingan') }}" required placeholder="Judul bimbingan">
                @error('judul_bimbingan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="jenis_bimbingan" class="form-label">Jenis Bimbingan</label>
                        <select name="jenis_bimbingan" id="jenis_bimbingan" class="form-control">
                            <option value="">Pilih Jenis</option>
                            <option value="PKL" {{ old('jenis_bimbingan') == 'PKL' ? 'selected' : '' }}>PKL</option>
                            <option value="PPL" {{ old('jenis_bimbingan') == 'PPL' ? 'selected' : '' }}>PPL</option>
                            <option value="KKN" {{ old('jenis_bimbingan') == 'KKN' ? 'selected' : '' }}>KKN</option>
                            <option value="Organisasi" {{ old('jenis_bimbingan') == 'Organisasi' ? 'selected' : '' }}>Organisasi</option>
                            <option value="Lomba" {{ old('jenis_bimbingan') == 'Lomba' ? 'selected' : '' }}>Lomba</option>
                            <option value="Lainnya" {{ old('jenis_bimbingan') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="program_studi" class="form-label">Program Studi</label>
                        <input type="text" name="program_studi" id="program_studi" class="form-control"
                               value="{{ old('program_studi') }}" placeholder="Nama program studi">
                    </div>
                </div>
            </div>

            <div class="alert alert-info">
                <strong>Preview Angka Kredit:</strong> <span id="ak-preview">0.00</span> AK
                <br><small>AK akan dihitung ulang saat verifikasi admin</small>
            </div>
                    <div class="form-group mb-3">
                <label for="link_dokumen" class="form-label">Link Dokumen (Bukti Fisik)</label>
                <input type="url" name="link_dokumen" id="link_dokumen" class="form-control @error('link_dokumen') is-invalid @enderror" 
                       value="{{ old('link_dokumen') }}" placeholder="https://drive.google.com/...">
                @error('link_dokumen')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
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
