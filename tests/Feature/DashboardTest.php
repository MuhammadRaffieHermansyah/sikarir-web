<?php

use App\Models\User;

test('admin_blk sees dashboard statistics', function () {
    $user = User::factory()->create(['role' => 'admin_blk']);

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertOk()
        ->assertViewHas('stats')
        ->assertSee('Total Pengguna Terdaftar');
});
