<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan kolom lokasi GPS ke tabel absens
     * dan menambahkan koordinat lokasi pelatihan ke jadwal_pelatihan.
     */
    public function up(): void
    {
        // Tambah kolom koordinat GPS peserta saat presensi
        if (Schema::hasTable('absens')) {
            Schema::table('absens', function (Blueprint $table) {
                if (!Schema::hasColumn('absens', 'latitude')) {
                    $table->decimal('latitude', 10, 7)->nullable()
                        ->comment('Latitude GPS peserta saat presensi');
                }
                if (!Schema::hasColumn('absens', 'longitude')) {
                    $table->decimal('longitude', 10, 7)->nullable()
                        ->comment('Longitude GPS peserta saat presensi');
                }
                if (!Schema::hasColumn('absens', 'jarak_meter')) {
                    $table->decimal('jarak_meter', 8, 2)->nullable()
                        ->comment('Jarak peserta ke lokasi pelatihan dalam meter');
                }
            });
        }

        // Tambah kolom koordinat lokasi pelatihan di jadwal_pelatihan
        if (Schema::hasTable('jadwal_pelatihan')) {
            Schema::table('jadwal_pelatihan', function (Blueprint $table) {
                if (!Schema::hasColumn('jadwal_pelatihan', 'lokasi_latitude')) {
                    $table->decimal('lokasi_latitude', 10, 7)->nullable()
                        ->comment('Latitude lokasi pelatihan (titik pusat absensi)');
                }
                if (!Schema::hasColumn('jadwal_pelatihan', 'lokasi_longitude')) {
                    $table->decimal('lokasi_longitude', 10, 7)->nullable()
                        ->comment('Longitude lokasi pelatihan (titik pusat absensi)');
                }
                if (!Schema::hasColumn('jadwal_pelatihan', 'radius_meter')) {
                    $table->unsignedInteger('radius_meter')->default(100)
                        ->comment('Radius (dalam meter) yang diizinkan untuk presensi');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('absens')) {
            Schema::table('absens', function (Blueprint $table) {
                $dropCols = [];
                if (Schema::hasColumn('absens', 'latitude')) $dropCols[] = 'latitude';
                if (Schema::hasColumn('absens', 'longitude')) $dropCols[] = 'longitude';
                if (Schema::hasColumn('absens', 'jarak_meter')) $dropCols[] = 'jarak_meter';
                if (!empty($dropCols)) {
                    $table->dropColumn($dropCols);
                }
            });
        }

        if (Schema::hasTable('jadwal_pelatihan')) {
            Schema::table('jadwal_pelatihan', function (Blueprint $table) {
                $dropCols = [];
                if (Schema::hasColumn('jadwal_pelatihan', 'lokasi_latitude')) $dropCols[] = 'lokasi_latitude';
                if (Schema::hasColumn('jadwal_pelatihan', 'lokasi_longitude')) $dropCols[] = 'lokasi_longitude';
                if (Schema::hasColumn('jadwal_pelatihan', 'radius_meter')) $dropCols[] = 'radius_meter';
                if (!empty($dropCols)) {
                    $table->dropColumn($dropCols);
                }
            });
        }
    }
};
