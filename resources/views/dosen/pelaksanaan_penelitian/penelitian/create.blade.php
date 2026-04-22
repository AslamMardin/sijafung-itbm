@extends('layouts.app')
@section('title', 'Input Penelitian')
@section('page-title', 'Input Penelitian')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form Input Penelitian</h3>
        <a href="{{ route('dosen.penelitian.index') }}" class="btn btn-outline btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <form action="{{ route('dosen.penelitian.store', 'penelitian') }}" method="POST">
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
                        <label for="tahun_pelaksanaan" class="form-label">Tahun Pelaksanaan <span class="text-danger">*</span></label>
                        <input type="number" name="tahun_pelaksanaan" id="tahun_pelaksanaan" class="form-control @error('tahun_pelaksanaan') is-invalid @enderror"
                               value="{{ old('tahun_pelaksanaan') }}" min="2000" max="{{ date('Y') + 1 }}" required placeholder="Contoh: 2025">
                        @error('tahun_pelaksanaan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="judul_kegiatan" class="form-label">Judul Kegiatan <span class="text-danger">*</span></label>
                <input type="text" name="judul_kegiatan" id="judul_kegiatan" class="form-control @error('judul_kegiatan') is-invalid @enderror"
                       value="{{ old('judul_kegiatan') }}" required placeholder="Judul kegiatan penelitian">
                @error('judul_kegiatan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="afiliasi" class="form-label">Afiliasi</label>
                <input type="text" name="afiliasi" id="afiliasi" class="form-control"
                       value="{{ old('afiliasi') }}" placeholder="Nama institusi/lembaga">
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label for="peran" class="form-label">Peran <span class="text-danger">*</span></label>
                        <select name="peran" id="peran" class="form-control @error('peran') is-invalid @enderror" required>
                            <option value="">Pilih Peran</option>
                            <option value="ketua" {{ old('peran') == 'ketua' ? 'selected' : '' }}>Ketua</option>
                            <option value="anggota" {{ old('peran') == 'anggota' ? 'selected' : '' }}>Anggota</option>
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
                               value="{{ old('jumlah_anggota') }}" min="0" placeholder="Jumlah anggota tim">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label for="lama_kegiatan_tahun" class="form-label">Lama Kegiatan (Tahun)</label>
                        <input type="number" name="lama_kegiatan_tahun" id="lama_kegiatan_tahun" class="form-control"
                               value="{{ old('lama_kegiatan_tahun') }}" min="0" step="0.5" placeholder="Durasi kegiatan">
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <div class="alert alert-info">
                <strong>Preview Angka Kredit:</strong> <span id="ak-preview">0.00</span> AK
                <br><small>AK akan dihitung ulang saat verifikasi admin</small>
            </div>
                    <div class="form-group mb-3">
                <label for="link_dokumen" class="form-label">Link Dokumen (Bukti Fisik)</label>
                <input type="url" name="link_dokumen" id="link_dokumen" class="form-control @error('link_dokumen') is-invalid @enderror" 
                       value="{{ old('link_dokumen') }}" placeholder="https://drive.google.com/...">
                @error('link_dokumen')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan Kegiatan
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
