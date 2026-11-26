<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sesi_presensi', function (Blueprint $table) {
            $table->id('id_sesi');
            $table->unsignedBigInteger('id_jadwal');
            $table->unsignedBigInteger('id_instruktur')->nullable();
            $table->unsignedInteger('pertemuan_ke');
            $table->date('tanggal');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->decimal('lokasi_latitude', 10, 7)->nullable();
            $table->decimal('lokasi_longitude', 10, 7)->nullable();
            $table->unsignedInteger('radius_meter')->default(100);
            $table->boolean('absen_dibuka')->default(false);
            $table->timestamps();

            $table->foreign('id_jadwal')->references('id_jadwal')->on('jadwal_pelatihan')->cascadeOnDelete();
            $table->unique(['id_jadwal', 'pertemuan_ke']);
            $table->index(['id_jadwal', 'absen_dibuka', 'tanggal']);
        });

        Schema::table('absens', function (Blueprint $table) {
            $table->unsignedBigInteger('id_sesi')->nullable()->after('id_jadwal');
            $table->foreign('id_sesi')->references('id_sesi')->on('sesi_presensi')->nullOnDelete();
            $table->unique(['id_peserta', 'id_sesi']);
        });
    }

    public function down(): void
    {
        Schema::table('absens', function (Blueprint $table) {
            $table->dropForeign(['id_sesi']);
            $table->dropUnique(['id_peserta', 'id_sesi']);
            $table->dropColumn('id_sesi');
        });

        Schema::dropIfExists('sesi_presensi');
    }
};
