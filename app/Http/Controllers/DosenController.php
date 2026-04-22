<?php

namespace App\Http\Controllers;

use App\Models\KegiatanTriDharma;
use App\Models\SimulasiAngkaKredit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DosenController extends Controller
{
    protected function user()
    {
        return Auth::user();
    }

    public function dashboard()
    {
        $user    = $this->user();
        $akPerKategori = $user->angkaKreditPerKategori();

        $pendidikanCount = $user->pelaksanaanPendidikan()->count();
        $penelitianCount = $user->pelaksanaanPenelitian()->count();
        $pengabdianCount = $user->pelaksanaanPengabdian()->count();

        $pendidikanPending = $user->pelaksanaanPendidikan()->where('status', 'Pending')->count();
        $penelitianPending = $user->pelaksanaanPenelitian()->where('status', 'Pending')->count();
        $pengabdianPending = $user->pelaksanaanPengabdian()->where('status', 'Pending')->count();

        $pendidikanDisetujui = $user->pelaksanaanPendidikan()->where('status', 'Disetujui')->count();
        $penelitianDisetujui = $user->pelaksanaanPenelitian()->where('status', 'Disetujui')->count();
        $pengabdianDisetujui = $user->pelaksanaanPengabdian()->where('status', 'Disetujui')->count();

        $stats = [
            'total_kegiatan'   => $pendidikanCount + $penelitianCount + $pengabdianCount,
            'pending'          => $pendidikanPending + $penelitianPending + $pengabdianPending,
            'disetujui'        => $pendidikanDisetujui + $penelitianDisetujui + $pengabdianDisetujui,
            'ak_total'         => $user->totalAngkaKreditDisetujui(),
            'ak_pending'       => $user->totalAngkaKreditPending(),
            'ak_dibutuhkan'    => $user->angkaKreditDibutuhkan(),
            'jabatan_target'   => $user->jabatanBerikutnya(),
            'ak_pendidikan'    => $akPerKategori['Pendidikan'] ?? 0,
            'ak_penelitian'    => $akPerKategori['Penelitian'] ?? 0,
            'ak_pengabdian'    => $akPerKategori['Pengabdian'] ?? 0,
        ];

        // Combine latest activities from all 3 tables
        $p = $user->pelaksanaanPendidikan()->latest()->limit(5)->get();
        $r = $user->pelaksanaanPenelitian()->latest()->limit(5)->get();
        $m = $user->pelaksanaanPengabdian()->latest()->limit(5)->get();

        $kegiatan_terbaru = $p->concat($r)->concat($m)->sortByDesc('created_at')->take(6);
        
        // Add dynamic name attribute
        $kegiatan_terbaru->each(function($k) {
            $k->nama_kegiatan = $k->judul_kegiatan ?? $k->mata_kuliah ?? $k->judul_bimbingan ?? $k->judul_pengujian ?? $k->judul_bahan_ajar ?? $k->nama_jurnal ?? $k->jabatan_struktural ?? 'Kegiatan';
            $k->tanggal_mulai = $k->created_at; 
        });
        $simulasi_terakhir = $user->simulasiAngkaKredit()->latest()->first();

        return view('dosen.dashboard', compact('stats', 'kegiatan_terbaru', 'simulasi_terakhir'));
    }


    // ── KEGIATAN ──────────────────────────────────────────────
    public function kegiatanIndex(Request $request)
    {
        $query = $this->user()->kegiatanTriDharma();

        if ($request->filled('status'))   $query->where('status', $request->status);
        if ($request->filled('kategori')) $query->where('kategori', $request->kategori);

        $kegiatans    = $query->latest()->paginate(10);
        $subKategori  = KegiatanTriDharma::subKategoriOptions();
        return view('dosen.kegiatan.index', compact('kegiatans', 'subKategori'));
    }

    public function kegiatanCreate()
    {
        $subKategori   = KegiatanTriDharma::subKategoriOptions();
        $angkaStandar  = KegiatanTriDharma::angkaKreditStandar();
        return view('dosen.kegiatan.create', compact('subKategori', 'angkaStandar'));
    }

    public function kegiatanStore(Request $request)
    {
        $data = $request->validate([
            'kategori'               => 'required|in:Pendidikan,Penelitian,Pengabdian Masyarakat',
            'sub_kategori'           => 'required|string',
            'nama_kegiatan'          => 'required|string|max:255',
            'deskripsi'              => 'nullable|string',
            'tanggal_mulai'          => 'required|date',
            'tanggal_selesai'        => 'nullable|date|after_or_equal:tanggal_mulai',
            'institusi_penyelenggara'=> 'nullable|string',
            'tingkat'                => 'nullable|string',
            'peran'                  => 'nullable|string',
            'angka_kredit'           => 'required|numeric|min:0',
        ]);

        $data['user_id'] = $this->user()->id;
        $data['status']  = 'Pending';

        KegiatanTriDharma::create($data);
        return redirect()->route('dosen.kegiatan.index')->with('success', 'Kegiatan berhasil disimpan dan menunggu persetujuan admin.');
    }

    public function kegiatanEdit(KegiatanTriDharma $kegiatan)
    {
        $this->authorize('update', $kegiatan);
        if ($kegiatan->status !== 'Pending') {
            return back()->with('error', 'Kegiatan yang sudah diproses tidak dapat diedit.');
        }
        $subKategori  = KegiatanTriDharma::subKategoriOptions();
        $angkaStandar = KegiatanTriDharma::angkaKreditStandar();
        return view('dosen.kegiatan.edit', compact('kegiatan', 'subKategori', 'angkaStandar'));
    }

    public function kegiatanUpdate(Request $request, KegiatanTriDharma $kegiatan)
    {
        $this->authorize('update', $kegiatan);
        $data = $request->validate([
            'kategori'               => 'required|in:Pendidikan,Penelitian,Pengabdian Masyarakat',
            'sub_kategori'           => 'required|string',
            'nama_kegiatan'          => 'required|string|max:255',
            'deskripsi'              => 'nullable|string',
            'tanggal_mulai'          => 'required|date',
            'tanggal_selesai'        => 'nullable|date',
            'institusi_penyelenggara'=> 'nullable|string',
            'tingkat'                => 'nullable|string',
            'peran'                  => 'nullable|string',
            'angka_kredit'           => 'required|numeric|min:0',
        ]);

        $kegiatan->update($data);
        return redirect()->route('dosen.kegiatan.index')->with('success', 'Kegiatan berhasil diperbarui.');
    }

    public function kegiatanDestroy(KegiatanTriDharma $kegiatan)
    {
        $this->authorize('delete', $kegiatan);
        $kegiatan->delete();
        return back()->with('success', 'Kegiatan berhasil dihapus.');
    }

    // ── SIMULASI ──────────────────────────────────────────────
    public function simulasiIndex()
    {
        $simulasis = $this->user()->simulasiAngkaKredit()->latest()->paginate(10);
        return view('dosen.simulasi.index', compact('simulasis'));
    }

    public function simulasiCreate()
    {
        return view('dosen.simulasi.create');
    }

    public function simulasiStore(Request $request)
    {
        $data = $request->validate([
            'nama_simulasi'  => 'required|string|max:255',
            'periode_mulai'  => 'required|date',
            'periode_selesai'=> 'required|date|after_or_equal:periode_mulai',
        ]);

        $user   = $this->user();
        $hasil  = SimulasiAngkaKredit::hitungSimulasi($user, $data['periode_mulai'], $data['periode_selesai']);

        SimulasiAngkaKredit::create([
            'user_id'            => $user->id,
            'nama_simulasi'      => $data['nama_simulasi'],
            'periode_mulai'      => $data['periode_mulai'],
            'periode_selesai'    => $data['periode_selesai'],
            'ak_pendidikan'      => $hasil['ak_pendidikan'],
            'ak_penelitian'      => $hasil['ak_penelitian'],
            'ak_pengabdian'      => $hasil['ak_pengabdian'],
            'ak_penunjang'       => 0,
            'ak_total'           => $hasil['ak_total'],
            'ak_dibutuhkan'      => $hasil['ak_dibutuhkan'],
            'jabatan_saat_ini'   => $user->jabatan_fungsional,
            'jabatan_target'     => $hasil['jabatan_target'],
            'memenuhi_syarat'    => $hasil['memenuhi_syarat'],
            'keterangan'         => implode('; ', $hasil['keterangan']),
            'detail_perhitungan' => $hasil['kegiatan']->toArray(),
        ]);

        return redirect()->route('dosen.simulasi.index')->with('success', 'Simulasi angka kredit berhasil dihitung.');
    }

    public function simulasiShow(SimulasiAngkaKredit $simulasi)
    {
        $this->authorize('view', $simulasi);
        $syarat = SimulasiAngkaKredit::syaratJabatan();
        return view('dosen.simulasi.show', compact('simulasi', 'syarat'));
    }
}
