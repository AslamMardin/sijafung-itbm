@extends('layouts.app')
@section('title', 'Edit Pembicara')
@section('page-title', 'Edit Pembicara')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form Edit Pembicara</h3>
        <a href="{{ route('dosen.pengabdian.index') }}" class="btn btn-outline btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <form action="{{ route('dosen.pengabdian.update', ['pembicara', $pengabdian]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
            @if($pengabdian->catatan_admin)
                <div class="alert alert-warning">
                    <i class="fas fa-info-circle"></i> <strong>Status:</strong> <span class="badge badge-{{ $pengabdian->badge_color }}">{{ $pengabdian->status }}</span>
                    <br><strong>Catatan Admin:</strong> {{ $pengabdian->catatan_admin }}
                </div>
            @endif

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="kategori_kegiatan_id" class="form-label">Kategori Kegiatan <span class="text-danger">*</span></label>
                        <select name="kategori_kegiatan_id" id="kategori_kegiatan_id" class="form-control @error('kategori_kegiatan_id') is-invalid @enderror" required onchange="updateAKPreview()">
                            <option value="">Pilih Kategori</option>
                            @foreach($kategoriOptions as $kat)
                                <option value="{{ $kat['id'] }}" data-ak="{{ $kat['angka_kredit'] }}" {{ old('kategori_kegiatan_id', $pengabdian->kategori_kegiatan_id) == $kat['id'] ? 'selected' : '' }}>
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
                               value="{{ old('kategori_pembicara', $pengabdian->kategori_pembicara) }}" required>
                        @error('kategori_pembicara')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="kategori_capaian_luaran" class="form-label">Kategori Capaian Luaran</label>
                <input type="text" name="kategori_capaian_luaran" id="kategori_capaian_luaran" class="form-control"
                       value="{{ old('kategori_capaian_luaran', $pengabdian->kategori_capaian_luaran) }}">
            </div>

            <div class="form-group mb-3">
                <label for="judul_makalah" class="form-label">Judul Makalah <span class="text-danger">*</span></label>
                <input type="text" name="judul_makalah" id="judul_makalah" class="form-control @error('judul_makalah') is-invalid @enderror"
                       value="{{ old('judul_makalah', $pengabdian->judul_makalah) }}" required>
                @error('judul_makalah')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="nama_temu_ilmiah" class="form-label">Nama Temu Ilmiah <span class="text-danger">*</span></label>
                        <input type="text" name="nama_temu_ilmiah" id="nama_temu_ilmiah" class="form-control @error('nama_temu_ilmiah') is-invalid @enderror"
                               value="{{ old('nama_temu_ilmiah', $pengabdian->nama_temu_ilmiah) }}" required>
                        @error('nama_temu_ilmiah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="penyelenggara" class="form-label">Penyelenggara <span class="text-danger">*</span></label>
                        <input type="text" name="penyelenggara" id="penyelenggara" class="form-control @error('penyelenggara') is-invalid @enderror"
                               value="{{ old('penyelenggara', $pengabdian->penyelenggara) }}" required>
                        @error('penyelenggara')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="tanggal_pelaksanaan" class="form-label">Tanggal Pelaksanaan <span class="text-danger">*</span></label>
                <input type="date" name="tanggal_pelaksanaan" id="tanggal_pelaksanaan" class="form-control @error('tanggal_pelaksanaan') is-invalid @enderror"
                       value="{{ old('tanggal_pelaksanaan', $pengabdian->tanggal_pelaksanaan) }}" required>
                @error('tanggal_pelaksanaan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update Kegiatan
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
    .alert-warning { background: #fff3cd; border: 1px solid #ffeaa7; color: #856404; padding: 12px; border-radius: 6px; }
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
