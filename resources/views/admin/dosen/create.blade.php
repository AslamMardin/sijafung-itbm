{{-- resources/views/admin/dosen/create.blade.php --}}
@extends('layouts.app')
@section('title','Tambah Dosen')
@section('page-title','Tambah Dosen')

@section('content')
<div class="page-header">
    <div class="page-header-left">
        <h2>Tambah Dosen Baru</h2>
    </div>
    <a href="{{ route('admin.dosen.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>

<div class="card">
    <div class="card-header"><h3 class="card-title">Data Dosen</h3></div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.dosen.store') }}">
            @csrf
            <div class="form-grid">
                <div class="form-group col-span-2">
                    <label class="form-label">Nama Lengkap <span class="req">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Email <span class="req">*</span></label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">NIP</label>
                    <input type="text" name="nip" class="form-control" value="{{ old('nip') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">NIDN</label>
                    <input type="text" name="nidn" class="form-control" value="{{ old('nidn') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Password <span class="req">*</span></label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Konfirmasi Password <span class="req">*</span></label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Program Studi</label>
                    <input type="text" name="prodi" class="form-control" value="{{ old('prodi') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Fakultas</label>
                    <input type="text" name="fakultas" class="form-control" value="{{ old('fakultas') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Jabatan Fungsional</label>
                    <select name="jabatan_fungsional" class="form-select">
                        <option value="">-- Pilih --</option>
                        @foreach(['Asisten Ahli','Lektor','Lektor Kepala','Profesor'] as $jab)
                        <option value="{{ $jab }}" {{ old('jabatan_fungsional')===$jab?'selected':'' }}>{{ $jab }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Pangkat / Golongan</label>
                    <input type="text" name="pangkat_golongan" class="form-control" value="{{ old('pangkat_golongan') }}" placeholder="cth: Penata / III-c">
                </div>
            </div>
            <div style="display:flex;gap:12px;padding-top:6px">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Dosen</button>
                <a href="{{ route('admin.dosen.index') }}" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection


{{-- resources/views/admin/dosen/edit.blade.php --}}
{{--
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
    <div class="card-body">
        <form method="POST" action="{{ route('admin.dosen.update',$dosen) }}">
            @csrf @method('PUT')
            [same fields as create with $dosen->field values]
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
@endsection
--}}
