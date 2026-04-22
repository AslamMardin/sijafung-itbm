<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\PelaksanaanPendidikanController;
use App\Http\Controllers\PelaksanaanPenelitianController;
use App\Http\Controllers\PelaksanaanPengabdianController;
use Illuminate\Support\Facades\Route;

// ── Auth ──────────────────────────────────────────────────────
// Route::get('/', fn() => redirect()->route('login'));
Route::get('/', function(){
    return view('welcome');
});
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ── Admin Routes ──────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Manajemen Dosen
    Route::prefix('dosen')->name('dosen.')->group(function () {
        Route::get('/',          [AdminController::class, 'dosenIndex'])->name('index');
        Route::get('/create',    [AdminController::class, 'dosenCreate'])->name('create');
        Route::post('/',         [AdminController::class, 'dosenStore'])->name('store');
        Route::get('/{dosen}/edit',   [AdminController::class, 'dosenEdit'])->name('edit');
        Route::put('/{dosen}',        [AdminController::class, 'dosenUpdate'])->name('update');
        Route::delete('/{dosen}',     [AdminController::class, 'dosenDestroy'])->name('destroy');
    });

    // Verifikasi Kegiatan (3 tabel baru)
    Route::prefix('verifikasi')->name('verifikasi.')->group(function () {
        Route::get('/', [AdminController::class, 'verifikasiIndex'])->name('index');
        Route::get('/{sumberKey}/{id}', [AdminController::class, 'verifikasiShow'])->name('show');
        Route::patch('/{sumberKey}/{id}/approve', [AdminController::class, 'verifikasiApprove'])->name('approve');
    });

    // Manajemen Kegiatan (Legacy)
    Route::prefix('kegiatan')->name('kegiatan.')->group(function () {
        Route::get('/',                         [AdminController::class, 'kegiatanIndex'])->name('index');
        Route::get('/{kegiatan}',               [AdminController::class, 'kegiatanShow'])->name('show');
        Route::patch('/{kegiatan}/approve',     [AdminController::class, 'kegiatanApprove'])->name('approve');
    });
});

// ── Dosen Routes ──────────────────────────────────────────────
Route::prefix('dosen')->name('dosen.')->middleware(['auth', 'role:dosen'])->group(function () {
    Route::get('/dashboard', [DosenController::class, 'dashboard'])->name('dashboard');

    // Pelaksanaan Pendidikan (Menu SISTER)
    Route::prefix('pendidikan')->name('pendidikan.')->group(function () {
        Route::get('/', [PelaksanaanPendidikanController::class, 'index'])->name('index');
        Route::get('/{jenisKegiatan}/create', [PelaksanaanPendidikanController::class, 'create'])->name('create');
        Route::post('/{jenisKegiatan}', [PelaksanaanPendidikanController::class, 'store'])->name('store');
        Route::get('/{jenisKegiatan}/{pendidikan}/edit', [PelaksanaanPendidikanController::class, 'edit'])->name('edit');
        Route::put('/{jenisKegiatan}/{pendidikan}', [PelaksanaanPendidikanController::class, 'update'])->name('update');
        Route::delete('/{pendidikan}', [PelaksanaanPendidikanController::class, 'destroy'])->name('destroy');
    });

    // Pelaksanaan Penelitian (Menu SISTER)
    Route::prefix('penelitian')->name('penelitian.')->group(function () {
        Route::get('/', [PelaksanaanPenelitianController::class, 'index'])->name('index');
        Route::get('/{jenisKegiatan}/create', [PelaksanaanPenelitianController::class, 'create'])->name('create');
        Route::post('/{jenisKegiatan}', [PelaksanaanPenelitianController::class, 'store'])->name('store');
        Route::get('/{jenisKegiatan}/{penelitian}/edit', [PelaksanaanPenelitianController::class, 'edit'])->name('edit');
        Route::put('/{jenisKegiatan}/{penelitian}', [PelaksanaanPenelitianController::class, 'update'])->name('update');
        Route::delete('/{penelitian}', [PelaksanaanPenelitianController::class, 'destroy'])->name('destroy');
    });

    // Pelaksanaan Pengabdian (Menu SISTER)
    Route::prefix('pengabdian')->name('pengabdian.')->group(function () {
        Route::get('/', [PelaksanaanPengabdianController::class, 'index'])->name('index');
        Route::get('/{jenisKegiatan}/create', [PelaksanaanPengabdianController::class, 'create'])->name('create');
        Route::post('/{jenisKegiatan}', [PelaksanaanPengabdianController::class, 'store'])->name('store');
        Route::get('/{jenisKegiatan}/{pengabdian}/edit', [PelaksanaanPengabdianController::class, 'edit'])->name('edit');
        Route::put('/{jenisKegiatan}/{pengabdian}', [PelaksanaanPengabdianController::class, 'update'])->name('update');
        Route::delete('/{pengabdian}', [PelaksanaanPengabdianController::class, 'destroy'])->name('destroy');
    });

    // Kegiatan Tri Dharma (Legacy - tetap dipertahankan)
    Route::prefix('kegiatan')->name('kegiatan.')->group(function () {
        Route::get('/',              [DosenController::class, 'kegiatanIndex'])->name('index');
        Route::get('/create',        [DosenController::class, 'kegiatanCreate'])->name('create');
        Route::post('/',             [DosenController::class, 'kegiatanStore'])->name('store');
        Route::get('/{kegiatan}/edit',    [DosenController::class, 'kegiatanEdit'])->name('edit');
        Route::put('/{kegiatan}',         [DosenController::class, 'kegiatanUpdate'])->name('update');
        Route::delete('/{kegiatan}',      [DosenController::class, 'kegiatanDestroy'])->name('destroy');
    });

    // Simulasi Angka Kredit
    Route::prefix('simulasi')->name('simulasi.')->group(function () {
        Route::get('/',              [DosenController::class, 'simulasiIndex'])->name('index');
        Route::get('/create',        [DosenController::class, 'simulasiCreate'])->name('create');
        Route::post('/',             [DosenController::class, 'simulasiStore'])->name('store');
        Route::get('/{simulasi}',    [DosenController::class, 'simulasiShow'])->name('show');
    });
});
