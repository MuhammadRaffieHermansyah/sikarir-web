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
     * Drop `users.name` now that every role table owns the name.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('name');
        });
    }

    /**
     * Recreate `users.name` and copy the names back from the role tables.
     *
     * The restored column is nullable because the original NOT NULL constraint
     * cannot be guaranteed to be satisfiable without a profile name.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->nullable();
        });

        DB::table('users')
            ->select('id', 'role')
            ->orderBy('id')
            ->chunkById(100, function ($users): void {
                foreach ($users as $user) {
                    $table = self::ROLE_TABLES[$user->role] ?? 'admin_blks';

                    $nama = DB::table($table)
                        ->where('id_user', $user->id)
                        ->value('nama');

                    if ($nama !== null) {
                        DB::table('users')
                            ->where('id', $user->id)
                            ->update(['name' => $nama]);
                    }
                }
            });
    }
};
