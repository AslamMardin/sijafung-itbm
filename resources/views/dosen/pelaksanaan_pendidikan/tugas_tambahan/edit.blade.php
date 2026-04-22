@extends('layouts.app')
@section('title', 'Edit Tugas Tambahan')
@section('page-title', 'Edit Tugas Tambahan')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form Edit Tugas Tambahan</h3>
        <a href="{{ route('dosen.pendidikan.index') }}" class="btn btn-outline btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <form action="{{ route('dosen.pendidikan.update', ['tugas_tambahan', $pendidikan]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="tanggal_mulai" class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control @error('tanggal_mulai') is-invalid @enderror"
                               value="{{ old('tanggal_mulai', $pendidikan->tanggal_mulai?->format('Y-m-d')) }}" required>
                        @error('tanggal_mulai')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control"
                               value="{{ old('tanggal_selesai', $pendidikan->tanggal_selesai?->format('Y-m-d')) }}">
                    </div>
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="tugas_tambahan" class="form-label">Tugas Tambahan <span class="text-danger">*</span></label>
                <input type="text" name="tugas_tambahan" id="tugas_tambahan" class="form-control @error('tugas_tambahan') is-invalid @enderror"
                       value="{{ old('tugas_tambahan', $pendidikan->tugas_tambahan) }}" required placeholder="Deskripsi tugas tambahan">
                @error('tugas_tambahan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="unit_kerja" class="form-label">Unit Kerja</label>
                        <input type="text" name="unit_kerja" id="unit_kerja" class="form-control"
                               value="{{ old('unit_kerja', $pendidikan->unit_kerja) }}" placeholder="Nama unit kerja">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="instansi" class="form-label">Instansi</label>
                        <input type="text" name="instansi" id="instansi" class="form-control"
                               value="{{ old('instansi', $pendidikan->instansi) }}" placeholder="Nama instansi">
                    </div>
                </div>
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
