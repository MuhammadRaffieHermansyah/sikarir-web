<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Map of the `users.role` value to the table that stores the person name.
     *
     * @var array<string, string>
     */
    private const ROLE_TABLES = [
        'admin_blk' => 'admin_blks',
        'mitra' => 'mitras',
        'peserta' => 'pesertas',
    ];

    /**
     * Add `nama` to each role table and copy the existing `users.name` into it.
     */
    public function up(): void
    {
        Schema::table('admin_blks', function (Blueprint $table) {
            $table->string('nama')->nullable();
        });

        Schema::table('mitras', function (Blueprint $table) {
            $table->string('nama')->nullable();
        });

        Schema::table('pesertas', function (Blueprint $table) {
            $table->string('nama')->nullable();
        });

        $now = now();

        DB::table('users')
            ->select('id', 'name', 'role')
            ->orderBy('id')
            ->chunkById(100, function ($users) use ($now): void {
                foreach ($users as $user) {
                    $table = self::ROLE_TABLES[$user->role] ?? 'admin_blks';

                    $updated = DB::table($table)
                        ->where('id_user', $user->id)
                        ->update(['nama' => $user->name]);

                    if ($updated > 0) {
                        continue;
                    }

                    $row = [
                        'id_user' => $user->id,
                        'nama' => $user->name,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];

                    if ($table === 'mitras') {
                        $row['nama_perusahaan'] = $user->name;
                    }

                    if ($table === 'pesertas') {
                        $row['nomor_peserta'] = 'PST-'.$now->format('Ymd').'-'.str_pad((string) $user->id, 4, '0', STR_PAD_LEFT);
                        $row['jenis_kelamin'] = 'Laki-laki';
                    }

                    DB::table($table)->insert($row);
                }
            });
    }

    /**
     * Remove the copied names. The original `users.name` values stay untouched.
     */
    public function down(): void
    {
        Schema::table('admin_blks', function (Blueprint $table) {
            $table->dropColumn('nama');
        });

        Schema::table('mitras', function (Blueprint $table) {
            $table->dropColumn('nama');
        });

        Schema::table('pesertas', function (Blueprint $table) {
            $table->dropColumn('nama');
        });
    }
};
