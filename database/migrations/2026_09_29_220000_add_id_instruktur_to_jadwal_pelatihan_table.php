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
        Schema::table('jadwal_pelatihan', function (Blueprint $table) {
            $table->dropColumn('instruktur');

            $table->foreignId('id_instruktur')
                ->nullable()
                ->after('jam_selesai')
                ->constrained('instruktur')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwal_pelatihan', function (Blueprint $table) {
            $table->dropForeign(['id_instruktur']);
            $table->dropColumn('id_instruktur');
            $table->string('instruktur')->nullable()->after('jam_selesai');
        });
    }
};
