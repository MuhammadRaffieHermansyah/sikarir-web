<?php

use App\Http\Controllers\AbsenController;
use App\Http\Controllers\AdminBlkController;
use App\Http\Controllers\DaftarLowonganController;
use App\Http\Controllers\DaftarPelatihanController;
use App\Http\Controllers\DurasiPelatihanController;
use App\Http\Controllers\JadwalPelatihanController;
use App\Http\Controllers\InstrukturController;
use App\Http\Controllers\KelasPelatihanController;
use App\Http\Controllers\LamaranLowonganController;
use App\Http\Controllers\MitraController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicLowonganController;
use App\Models\DaftarLowongan;
use App\Models\DaftarPelatihan;
use App\Http\Controllers\PublicPelatihanController;
use App\Http\Controllers\HariLiburController;
use App\Http\Controllers\SertifikatController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RuanganWorkshopController;

Route::get('/', function () {
    $pelatihans = DaftarPelatihan::latest('id_pelatihan')->take(8)->get();
    $lowongans = DaftarLowongan::with('mitra.user')
    ->where('status', 'aktif')
    ->latest('id_lowongan')
    ->take(6)
    ->get();
    return view('welcome', compact('pelatihans', 'lowongans'));
});
Route::get('/program-pelatihan', [PublicPelatihanController::class, 'index'])->name('pelatihan.katalog');
Route::get('/lowongan-kerja', [PublicLowonganController::class, 'index'])->name('lowongan.katalog');
Route::get('/lowongan-kerja', [PublicLowonganController::class, 'index'])->name('lowongan.katalog');
Route::get('/lowongan-kerja/{id}', [PublicLowonganController::class, 'show'])->whereNumber('id')->name('lowongan.detail');
Route::view('/tentang-blk', 'public.tentang-blk')->name('tentang.index');

// Route internal untuk data dinamis pada form jadwal pelatihan
Route::get('/internal/hari-libur', [HariLiburController::class, 'index'])->name('hari-libur.index')->middleware('auth');
Route::get('/internal/pelatihan/{id}/durasi', function ($id) {
    $pelatihan = \App\Models\DaftarPelatihan::with('durasi')->find($id);
    if (!$pelatihan || !$pelatihan->durasi) {
        return response()->json(['jam_mulai' => null, 'jam_selesai' => null, 'hari' => null, 'jam' => null]);
    }
    return response()->json([
        'hari'      => $pelatihan->durasi->hari,
        'jam'       => $pelatihan->durasi->jam,
        'jam_mulai' => '08:00',
        'jam_selesai' => '15:30',
    ]);
})->name('pelatihan.durasi')->middleware('auth');

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
        Route::resource('durasi-pelatihan', DurasiPelatihanController::class);
        Route::resource('instruktur', InstrukturController::class);
        Route::resource('pesertas', PesertaController::class);
        Route::resource('admin-blk', AdminBlkController::class);
        Route::resource('jadwal-pelatihan', JadwalPelatihanController::class);
        Route::resource('kelas-pelatihan', KelasPelatihanController::class);
        Route::resource('ruangan-workshop', RuanganWorkshopController::class);
    });

    Route::middleware('role:admin_blk,mitra')->group(function () {
        Route::resource('lowongan', DaftarLowonganController::class);
    });

    Route::middleware('role:admin_blk,mitra,peserta')->group(function () {
        Route::resource('pelatihan', DaftarPelatihanController::class);
    });

    Route::middleware('role:admin_blk,peserta')->group(function () {
        Route::get('absen/rekap', [AbsenController::class, 'rekap'])->name('absen.rekap');
        Route::get('absen/export', [AbsenController::class, 'export'])->name('absen.export');
        Route::get('absen/cetak', [AbsenController::class, 'cetak'])->name('absen.cetak');
        Route::resource('absen', AbsenController::class);
        Route::resource('sertifikat', SertifikatController::class);
    });
});

require __DIR__ . '/auth.php';
