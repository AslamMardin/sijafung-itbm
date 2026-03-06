{{-- resources/views/dosen/simulasi/create.blade.php --}}
@extends('layouts.app')
@section('title','Buat Simulasi AK')
@section('page-title','Simulasi Angka Kredit')

@section('content')
<div class="page-header">
    <div class="page-header-left">
        <h2>Buat Simulasi Angka Kredit</h2>
        <p>Hitung estimasi angka kredit berdasarkan kegiatan yang telah disetujui</p>
    </div>
    <a href="{{ route('dosen.simulasi.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px">
    <div class="card">
        <div class="card-header"><h3 class="card-title">Parameter Simulasi</h3></div>
        <div class="card-body">
            <form method="POST" action="{{ route('dosen.simulasi.store') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label">Nama Simulasi <span class="req">*</span></label>
                    <input type="text" name="nama_simulasi" class="form-control"
                        placeholder="cth: Simulasi Kenaikan ke Lektor Kepala 2024"
                        value="{{ old('nama_simulasi') }}" required>
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Periode Mulai <span class="req">*</span></label>
                        <input type="date" name="periode_mulai" class="form-control" value="{{ old('periode_mulai') }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Periode Selesai <span class="req">*</span></label>
                        <input type="date" name="periode_selesai" class="form-control" value="{{ old('periode_selesai') }}" required>
                    </div>
                </div>

                <div style="background:var(--maroon-pale);border-radius:8px;padding:14px;margin-bottom:18px">
                    <p style="font-size:0.82rem;color:var(--maroon)"><i class="fas fa-info-circle"></i>
                        Sistem akan menghitung angka kredit dari kegiatan berstatus <strong>Disetujui</strong> dalam periode yang ditentukan.
                    </p>
                </div>

                <button type="submit" class="btn btn-gold" style="width:100%">
                    <i class="fas fa-calculator"></i> Hitung Simulasi Sekarang
                </button>
            </form>
        </div>
    </div>

    <!-- Info Syarat Kenaikan -->
    <div class="card">
        <div class="card-header"><h3 class="card-title">📋 Syarat Kenaikan Jabatan</h3></div>
        <div class="card-body" style="padding:16px">
            @foreach(\App\Models\SimulasiAngkaKredit::syaratJabatan() as $jab => $syarat)
            <div style="padding:12px;border-radius:8px;background:{{ auth()->user()->jabatanBerikutnya()===$jab ? 'var(--maroon-pale)' : '#fafafa' }};border:1px solid {{ auth()->user()->jabatanBerikutnya()===$jab ? 'rgba(107,15,26,0.2)' : 'transparent' }};margin-bottom:10px">
                <div style="font-weight:600;font-size:0.88rem;color:var(--maroon-dark);margin-bottom:6px">
                    {{ $jab }}
                    @if(auth()->user()->jabatanBerikutnya()===$jab)
                    <span class="badge badge-maroon" style="margin-left:6px;font-size:0.65rem">TARGET ANDA</span>
                    @endif
                </div>
                <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:6px;font-size:0.78rem">
                    <div>Total AK: <strong>{{ $syarat['ak_minimal'] }}</strong></div>
                    <div>Pendidikan: <strong>>{{ $syarat['ak_pendidikan']['min'] }}</strong></div>
                    <div>Penelitian: <strong>>{{ $syarat['ak_penelitian']['min'] }}</strong></div>
                    <div>Pengabdian: <strong>>{{ $syarat['ak_pengabdian']['min'] }}</strong></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
