<?php

use App\Http\Controllers\AbsenController;
use App\Http\Controllers\AdminBlkController;
use App\Http\Controllers\DaftarLowonganController;
use App\Http\Controllers\DaftarPelatihanController;
use App\Http\Controllers\JadwalPelatihanController;
use App\Http\Controllers\KelasPelatihanController;
use App\Http\Controllers\MitraController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicLowonganController;
use App\Http\Controllers\PublicPelatihanController;
use App\Http\Controllers\SertifikatController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/program-pelatihan', [PublicPelatihanController::class, 'index'])->name('pelatihan.katalog');
Route::get('/lowongan-kerja', [PublicLowonganController::class, 'index'])->name('lowongan.katalog');
Route::view('/tentang-blk', 'public.tentang-blk')->name('tentang.index');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Resource web routes (return views)
    Route::middleware('role:admin_blk')->group(function () {
        Route::resource('mitras', MitraController::class);
        Route::resource('pesertas', PesertaController::class);
        Route::resource('admin-blk', AdminBlkController::class);
        Route::resource('jadwal-pelatihan', JadwalPelatihanController::class);
        Route::resource('kelas-pelatihan', KelasPelatihanController::class);
    });

    Route::middleware('role:admin_blk,mitra')->group(function () {
        Route::resource('lowongan', DaftarLowonganController::class);
    });

    Route::middleware('role:admin_blk,mitra,peserta')->group(function () {
        Route::resource('pelatihan', DaftarPelatihanController::class);
    });

    Route::middleware('role:admin_blk,peserta')->group(function () {
        Route::resource('absen', AbsenController::class);
        Route::resource('sertifikat', SertifikatController::class);
    });
});

require __DIR__.'/auth.php';
