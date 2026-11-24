<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role', 30)->default('admin_blk')->change();
        });

        Schema::table('instruktur', function (Blueprint $table) {
            $table->foreignId('id_user')->nullable()->unique()->after('id')
                ->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('instruktur', function (Blueprint $table) {
            $table->dropConstrainedForeignId('id_user');
        });
    }
};
