<?php

use App\Http\Controllers\Api\AdminBlkController;
use App\Http\Controllers\Api\AbsenController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DaftarLowonganController;
use App\Http\Controllers\Api\DaftarPelatihanController;
use App\Http\Controllers\Api\DurasiPelatihanController;
use App\Http\Controllers\Api\InstrukturController;
use App\Http\Controllers\Api\JadwalPelatihanController;
use App\Http\Controllers\Api\KelasPelatihanController;
use App\Http\Controllers\Api\MitraController;
use App\Http\Controllers\Api\PesertaController;
use App\Http\Controllers\Api\SertifikatController;
use App\Http\Controllers\Api\SwaggerTestController;
use Illuminate\Support\Facades\Route;

Route::name('api.')->group(function () {
    // Auth routes (public)
    Route::prefix('auth')->name('auth.')->group(function () {
        Route::post('register', [AuthController::class, 'register'])->name('register');
        Route::post('login', [AuthController::class, 'login'])->name('login');

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
        // Mitra
        Route::apiResource('mitras', MitraController::class)->except(['index', 'show']);
        Route::apiResource('mitra', MitraController::class)->except(['index', 'show']);

        Route::apiResource('durasi-pelatihan', DurasiPelatihanController::class);
        Route::apiResource('instruktur', InstrukturController::class);

        // Peserta me & aliases (mendukung singular & plural)
        Route::get('pesertas/me', [PesertaController::class, 'me'])->name('pesertas.me');
        Route::match(['put', 'post'], 'pesertas/me', [PesertaController::class, 'updateMe'])->name('pesertas.update-me');
        Route::get('peserta/me', [PesertaController::class, 'me'])->name('peserta.me');
        Route::match(['put', 'post'], 'peserta/me', [PesertaController::class, 'updateMe'])->name('peserta.update-me');
        Route::apiResource('pesertas', PesertaController::class);
        Route::apiResource('peserta', PesertaController::class);

        Route::apiResource('admin-blk', AdminBlkController::class);

        // Lowongan kerja & lamaran (my-applications HARUS sebelum {id})
        Route::get('lowongan/my-applications', [DaftarLowonganController::class, 'myApplications'])->name('lowongan.my-applications');
        Route::post('lowongan/{id}/lamar', [DaftarLowonganController::class, 'lamar'])->name('lowongan.lamar');
        Route::get('lowongan/{id}', [DaftarLowonganController::class, 'show'])->whereNumber('id');
        Route::apiResource('lowongan', DaftarLowonganController::class)->except(['index', 'show']);

        // Pelatihan & Jadwal CRUD
        Route::apiResource('pelatihan', DaftarPelatihanController::class)->except(['index', 'show']);
        Route::apiResource('daftar-pelatihan', DaftarPelatihanController::class)->except(['index', 'show']);
        Route::apiResource('jadwal-pelatihan', JadwalPelatihanController::class)->except(['index', 'show']);
        Route::apiResource('jadwal', JadwalPelatihanController::class)->except(['index', 'show']);

        // Kelas Pelatihan & aliases
        Route::get('kelas-pelatihan/me', [KelasPelatihanController::class, 'myClasses'])->name('kelas-pelatihan.me');
        Route::get('kelas/me', [KelasPelatihanController::class, 'myClasses'])->name('kelas.me');
        Route::apiResource('kelas-pelatihan', KelasPelatihanController::class);
        Route::apiResource('kelas', KelasPelatihanController::class);

        // Absensi & aliases
        Route::get('absen/today', [AbsenController::class, 'today'])->name('absen.today');
        Route::get('absen/rekap', [AbsenController::class, 'rekap'])->name('absen.rekap');
        Route::get('absensi/today', [AbsenController::class, 'today'])->name('absensi.today');
        Route::get('absensi/rekap', [AbsenController::class, 'rekap'])->name('absensi.rekap');
        Route::apiResource('absen', AbsenController::class);
        Route::apiResource('absensi', AbsenController::class);

        // Sertifikat & aliases
        Route::get('sertifikat/me', [SertifikatController::class, 'me'])->name('sertifikat.me');
        Route::get('sertifikasi/me', [SertifikatController::class, 'me'])->name('sertifikasi.me');
        Route::apiResource('sertifikat', SertifikatController::class);
        Route::apiResource('sertifikasi', SertifikatController::class);
    });

    // Public show lowongan fallback
    Route::get('lowongan/{id}', [DaftarLowonganController::class, 'show'])->whereNumber('id');

    // Swagger test (public)
    Route::get('/swagger-test', [SwaggerTestController::class, 'index'])->name('swagger-test');
});
