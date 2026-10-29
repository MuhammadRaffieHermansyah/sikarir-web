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

    // Protected API resource routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::apiResource('mitras', MitraController::class);
        Route::apiResource('durasi-pelatihan', DurasiPelatihanController::class);
        Route::apiResource('instruktur', InstrukturController::class);
        Route::get('pesertas/me', [PesertaController::class, 'me'])->name('pesertas.me');
        Route::match(['put', 'post'], 'pesertas/me', [PesertaController::class, 'updateMe'])->name('pesertas.update-me');
        Route::apiResource('pesertas', PesertaController::class);
        Route::apiResource('admin-blk', AdminBlkController::class);

        // Lowongan kerja & lamaran
        Route::get('lowongan/my-applications', [DaftarLowonganController::class, 'myApplications'])->name('lowongan.my-applications');
        Route::post('lowongan/{id}/lamar', [DaftarLowonganController::class, 'lamar'])->name('lowongan.lamar');
        Route::apiResource('lowongan', DaftarLowonganController::class);

        Route::apiResource('pelatihan', DaftarPelatihanController::class);
        Route::apiResource('jadwal-pelatihan', JadwalPelatihanController::class);
        Route::get('kelas-pelatihan/me', [KelasPelatihanController::class, 'myClasses'])->name('kelas-pelatihan.me');
        Route::apiResource('kelas-pelatihan', KelasPelatihanController::class);

        // Absensi
        Route::get('absen/today', [AbsenController::class, 'today'])->name('absen.today');
        Route::get('absen/rekap', [AbsenController::class, 'rekap'])->name('absen.rekap');
        Route::apiResource('absen', AbsenController::class);

        // Sertifikat
        Route::get('sertifikat/me', [SertifikatController::class, 'me'])->name('sertifikat.me');
        Route::apiResource('sertifikat', SertifikatController::class);
    });

    // Swagger test (public)
    Route::get('/swagger-test', [SwaggerTestController::class, 'index'])->name('swagger-test');
});
