@extends('layouts.app')
@section('title', 'Edit Publikasi Karya')
@section('page-title', 'Edit Publikasi Karya')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form Edit Publikasi Karya</h3>
        <a href="{{ route('dosen.penelitian.index') }}" class="btn btn-outline btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <form action="{{ route('dosen.penelitian.update', ['publikasi_karya', $penelitian]) }}" method="POST">
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
                                <option value="{{ $kat['id'] }}" data-ak="{{ $kat['angka_kredit'] }}" {{ old('kategori_kegiatan_id', $penelitian->kategori_kegiatan_id) == $kat['id'] ? 'selected' : '' }}>
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
                               value="{{ old('tanggal_terbit', $penelitian->tanggal_terbit) }}" required>
                        @error('tanggal_terbit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="judul_kegiatan" class="form-label">Judul Kegiatan <span class="text-danger">*</span></label>
                <input type="text" name="judul_kegiatan" id="judul_kegiatan" class="form-control @error('judul_kegiatan') is-invalid @enderror"
                       value="{{ old('judul_kegiatan', $penelitian->judul_kegiatan) }}" required>
                @error('judul_kegiatan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="jenis_publikasi" class="form-label">Jenis Publikasi <span class="text-danger">*</span></label>
                        <select name="jenis_publikasi" id="jenis_publikasi" class="form-control @error('jenis_publikasi') is-invalid @enderror" required>
                            <option value="">Pilih Jenis Publikasi</option>
                            <option value="Jurnal nasional terakreditasi" {{ old('jenis_publikasi', $penelitian->jenis_publikasi) == 'Jurnal nasional terakreditasi' ? 'selected' : '' }}>Jurnal Nasional Terakreditasi</option>
                            <option value="Buku referensi" {{ old('jenis_publikasi', $penelitian->jenis_publikasi) == 'Buku referensi' ? 'selected' : '' }}>Buku Referensi</option>
                            <option value="Prosiding" {{ old('jenis_publikasi', $penelitian->jenis_publikasi) == 'Prosiding' ? 'selected' : '' }}>Prosiding</option>
                            <option value="Lainnya" {{ old('jenis_publikasi', $penelitian->jenis_publikasi) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('jenis_publikasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="peran_penulis" class="form-label">Peran Penulis <span class="text-danger">*</span></label>
                        <select name="peran_penulis" id="peran_penulis" class="form-control @error('peran_penulis') is-invalid @enderror" required>
                            <option value="">Pilih Peran</option>
                            <option value="penulis" {{ old('peran_penulis', $penelitian->peran_penulis) == 'penulis' ? 'selected' : '' }}>Penulis</option>
                            <option value="editor" {{ old('peran_penulis', $penelitian->peran_penulis) == 'editor' ? 'selected' : '' }}>Editor</option>
                            <option value="penerjemah" {{ old('peran_penulis', $penelitian->peran_penulis) == 'penerjemah' ? 'selected' : '' }}>Penerjemah</option>
                        </select>
                        @error('peran_penulis')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="jumlah_anggota" class="form-label">Jumlah Anggota</label>
                <input type="number" name="jumlah_anggota" id="jumlah_anggota" class="form-control"
                       value="{{ old('jumlah_anggota', $penelitian->jumlah_anggota) }}" min="0">
            </div>

            <hr class="my-4">

            <div class="alert alert-warning">
                <i class="fas fa-info-circle"></i> <strong>Status:</strong> <span class="badge badge-{{ $penelitian->badge_color }}">{{ $penelitian->status }}</span>
                @if($penelitian->catatan_admin)
                    <br><strong>Catatan Admin:</strong> {{ $penelitian->catatan_admin }}
                @endif
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update Kegiatan
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
