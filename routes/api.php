<?php

use App\Http\Controllers\Api\AbsenController;
use App\Http\Controllers\Api\AdminBlkController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DaftarLowonganController;
use App\Http\Controllers\Api\DaftarPelatihanController;
use App\Http\Controllers\Api\DurasiPelatihanController;
use App\Http\Controllers\Api\InstrukturController;
use App\Http\Controllers\Api\JadwalPelatihanController;
use App\Http\Controllers\Api\KelasPelatihanController;
use App\Http\Controllers\Api\MateriController;
use App\Http\Controllers\Api\MitraController;
use App\Http\Controllers\Api\ModulController;
use App\Http\Controllers\Api\PesertaController;
use App\Http\Controllers\Api\ProfilePasswordController;
use App\Http\Controllers\Api\SertifikatController;
use App\Http\Controllers\Api\SesiPresensiController;
use App\Http\Controllers\Api\SwaggerTestController;
use Illuminate\Support\Facades\Route;

Route::name('api.')->group(function () {
    // Auth routes (public)
    Route::prefix('auth')->name('auth.')->group(function () {
        Route::middleware('throttle:10,1')->group(function () {
            Route::post('register', [AuthController::class, 'register'])->name('register');
            Route::post('login', [AuthController::class, 'login'])->name('login');
        });

        Route::middleware('auth:sanctum')->group(function () {
            Route::get('me', [AuthController::class, 'me'])->name('me');
            Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        });
    });

    // Public catalog & vacancy routes (read-only)
    Route::get('pelatihan', [DaftarPelatihanController::class, 'index']);
    Route::get('pelatihan/{id}', [DaftarPelatihanController::class, 'show'])->whereNumber('id');
    Route::get('daftar-pelatihan', [DaftarPelatihanController::class, 'index']);
    Route::get('daftar-pelatihan/{id}', [DaftarPelatihanController::class, 'show'])->whereNumber('id');

    Route::get('jadwal-pelatihan', [JadwalPelatihanController::class, 'index']);
    Route::get('jadwal-pelatihan/{id}', [JadwalPelatihanController::class, 'show'])->whereNumber('id');
    Route::get('jadwal', [JadwalPelatihanController::class, 'index']);
    Route::get('jadwal/{id}', [JadwalPelatihanController::class, 'show'])->whereNumber('id');

    // Lowongan umum (my-applications didefinisikan sebelum {id})
    Route::get('lowongan', [DaftarLowonganController::class, 'index']);

    Route::get('mitras', [MitraController::class, 'index']);
    Route::get('mitras/{id}', [MitraController::class, 'show'])->whereNumber('id');
    Route::get('mitra', [MitraController::class, 'index']);
    Route::get('mitra/{id}', [MitraController::class, 'show'])->whereNumber('id');

    // Protected API resource routes
    Route::middleware('auth:sanctum')->group(function () {
        // Data master: hanya admin BLK
        Route::middleware('role:admin_blk')->group(function () {
            Route::apiResource('mitras', MitraController::class)->except(['index', 'show']);
            Route::apiResource('mitra', MitraController::class)->except(['index', 'show']);
            Route::apiResource('durasi-pelatihan', DurasiPelatihanController::class);
        });
        // Fitur instruktur (mobile): kelas yang diampu, modul & materi
        Route::middleware('role:instruktur')->group(function () {
            Route::get('instruktur/me', [InstrukturController::class, 'me'])->name('instruktur.me');
            Route::match(['put', 'post'], 'instruktur/me', [InstrukturController::class, 'updateMe'])->name('instruktur.update-me');
        });
        Route::put('profile/password', ProfilePasswordController::class)->name('profile.password');
        Route::get('instruktur/kelas', [ModulController::class, 'kelasInstruktur'])->name('instruktur.kelas');
        Route::get('kelas-pelatihan/{idKelas}/modul', [ModulController::class, 'index'])->whereNumber('idKelas')->name('kelas.modul.index');
        Route::post('kelas-pelatihan/{idKelas}/modul', [ModulController::class, 'store'])->whereNumber('idKelas')->name('kelas.modul.store');
        Route::delete('modul/{idModul}', [ModulController::class, 'destroy'])->whereNumber('idModul')->name('modul.destroy');
        Route::post('modul/{idModul}/materi', [MateriController::class, 'store'])->whereNumber('idModul')->name('modul.materi.store');
        Route::delete('materi/{idMateri}', [MateriController::class, 'destroy'])->whereNumber('idMateri')->name('materi.destroy');

        // Sesi presensi dikontrol instruktur; `aktif` dipakai peserta.
        Route::get('kelas-pelatihan/{idKelas}/sesi-presensi/aktif', [SesiPresensiController::class, 'aktif'])->whereNumber('idKelas')->name('kelas.sesi-presensi.aktif');
        Route::get('kelas-pelatihan/{idKelas}/sesi-presensi', [SesiPresensiController::class, 'index'])->whereNumber('idKelas')->name('kelas.sesi-presensi.index');
        Route::post('kelas-pelatihan/{idKelas}/sesi-presensi', [SesiPresensiController::class, 'store'])->whereNumber('idKelas')->name('kelas.sesi-presensi.store');
        Route::patch('sesi-presensi/{idSesi}', [SesiPresensiController::class, 'update'])->whereNumber('idSesi')->name('sesi-presensi.update');
        Route::delete('sesi-presensi/{idSesi}', [SesiPresensiController::class, 'destroy'])->whereNumber('idSesi')->name('sesi-presensi.destroy');

        Route::apiResource('instruktur', InstrukturController::class)->middleware('role:admin_blk');

        // Peserta me & aliases (mendukung singular & plural)
        Route::get('pesertas/me', [PesertaController::class, 'me'])->name('pesertas.me');
        Route::match(['put', 'post'], 'pesertas/me', [PesertaController::class, 'updateMe'])->name('pesertas.update-me');
        Route::get('peserta/me', [PesertaController::class, 'me'])->name('peserta.me');
        Route::match(['put', 'post'], 'peserta/me', [PesertaController::class, 'updateMe'])->name('peserta.update-me');
        Route::middleware('role:admin_blk')->group(function () {
            Route::apiResource('pesertas', PesertaController::class);
            Route::apiResource('peserta', PesertaController::class);
            Route::apiResource('admin-blk', AdminBlkController::class);
        });

        // Lowongan kerja & lamaran (my-applications HARUS sebelum {id})
        Route::get('lowongan/my-applications', [DaftarLowonganController::class, 'myApplications'])->name('lowongan.my-applications');
        Route::post('lowongan/{id}/lamar', [DaftarLowonganController::class, 'lamar'])->name('lowongan.lamar');
        Route::get('lowongan/{id}', [DaftarLowonganController::class, 'show'])->whereNumber('id');
        Route::apiResource('lowongan', DaftarLowonganController::class)
            ->except(['index', 'show'])
            ->middleware(['role:admin_blk,mitra', 'mitra.verified']);

        // Pelatihan & Jadwal CRUD
        Route::middleware('role:admin_blk')->group(function () {
            Route::apiResource('pelatihan', DaftarPelatihanController::class)->except(['index', 'show']);
            Route::apiResource('daftar-pelatihan', DaftarPelatihanController::class)->except(['index', 'show']);
            Route::apiResource('jadwal-pelatihan', JadwalPelatihanController::class)->except(['index', 'show']);
            Route::apiResource('jadwal', JadwalPelatihanController::class)->except(['index', 'show']);
        });

        // Kelas Pelatihan & aliases
        Route::get('kelas-pelatihan/me', [KelasPelatihanController::class, 'myClasses'])->name('kelas-pelatihan.me');
        Route::get('kelas/me', [KelasPelatihanController::class, 'myClasses'])->name('kelas.me');
        // Daftar kelas: peserta untuk diri sendiri, admin untuk siapa pun. Detail dicek di controller.
        Route::post('kelas-pelatihan', [KelasPelatihanController::class, 'store'])->middleware('role:peserta,admin_blk')->name('kelas-pelatihan.store');
        Route::post('kelas', [KelasPelatihanController::class, 'store'])->middleware('role:peserta,admin_blk')->name('kelas.store');
        Route::apiResource('kelas-pelatihan', KelasPelatihanController::class)->only(['show']);
        Route::apiResource('kelas', KelasPelatihanController::class)->only(['show']);
        Route::middleware('role:admin_blk')->group(function () {
            Route::apiResource('kelas-pelatihan', KelasPelatihanController::class)->only(['index', 'update', 'destroy']);
            Route::apiResource('kelas', KelasPelatihanController::class)->only(['index', 'update', 'destroy']);
        });

        // Absensi & aliases
        Route::get('absen/today', [AbsenController::class, 'today'])->name('absen.today');
        Route::get('absen/rekap', [AbsenController::class, 'rekap'])->name('absen.rekap');
        Route::get('absensi/today', [AbsenController::class, 'today'])->name('absensi.today');
        Route::get('absensi/rekap', [AbsenController::class, 'rekap'])->name('absensi.rekap');
        // Absensi: peserta mencatat & melihat miliknya, admin melihat semua. Detail dicek di controller.
        Route::middleware('role:peserta,admin_blk')->group(function () {
            Route::apiResource('absen', AbsenController::class)->only(['index', 'show']);
            Route::apiResource('absensi', AbsenController::class)->only(['index', 'show']);
        });
        Route::middleware('role:peserta')->group(function () {
            Route::apiResource('absen', AbsenController::class)->only(['store']);
            Route::apiResource('absensi', AbsenController::class)->only(['store']);
        });
        Route::middleware('role:admin_blk')->group(function () {
            Route::apiResource('absen', AbsenController::class)->only(['update', 'destroy']);
            Route::apiResource('absensi', AbsenController::class)->only(['update', 'destroy']);
        });

        // Sertifikat & aliases
        Route::get('sertifikat/me', [SertifikatController::class, 'me'])->name('sertifikat.me');
        Route::get('sertifikasi/me', [SertifikatController::class, 'me'])->name('sertifikasi.me');
        // Sertifikat: diterbitkan admin; detail boleh dilihat pemiliknya (dicek di controller).
        Route::apiResource('sertifikat', SertifikatController::class)->only(['show']);
        Route::apiResource('sertifikasi', SertifikatController::class)->only(['show']);
        Route::middleware('role:admin_blk')->group(function () {
            Route::apiResource('sertifikat', SertifikatController::class)->except(['show']);
            Route::apiResource('sertifikasi', SertifikatController::class)->except(['show']);
        });
    });

    // Public show lowongan fallback
    Route::get('lowongan/{id}', [DaftarLowonganController::class, 'show'])->whereNumber('id');

    // Swagger test (public)
    Route::get('/swagger-test', [SwaggerTestController::class, 'index'])->name('swagger-test');
});
