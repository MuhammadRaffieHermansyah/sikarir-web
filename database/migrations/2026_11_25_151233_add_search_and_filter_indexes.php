<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Index tambahan untuk kolom yang sering dipakai pada filter, pengurutan,
 * pengecekan unique, dan GROUP BY. Hanya menambah index (tanpa mengubah data),
 * dan dilewati bila index dengan nama yang sama sudah ada.
 */
return new class extends Migration
{
    /**
     * @var array<string, array<string, list<string>>>
     */
    private const INDEXES = [
        'daftar_lowongan' => ['daftar_lowongan_status_id_index' => ['status', 'id_lowongan']],
        'jadwal_pelatihan' => ['jadwal_pelatihan_status_index' => ['status']],
        'absens' => ['absens_peserta_tanggal_index' => ['id_peserta', 'tanggal']],
        'daftar_pelatihan' => ['daftar_pelatihan_nama_index' => ['nama_pelatihan']],
        'mitras' => [
            'mitras_nama_perusahaan_index' => ['nama_perusahaan'],
            'mitras_jenis_mitra_index' => ['jenis_mitra'],
        ],
        'pesertas' => ['pesertas_jurusan_index' => ['jurusan']],
    ];

    public function up(): void
    {
        foreach (self::INDEXES as $table => $indexes) {
            foreach ($indexes as $name => $columns) {
                if (! Schema::hasIndex($table, $name)) {
                    Schema::table($table, fn (Blueprint $blueprint) => $blueprint->index($columns, $name));
                }
            }
        }
    }

    public function down(): void
    {
        foreach (self::INDEXES as $table => $indexes) {
            foreach (array_keys($indexes) as $name) {
                if (Schema::hasIndex($table, $name)) {
                    Schema::table($table, fn (Blueprint $blueprint) => $blueprint->dropIndex($name));
                }
            }
        }
    }
};
