@extends('layouts.app')
@section('title', 'Edit Pengujian Mahasiswa')
@section('page-title', 'Edit Pengujian Mahasiswa')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form Edit Pengujian Mahasiswa</h3>
        <a href="{{ route('dosen.pendidikan.index') }}" class="btn btn-outline btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <form action="{{ route('dosen.pendidikan.update', ['pengujian', $pendidikan]) }}" method="POST">
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
                        <label for="semester" class="form-label">Semester <span class="text-danger">*</span></label>
                        <input type="text" name="semester" id="semester" class="form-control @error('semester') is-invalid @enderror"
                               value="{{ old('semester', $pendidikan->semester) }}" required placeholder="Contoh: 2024/2025 Genap">
                        @error('semester')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="judul_pengujian" class="form-label">Judul Pengujian <span class="text-danger">*</span></label>
                <input type="text" name="judul_pengujian" id="judul_pengujian" class="form-control @error('judul_pengujian') is-invalid @enderror"
                       value="{{ old('judul_pengujian', $pendidikan->judul_pengujian) }}" required placeholder="Judul skripsi/tesis/disertasi yang diuji">
                @error('judul_pengujian')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="bidang_keilmuan" class="form-label">Bidang Keilmuan</label>
                        <input type="text" name="bidang_keilmuan" id="bidang_keilmuan" class="form-control"
                               value="{{ old('bidang_keilmuan', $pendidikan->bidang_keilmuan) }}" placeholder="Contoh: Teknik Informatika">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="jenis_pengujian" class="form-label">Jenis Pengujian</label>
                        <select name="jenis_pengujian" id="jenis_pengujian" class="form-control">
                            <option value="">Pilih Jenis</option>
                            <option value="Skripsi" {{ old('jenis_pengujian', $pendidikan->jenis_pengujian) == 'Skripsi' ? 'selected' : '' }}>Skripsi</option>
                            <option value="Tesis" {{ old('jenis_pengujian', $pendidikan->jenis_pengujian) == 'Tesis' ? 'selected' : '' }}>Tesis</option>
                            <option value="Disertasi" {{ old('jenis_pengujian', $pendidikan->jenis_pengujian) == 'Disertasi' ? 'selected' : '' }}>Disertasi</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="program_studi" class="form-label">Program Studi</label>
                <input type="text" name="program_studi" id="program_studi" class="form-control"
                       value="{{ old('program_studi', $pendidikan->program_studi) }}" placeholder="Nama program studi">
            </div>

            <div class="alert alert-warning">
                <i class="fas fa-info-circle"></i> <strong>Status:</strong> <span class="badge badge-{{ $pendidikan->badge_color }}">{{ $pendidikan->status }}</span>
                @if($pendidikan->catatan_admin)
                    <br><strong>Catatan Admin:</strong> {{ $pendidikan->catatan_admin }}
                @endif
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
