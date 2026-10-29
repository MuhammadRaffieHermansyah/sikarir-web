<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lamaran_lowongan', function (Blueprint $table) {
            $table->id('id_lamaran');
            $table->foreignId('id_lowongan')->constrained('daftar_lowongan', 'id_lowongan')->cascadeOnDelete();
            $table->foreignId('id_peserta')->constrained('pesertas', 'id_peserta')->cascadeOnDelete();
            $table->date('tanggal_melamar');
            $table->enum('status', ['melamar', 'diproses', 'wawancara', 'diterima', 'ditolak'])->default('melamar');
            $table->text('catatan_pelamar')->nullable();
            $table->text('catatan_mitra')->nullable();
            $table->string('resume_url')->nullable();
            $table->timestamps();
            $table->unique(['id_lowongan', 'id_peserta']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lamaran_lowongan');
    }
};

