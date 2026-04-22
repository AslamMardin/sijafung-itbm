Berikut adalah **Product Requirements Document (PRD)** yang disusun berdasarkan ringkasan alur dan struktur menu yang telah Anda berikan. Dokumen ini dirancang untuk menjadi acuan bagi tim pengembang dalam membangun aplikasi **Sijafung (Sistem Informasi Jabatan Fungsional Dosen)**.

---

# Product Requirements Document: Sijafung (Sistem Informasi Jabatan Fungsional Dosen)

## 1. Ikhtisar Produk
Aplikasi Sijafung adalah platform berbasis web/mobile yang dirancang untuk membantu dosen mengelola, menghitung, dan mendokumentasikan pencapaian angka kredit (AK) secara otomatis berdasarkan kegiatan Tri Dharma Perguruan Tinggi.

**Tujuan Utama:**
* Memudahkan dosen dalam input data kegiatan secara mandiri.
* Mengotomatisasi perhitungan angka kredit sesuai dengan aturan yang berlaku.
* Menyediakan arsip digital (bukti fisik) untuk keperluan kenaikan jabatan fungsional.

---

## 2. Arsitektur Fitur & Modul Data
Berikut adalah pemetaan struktur input data ke dalam modul sistem. Setiap entri data harus menyertakan **link dokumen/bukti fisik** sebagai syarat validasi.

### A. Modul Pelaksanaan Pendidikan
| Sub-menu | Input Utama yang Dibutuhkan |
| :--- | :--- |
| **Pengajaran** | Matakuliah, Jenis MK, Bidang Keilmuan, Kelas, Jml Mahasiswa, SKS, Periode. |
| **Bimbingan Mhs** | Semester, Kategori (Skripsi/Tesis/Disertasi), Judul, Jenis, Prodi, Periode. |
| **Pengujian** | Judul, Bidang Keilmuan, Jenis (Ketua/Anggota), Prodi, Periode. |
| **Bahan Ajar** | Kategori (Buku/Modul/Diktat), Judul, ISBN, Penerbit, Status Penulis, Jml Anggota. |
| **Pembinaan Mhs** | Semester, Kategori, Judul, Jenis Bimbingan, Prodi, Periode. |
| **Visiting Scientist** | Perguruan Tinggi, Lama (Jam), Tanggal, Kategori jam kegiatan. |
| **Detasering** | Kategori (Qs100/Nasional), PT Sasaran, Deskripsi, No SK, Tgl SK. |
| **Orasi Ilmiah** | Kategori, Posisi, Judul, Nama Forum, Penyelenggara, Tanggal. |
| **Pembimbing Dosen** | Kategori (Pencangkokan/Reguler), Jenis, Dosen Bimbingan, No SK. |
| **Tugas Tambahan** | Jabatan, Unit Kerja, Instansi, Tgl Mulai, Tgl Berakhir. |

### B. Modul Pelaksanaan Penelitian
| Sub-menu | Input Utama yang Dibutuhkan |
| :--- | :--- |
| **Penelitian** | Kategori, Judul, Afiliasi, Tahun, Lama (Thn), Peran (Ketua/Anggota), Jml Anggota. |
| **Publikasi** | Kategori, Judul, Jenis (Jurnal/Prosiding/Populer), Peran Penulis, Jml Anggota. |
| **Paten/HKI** | Judul, Jenis (Paten/Hak Cipta), Tanggal Terbit, Peran, Jml Anggota. |

### C. Modul Pelaksanaan Pengabdian
| Sub-menu | Input Utama yang Dibutuhkan |
| :--- | :--- |
| **Pengabdian** | Kategori, Judul, Afiliasi, Tahun, Lama (Thn), Peran, Jml Anggota. |
| **Pembicara** | Tingkat (Intl/Nas/Lokal), Insidental/Terjadwal, Judul Makalah, Nama Forum. |
| **Pengelola Jurnal** | Kategori (Editor/Reviewer), Nama Jurnal, No SK, Periode Aktif, Peran. |
| **Jabatan Struktural**| Jabatan, No SK, Terhitung Mulai, Terhitung Selesai. |

---

## 3. Logika Perhitungan (Business Rules)
Sistem harus memiliki *Calculation Engine* yang menerapkan aturan berikut:

### I. Pembobotan Peran (Multiplier)
Sistem menerapkan fungsi pembagian otomatis berdasarkan peran:
* **Ketua / Penulis Utama / Inventor Utama:** Diberikan nilai bobot 100% (penuh).
* **Anggota / Co-Author / Co-Inventor:** Diberikan nilai bobot proporsional (40%–60% dari nilai penuh, bergantung pada jenis kegiatan).

### II. Aturan Batasan (Capping)
* **Pengajaran:** Maksimal 12 SKS per semester (kelebihan SKS tidak dihitung).
* **Orasi Ilmiah:** Maksimal 2 kali per semester (lebih dari itu tidak menambah AK).
* **Tugas Tambahan:** Dihitung berdasarkan nilai *fixed* per jabatan (Rektor=15, Dekan/WR=13, Kajur=10, Sekjur/Kapuslab=6).

### III. Matriks Perhitungan (Contoh Implementasi)
| Jenis Kegiatan | Nilai Dasar | Logika Sistem |
| :--- | :--- | :--- |
| Pembimbing Skripsi (Utama) | 1 AK | `Value = 1 * (Qty Mahasiswa)` |
| Jurnal Internasional (Utama) | 40 AK | `Value = 40` |
| Jurnal Internasional (Co) | 40 AK | `Value = 40 * 0.6` |
| Jabatan (Rektor) | 15 AK | `Value = 15 per Semester` |

---

## 4. Persyaratan Non-Fungsional
* **Keamanan Data:** Setiap upload dokumen wajib divalidasi format (PDF) dan ukuran maksimal (misal: 5MB).
* **Audit Trail:** Sistem harus mencatat *timestamp* setiap perubahan data oleh dosen.
* **Responsivitas:** Sistem harus dapat diakses dengan lancar via desktop (browser) dan mobile browser.
* **Integrasi:** (Opsional) Memiliki API untuk sinkronisasi data dengan PDDikti atau aplikasi SISTER.

---

## 5. Alur Pengguna (User Journey)
1.  **Login:** Dosen masuk ke dasbor menggunakan akun universitas.
2.  **Input:** Dosen memilih menu kategori (Pendidikan/Penelitian/Pengabdian) dan mengisi *field* yang disediakan.
3.  **Upload:** Dosen mengunggah bukti fisik (PDF) sesuai *field* "Link Dokumen".
4.  **Auto-Calculate:** Sistem menghitung AK berdasarkan input dan peran (Ketua/Anggota).
5.  **Simulasi:** Dosen dapat melihat total AK sementara sebelum melakukan "Submit".
6.  **Submission:** Dosen melakukan submit untuk diajukan kepada verifikator/admin.
7.  **Finalisasi:** Admin melakukan verifikasi dokumen; jika valid, AK ditambahkan ke total kumulatif dosen.