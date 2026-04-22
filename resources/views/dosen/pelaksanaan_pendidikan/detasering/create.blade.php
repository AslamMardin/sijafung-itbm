@extends('layouts.app')
@section('title', 'Input Detasering')
@section('page-title', 'Input Detasering')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form Input Detasering</h3>
        <a href="{{ route('dosen.pendidikan.index') }}" class="btn btn-outline btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <form action="{{ route('dosen.pendidikan.store', 'detasering') }}" method="POST">
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
                        <label for="tanggal_sk_penugasan" class="form-label">Tanggal SK Penugasan</label>
                        <input type="date" name="tanggal_sk_penugasan" id="tanggal_sk_penugasan" class="form-control"
                               value="{{ old('tanggal_sk_penugasan') }}">
                    </div>
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="perguruan_tinggi_sasaran" class="form-label">Perguruan Tinggi Sasaran <span class="text-danger">*</span></label>
                <input type="text" name="perguruan_tinggi_sasaran" id="perguruan_tinggi_sasaran" class="form-control @error('perguruan_tinggi_sasaran') is-invalid @enderror"
                       value="{{ old('perguruan_tinggi_sasaran') }}" required placeholder="Nama perguruan tinggi sasaran">
                @error('perguruan_tinggi_sasaran')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="deskripsi_kegiatan" class="form-label">Deskripsi Kegiatan <span class="text-danger">*</span></label>
                <textarea name="deskripsi_kegiatan" id="deskripsi_kegiatan" rows="4"
                          class="form-control @error('deskripsi_kegiatan') is-invalid @enderror"
                          required placeholder="Deskripsi kegiatan detasering">{{ old('deskripsi_kegiatan') }}</textarea>
                @error('deskripsi_kegiatan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="metode_pelaksanaan" class="form-label">Metode Pelaksanaan</label>
                        <input type="text" name="metode_pelaksanaan" id="metode_pelaksanaan" class="form-control"
                               value="{{ old('metode_pelaksanaan') }}" placeholder="Metode pelaksanaan">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="nomor_sk_penugasan" class="form-label">Nomor SK Penugasan</label>
                        <input type="text" name="nomor_sk_penugasan" id="nomor_sk_penugasan" class="form-control"
                               value="{{ old('nomor_sk_penugasan') }}" placeholder="Nomor SK penugasan">
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
