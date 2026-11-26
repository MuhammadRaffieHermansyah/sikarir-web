<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bidang_keahlian', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 150)->unique();
            $table->timestamps();
        });

        // Bidang keahlian yang sudah dipakai instruktur dimasukkan ke master
        // supaya data lama tetap valid saat form instruktur memakai dropdown.
        $namaTerpakai = DB::table('instruktur')
            ->whereNotNull('bidang_keahlian')
            ->where('bidang_keahlian', '!=', '-')
            ->where('bidang_keahlian', '!=', '')
            ->distinct()
            ->pluck('bidang_keahlian');

        $sekarang = now();

        DB::table('bidang_keahlian')->insert(
            $namaTerpakai->map(fn (string $nama): array => [
                'nama' => $nama,
                'created_at' => $sekarang,
                'updated_at' => $sekarang,
            ])->all()
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bidang_keahlian');
    }
};
