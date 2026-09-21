<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MitraController;
use App\Http\Controllers\Api\PesertaController;
use App\Http\Controllers\Api\AdminBlkController;
use App\Http\Controllers\Api\DaftarLowonganController;
use App\Http\Controllers\Api\DaftarPelatihanController;
use App\Http\Controllers\Api\JadwalPelatihanController;
use App\Http\Controllers\Api\KelasPelatihanController;
use App\Http\Controllers\Api\AbsenController;
use App\Http\Controllers\Api\SertifikatController;
use App\Http\Controllers\Api\SwaggerTestController;
use Illuminate\Support\Facades\Route;

// Auth routes (public)
Route::name('api.')->prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register'])->name('register');
    Route::post('login', [AuthController::class, 'login'])->name('login');

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('me', [AuthController::class, 'me'])->name('me');
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    });
});

// Protected API resource routes
Route::name('api.')->middleware('auth:sanctum')->group(function () {
    Route::apiResource('mitras', MitraController::class);
    Route::apiResource('pesertas', PesertaController::class);
    Route::apiResource('admin-blk', AdminBlkController::class);
    Route::apiResource('lowongan', DaftarLowonganController::class);
    Route::apiResource('pelatihan', DaftarPelatihanController::class);
    Route::apiResource('jadwal-pelatihan', JadwalPelatihanController::class);
    Route::apiResource('kelas-pelatihan', KelasPelatihanController::class);
    Route::apiResource('absen', AbsenController::class);
    Route::apiResource('sertifikat', SertifikatController::class);
});

// Swagger test (public)
Route::get('/swagger-test', [SwaggerTestController::class, 'index'])->name('api.swagger-test');

