@extends('layouts.app')
@section('title', 'Input Paten/HKI')
@section('page-title', 'Input Paten/HKI')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form Input Paten/HKI</h3>
        <a href="{{ route('dosen.penelitian.index') }}" class="btn btn-outline btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <form action="{{ route('dosen.penelitian.store', 'paten_hki') }}" method="POST">
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
                        <label for="tanggal_terbit" class="form-label">Tanggal Terbit <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_terbit" id="tanggal_terbit" class="form-control @error('tanggal_terbit') is-invalid @enderror"
                               value="{{ old('tanggal_terbit') }}" required>
                        @error('tanggal_terbit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="judul_kegiatan" class="form-label">Judul Kegiatan <span class="text-danger">*</span></label>
                <input type="text" name="judul_kegiatan" id="judul_kegiatan" class="form-control @error('judul_kegiatan') is-invalid @enderror"
                       value="{{ old('judul_kegiatan') }}" required placeholder="Judul paten/HKI">
                @error('judul_kegiatan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="jenis_hki" class="form-label">Jenis HKI <span class="text-danger">*</span></label>
                        <select name="jenis_hki" id="jenis_hki" class="form-control @error('jenis_hki') is-invalid @enderror" required>
                            <option value="">Pilih Jenis HKI</option>
                            <option value="Paten" {{ old('jenis_hki') == 'Paten' ? 'selected' : '' }}>Paten</option>
                            <option value="Hak Cipta" {{ old('jenis_hki') == 'Hak Cipta' ? 'selected' : '' }}>Hak Cipta</option>
                            <option value="Desain Produk Industri" {{ old('jenis_hki') == 'Desain Produk Industri' ? 'selected' : '' }}>Desain Produk Industri</option>
                            <option value="Lainnya" {{ old('jenis_hki') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('jenis_hki')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="nomor_paten" class="form-label">Nomor Paten</label>
                        <input type="text" name="nomor_paten" id="nomor_paten" class="form-control"
                               value="{{ old('nomor_paten') }}" placeholder="Nomor paten/HKI (jika ada)">
                    </div>
                </div>
            </div>

            <hr class="my-4">

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
            <a href="{{ route('dosen.penelitian.index') }}" class="btn btn-outline">
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
