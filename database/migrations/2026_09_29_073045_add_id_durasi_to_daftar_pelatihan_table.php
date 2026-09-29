<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('daftar_pelatihan', function (Blueprint $table) {
            $table->dropColumn('durasi_lp');

            $table->foreignId('id_durasi')
                ->nullable()
                ->after('deskripsi_pelatihan')
                ->constrained('durasi_pelatihan', 'id_durasi')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('daftar_pelatihan', function (Blueprint $table) {
            $table->dropForeign(['id_durasi']);
            $table->dropColumn('id_durasi');

            $table->string('durasi_lp')->nullable();
        });
    }
};
