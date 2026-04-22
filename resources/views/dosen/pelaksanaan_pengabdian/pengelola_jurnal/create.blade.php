@extends('layouts.app')
@section('title', 'Input Pengelola Jurnal')
@section('page-title', 'Input Pengelola Jurnal')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form Input Pengelola Jurnal</h3>
        <a href="{{ route('dosen.pengabdian.index') }}" class="btn btn-outline btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
    
    <form action="{{ route('dosen.pengabdian.store', 'pengelola_jurnal') }}" method="POST">
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
                        <label for="nama_jurnal" class="form-label">Nama Jurnal <span class="text-danger">*</span></label>
                        <input type="text" name="nama_jurnal" id="nama_jurnal" class="form-control @error('nama_jurnal') is-invalid @enderror" 
                               value="{{ old('nama_jurnal') }}" required placeholder="Nama jurnal ilmiah">
                        @error('nama_jurnal')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="no_sk_penugasan" class="form-label">No. SK Penugasan</label>
                        <input type="text" name="no_sk_penugasan" id="no_sk_penugasan" class="form-control" 
                               value="{{ old('no_sk_penugasan') }}" placeholder="Nomor SK penugasan">
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="peran_jurnal" class="form-label">Peran <span class="text-danger">*</span></label>
                        <select name="peran_jurnal" id="peran_jurnal" class="form-control @error('peran_jurnal') is-invalid @enderror" required>
                            <option value="">Pilih Peran</option>
                            <option value="Editor" {{ old('peran_jurnal') == 'Editor' ? 'selected' : '' }}>Editor</option>
                            <option value="Dewan Penyunting" {{ old('peran_jurnal') == 'Dewan Penyunting' ? 'selected' : '' }}>Dewan Penyunting</option>
                            <option value="Dewan Redaksi" {{ old('peran_jurnal') == 'Dewan Redaksi' ? 'selected' : '' }}>Dewan Redaksi</option>
                        </select>
                        @error('peran_jurnal')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="terhitung_mulai" class="form-label">Terhitung Mulai Tanggal <span class="text-danger">*</span></label>
                        <input type="date" name="terhitung_mulai" id="terhitung_mulai" class="form-control @error('terhitung_mulai') is-invalid @enderror" 
                               value="{{ old('terhitung_mulai') }}" required>
                        @error('terhitung_mulai')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control" 
                               value="{{ old('tanggal_selesai') }}">
                        <small class="text-muted">Kosongkan jika masih aktif</small>
                    </div>
                </div>
            </div>

            <div class="form-group mb-3">
                <div class="form-check">
                    <input type="hidden" name="status_aktif" value="0">
                    <input type="checkbox" name="status_aktif" id="status_aktif" class="form-check-input" value="1" {{ old('status_aktif', true) ? 'checked' : '' }}>
                    <label for="status_aktif" class="form-check-label">Status Aktif</label>
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
