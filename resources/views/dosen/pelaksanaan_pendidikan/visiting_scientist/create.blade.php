@extends('layouts.app')
@section('title', 'Input Visiting Scientist')
@section('page-title', 'Input Visiting Scientist')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form Input Visiting Scientist</h3>
        <a href="{{ route('dosen.pendidikan.index') }}" class="btn btn-outline btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <form action="{{ route('dosen.pendidikan.store', 'visiting_scientist') }}" method="POST">
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

            <div class="form-group mb-3">
                <label for="perguruan_tinggi_pengundang" class="form-label">Perguruan Tinggi Pengundang <span class="text-danger">*</span></label>
                <input type="text" name="perguruan_tinggi_pengundang" id="perguruan_tinggi_pengundang" class="form-control @error('perguruan_tinggi_pengundang') is-invalid @enderror"
                       value="{{ old('perguruan_tinggi_pengundang') }}" required placeholder="Nama perguruan tinggi pengundang">
                @error('perguruan_tinggi_pengundang')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="lama_kegiatan_hari" class="form-label">Lama Kegiatan (Hari) <span class="text-danger">*</span></label>
                        <input type="number" name="lama_kegiatan_hari" id="lama_kegiatan_hari" class="form-control @error('lama_kegiatan_hari') is-invalid @enderror"
                               value="{{ old('lama_kegiatan_hari') }}" min="1" required placeholder="Durasi dalam hari">
                        @error('lama_kegiatan_hari')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
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
