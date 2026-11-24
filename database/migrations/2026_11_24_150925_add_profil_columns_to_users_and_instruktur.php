<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('foto')->nullable()->after('role');
            $table->boolean('must_change_password')->default(false)->after('foto');
        });

        Schema::table('instruktur', function (Blueprint $table) {
            $table->string('nomor_wa', 20)->nullable()->after('bidang_keahlian');
            $table->string('bio', 500)->nullable()->after('nomor_wa');
            $table->string('keahlian', 200)->nullable()->after('bio');
        });
    }

    public function down(): void
    {
        Schema::table('instruktur', function (Blueprint $table) {
            $table->dropColumn(['nomor_wa', 'bio', 'keahlian']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['foto', 'must_change_password']);
        });
    }
};
