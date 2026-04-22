@extends('layouts.app')
@section('title', 'Input Pengajaran')
@section('page-title', 'Input Pengajaran')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form Input Pengajaran</h3>
        <a href="{{ route('dosen.pendidikan.index') }}" class="btn btn-outline btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
    
    <form action="{{ route('dosen.pendidikan.store', 'pengajaran') }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="mata_kuliah" class="form-label">Mata Kuliah <span class="text-danger">*</span></label>
                        <input type="text" name="mata_kuliah" id="mata_kuliah" class="form-control @error('mata_kuliah') is-invalid @enderror" 
                               value="{{ old('mata_kuliah') }}" required placeholder="Contoh: Pemrograman Web">
                        @error('mata_kuliah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="jenis_mata_kuliah" class="form-label">Jenis Mata Kuliah</label>
                        <select name="jenis_mata_kuliah" id="jenis_mata_kuliah" class="form-control">
                            <option value="">Pilih Jenis</option>
                            <option value="Wajib" {{ old('jenis_mata_kuliah') == 'Wajib' ? 'selected' : '' }}>Wajib</option>
                            <option value="Pilihan" {{ old('jenis_mata_kuliah') == 'Pilihan' ? 'selected' : '' }}>Pilihan</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="bidang_keilmuan" class="form-label">Bidang Keilmuan</label>
                        <input type="text" name="bidang_keilmuan" id="bidang_keilmuan" class="form-control" 
                               value="{{ old('bidang_keilmuan') }}" placeholder="Contoh: Teknik Informatika">
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="kelas" class="form-label">Kelas</label>
                        <input type="text" name="kelas" id="kelas" class="form-control" 
                               value="{{ old('kelas') }}" placeholder="Contoh: TI-2A">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label for="sks" class="form-label">SKS <span class="text-danger">*</span></label>
                        <input type="number" name="sks" id="sks" class="form-control @error('sks') is-invalid @enderror" 
                               value="{{ old('sks') }}" min="1" max="10" required placeholder="Jumlah SKS">
                        @error('sks')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label for="jumlah_mahasiswa" class="form-label">Jumlah Mahasiswa</label>
                        <input type="number" name="jumlah_mahasiswa" id="jumlah_mahasiswa" class="form-control" 
                               value="{{ old('jumlah_mahasiswa') }}" min="0" placeholder="Jumlah mahasiswa">
                    </div>
                </div>
                
                <div class="col-md-4">
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
    .form-label .text-danger {
        color: #dc3545;
    }
    .card-footer {
        background: transparent;
        border-top: 1px solid rgba(0,0,0,0.1);
        padding: 16px;
    }
</style>
@endpush
