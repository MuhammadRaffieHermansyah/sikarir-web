<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan data presensi pulang (jam + GPS) dan lampiran izin/sakit.
     */
    public function up(): void
    {
        Schema::table('absens', function (Blueprint $table) {
            $table->time('jam_keluar')->nullable()->after('jam_hadir')
                ->comment('Jam presensi pulang (waktu server)');
            $table->decimal('latitude_keluar', 10, 7)->nullable()
                ->comment('Latitude GPS peserta saat presensi pulang');
            $table->decimal('longitude_keluar', 10, 7)->nullable()
                ->comment('Longitude GPS peserta saat presensi pulang');
            $table->decimal('jarak_keluar_meter', 8, 2)->nullable()
                ->comment('Jarak peserta ke lokasi pelatihan saat presensi pulang (meter)');
            $table->string('lampiran')->nullable()
                ->comment('Path lampiran izin/sakit (disk public)');
        });
    }

    public function down(): void
    {
        Schema::table('absens', function (Blueprint $table) {
            $table->dropColumn([
                'jam_keluar',
                'latitude_keluar',
                'longitude_keluar',
                'jarak_keluar_meter',
                'lampiran',
            ]);
        });
    }
};
