<?php

namespace App\Http\Controllers;

use App\Models\PelaksanaanPengabdian;
use App\Models\KategoriKegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PelaksanaanPengabdianController extends Controller
{
    protected function user()
    {
        return Auth::user();
    }

    // Display list of pengabdian activities
    public function index(Request $request, $jenisKegiatan = null)
    {
        $query = $this->user()->pelaksanaanPengabdian();

        if ($jenisKegiatan) {
            $query->where('jenis_kegiatan', $jenisKegiatan);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $kegiatans = $query->latest()->paginate(15);
        $jenisKegiatanOptions = PelaksanaanPengabdian::jenisKegiatanOptions();
        
        return view('dosen.pelaksanaan_pengabdian.index', compact('kegiatans', 'jenisKegiatanOptions', 'jenisKegiatan'));
    }

    // Show create form
    public function create($jenisKegiatan)
    {
        $this->validateJenisKegiatan($jenisKegiatan);
        
        $kategoriOptions = $this->getKategoriOptions($jenisKegiatan);
        $viewName = $this->getViewName($jenisKegiatan);
        
        return view("dosen.pelaksanaan_pengabdian.{$viewName}.create", compact('jenisKegiatan', 'kategoriOptions'));
    }

    // Store new record
    public function store(Request $request, $jenisKegiatan)
    {
        $this->validateJenisKegiatan($jenisKegiatan);
        
        $validationRules = $this->getValidationRules($jenisKegiatan);
        $data = $request->validate($validationRules);

        // Set user_id and status
        $data['user_id'] = $this->user()->id;
        $data['status'] = 'Pending';
        $data['jenis_kegiatan'] = $jenisKegiatan;

        // Calculate AK
        $record = new PelaksanaanPengabdian($data);
        $data['angka_kredit'] = $record->calculateAngkaKredit($this->user());

        PelaksanaanPengabdian::create($data);
        
        $jenisLabel = PelaksanaanPengabdian::jenisKegiatanOptions()[$jenisKegiatan];
        return redirect()->route('dosen.pengabdian.index')
            ->with('success', "{$jenisLabel} berhasil disimpan dan menunggu persetujuan admin.");
    }

    // Show edit form
    public function edit($jenisKegiatan, PelaksanaanPengabdian $pengabdian)
    {
        $this->authorize('update', $pengabdian);
        
        if ($pengabdian->status !== 'Pending') {
            return back()->with('error', 'Kegiatan yang sudah diproses tidak dapat diedit.');
        }
        
        $kategoriOptions = $this->getKategoriOptions($jenisKegiatan);
        $viewName = $this->getViewName($jenisKegiatan);
        
        return view("dosen.pelaksanaan_pengabdian.{$viewName}.edit", compact('pengabdian', 'jenisKegiatan', 'kategoriOptions'));
    }

    // Update record
    public function update(Request $request, $jenisKegiatan, PelaksanaanPengabdian $pengabdian)
    {
        $this->authorize('update', $pengabdian);
        
        $validationRules = $this->getValidationRules($jenisKegiatan);
        $data = $request->validate($validationRules);

        // Update and recalculate AK
        $pengabdian->update($data);
        $pengabdian->angka_kredit = $pengabdian->calculateAngkaKredit($this->user());
        $pengabdian->save();
        
        $jenisLabel = PelaksanaanPengabdian::jenisKegiatanOptions()[$jenisKegiatan];
        return redirect()->route('dosen.pengabdian.index')
            ->with('success', "{$jenisLabel} berhasil diperbarui.");
    }

    // Delete record
    public function destroy(PelaksanaanPengabdian $pengabdian)
    {
        $this->authorize('delete', $pengabdian);

        $pengabdian->delete();
        return back()->with('success', 'Kegiatan berhasil dihapus.');
    }

    // Helper: Validate jenis kegiatan
    private function validateJenisKegiatan($jenisKegiatan)
    {
        $valid = array_keys(PelaksanaanPengabdian::jenisKegiatanOptions());
        if (!in_array($jenisKegiatan, $valid)) {
            abort(404, 'Jenis kegiatan tidak valid');
        }
    }

    // Helper: Get kategori options for dropdown
    private function getKategoriOptions($jenisKegiatan)
    {
        $submenuMap = [
            'pengabdian' => 'Pengabdian',
            'pembicara' => 'Pembicara',
            'pengelola_jurnal' => 'Pengelola Jurnal',
            'jabatan_struktural' => 'Jabatan Struktural',
        ];
        
        $submenu = $submenuMap[$jenisKegiatan] ?? null;
        if ($submenu) {
            return KategoriKegiatan::getKategoriBySubmenu($submenu);
        }
        
        return [];
    }

    // Helper: Get view name based on jenis
    private function getViewName($jenisKegiatan)
    {
        return $jenisKegiatan;
    }

    // Helper: Get validation rules based on jenis
    private function getValidationRules($jenisKegiatan): array
    {
        $baseRules = [];

        $rules = [
            'pengabdian' => array_merge($baseRules, [
                'kategori_kegiatan_id' => 'required|exists:kategori_kegiatan,id',
                'judul_kegiatan' => 'required|string|max:255',
                'afiliasi' => 'nullable|string|max:255',
                'tahun_pelaksanaan' => 'required|integer|min:2000|max:2100',
                'lama_kegiatan_tahun' => 'nullable|integer|min:0',
                'peran' => 'required|in:ketua,anggota',
                'jumlah_anggota' => 'nullable|integer|min:0',
                'link_dokumen' => 'nullable|url|max:255',
            ]),
            
            'pembicara' => array_merge($baseRules, [
                'kategori_kegiatan_id' => 'required|exists:kategori_kegiatan,id',
                'kategori_capaian_luaran' => 'nullable|string|max:255',
                'kategori_pembicara' => 'required|string|max:255',
                'judul_makalah' => 'required|string|max:255',
                'nama_temu_ilmiah' => 'required|string|max:255',
                'penyelenggara' => 'required|string|max:255',
                'tanggal_pelaksanaan' => 'required|date',
                'link_dokumen' => 'nullable|url|max:255',
            ]),
            
            'pengelola_jurnal' => array_merge($baseRules, [
                'kategori_kegiatan_id' => 'required|exists:kategori_kegiatan,id',
                'nama_jurnal' => 'required|string|max:255',
                'no_sk_penugasan' => 'nullable|string|max:255',
                'terhitung_mulai' => 'required|date',
                'tanggal_selesai' => 'nullable|date|after_or_equal:terhitung_mulai',
                'status_aktif' => 'nullable|boolean',
                'peran_jurnal' => 'required|string|max:255',
                'link_dokumen' => 'nullable|url|max:255',
            ]),
            
            'jabatan_struktural' => array_merge($baseRules, [
                'kategori_kegiatan_id' => 'nullable|exists:kategori_kegiatan,id',
                'jabatan_struktural' => 'required|string|max:255',
                'nomor_sk' => 'nullable|string|max:255',
                'terhitung' => 'nullable|date',
                'tanggal_mulai' => 'required|date',
                'terhitung_tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
                'link_dokumen' => 'nullable|url|max:255',
            ]),
        ];

        return $rules[$jenisKegiatan] ?? $baseRules;
    }
}
