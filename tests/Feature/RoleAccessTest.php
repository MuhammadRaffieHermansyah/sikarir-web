<?php

use App\Models\User;

test('guest is redirected to login when accessing role protected route', function () {
    $this->get('/mitras')->assertRedirect('/login');
});

test('admin_blk can access admin only routes', function () {
    $user = User::factory()->create(['role' => 'admin_blk']);

    $this->actingAs($user)
        ->get('/mitras')
        ->assertOk();
});

test('peserta is redirected to dashboard with error when accessing admin only route', function () {
    $user = User::factory()->create(['role' => 'peserta']);

    $this->actingAs($user)
        ->get('/mitras')
        ->assertRedirect(route('dashboard'))
        ->assertSessionHas('error', 'Anda tidak memiliki akses ke halaman ini.');
});

test('mitra can access lowongan routes', function () {
    $user = User::factory()->create(['role' => 'mitra']);

    $this->actingAs($user)
        ->get('/lowongan')
        ->assertOk();
});

test('peserta is redirected to dashboard when accessing lowongan routes', function () {
    $user = User::factory()->create(['role' => 'peserta']);

    $this->actingAs($user)
        ->get('/lowongan')
        ->assertRedirect(route('dashboard'))
        ->assertSessionHas('error');
});

test('peserta can access absen and sertifikat routes', function () {
    $user = User::factory()->create(['role' => 'peserta']);

    $this->actingAs($user)
        ->get('/absen')
        ->assertOk();

    $this->actingAs($user)
        ->get('/sertifikat')
        ->assertOk();
});

test('mitra is redirected to dashboard when accessing absen routes', function () {
    $user = User::factory()->create(['role' => 'mitra']);

    $this->actingAs($user)
        ->get('/absen')
        ->assertRedirect(route('dashboard'))
        ->assertSessionHas('error');
});

test('api request returns json 403 on denied role', function () {
    $user = User::factory()->create(['role' => 'peserta']);

    $this->actingAs($user)
        ->getJson('/mitras')
        ->assertStatus(403)
        ->assertJson(['message' => 'Akses ditolak.']);
});
