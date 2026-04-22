@extends('layouts.app')
@section('title', 'Edit Jabatan Struktural')
@section('page-title', 'Edit Jabatan Struktural')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form Edit Jabatan Struktural</h3>
        <a href="{{ route('dosen.pengabdian.index') }}" class="btn btn-outline btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
    
    <form action="{{ route('dosen.pengabdian.update', ['jabatan_struktural', $pengabdian]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group mb-3">
                <label for="jabatan_struktural" class="form-label">Jabatan Struktural <span class="text-danger">*</span></label>
                <input type="text" name="jabatan_struktural" id="jabatan_struktural" class="form-control @error('jabatan_struktural') is-invalid @enderror" 
                       value="{{ old('jabatan_struktural', $pengabdian->jabatan_struktural) }}" required>
                @error('jabatan_struktural')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="nomor_sk" class="form-label">Nomor SK</label>
                        <input type="text" name="nomor_sk" id="nomor_sk" class="form-control" 
                               value="{{ old('nomor_sk', $pengabdian->nomor_sk) }}">
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="terhitung" class="form-label">Terhitung</label>
                        <input type="date" name="terhitung" id="terhitung" class="form-control" 
                               value="{{ old('terhitung', $pengabdian->terhitung?->format('Y-m-d')) }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="tanggal_mulai" class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control @error('tanggal_mulai') is-invalid @enderror" 
                               value="{{ old('tanggal_mulai', $pengabdian->tanggal_mulai?->format('Y-m-d')) }}" required>
                        @error('tanggal_mulai')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="terhitung_tanggal_selesai" class="form-label">Terhitung Tanggal Selesai</label>
                        <input type="date" name="terhitung_tanggal_selesai" id="terhitung_tanggal_selesai" class="form-control" 
                               value="{{ old('terhitung_tanggal_selesai', $pengabdian->terhitung_tanggal_selesai?->format('Y-m-d')) }}">
                        <small class="text-muted">Kosongkan jika masih menjabat</small>
                    </div>
                </div>
            </div>

            <div class="alert alert-warning">
                <i class="fas fa-info-circle"></i> <strong>Status:</strong> <span class="badge badge-{{ $pengabdian->badge_color }}">{{ $pengabdian->status }}</span>
                @if($pengabdian->catatan_admin)
                    <br><strong>Catatan Admin:</strong> {{ $pengabdian->catatan_admin }}
                @endif
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
</style>
@endpush
