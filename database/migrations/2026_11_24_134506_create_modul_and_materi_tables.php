<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('modul', function (Blueprint $table) {
            $table->id('id_modul');
            $table->unsignedBigInteger('id_jadwal');
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->unsignedInteger('pertemuan_ke');
            $table->timestamps();

            $table->foreign('id_jadwal')->references('id_jadwal')->on('jadwal_pelatihan')->cascadeOnDelete();
        });

        Schema::create('materi', function (Blueprint $table) {
            $table->id('id_materi');
            $table->unsignedBigInteger('id_modul');
            $table->string('judul');
            $table->enum('tipe', ['file', 'link', 'teks']);
            $table->string('url', 2048)->nullable();
            $table->string('nama_file')->nullable();
            $table->longText('konten')->nullable();
            $table->timestamps();

            $table->foreign('id_modul')->references('id_modul')->on('modul')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('materi');
        Schema::dropIfExists('modul');
    }
};
