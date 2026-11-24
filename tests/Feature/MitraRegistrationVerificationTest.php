<?php

use App\Models\DaftarLowongan;
use App\Models\LamaranLowongan;
use App\Models\Mitra;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

test('mitra can register with verification documents', function () {
    Storage::fake('local');

    $response = $this->post(route('register.mitra.store'), [
        'name' => 'Siti Rahma',
        'nama_perusahaan' => 'PT Maju Bersama',
        'email' => 'hrd@maju.test',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'surat_legalitas' => UploadedFile::fake()->create('legalitas.pdf', 100, 'application/pdf'),
        'surat_permohonan_kerjasama' => UploadedFile::fake()->create('permohonan.pdf', 100, 'application/pdf'),
    ]);

    $response->assertRedirect(route('dashboard'));
    $response->assertSessionHas('success');

    $user = User::where('email', 'hrd@maju.test')->firstOrFail();
    $mitra = Mitra::where('id_user', $user->id)->firstOrFail();

    expect($user->role)->toBe('mitra')
        ->and($mitra->is_verified)->toBeFalse()
        ->and($mitra->nama)->toBe('Siti Rahma')
        ->and($user->name)->toBe('Siti Rahma');

    Storage::disk('local')->assertExists($mitra->surat_legalitas_path);
    Storage::disk('local')->assertExists($mitra->surat_permohonan_kerjasama_path);
});

test('admin can verify a pending mitra and unlock lowongan access', function () {
    $admin = User::factory()->create(['role' => 'admin_blk']);
    $mitraUser = User::factory()->create(['role' => 'mitra']);
    $mitra = Mitra::factory()->create(['id_user' => $mitraUser->id, 'is_verified' => false]);

    $this->actingAs($mitraUser)->get(route('lowongan.index'))
        ->assertRedirect(route('dashboard'));

    $this->actingAs($admin)->patch(route('mitras.verify', $mitra))
        ->assertRedirect(route('mitras.show', $mitra));

    $this->assertDatabaseHas('mitras', [
        'id_mitra' => $mitra->id_mitra,
        'is_verified' => true,
        'verified_by' => $admin->id,
    ]);

    $this->actingAs($mitraUser)->get(route('lowongan.index'))->assertOk();

    $this->actingAs($mitraUser)->get(route('profile.edit'))
        ->assertOk()
        ->assertSee('Mitra Terverifikasi')
        ->assertSee('Status Mitra');
});

test('unverified mitra cannot manage lowongan through the API', function () {
    $user = User::factory()->create(['role' => 'mitra']);
    Mitra::factory()->create(['id_user' => $user->id, 'is_verified' => false]);

    $this->actingAs($user, 'sanctum')->postJson('/api/lowongan', [
        'judul_lowongan' => 'Web Developer',
    ])->assertForbidden()
        ->assertJson(['message' => 'Akun mitra Anda masih menunggu verifikasi admin.']);
});

test('verified mitra sees only its own lowongan statistics on the dashboard', function () {
    $mitraUser = User::factory()->create(['role' => 'mitra']);
    $mitra = Mitra::factory()->create(['id_user' => $mitraUser->id, 'is_verified' => true]);
    $otherMitra = Mitra::factory()->create(['is_verified' => true]);

    $aktif = DaftarLowongan::factory()->create([
        'id_mitra' => $mitra->id_mitra,
        'judul_lowongan' => 'Frontend Developer Mitra Saya',
        'status' => 'aktif',
    ]);
    DaftarLowongan::factory()->create(['id_mitra' => $mitra->id_mitra, 'status' => 'draft']);
    DaftarLowongan::factory()->create(['id_mitra' => $mitra->id_mitra, 'status' => 'ditutup']);
    $otherLowongan = DaftarLowongan::factory()->create([
        'id_mitra' => $otherMitra->id_mitra,
        'judul_lowongan' => 'Lowongan Perusahaan Lain',
        'status' => 'aktif',
    ]);

    LamaranLowongan::factory()->count(2)->create(['id_lowongan' => $aktif->id_lowongan]);
    LamaranLowongan::factory()->count(3)->create(['id_lowongan' => $otherLowongan->id_lowongan]);

    $this->actingAs($mitraUser)->get(route('dashboard'))
        ->assertOk()
        ->assertSee('Dashboard Mitra')
        ->assertSee('Frontend Developer Mitra Saya')
        ->assertDontSee('Lowongan Perusahaan Lain')
        ->assertSee('2 Orang');
});

test('pending mitra sees the verification dashboard instead of lowongan statistics', function () {
    $mitraUser = User::factory()->create(['role' => 'mitra']);
    Mitra::factory()->create(['id_user' => $mitraUser->id, 'is_verified' => false]);

    $this->actingAs($mitraUser)->get(route('dashboard'))
        ->assertOk()
        ->assertSee('Pendaftaran mitra sedang ditinjau')
        ->assertDontSee('Buka Lowongan Baru');
});
