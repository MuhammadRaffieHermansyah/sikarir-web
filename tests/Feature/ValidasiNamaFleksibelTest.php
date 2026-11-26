<?php

use App\Models\Mitra;
use App\Models\Peserta;
use App\Models\User;

test('registrasi peserta lewat aplikasi otomatis membuat profil peserta', function () {
    $this->postJson('/api/auth/register', [
        'name' => 'Siti Aminah',
        'email' => 'siti@example.com',
        'password' => 'password-kuat-123',
        'password_confirmation' => 'password-kuat-123',
    ]);

    $user = User::where('email', 'siti@example.com')->firstOrFail();

    expect($user->role)->toBe('peserta')
        ->and(Peserta::where('id_user', $user->id)->exists())->toBeTrue();
});

test('admin bisa menambah instruktur dengan gelar dan apostrof pada nama', function () {
    $admin = User::factory()->create(['role' => 'admin_blk']);

    $this->actingAs($admin)
        ->post(route('instruktur.store'), [
            'nama' => "Dr. Ma'ruf Hidayat, S.T., M.T.",
            'bidang_keahlian' => 'Teknik Listrik & Instalasi (K3)',
        ])
        ->assertSessionDoesntHaveErrors(['nama', 'bidang_keahlian']);
});

test('admin bisa memperbarui mitra dengan nama perusahaan bertanda baca', function () {
    $admin = User::factory()->create(['role' => 'admin_blk']);
    $mitra = Mitra::factory()->create();

    $this->actingAs($admin)
        ->put(route('mitras.update', $mitra->id_mitra), [
            'nama_perusahaan' => 'PT. Maju Jaya Sentosa',
            'bidang_usaha' => 'Manufaktur & Logistik',
            'jabatan_pic' => 'Kepala Divisi HRD',
            'provinsi' => 'DKI Jakarta',
            'kota' => 'Kab. Jember',
            'no_izin' => 'NIB/123-456',
        ])
        ->assertSessionDoesntHaveErrors(['nama_perusahaan', 'bidang_usaha', 'jabatan_pic', 'provinsi', 'kota', 'no_izin']);
});

test('instruktur tetap menolak karakter berbahaya pada nama', function () {
    $admin = User::factory()->create(['role' => 'admin_blk']);

    $this->actingAs($admin)
        ->post(route('instruktur.store'), ['nama' => '<script>alert(1)</script>', 'bidang_keahlian' => 'Las'])
        ->assertSessionHasErrors('nama');
});
