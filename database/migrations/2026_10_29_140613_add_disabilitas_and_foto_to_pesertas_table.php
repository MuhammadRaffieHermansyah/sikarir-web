<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pesertas', function (Blueprint $table) {
            // Apakah peserta merupakan penyandang disabilitas
            $table->boolean('is_disabilitas')->default(false)->after('jurusan');
            // Jenis disabilitas jika ada (opsional)
            $table->string('jenis_disabilitas', 100)->nullable()->after('is_disabilitas');
            // Status pendidikan saat ini: sudah_lulus / masih_menempuh
            $table->enum('status_pendidikan', ['sudah_lulus', 'masih_menempuh'])->nullable()->after('jenis_disabilitas');
        });
    }

    public function down(): void
    {
        Schema::table('pesertas', function (Blueprint $table) {
            $table->dropColumn(['is_disabilitas', 'jenis_disabilitas', 'status_pendidikan']);
        });
    }
};
