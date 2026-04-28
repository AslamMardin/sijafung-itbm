<?php

namespace App\Http\Controllers;

use App\Models\KegiatanTriDharma;
use App\Models\SimulasiAngkaKredit;
use App\Models\User;
use App\Models\PelaksanaanPendidikan;
use App\Models\PelaksanaanPenelitian;
use App\Models\PelaksanaanPengabdian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_dosen'    => User::where('role', 'dosen')->count(),
            'total_kegiatan' => PelaksanaanPendidikan::count() + PelaksanaanPenelitian::count() + PelaksanaanPengabdian::count(),
            'pending'          => PelaksanaanPendidikan::where('status', 'Pending')->count() + PelaksanaanPenelitian::where('status', 'Pending')->count() + PelaksanaanPengabdian::where('status', 'Pending')->count(),
            'pending_pendidikan' => PelaksanaanPendidikan::where('status', 'Pending')->count(),
            'pending_penelitian' => PelaksanaanPenelitian::where('status', 'Pending')->count(),
            'pending_pengabdian' => PelaksanaanPengabdian::where('status', 'Pending')->count(),
            'disetujui'      => PelaksanaanPendidikan::where('status', 'Disetujui')->count() + PelaksanaanPenelitian::where('status', 'Disetujui')->count() + PelaksanaanPengabdian::where('status', 'Disetujui')->count(),
            'ditolak'        => PelaksanaanPendidikan::where('status', 'Ditolak')->count() + PelaksanaanPenelitian::where('status', 'Ditolak')->count() + PelaksanaanPengabdian::where('status', 'Ditolak')->count(),
            'total_simulasi' => SimulasiAngkaKredit::count(),
        ];

        // Get latest activities from all 3 tables
        $pendidikan = PelaksanaanPendidikan::with('user')->latest()->limit(5)->get();
        $penelitian = PelaksanaanPenelitian::with('user')->latest()->limit(5)->get();
        $pengabdian = PelaksanaanPengabdian::with('user')->latest()->limit(5)->get();
        
        $kegiatan_terbaru = $pendidikan->concat($penelitian)->concat($pengabdian)->sortByDesc('created_at')->take(8)->values();
        
        // Add dynamic name attribute for consistent display
        $kegiatan_terbaru->each(function($k) {
            $k->nama_kegiatan = $k->judul_kegiatan ?? $k->mata_kuliah ?? $k->judul_bimbingan ?? $k->judul_pengujian ?? $k->judul_bahan_ajar ?? $k->nama_jurnal ?? $k->jabatan_struktural ?? 'Kegiatan';
        });

        $dosen_aktif = User::where('role', 'dosen')
            ->withCount(['pelaksanaanPendidikan', 'pelaksanaanPenelitian', 'pelaksanaanPengabdian'])
            ->get()
            ->map(function($user) {
                $user->kegiatan_count = $user->pelaksanaan_pendidikan_count + $user->pelaksanaan_penelitian_count + $user->pelaksanaan_pengabdian_count;
                return $user;
            })
            ->sortByDesc('kegiatan_count')
            ->take(5);

        $per_jabatan = User::where('role', 'dosen')
            ->selectRaw('jabatan_fungsional, COUNT(*) as total')
            ->groupBy('jabatan_fungsional')
            ->pluck('total', 'jabatan_fungsional');

        return view('admin.dashboard', compact('stats', 'kegiatan_terbaru', 'dosen_aktif', 'per_jabatan'));
    }

    // ── DOSEN MANAGEMENT ──────────────────────────────────────
    public function dosenIndex()
    {
        $dosens = User::where('role', 'dosen')
            ->withCount(['pelaksanaanPendidikan', 'pelaksanaanPenelitian', 'pelaksanaanPengabdian'])
            ->latest()
            ->paginate(10);
        
        // Add total_kegiatan attribute manually
        $dosens->getCollection()->transform(function($dosen) {
            $dosen->kegiatan_tri_dharma_count = $dosen->pelaksanaan_pendidikan_count + $dosen->pelaksanaan_penelitian_count + $dosen->pelaksanaan_pengabdian_count;
            return $dosen;
        });

        return view('admin.dosen.index', compact('dosens'));
    }

    public function dosenCreate()
    {
        return view('admin.dosen.create');
    }

    public function dosenStore(Request $request)
    {
        $data = $request->validate([
            'name'               => 'required|string|max:255',
            'email'              => 'required|email|unique:users',
            'password'           => 'required|min:8|confirmed',
            'nip'                => 'nullable|unique:users',
            'nidn'               => 'nullable|unique:users',
            'prodi'              => 'nullable|string',
            'fakultas'           => 'nullable|string',
            'jabatan_fungsional' => 'nullable|string',
            'pangkat_golongan'   => 'nullable|string',
        ]);

        $data['role']     = 'dosen';
        $data['password'] = Hash::make($data['password']);

        User::create($data);
        return redirect()->route('admin.dosen.index')->with('success', 'Dosen berhasil ditambahkan.');
    }

    public function dosenEdit(User $dosen)
    {
        return view('admin.dosen.edit', compact('dosen'));
    }

    public function dosenUpdate(Request $request, User $dosen)
    {
        $data = $request->validate([
            'name'                   => 'required|string|max:255',
            'email'                  => 'required|email|unique:users,email,' . $dosen->id,
            'nip'                    => 'nullable|unique:users,nip,' . $dosen->id,
            'nidn'                   => 'nullable|unique:users,nidn,' . $dosen->id,
            'prodi'                  => 'nullable|string',
            'fakultas'               => 'nullable|string',
            'jabatan_fungsional'     => 'nullable|string',
            'pangkat_golongan'       => 'nullable|string',
            'angka_kredit_kumulatif' => 'nullable|numeric|min:0',
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:8|confirmed']);
            $data['password'] = Hash::make($request->password);
        }

        $dosen->update($data);
        return redirect()->route('admin.dosen.index')->with('success', 'Data dosen berhasil diperbarui.');
    }

    public function dosenDestroy(User $dosen)
    {
        $dosen->delete();
        return redirect()->route('admin.dosen.index')->with('success', 'Dosen berhasil dihapus.');
    }

    // ── KEGIATAN MANAGEMENT ────────────────────────────────────
    public function kegiatanIndex(Request $request)
    {
        $query = KegiatanTriDharma::with('user');

        if ($request->filled('status'))   $query->where('status', $request->status);
        if ($request->filled('kategori')) $query->where('kategori', $request->kategori);
        if ($request->filled('dosen_id')) $query->where('user_id', $request->dosen_id);

        $kegiatans = $query->latest()->paginate(15);
        $dosens    = User::where('role', 'dosen')->get();
        return view('admin.kegiatan.index', compact('kegiatans', 'dosens'));
    }

    public function kegiatanShow(KegiatanTriDharma $kegiatan)
    {
        return view('admin.kegiatan.show', compact('kegiatan'));
    }

    public function kegiatanApprove(Request $request, KegiatanTriDharma $kegiatan)
    {
        $kegiatan->update([
            'status'         => $request->status,
            'catatan_admin'  => $request->catatan_admin,
        ]);

        // Recalculate kumulatif
        if ($request->status === 'Disetujui') {
            $kegiatan->user->update([
                'angka_kredit_kumulatif' => $kegiatan->user->totalAngkaKreditDisetujui(),
            ]);
        }

        return back()->with('success', 'Status kegiatan berhasil diperbarui.');
    }

    // ── VERIFIKASI KEGIATAN BARU (3 TABEL) ────────────────────
    
    // List all pending activities for verification
    public function verifikasiIndex(Request $request)
    {
        $sumber = $request->get('sumber', 'semua'); // semua, pendidikan, penelitian, pengabdian
        
        $pendidikan = collect();
        $penelitian = collect();
        $pengabdian = collect();

        if ($sumber === 'semua' || $sumber === 'pendidikan') {
            $query = PelaksanaanPendidikan::with(['user', 'kategori']);
            if ($request->filled('status')) $query->where('status', $request->status);
            if ($request->filled('dosen_id')) $query->where('user_id', $request->dosen_id);
            $pendidikan = $query->latest()->get()->map(function($k) {
                $k->sumber = 'Pendidikan';
                $k->sumber_key = 'pendidikan';
                $k->nama_kegiatan = $k->judul_kegiatan ?? $k->mata_kuliah ?? $k->judul_bimbingan ?? $k->judul_pengujian ?? $k->judul_bahan_ajar ?? $k->nama_jurnal ?? $k->jabatan_struktural ?? 'Kegiatan';
                return $k;
            });
        }

        if ($sumber === 'semua' || $sumber === 'penelitian') {
            $query = PelaksanaanPenelitian::with(['user', 'kategori']);
            if ($request->filled('status')) $query->where('status', $request->status);
            if ($request->filled('dosen_id')) $query->where('user_id', $request->dosen_id);
            $penelitian = $query->latest()->get()->map(function($k) {
                $k->sumber = 'Penelitian';
                $k->sumber_key = 'penelitian';
                $k->nama_kegiatan = $k->judul_kegiatan ?? $k->mata_kuliah ?? $k->judul_bimbingan ?? $k->judul_pengujian ?? $k->judul_bahan_ajar ?? $k->nama_jurnal ?? $k->jabatan_struktural ?? 'Kegiatan';
                return $k;
            });
        }

        if ($sumber === 'semua' || $sumber === 'pengabdian') {
            $query = PelaksanaanPengabdian::with(['user', 'kategori']);
            if ($request->filled('status')) $query->where('status', $request->status);
            if ($request->filled('dosen_id')) $query->where('user_id', $request->dosen_id);
            $pengabdian = $query->latest()->get()->map(function($k) {
                $k->sumber = 'Pengabdian';
                $k->sumber_key = 'pengabdian';
                $k->nama_kegiatan = $k->judul_kegiatan ?? $k->mata_kuliah ?? $k->judul_bimbingan ?? $k->judul_pengujian ?? $k->judul_bahan_ajar ?? $k->nama_jurnal ?? $k->jabatan_struktural ?? 'Kegiatan';
                return $k;
            });
        }

        $kegiatans = $pendidikan->concat($penelitian)->concat($pengabdian)->sortByDesc('created_at')->values();
        $dosens = User::where('role', 'dosen')->get();
        
        return view('admin.verifikasi.index', compact('kegiatans', 'dosens', 'sumber'));
    }

    // Show detail for verification
    public function verifikasiShow($sumberKey, $id)
    {
        $model = $this->getModel($sumberKey);
        $kegiatan = $model::with(['user', 'kategori'])->findOrFail($id);
        
        $triDharma = match($sumberKey) {
            'pendidikan' => 'Pelaksanaan Pendidikan',
            'penelitian' => 'Pelaksanaan Penelitian',
            'pengabdian' => 'Pelaksanaan Pengabdian',
            default => 'Tri Dharma',
        };
        
        return view('admin.verifikasi.show', compact('kegiatan', 'sumberKey', 'triDharma'));
    }

    // Approve/Reject activity
    public function verifikasiApprove(Request $request, $sumberKey, $id)
    {
        $model = $this->getModel($sumberKey);
        $kegiatan = $model::findOrFail($id);

        $request->validate([
            'status' => 'required|in:Disetujui,Ditolak',
            'catatan_admin' => 'nullable|string',
            'angka_kredit' => 'nullable|numeric|min:0',
        ]);

        $kegiatan->update([
            'status' => $request->status,
            'catatan_admin' => $request->catatan_admin,
            'angka_kredit' => $request->angka_kredit ?? $kegiatan->calculateAngkaKredit($kegiatan->user),
        ]);

        // Update user's cumulative AK if approved
        if ($request->status === 'Disetujui') {
            $user = $kegiatan->user;
            $user->update([
                'angka_kredit_kumulatif' => $user->totalAngkaKreditDisetujui(),
            ]);
        }

        $statusLabel = $request->status === 'Disetujui' ? 'disetujui' : 'ditolak';
        return back()->with('success', "Kegiatan berhasil {$statusLabel}.");
    }

    // Helper: Get model by sumber key
    private function getModel($sumberKey)
    {
        return match($sumberKey) {
            'pendidikan' => PelaksanaanPendidikan::class,
            'penelitian' => PelaksanaanPenelitian::class,
            'pengabdian' => PelaksanaanPengabdian::class,
            default => abort(404, 'Sumber tidak valid'),
        };
    }
}
