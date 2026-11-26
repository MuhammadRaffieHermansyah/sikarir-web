<?php

use App\Models\Sertifikat;
use Database\Seeders\SertifikatDemoSeeder;
use Illuminate\Support\Facades\Storage;

test('seeder membuat file PDF untuk sertifikat yang filenya belum ada', function () {
    Storage::fake('public');
    $tanpaFile = Sertifikat::factory()->create(['file_sertifikat' => 'sertifikat/demo.pdf']);
    $sudahAda = Sertifikat::factory()->create(['file_sertifikat' => 'sertifikat/asli.pdf']);
    Storage::disk('public')->put('sertifikat/asli.pdf', 'ISI ASLI');

    $this->seed(SertifikatDemoSeeder::class);

    expect(Storage::disk('public')->get($tanpaFile->file_sertifikat))->toStartWith('%PDF-1.4')
        ->toContain($tanpaFile->no_sertifikat)
        ->and(Storage::disk('public')->get($sudahAda->file_sertifikat))->toBe('ISI ASLI');
});

test('file sertifikat bisa diunduh lewat file_url dari API', function () {
    Storage::fake('public');
    $sertifikat = Sertifikat::factory()->create(['file_sertifikat' => 'sertifikat/demo.pdf']);

    $this->seed(SertifikatDemoSeeder::class);

    $this->actingAs($sertifikat->peserta->user, 'sanctum')
        ->getJson('/api/sertifikat/me')
        ->assertOk()
        ->assertJsonPath('data.0.file_url', url('storage/sertifikat/demo.pdf'));
});
