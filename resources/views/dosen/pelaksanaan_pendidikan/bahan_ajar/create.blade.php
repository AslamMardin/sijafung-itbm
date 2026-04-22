@extends('layouts.app')
@section('title', 'Input Bahan Ajar')
@section('page-title', 'Input Bahan Ajar')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form Input Bahan Ajar</h3>
        <a href="{{ route('dosen.pendidikan.index') }}" class="btn btn-outline btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <form action="{{ route('dosen.pendidikan.store', 'bahan_ajar') }}" method="POST">
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
                <label for="judul_bahan_ajar" class="form-label">Judul Bahan Ajar <span class="text-danger">*</span></label>
                <input type="text" name="judul_bahan_ajar" id="judul_bahan_ajar" class="form-control @error('judul_bahan_ajar') is-invalid @enderror"
                       value="{{ old('judul_bahan_ajar') }}" required placeholder="Judul bahan ajar">
                @error('judul_bahan_ajar')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="isbn" class="form-label">ISBN</label>
                        <input type="text" name="isbn" id="isbn" class="form-control"
                               value="{{ old('isbn') }}" placeholder="Nomor ISBN">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="penerbit" class="form-label">Penerbit</label>
                        <input type="text" name="penerbit" id="penerbit" class="form-control"
                               value="{{ old('penerbit') }}" placeholder="Nama penerbit">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="status_penulis" class="form-label">Status Penulis</label>
                        <select name="status_penulis" id="status_penulis" class="form-control">
                            <option value="">Pilih Status</option>
                            <option value="Penulis Utama" {{ old('status_penulis') == 'Penulis Utama' ? 'selected' : '' }}>Penulis Utama</option>
                            <option value="Penulis Pendamping" {{ old('status_penulis') == 'Penulis Pendamping' ? 'selected' : '' }}>Penulis Pendamping</option>
                            <option value="Editor" {{ old('status_penulis') == 'Editor' ? 'selected' : '' }}>Editor</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="jumlah_anggota" class="form-label">Jumlah Anggota</label>
                        <input type="number" name="jumlah_anggota" id="jumlah_anggota" class="form-control"
                               value="{{ old('jumlah_anggota') }}" min="0" placeholder="Jumlah anggota">
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
