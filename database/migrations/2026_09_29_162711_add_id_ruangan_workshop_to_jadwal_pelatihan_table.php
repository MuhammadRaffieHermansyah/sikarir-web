<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
        public function up(): void
    {
        Schema::table('jadwal_pelatihan', function (Blueprint $table) {
            $table->dropColumn('tempat');

            $table->foreignId('id_ruangan_workshop')
                ->nullable()
                ->constrained('ruangan_workshop')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('jadwal_pelatihan', function (Blueprint $table) {
            $table->dropForeign(['id_ruangan_workshop']);
            $table->dropColumn('id_ruangan_workshop');
        });
    }
};