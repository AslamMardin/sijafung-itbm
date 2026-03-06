@extends('layouts.app')
@section('title','Detail Kegiatan')
@section('page-title','Detail Kegiatan')

@section('content')
<div class="page-header">
    <div class="page-header-left">
        <h2>Detail & Verifikasi Kegiatan</h2>
    </div>
    <a href="{{ route('admin.kegiatan.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>

<div style="display:grid;grid-template-columns:2fr 1fr;gap:20px">
    <div>
        <!-- Detail Kegiatan -->
        <div class="card" style="margin-bottom:20px">
            <div class="card-header">
                <h3 class="card-title">{{ $kegiatan->nama_kegiatan }}</h3>
                <span class="badge badge-{{ $kegiatan->badge_color }} " style="font-size:0.82rem">{{ $kegiatan->status }}</span>
            </div>
            <div class="card-body">
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
                    <div>
                        <div style="font-size:0.75rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.06em;margin-bottom:4px">Kategori</div>
                        <div style="font-weight:600">{{ $kegiatan->kategori_icon }} {{ $kegiatan->kategori }}</div>
                    </div>
                    <div>
                        <div style="font-size:0.75rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.06em;margin-bottom:4px">Sub Kategori</div>
                        <div style="font-weight:500">{{ $kegiatan->sub_kategori }}</div>
                    </div>
                    <div>
                        <div style="font-size:0.75rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.06em;margin-bottom:4px">Tanggal Mulai</div>
                        <div>{{ $kegiatan->tanggal_mulai->format('d F Y') }}</div>
                    </div>
                    <div>
                        <div style="font-size:0.75rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.06em;margin-bottom:4px">Tanggal Selesai</div>
                        <div>{{ $kegiatan->tanggal_selesai ? $kegiatan->tanggal_selesai->format('d F Y') : '-' }}</div>
                    </div>
                    @if($kegiatan->institusi_penyelenggara)
                    <div>
                        <div style="font-size:0.75rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.06em;margin-bottom:4px">Institusi</div>
                        <div>{{ $kegiatan->institusi_penyelenggara }}</div>
                    </div>
                    @endif
                    @if($kegiatan->tingkat)
                    <div>
                        <div style="font-size:0.75rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.06em;margin-bottom:4px">Tingkat</div>
                        <div>{{ $kegiatan->tingkat }}</div>
                    </div>
                    @endif
                    @if($kegiatan->peran)
                    <div>
                        <div style="font-size:0.75rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.06em;margin-bottom:4px">Peran</div>
                        <div>{{ $kegiatan->peran }}</div>
                    </div>
                    @endif
                    <div>
                        <div style="font-size:0.75rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.06em;margin-bottom:4px">Angka Kredit Diajukan</div>
                        <div style="font-size:1.4rem;font-weight:700;color:var(--maroon)">{{ $kegiatan->angka_kredit }}</div>
                    </div>
                </div>

                @if($kegiatan->deskripsi)
                <div style="margin-top:16px;padding-top:16px;border-top:1px solid rgba(107,15,26,0.08)">
                    <div style="font-size:0.75rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.06em;margin-bottom:6px">Deskripsi</div>
                    <p style="font-size:0.88rem;line-height:1.6;color:#333">{{ $kegiatan->deskripsi }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Verifikasi Form -->
        @if($kegiatan->status === 'Pending')
        <div class="card">
            <div class="card-header"><h3 class="card-title">Verifikasi Kegiatan</h3></div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.kegiatan.approve', $kegiatan) }}">
                    @csrf @method('PATCH')
                    <div class="form-group">
                        <label class="form-label">Keputusan Verifikasi</label>
                        <div style="display:flex;gap:12px">
                            <label style="display:flex;align-items:center;gap:8px;padding:12px 18px;border:2px solid #ecd8db;border-radius:8px;cursor:pointer;flex:1;transition:all 0.2s" id="label-approve">
                                <input type="radio" name="status" value="Disetujui" required onchange="highlightChoice(this)">
                                <span style="font-weight:600;color:#1a7a45">✅ Setujui Kegiatan</span>
                            </label>
                            <label style="display:flex;align-items:center;gap:8px;padding:12px 18px;border:2px solid #ecd8db;border-radius:8px;cursor:pointer;flex:1;transition:all 0.2s" id="label-reject">
                                <input type="radio" name="status" value="Ditolak" onchange="highlightChoice(this)">
                                <span style="font-weight:600;color:#a82010">❌ Tolak Kegiatan</span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Catatan Admin (opsional)</label>
                        <textarea name="catatan_admin" class="form-control" rows="3"
                            placeholder="Berikan catatan atau alasan keputusan verifikasi...">{{ old('catatan_admin', $kegiatan->catatan_admin) }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Simpan Keputusan</button>
                </form>
            </div>
        </div>
        @elseif($kegiatan->catatan_admin)
        <div class="card">
            <div class="card-header"><h3 class="card-title">Catatan Admin</h3></div>
            <div class="card-body">
                <p>{{ $kegiatan->catatan_admin }}</p>
            </div>
        </div>
        @endif
    </div>

    <!-- Sidebar: Info Dosen -->
    <div>
        <div class="card">
            <div class="card-header"><h3 class="card-title">Info Dosen</h3></div>
            <div class="card-body">
                <div style="text-align:center;padding-bottom:16px;border-bottom:1px solid rgba(107,15,26,0.08);margin-bottom:16px">
                    <div style="width:60px;height:60px;background:var(--maroon);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:1.5rem;font-weight:700;color:#fff;margin:0 auto 10px">
                        {{ strtoupper(substr($kegiatan->user->name, 0, 2)) }}
                    </div>
                    <div style="font-weight:600">{{ $kegiatan->user->name }}</div>
                    <div style="font-size:0.8rem;color:var(--text-muted)">{{ $kegiatan->user->jabatan_fungsional }}</div>
                </div>

                @foreach(['NIP'=>$kegiatan->user->nip,'NIDN'=>$kegiatan->user->nidn,'Program Studi'=>$kegiatan->user->prodi,'Fakultas'=>$kegiatan->user->fakultas,'Pangkat/Gol.'=>$kegiatan->user->pangkat_golongan] as $label=>$val)
                @if($val)
                <div style="margin-bottom:10px">
                    <div style="font-size:0.73rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.05em">{{ $label }}</div>
                    <div style="font-weight:500;font-size:0.88rem">{{ $val }}</div>
                </div>
                @endif
                @endforeach

                <div style="margin-top:14px;padding:14px;background:var(--maroon-pale);border-radius:8px;text-align:center">
                    <div style="font-size:0.75rem;color:var(--text-muted);margin-bottom:4px">AK Kumulatif</div>
                    <div style="font-size:1.6rem;font-weight:700;color:var(--maroon)">{{ number_format($kegiatan->user->angka_kredit_kumulatif,1) }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function highlightChoice(el) {
    document.getElementById('label-approve').style.borderColor = '#e0d0d3';
    document.getElementById('label-reject').style.borderColor = '#e0d0d3';
    if (el.value === 'Disetujui') {
        document.getElementById('label-approve').style.borderColor = '#1a7a45';
        document.getElementById('label-approve').style.background = '#edfaf3';
    } else {
        document.getElementById('label-reject').style.borderColor = '#a82010';
        document.getElementById('label-reject').style.background = '#fdf0ef';
    }
}
</script>
@endsection
