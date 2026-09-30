<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
        public function up(): void
    {
        Schema::table('jadwal_pelatihan', function (Blueprint $table) {
            $table->foreign('id_ruangan_workshop')
                ->references('id')
                ->on('ruangan_workshops')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('jadwal_pelatihan', function (Blueprint $table) {
            $table->dropForeign(['id_ruangan_workshop']);
        });
    }
};