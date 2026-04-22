@extends('layouts.app')
@section('title', 'Edit Orasi Ilmiah')
@section('page-title', 'Edit Orasi Ilmiah')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form Edit Orasi Ilmiah</h3>
        <a href="{{ route('dosen.pendidikan.index') }}" class="btn btn-outline btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <form action="{{ route('dosen.pendidikan.update', ['orasi_ilmiah', $pendidikan]) }}" method="POST">
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
                        <label for="tanggal_mulai" class="form-label">Tanggal Pelaksanaan <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control @error('tanggal_mulai') is-invalid @enderror"
                               value="{{ old('tanggal_mulai', $pendidikan->tanggal_mulai?->format('Y-m-d')) }}" required>
                        @error('tanggal_mulai')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="judul_makalah" class="form-label">Judul Makalah <span class="text-danger">*</span></label>
                <input type="text" name="judul_makalah" id="judul_makalah" class="form-control @error('judul_makalah') is-invalid @enderror"
                       value="{{ old('judul_makalah', $pendidikan->judul_makalah) }}" required placeholder="Judul makalah orasi ilmiah">
                @error('judul_makalah')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="nama_pertemuan_ilmiah" class="form-label">Nama Pertemuan Ilmiah <span class="text-danger">*</span></label>
                        <input type="text" name="nama_pertemuan_ilmiah" id="nama_pertemuan_ilmiah" class="form-control @error('nama_pertemuan_ilmiah') is-invalid @enderror"
                               value="{{ old('nama_pertemuan_ilmiah', $pendidikan->nama_pertemuan_ilmiah) }}" required placeholder="Nama pertemuan ilmiah">
                        @error('nama_pertemuan_ilmiah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="penyelenggara" class="form-label">Penyelenggara <span class="text-danger">*</span></label>
                        <input type="text" name="penyelenggara" id="penyelenggara" class="form-control @error('penyelenggara') is-invalid @enderror"
                               value="{{ old('penyelenggara', $pendidikan->penyelenggara) }}" required placeholder="Nama penyelenggara">
                        @error('penyelenggara')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="kategori_pembicara" class="form-label">Kategori Pembicara</label>
                <input type="text" name="kategori_pembicara" id="kategori_pembicara" class="form-control"
                       value="{{ old('kategori_pembicara', $pendidikan->kategori_pembicara) }}" placeholder="Kategori pembicara">
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
