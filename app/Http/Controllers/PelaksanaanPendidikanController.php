<?php

namespace App\Http\Controllers;

use App\Models\KategoriKegiatan;
use App\Models\PelaksanaanPendidikan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PelaksanaanPendidikanController extends Controller
{
    protected function user()
    {
        return Auth::user();
    }

    // Display list of pendidikan activities
    public function index(Request $request, $jenisKegiatan = null)
    {
        $query = $this->user()->pelaksanaanPendidikan();

        if ($jenisKegiatan) {
            $query->where('jenis_kegiatan', $jenisKegiatan);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $kegiatans = $query->latest()->paginate(15);
        $jenisKegiatanOptions = PelaksanaanPendidikan::jenisKegiatanOptions();

        return view('dosen.pelaksanaan_pendidikan.index', compact('kegiatans', 'jenisKegiatanOptions', 'jenisKegiatan'));
    }

    // Show create form
    public function create($jenisKegiatan)
    {
        $this->validateJenisKegiatan($jenisKegiatan);

        $kategoriOptions = $this->getKategoriOptions($jenisKegiatan);
        $viewName = $this->getViewName($jenisKegiatan);

        return view("dosen.pelaksanaan_pendidikan.{$viewName}.create", compact('jenisKegiatan', 'kategoriOptions'));
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
        $record = new PelaksanaanPendidikan($data);
        $data['angka_kredit'] = $record->calculateAngkaKredit($this->user());

        PelaksanaanPendidikan::create($data);

        $jenisLabel = PelaksanaanPendidikan::jenisKegiatanOptions()[$jenisKegiatan];

        return redirect()->route('dosen.pendidikan.index')
            ->with('success', "{$jenisLabel} berhasil disimpan dan menunggu persetujuan admin.");
    }

    // Show edit form
    public function edit($jenisKegiatan, PelaksanaanPendidikan $pendidikan)
    {
        $this->authorize('update', $pendidikan);

        if ($pendidikan->status !== 'Pending') {
            return back()->with('error', 'Kegiatan yang sudah diproses tidak dapat diedit.');
        }

        $kategoriOptions = $this->getKategoriOptions($jenisKegiatan);
        $viewName = $this->getViewName($jenisKegiatan);

        return view("dosen.pelaksanaan_pendidikan.{$viewName}.edit", compact('pendidikan', 'jenisKegiatan', 'kategoriOptions'));
    }

    // Update record
    public function update(Request $request, $jenisKegiatan, PelaksanaanPendidikan $pendidikan)
    {
        $this->authorize('update', $pendidikan);

        $validationRules = $this->getValidationRules($jenisKegiatan);
        $data = $request->validate($validationRules);

        // Update and recalculate AK
        $pendidikan->update($data);
        $pendidikan->angka_kredit = $pendidikan->calculateAngkaKredit($this->user());
        $pendidikan->save();

        $jenisLabel = PelaksanaanPendidikan::jenisKegiatanOptions()[$jenisKegiatan];

        return redirect()->route('dosen.pendidikan.index')
            ->with('success', "{$jenisLabel} berhasil diperbarui.");
    }

    // Delete record
    public function destroy(PelaksanaanPendidikan $pendidikan)
    {
        $this->authorize('delete', $pendidikan);

        $pendidikan->delete();

        return back()->with('success', 'Kegiatan berhasil dihapus.');
    }

    // Helper: Validate jenis kegiatan
    private function validateJenisKegiatan($jenisKegiatan)
    {
        $valid = array_keys(PelaksanaanPendidikan::jenisKegiatanOptions());
        if (! in_array($jenisKegiatan, $valid)) {
            abort(404, 'Jenis kegiatan tidak valid');
        }
    }

    // Helper: Get kategori options for dropdown
    private function getKategoriOptions($jenisKegiatan)
    {
        $submenuMap = [
            'pengajaran' => 'Pengajaran',
            'bimbingan' => 'Bimbingan Mahasiswa',
            'pengujian' => 'Pengujian Mahasiswa',
            'bahan_ajar' => 'Bahan Ajar',
            'pembinaan' => 'Pembinaan Mahasiswa',
            'visiting_scientist' => 'Visiting Scientist',
            'detasering' => 'Detasering',
            'orasi_ilmiah' => 'Orasi Ilmiah',
            'pembimbing_dosen' => 'Pembimbing Dosen',
            'tugas_tambahan' => 'Tugas Tambahan',
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
        return $jenisKegiatan; // Will map to view folder name
    }

    // Helper: Get validation rules based on jenis
    private function getValidationRules($jenisKegiatan): array
    {
        $baseRules = [];

        $rules = [
            'pengajaran' => array_merge($baseRules, [
                'mata_kuliah' => 'required|string|max:255',
                'jenis_mata_kuliah' => 'nullable|string|max:255',
                'bidang_keilmuan' => 'nullable|string|max:255',
                'kelas' => 'nullable|string|max:255',
                'jumlah_mahasiswa' => 'nullable|integer|min:0',
                'sks' => 'required|integer|min:1|max:10',
                'semester' => 'required|string|max:255',
                'link_dokumen' => 'nullable|url|max:255',
            ]),

            'bimbingan' => array_merge($baseRules, [
                'semester' => 'required|string|max:255',
                'kategori_kegiatan_id' => 'required|exists:kategori_kegiatan,id',
                'judul_bimbingan' => 'required|string|max:255',
                'bidang_keilmuan' => 'nullable|string|max:255',
                'jenis_bimbingan' => 'nullable|string|max:255',
                'program_studi' => 'nullable|string|max:255',
            ]),

            'pengujian' => array_merge($baseRules, [
                'kategori_kegiatan_id' => 'required|exists:kategori_kegiatan,id',
                'judul_pengujian' => 'required|string|max:255',
                'bidang_keilmuan' => 'nullable|string|max:255',
                'jenis_pengujian' => 'nullable|string|max:255',
                'program_studi' => 'nullable|string|max:255',
                'semester' => 'required|string|max:255',
                'link_dokumen' => 'nullable|url|max:255',
            ]),

            'bahan_ajar' => array_merge($baseRules, [
                'kategori_kegiatan_id' => 'required|exists:kategori_kegiatan,id',
                'judul_bahan_ajar' => 'required|string|max:255',
                'isbn' => 'nullable|string|max:255',
                'tanggal_terbit' => 'required|date',
                'penerbit' => 'nullable|string|max:255',
                'status_penulis' => 'nullable|string|max:255',
                'jumlah_anggota' => 'nullable|integer|min:0',
            ]),

            'pembinaan' => array_merge($baseRules, [
                'semester' => 'required|string|max:255',
                'kategori_kegiatan_id' => 'required|exists:kategori_kegiatan,id',
                'judul_bimbingan' => 'required|string|max:255',
                'jenis_bimbingan' => 'nullable|string|max:255',
                'program_studi' => 'nullable|string|max:255',
            ]),

            'visiting_scientist' => array_merge($baseRules, [
                'perguruan_tinggi_pengundang' => 'required|string|max:255',
                'lama_kegiatan_hari' => 'required|integer|min:1',
                'kategori_kegiatan_id' => 'required|exists:kategori_kegiatan,id',
                'tanggal_mulai' => 'required|date',
            ]),

            'detasering' => array_merge($baseRules, [
                'kategori_kegiatan_id' => 'required|exists:kategori_kegiatan,id',
                'perguruan_tinggi_sasaran' => 'required|string|max:255',
                'deskripsi_kegiatan' => 'required|string',
                'metode_pelaksanaan' => 'nullable|string|max:255',
                'nomor_sk_penugasan' => 'nullable|string|max:255',
                'tanggal_sk_penugasan' => 'nullable|date',
            ]),

            'orasi_ilmiah' => array_merge($baseRules, [
                'kategori_kegiatan_id' => 'required|exists:kategori_kegiatan,id',
                'kategori_pembicara' => 'nullable|string|max:255',
                'judul_makalah' => 'required|string|max:255',
                'nama_pertemuan_ilmiah' => 'required|string|max:255',
                'penyelenggara' => 'required|string|max:255',
                'tanggal_mulai' => 'required|date',
            ]),

            'pembimbing_dosen' => array_merge($baseRules, [
                'kategori_kegiatan_id' => 'required|exists:kategori_kegiatan,id',
                'program_studi' => 'nullable|string|max:255',
                'tanggal_mulai' => 'required|date',
                'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
                'jenis_bimbingan' => 'nullable|string|max:255',
                'bidang_ahli_pembimbing' => 'nullable|string|max:255',
                'jabatan_fungsional_pembimbing' => 'nullable|string|max:255',
                'dosen_bimbingan' => 'nullable|string|max:255',
                'jabatan_fungsional_bimbingan' => 'nullable|string|max:255',
                'no_sk_tugas' => 'nullable|string|max:255',
                'tanggal_sk_tugas' => 'nullable|date',
            ]),

            'tugas_tambahan' => array_merge($baseRules, [
                'tugas_tambahan' => 'required|string|max:255',
                'unit_kerja' => 'nullable|string|max:255',
                'instansi' => 'nullable|string|max:255',
                'tanggal_mulai' => 'required|date',
                'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            ]),
        ];

        return $rules[$jenisKegiatan] ?? $baseRules;
    }
}
