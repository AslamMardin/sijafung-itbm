@extends('layouts.app')
@section('title','Input Kegiatan')
@section('page-title','Input Kegiatan')

@push('styles')
<style>
.ak-preview {
    background: linear-gradient(135deg, var(--maroon-dark), var(--maroon-mid));
    color: #fff;
    border-radius: var(--radius);
    padding: 22px 24px;
    margin-bottom: 20px;
}
.ak-preview h3 { font-family:'Playfair Display',serif;margin-bottom:8px; }
.ak-preview .val { font-size: 2.5rem; font-weight: 700; color: var(--gold); }
.ak-preview small { color: rgba(255,255,255,0.6); }
</style>
@endpush

@section('content')
<div class="page-header">
    <div class="page-header-left">
        <h2>Input Kegiatan Tri Dharma</h2>
        <p>Tambahkan kegiatan baru untuk diverifikasi admin</p>
    </div>
    <a href="{{ route('dosen.kegiatan.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>

<div style="display:grid;grid-template-columns:1fr 280px;gap:20px">
    <div class="card">
        <div class="card-header"><h3 class="card-title">Form Input Kegiatan</h3></div>
        <div class="card-body">
            <form method="POST" action="{{ route('dosen.kegiatan.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label class="form-label">Kategori Tri Dharma <span class="req">*</span></label>
                    <select name="kategori" id="kategori" class="form-select" required onchange="updateSubKategori()">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach(array_keys($subKategori) as $kat)
                        <option value="{{ $kat }}" {{ old('kategori')===$kat?'selected':'' }}>{{ $kat }}</option>
                        @endforeach
                    </select>
                    @error('kategori')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Sub Kategori <span class="req">*</span></label>
                    <select name="sub_kategori" id="sub_kategori" class="form-select" required onchange="setDefaultAK()">
                        <option value="">-- Pilih Kategori terlebih dahulu --</option>
                    </select>
                    @error('sub_kategori')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Nama Kegiatan <span class="req">*</span></label>
                    <input type="text" name="nama_kegiatan" class="form-control {{ $errors->has('nama_kegiatan') ? 'is-invalid' : '' }}"
                        placeholder="Judul/nama kegiatan secara lengkap" value="{{ old('nama_kegiatan') }}" required>
                    @error('nama_kegiatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Tanggal Mulai <span class="req">*</span></label>
                        <input type="date" name="tanggal_mulai" class="form-control" value="{{ old('tanggal_mulai') }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" class="form-control" value="{{ old('tanggal_selesai') }}">
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Institusi Penyelenggara</label>
                        <input type="text" name="institusi_penyelenggara" class="form-control" placeholder="Nama institusi" value="{{ old('institusi_penyelenggara') }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tingkat</label>
                        <select name="tingkat" class="form-select">
                            <option value="">-- Pilih --</option>
                            @foreach(['Lokal','Regional','Nasional','Internasional'] as $t)
                            <option value="{{ $t }}" {{ old('tingkat')===$t?'selected':'' }}>{{ $t }}</option>
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
                            <option value="{{ $p }}" {{ old('peran')===$p?'selected':'' }}>{{ $p }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Angka Kredit <span class="req">*</span></label>
                        <input type="number" name="angka_kredit" id="angka_kredit" class="form-control"
                            step="0.5" min="0" value="{{ old('angka_kredit', 0) }}" required
                            oninput="updatePreview()">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="3" placeholder="Penjelasan singkat tentang kegiatan ini...">{{ old('deskripsi') }}</textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Bukti Dokumen</label>
                    <input type="file" name="bukti_dokumen" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                    <small style="color:var(--text-muted);font-size:0.78rem">PDF/JPG/PNG, maks 5MB</small>
                </div>

                <div style="display:flex;gap:12px;padding-top:8px">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Kegiatan</button>
                    <a href="{{ route('dosen.kegiatan.index') }}" class="btn btn-outline">Batal</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Preview AK -->
    <div>
        <div class="ak-preview">
            <h3>Preview Angka Kredit</h3>
            <div class="val" id="ak-preview-val">0</div>
            <small>Angka Kredit yang akan diajukan</small>
        </div>

        <!-- Panduan AK -->
        <div class="card">
            <div class="card-header"><h3 class="card-title" style="font-size:0.9rem">📋 Referensi AK</h3></div>
            <div class="card-body" style="padding:14px 18px">
                <p style="font-size:0.8rem;color:var(--text-muted);margin-bottom:12px">Standar angka kredit per jenis kegiatan:</p>
                @foreach([
                    ['Jurnal Nasional','10'],
                    ['Jurnal Internasional','20'],
                    ['Jurnal Int. Bereputasi','40'],
                    ['Seminar Nasional','5'],
                    ['Seminar Internasional','10'],
                    ['Buku Diterbitkan','20'],
                    ['HKI/Paten','15'],
                    ['Mengajar S1/smt','0.5'],
                    ['Bimbing Skripsi','1'],
                    ['Bimbing Tesis','2'],
                ] as [$lbl,$val])
                <div style="display:flex;justify-content:space-between;padding:6px 0;border-bottom:1px solid rgba(107,15,26,0.06);font-size:0.8rem">
                    <span style="color:#555">{{ $lbl }}</span>
                    <strong style="color:var(--maroon)">{{ $val }}</strong>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
const subKategoriData = @json($subKategori);
const angkaStandar    = @json($angkaStandar);

function updateSubKategori() {
    const kat = document.getElementById('kategori').value;
    const sel = document.getElementById('sub_kategori');
    sel.innerHTML = '<option value="">-- Pilih Sub Kategori --</option>';
    if (kat && subKategoriData[kat]) {
        subKategoriData[kat].forEach(sub => {
            const opt = document.createElement('option');
            opt.value = sub; opt.textContent = sub;
            sel.appendChild(opt);
        });
    }
}

function setDefaultAK() {
    const sub = document.getElementById('sub_kategori').value;
    if (angkaStandar[sub]) {
        document.getElementById('angka_kredit').value = angkaStandar[sub];
        updatePreview();
    }
}

function updatePreview() {
    const val = parseFloat(document.getElementById('angka_kredit').value) || 0;
    document.getElementById('ak-preview-val').textContent = val.toFixed(1);
}

// Restore on old() values
document.addEventListener('DOMContentLoaded', () => {
    const kat = document.getElementById('kategori').value;
    if (kat) updateSubKategori();
    updatePreview();
});
</script>
@endpush
@endsection
