@extends('layouts.app')
@section('title','Edit Dosen')
@section('page-title','Edit Data Dosen')

@section('content')
<div class="page-header">
    <div class="page-header-left">
        <h2>Edit Dosen: {{ $dosen->name }}</h2>
    </div>
    <a href="{{ route('admin.dosen.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>

<div class="card">
    <div class="card-header"><h3 class="card-title">Perbarui Data Dosen</h3></div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.dosen.update', $dosen) }}">
            @csrf @method('PUT')
            <div class="form-grid">
                <div class="form-group col-span-2">
                    <label class="form-label">Nama Lengkap <span class="req">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $dosen->name) }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Email <span class="req">*</span></label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $dosen->email) }}" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">NIP</label>
                    <input type="text" name="nip" class="form-control" value="{{ old('nip', $dosen->nip) }}">
                </div>
                <div class="form-group">
                    <label class="form-label">NIDN</label>
                    <input type="text" name="nidn" class="form-control" value="{{ old('nidn', $dosen->nidn) }}">
                </div>
                <div class="form-group">
                    <label class="form-label">AK Kumulatif</label>
                    <input type="number" name="angka_kredit_kumulatif" class="form-control" step="0.01" min="0"
                        value="{{ old('angka_kredit_kumulatif', $dosen->angka_kredit_kumulatif) }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Program Studi</label>
                    <input type="text" name="prodi" class="form-control" value="{{ old('prodi', $dosen->prodi) }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Fakultas</label>
                    <input type="text" name="fakultas" class="form-control" value="{{ old('fakultas', $dosen->fakultas) }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Jabatan Fungsional</label>
                    <select name="jabatan_fungsional" class="form-select">
                        <option value="">-- Pilih --</option>
                        @foreach(['Asisten Ahli','Lektor','Lektor Kepala','Profesor'] as $jab)
                        <option value="{{ $jab }}" {{ old('jabatan_fungsional', $dosen->jabatan_fungsional)===$jab?'selected':'' }}>{{ $jab }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Pangkat / Golongan</label>
                    <input type="text" name="pangkat_golongan" class="form-control"
                        value="{{ old('pangkat_golongan', $dosen->pangkat_golongan) }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Password Baru <small style="font-weight:400;color:var(--text-muted)">(kosongkan jika tidak diubah)</small></label>
                    <input type="password" name="password" class="form-control">
                </div>
                <div class="form-group">
                    <label class="form-label">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>
            </div>
            <div style="display:flex;gap:12px;padding-top:6px">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Perbarui Data</button>
                <a href="{{ route('admin.dosen.index') }}" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
