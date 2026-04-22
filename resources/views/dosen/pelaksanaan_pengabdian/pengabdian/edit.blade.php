@extends('layouts.app')
@section('title', 'Edit Pengabdian')
@section('page-title', 'Edit Pengabdian')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form Edit Pengabdian</h3>
        <a href="{{ route('dosen.pengabdian.index') }}" class="btn btn-outline btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <form action="{{ route('dosen.pengabdian.update', ['pengabdian', $pengabdian]) }}" method="POST">
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
                        <label for="tahun_pelaksanaan" class="form-label">Tahun Pelaksanaan <span class="text-danger">*</span></label>
                        <input type="number" name="tahun_pelaksanaan" id="tahun_pelaksanaan" class="form-control @error('tahun_pelaksanaan') is-invalid @enderror"
                               value="{{ old('tahun_pelaksanaan', $pengabdian->tahun_pelaksanaan) }}" min="2000" max="{{ date('Y') + 1 }}" required>
                        @error('tahun_pelaksanaan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="judul_kegiatan" class="form-label">Judul Kegiatan <span class="text-danger">*</span></label>
                <input type="text" name="judul_kegiatan" id="judul_kegiatan" class="form-control @error('judul_kegiatan') is-invalid @enderror"
                       value="{{ old('judul_kegiatan', $pengabdian->judul_kegiatan) }}" required>
                @error('judul_kegiatan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="afiliasi" class="form-label">Afiliasi</label>
                <input type="text" name="afiliasi" id="afiliasi" class="form-control"
                       value="{{ old('afiliasi', $pengabdian->afiliasi) }}">
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label for="peran" class="form-label">Peran <span class="text-danger">*</span></label>
                        <select name="peran" id="peran" class="form-control @error('peran') is-invalid @enderror" required>
                            <option value="">Pilih Peran</option>
                            <option value="ketua" {{ old('peran', $pengabdian->peran) == 'ketua' ? 'selected' : '' }}>Ketua</option>
                            <option value="anggota" {{ old('peran', $pengabdian->peran) == 'anggota' ? 'selected' : '' }}>Anggota</option>
                        </select>
                        @error('peran')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label for="jumlah_anggota" class="form-label">Jumlah Anggota</label>
                        <input type="number" name="jumlah_anggota" id="jumlah_anggota" class="form-control"
                               value="{{ old('jumlah_anggota', $pengabdian->jumlah_anggota) }}" min="0">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label for="lama_kegiatan_tahun" class="form-label">Lama Kegiatan (Tahun)</label>
                        <input type="number" name="lama_kegiatan_tahun" id="lama_kegiatan_tahun" class="form-control"
                               value="{{ old('lama_kegiatan_tahun', $pengabdian->lama_kegiatan_tahun) }}" min="0" step="0.5">
                    </div>
                </div>
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
