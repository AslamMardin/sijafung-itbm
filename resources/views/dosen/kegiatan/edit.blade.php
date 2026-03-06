@extends('layouts.app')
@section('title','Edit Kegiatan')
@section('page-title','Edit Kegiatan')

@section('content')
<div class="page-header">
    <div class="page-header-left">
        <h2>Edit Kegiatan</h2>
        <p>Perbarui data kegiatan yang masih berstatus Pending</p>
    </div>
    <a href="{{ route('dosen.kegiatan.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>

<div class="card">
    <div class="card-header"><h3 class="card-title">Form Edit Kegiatan</h3></div>
    <div class="card-body">
        <form method="POST" action="{{ route('dosen.kegiatan.update', $kegiatan) }}">
            @csrf @method('PUT')

            <div class="form-group">
                <label class="form-label">Kategori Tri Dharma <span class="req">*</span></label>
                <select name="kategori" id="kategori" class="form-select" required onchange="updateSubKategori()">
                    @foreach(array_keys($subKategori) as $kat)
                    <option value="{{ $kat }}" {{ old('kategori',$kegiatan->kategori)===$kat?'selected':'' }}>{{ $kat }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Sub Kategori <span class="req">*</span></label>
                <select name="sub_kategori" id="sub_kategori" class="form-select" required onchange="setDefaultAK()">
                    @foreach($subKategori[$kegiatan->kategori] ?? [] as $sub)
                    <option value="{{ $sub }}" {{ old('sub_kategori',$kegiatan->sub_kategori)===$sub?'selected':'' }}>{{ $sub }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Nama Kegiatan <span class="req">*</span></label>
                <input type="text" name="nama_kegiatan" class="form-control"
                    value="{{ old('nama_kegiatan', $kegiatan->nama_kegiatan) }}" required>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Tanggal Mulai <span class="req">*</span></label>
                    <input type="date" name="tanggal_mulai" class="form-control"
                        value="{{ old('tanggal_mulai', $kegiatan->tanggal_mulai->format('Y-m-d')) }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" class="form-control"
                        value="{{ old('tanggal_selesai', $kegiatan->tanggal_selesai?->format('Y-m-d')) }}">
                </div>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Institusi Penyelenggara</label>
                    <input type="text" name="institusi_penyelenggara" class="form-control"
                        value="{{ old('institusi_penyelenggara', $kegiatan->institusi_penyelenggara) }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Tingkat</label>
                    <select name="tingkat" class="form-select">
                        <option value="">-- Pilih --</option>
                        @foreach(['Lokal','Regional','Nasional','Internasional'] as $t)
                        <option value="{{ $t }}" {{ old('tingkat',$kegiatan->tingkat)===$t?'selected':'' }}>{{ $t }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Peran</label>
                    <select name="peran" class="form-select">
                        <option value="">-- Pilih --</option>
                        @foreach(['Ketua','Anggota','Pemakalah','Peserta','Instruktur','Narasumber','Reviewer'] as $p)
                        <option value="{{ $p }}" {{ old('peran',$kegiatan->peran)===$p?'selected':'' }}>{{ $p }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Angka Kredit <span class="req">*</span></label>
                    <input type="number" name="angka_kredit" id="angka_kredit" class="form-control"
                        step="0.5" min="0" value="{{ old('angka_kredit', $kegiatan->angka_kredit) }}" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $kegiatan->deskripsi) }}</textarea>
            </div>

            <div style="display:flex;gap:12px;padding-top:6px">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Perbarui Kegiatan</button>
                <a href="{{ route('dosen.kegiatan.index') }}" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
const subKategoriData = @json($subKategori);
const angkaStandar    = @json($angkaStandar);
function updateSubKategori() {
    const kat = document.getElementById('kategori').value;
    const sel = document.getElementById('sub_kategori');
    const current = '{{ $kegiatan->sub_kategori }}';
    sel.innerHTML = '';
    if (kat && subKategoriData[kat]) {
        subKategoriData[kat].forEach(sub => {
            const opt = document.createElement('option');
            opt.value = sub; opt.textContent = sub;
            if (sub === current) opt.selected = true;
            sel.appendChild(opt);
        });
    }
}
function setDefaultAK() {
    const sub = document.getElementById('sub_kategori').value;
    if (angkaStandar[sub]) document.getElementById('angka_kredit').value = angkaStandar[sub];
}
</script>
@endpush
@endsection
