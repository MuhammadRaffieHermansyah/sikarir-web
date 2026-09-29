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
        Schema::table('durasi_pelatihan', function (Blueprint $table) {
            $table->unique(['hari', 'jam']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('durasi_pelatihan', function (Blueprint $table) {
            $table->dropUnique(['hari', 'jam']);
        });
    }
};
