<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('daftar_pelatihan', function (Blueprint $table) {
            // Program baru memakai instruktur. Admin lama tetap disimpan bila ada.
            $table->dropForeign(['id_admin']);
            $table->foreignId('id_admin')->nullable()->change();
            $table->foreign('id_admin')->references('id_admin')->on('admin_blks')->nullOnDelete();

            $table->foreignId('id_instruktur')
                ->nullable()
                ->after('id_admin')
                ->constrained('instruktur')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('daftar_pelatihan', function (Blueprint $table) {
            $table->dropForeign(['id_instruktur']);
            $table->dropColumn('id_instruktur');

            $table->dropForeign(['id_admin']);
            $table->foreignId('id_admin')->nullable(false)->change();
            $table->foreign('id_admin')->references('id_admin')->on('admin_blks')->cascadeOnDelete();
        });
    }
};
