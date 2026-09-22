<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Penjagaan level database (non-destruktif):
 * - Hanya MENAMBAH index untuk query laporan & filter yang sering dipakai.
 * - Tidak mengubah tipe kolom, nullable, FK, unique, atau default yang sudah ada,
 *   sehingga aman dijalankan di database yang sudah berisi data produksi.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('absens', function (Blueprint $table) {
            $table->index('tanggal', 'absens_tanggal_index');
        });

        Schema::table('jadwal_pelatihan', function (Blueprint $table) {
            $table->index('tanggal_mulai', 'jadwal_pelatihan_tanggal_mulai_index');
        });

        Schema::table('daftar_lowongan', function (Blueprint $table) {
            $table->index('status', 'daftar_lowongan_status_index');
        });
    }

    public function down(): void
    {
        Schema::table('daftar_lowongan', function (Blueprint $table) {
            $table->dropIndex('daftar_lowongan_status_index');
        });

        Schema::table('jadwal_pelatihan', function (Blueprint $table) {
            $table->dropIndex('jadwal_pelatihan_tanggal_mulai_index');
        });

        Schema::table('absens', function (Blueprint $table) {
            $table->dropIndex('absens_tanggal_index');
        });
    }
};
