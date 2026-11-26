<?php

use App\Http\Middleware\PastikanAksesWeb;
use App\Models\Mitra;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

test('peserta dan instruktur ditolak saat masuk lewat web', function (string $role) {
    $user = User::factory()->create(['role' => $role]);

    $this->post('/login', ['email' => $user->email, 'password' => 'password'])
        ->assertSessionHasErrors(['email' => PastikanAksesWeb::PESAN_KHUSUS_APLIKASI]);

    $this->assertGuest();
})->with(['peserta', 'instruktur']);

test('admin BLK dan mitra tetap bisa masuk lewat web', function (string $role) {
    $user = User::factory()->create(['role' => $role]);
    if ($role === 'mitra') {
        Mitra::factory()->create(['id_user' => $user->id, 'is_verified' => true]);
    }

    $this->post('/login', ['email' => $user->email, 'password' => 'password'])
        ->assertRedirect(route('dashboard', absolute: false));

    $this->assertAuthenticatedAs($user);
    $this->get(route('dashboard'))->assertOk();
})->with(['admin_blk', 'mitra']);

test('sesi web peserta yang masih aktif diakhiri dan diarahkan ke halaman masuk', function () {
    $this->actingAs(User::factory()->peserta()->create())
        ->get(route('profile.edit'))
        ->assertRedirect(route('login'))
        ->assertSessionHasErrors('email');

    $this->assertGuest();
});

test('peserta tetap bisa masuk dan memakai API mobile', function () {
    $user = User::factory()->peserta()->create();

    $this->postJson('/api/auth/login', ['email' => $user->email, 'password' => 'password'])
        ->assertOk();

    Sanctum::actingAs($user);
    $this->getJson('/api/sertifikat/me')->assertOk();
});
