<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mitras', function (Blueprint $table) {
            $table->id('id_mitra');
            $table->foreignId('id_user')->nullable()->unique()->constrained('users')->nullOnDelete();
            $table->string('nama_perusahaan');
            $table->string('jenis_mitra')->nullable();
            $table->string('logo_perusahaan')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kota')->nullable();
            $table->text('alamat')->nullable();
            $table->string('no_telp', 30)->nullable();
            $table->string('no_izin')->nullable();
            $table->string('jabatan_pic')->nullable();
            $table->string('bidang_usaha')->nullable();
            $table->timestamps();
        });

        Schema::create('admin_blks', function (Blueprint $table) {
            $table->id('id_admin');
            $table->foreignId('id_user')->unique()->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('pesertas', function (Blueprint $table) {
            $table->id('id_peserta');
            $table->foreignId('id_user')->unique()->constrained('users')->cascadeOnDelete();
            $table->foreignId('id_admin')->nullable()->constrained('admin_blks', 'id_admin')->nullOnDelete();
            $table->string('nomor_peserta')->unique();
            $table->string('jenis_kelamin', 20);
            $table->string('nomor_kk')->nullable();
            $table->string('nomor_wa', 30)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->text('alamat_lengkap')->nullable();
            $table->string('pendidikan_terakhir')->nullable();
            $table->string('pendidikan_sekarang')->nullable();
            $table->string('pas_foto')->nullable();
            $table->string('jurusan')->nullable();
            $table->timestamps();
        });

        Schema::create('daftar_lowongan', function (Blueprint $table) {
            $table->id('id_lowongan');
            $table->foreignId('id_mitra')->constrained('mitras', 'id_mitra')->cascadeOnDelete();
            $table->foreignId('id_admin')->constrained('admin_blks', 'id_admin')->cascadeOnDelete();
            $table->string('judul_lowongan');
            $table->string('lokasi')->nullable();
            $table->text('deskripsi')->nullable();
            $table->text('kualifikasi')->nullable();
            $table->date('tanggal_posting')->nullable();
            $table->string('status', 30)->default('aktif');
            $table->timestamps();
        });

        Schema::create('daftar_pelatihan', function (Blueprint $table) {
            $table->id('id_pelatihan');
            $table->foreignId('id_admin')->constrained('admin_blks', 'id_admin')->cascadeOnDelete();
            $table->string('nama_pelatihan');
            $table->text('deskripsi_pelatihan')->nullable();
            $table->string('durasi_lp')->nullable();
            $table->unsignedInteger('kuota')->default(0);
            $table->timestamps();
        });

        Schema::create('jadwal_pelatihan', function (Blueprint $table) {
            $table->id('id_jadwal');
            $table->foreignId('id_pelatihan')->constrained('daftar_pelatihan', 'id_pelatihan')->cascadeOnDelete();
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->time('jam_mulai')->nullable();
            $table->time('jam_selesai')->nullable();
            $table->string('instruktur')->nullable();
            $table->string('tempat')->nullable();
            $table->string('status', 30)->default('tersedia');
            $table->timestamps();
        });

        Schema::create('kelas_pelatihan', function (Blueprint $table) {
            $table->id('id_kelas');
            $table->foreignId('id_peserta')->constrained('pesertas', 'id_peserta')->cascadeOnDelete();
            $table->foreignId('id_jadwal')->constrained('jadwal_pelatihan', 'id_jadwal')->cascadeOnDelete();
            $table->string('status', 30)->default('terdaftar');
            $table->timestamps();
            $table->unique(['id_peserta', 'id_jadwal']);
        });

        Schema::create('absens', function (Blueprint $table) {
            $table->id('id_absen');
            $table->foreignId('id_jadwal')->constrained('jadwal_pelatihan', 'id_jadwal')->cascadeOnDelete();
            $table->foreignId('id_peserta')->constrained('pesertas', 'id_peserta')->cascadeOnDelete();
            $table->date('tanggal');
            $table->time('jam_hadir')->nullable();
            $table->string('status_kehadiran', 30)->default('hadir');
            $table->string('keterangan')->nullable();
            $table->timestamps();
            $table->unique(['id_jadwal', 'id_peserta', 'tanggal']);
        });

        Schema::create('sertifikats', function (Blueprint $table) {
            $table->id('id_sertifikat');
            $table->foreignId('id_jadwal')->constrained('jadwal_pelatihan', 'id_jadwal')->cascadeOnDelete();
            $table->foreignId('id_peserta')->constrained('pesertas', 'id_peserta')->cascadeOnDelete();
            $table->string('no_sertifikat')->unique();
            $table->date('tanggal_terbit');
            $table->string('file_sertifikat')->nullable();
            $table->foreignId('id_admin')->constrained('admin_blks', 'id_admin')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['id_jadwal', 'id_peserta']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sertifikats');
        Schema::dropIfExists('absens');
        Schema::dropIfExists('kelas_pelatihan');
        Schema::dropIfExists('jadwal_pelatihan');
        Schema::dropIfExists('daftar_pelatihan');
        Schema::dropIfExists('daftar_lowongan');
        Schema::dropIfExists('pesertas');
        Schema::dropIfExists('admin_blks');
        Schema::dropIfExists('mitras');
    }
};
