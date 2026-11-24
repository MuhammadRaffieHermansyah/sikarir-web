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
        Schema::table('mitras', function (Blueprint $table): void {
            $table->string('surat_legalitas_path')->nullable()->after('no_izin');
            $table->string('surat_permohonan_kerjasama_path')->nullable()->after('surat_legalitas_path');
            $table->boolean('is_verified')->default(false)->after('surat_permohonan_kerjasama_path');
            $table->timestamp('verified_at')->nullable()->after('is_verified');
            $table->foreignId('verified_by')->nullable()->after('verified_at')->constrained('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mitras', function (Blueprint $table): void {
            $table->dropConstrainedForeignId('verified_by');
            $table->dropColumn([
                'surat_legalitas_path',
                'surat_permohonan_kerjasama_path',
                'is_verified',
                'verified_at',
            ]);
        });
    }
};
