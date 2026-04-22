<?php

namespace App\Http\Controllers;

use App\Models\PelaksanaanPenelitian;
use App\Models\KategoriKegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PelaksanaanPenelitianController extends Controller
{
    protected function user()
    {
        return Auth::user();
    }

    // Display list of penelitian activities
    public function index(Request $request, $jenisKegiatan = null)
    {
        $query = $this->user()->pelaksanaanPenelitian();

        if ($jenisKegiatan) {
            $query->where('jenis_kegiatan', $jenisKegiatan);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $kegiatans = $query->latest()->paginate(15);
        $jenisKegiatanOptions = PelaksanaanPenelitian::jenisKegiatanOptions();
        
        return view('dosen.pelaksanaan_penelitian.index', compact('kegiatans', 'jenisKegiatanOptions', 'jenisKegiatan'));
    }

    // Show create form
    public function create($jenisKegiatan)
    {
        $this->validateJenisKegiatan($jenisKegiatan);
        
        $kategoriOptions = $this->getKategoriOptions($jenisKegiatan);
        $viewName = $this->getViewName($jenisKegiatan);
        
        return view("dosen.pelaksanaan_penelitian.{$viewName}.create", compact('jenisKegiatan', 'kategoriOptions'));
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
        $record = new PelaksanaanPenelitian($data);
        $data['angka_kredit'] = $record->calculateAngkaKredit($this->user());

        PelaksanaanPenelitian::create($data);
        
        $jenisLabel = PelaksanaanPenelitian::jenisKegiatanOptions()[$jenisKegiatan];
        return redirect()->route('dosen.penelitian.index')
            ->with('success', "{$jenisLabel} berhasil disimpan dan menunggu persetujuan admin.");
    }

    // Show edit form
    public function edit($jenisKegiatan, PelaksanaanPenelitian $penelitian)
    {
        $this->authorize('update', $penelitian);
        
        if ($penelitian->status !== 'Pending') {
            return back()->with('error', 'Kegiatan yang sudah diproses tidak dapat diedit.');
        }
        
        $kategoriOptions = $this->getKategoriOptions($jenisKegiatan);
        $viewName = $this->getViewName($jenisKegiatan);
        
        return view("dosen.pelaksanaan_penelitian.{$viewName}.edit", compact('penelitian', 'jenisKegiatan', 'kategoriOptions'));
    }

    // Update record
    public function update(Request $request, $jenisKegiatan, PelaksanaanPenelitian $penelitian)
    {
        $this->authorize('update', $penelitian);
        
        $validationRules = $this->getValidationRules($jenisKegiatan);
        $data = $request->validate($validationRules);

        // Update and recalculate AK
        $penelitian->update($data);
        $penelitian->angka_kredit = $penelitian->calculateAngkaKredit($this->user());
        $penelitian->save();
        
        $jenisLabel = PelaksanaanPenelitian::jenisKegiatanOptions()[$jenisKegiatan];
        return redirect()->route('dosen.penelitian.index')
            ->with('success', "{$jenisLabel} berhasil diperbarui.");
    }

    // Delete record
    public function destroy(PelaksanaanPenelitian $penelitian)
    {
        $this->authorize('delete', $penelitian);

        $penelitian->delete();
        return back()->with('success', 'Kegiatan berhasil dihapus.');
    }

    // Helper: Validate jenis kegiatan
    private function validateJenisKegiatan($jenisKegiatan)
    {
        $valid = array_keys(PelaksanaanPenelitian::jenisKegiatanOptions());
        if (!in_array($jenisKegiatan, $valid)) {
            abort(404, 'Jenis kegiatan tidak valid');
        }
    }

    // Helper: Get kategori options for dropdown
    private function getKategoriOptions($jenisKegiatan)
    {
        $submenuMap = [
            'penelitian' => 'Penelitian',
            'publikasi_karya' => 'Publikasi Karya',
            'paten_hki' => 'Paten/HKI',
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
            'penelitian' => array_merge($baseRules, [
                'kategori_kegiatan_id' => 'required|exists:kategori_kegiatan,id',
                'judul_kegiatan' => 'required|string|max:255',
                'afiliasi' => 'nullable|string|max:255',
                'tahun_pelaksanaan' => 'required|integer|min:2000|max:2100',
                'lama_kegiatan_tahun' => 'nullable|integer|min:0',
                'peran' => 'required|in:ketua,anggota',
                'jumlah_anggota' => 'nullable|integer|min:0',
                'link_dokumen' => 'nullable|url|max:255',
            ]),
            
            'publikasi_karya' => array_merge($baseRules, [
                'kategori_kegiatan_id' => 'required|exists:kategori_kegiatan,id',
                'judul_kegiatan' => 'required|string|max:255',
                'jenis_publikasi' => 'required|string|max:255',
                'tanggal_terbit' => 'required|date',
                'peran_penulis' => 'required|in:penulis,editor,penerjemah',
                'jumlah_anggota' => 'nullable|integer|min:0',
                'link_dokumen' => 'nullable|url|max:255',
            ]),
            
            'paten_hki' => array_merge($baseRules, [
                'kategori_kegiatan_id' => 'required|exists:kategori_kegiatan,id',
                'judul_kegiatan' => 'required|string|max:255',
                'jenis_hki' => 'required|string|max:255',
                'tanggal_terbit' => 'required|date',
                'nomor_paten' => 'nullable|string|max:255',
            ]),
        ];

        return $rules[$jenisKegiatan] ?? $baseRules;
    }
}
