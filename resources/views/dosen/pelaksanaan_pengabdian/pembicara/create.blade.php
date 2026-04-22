@extends('layouts.app')
@section('title', 'Input Pembicara')
@section('page-title', 'Input Pembicara')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form Input Pembicara</h3>
        <a href="{{ route('dosen.pengabdian.index') }}" class="btn btn-outline btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <form action="{{ route('dosen.pengabdian.store', 'pembicara') }}" method="POST">
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
                        <label for="kategori_pembicara" class="form-label">Kategori Pembicara <span class="text-danger">*</span></label>
                        <input type="text" name="kategori_pembicara" id="kategori_pembicara" class="form-control @error('kategori_pembicara') is-invalid @enderror"
                               value="{{ old('kategori_pembicara') }}" required placeholder="Contoh: Keynote Speaker, Invited Speaker">
                        @error('kategori_pembicara')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="kategori_capaian_luaran" class="form-label">Kategori Capaian Luaran</label>
                <input type="text" name="kategori_capaian_luaran" id="kategori_capaian_luaran" class="form-control"
                       value="{{ old('kategori_capaian_luaran') }}" placeholder="Deskripsi capaian luaran">
            </div>

            <div class="form-group mb-3">
                <label for="judul_makalah" class="form-label">Judul Makalah <span class="text-danger">*</span></label>
                <input type="text" name="judul_makalah" id="judul_makalah" class="form-control @error('judul_makalah') is-invalid @enderror"
                       value="{{ old('judul_makalah') }}" required placeholder="Judul makalah yang disampaikan">
                @error('judul_makalah')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="nama_temu_ilmiah" class="form-label">Nama Temu Ilmiah <span class="text-danger">*</span></label>
                        <input type="text" name="nama_temu_ilmiah" id="nama_temu_ilmiah" class="form-control @error('nama_temu_ilmiah') is-invalid @enderror"
                               value="{{ old('nama_temu_ilmiah') }}" required placeholder="Nama seminar/konferensi">
                        @error('nama_temu_ilmiah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="penyelenggara" class="form-label">Penyelenggara <span class="text-danger">*</span></label>
                        <input type="text" name="penyelenggara" id="penyelenggara" class="form-control @error('penyelenggara') is-invalid @enderror"
                               value="{{ old('penyelenggara') }}" required placeholder="Nama lembaga penyelenggara">
                        @error('penyelenggara')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="tanggal_pelaksanaan" class="form-label">Tanggal Pelaksanaan <span class="text-danger">*</span></label>
                <input type="date" name="tanggal_pelaksanaan" id="tanggal_pelaksanaan" class="form-control @error('tanggal_pelaksanaan') is-invalid @enderror"
                       value="{{ old('tanggal_pelaksanaan') }}" required>
                @error('tanggal_pelaksanaan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
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
            <a href="{{ route('dosen.pengabdian.index') }}" class="btn btn-outline">
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
