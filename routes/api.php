<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MitraController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\AdminBlkController;
use App\Http\Controllers\DaftarLowonganController;
use App\Http\Controllers\DaftarPelatihanController;
use App\Http\Controllers\JadwalPelatihanController;
use App\Http\Controllers\KelasPelatihanController;
use App\Http\Controllers\AbsenController;
use App\Http\Controllers\SertifikatController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function(){
    Route::post('register',[AuthController::class,'register']);
    Route::post('login',[AuthController::class,'login']);
    Route::middleware('auth:sanctum')->group(function(){Route::get('me',[AuthController::class,'me']);Route::post('logout',[AuthController::class,'logout']);});
});

Route::middleware('auth:sanctum')->group(function(){
    Route::apiResource('mitras',MitraController::class);
    Route::apiResource('pesertas',PesertaController::class);
    Route::apiResource('admin-blk',AdminBlkController::class);
    Route::apiResource('lowongan',DaftarLowonganController::class);
    Route::apiResource('pelatihan',DaftarPelatihanController::class);
    Route::apiResource('jadwal-pelatihan',JadwalPelatihanController::class);
    Route::apiResource('kelas-pelatihan',KelasPelatihanController::class);
    Route::apiResource('absen',AbsenController::class);
    Route::apiResource('sertifikat',SertifikatController::class);
});

use App\Http\Controllers\Api\SwaggerTestController;

Route::get('/swagger-test', [
    SwaggerTestController::class,
    'index'
]);