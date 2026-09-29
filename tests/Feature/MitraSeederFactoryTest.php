<?php

use App\Models\Mitra;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\MitraSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('mitra factory creates a user with role mitra by default', function () {
    $mitra = Mitra::factory()->create();

    expect($mitra->id_user)->not->toBeNull()
        ->and($mitra->user)->not->toBeNull()
        ->and($mitra->user->role)->toBe('mitra');
});

test('mitra factory accepts custom id_user with role mitra', function () {
    $user = User::factory()->mitra()->create();
    $mitra = Mitra::factory()->create(['id_user' => $user->id]);

    expect($mitra->id_user)->toBe($user->id)
        ->and($mitra->user->role)->toBe('mitra');
});

test('mitra seeder creates demo mitra and assigns unassigned mitra users', function () {
    $extraMitraUser = User::factory()->mitra()->create();

    $this->seed(MitraSeeder::class);

    $demoUser = User::where('email', 'mitra@sikarir.test')->first();
    expect($demoUser)->not->toBeNull()
        ->and($demoUser->role)->toBe('mitra')
        ->and($demoUser->mitra)->not->toBeNull();

    $extraMitraUser->refresh();
    expect($extraMitraUser->mitra)->not->toBeNull()
        ->and($extraMitraUser->mitra->id_user)->toBe($extraMitraUser->id);
});

test('database seeder creates mitras associated with users having role mitra', function () {
    $this->seed(DatabaseSeeder::class);

    $mitras = Mitra::with('user')->get();
    expect($mitras)->not->toBeEmpty();

    foreach ($mitras as $mitra) {
        expect($mitra->id_user)->not->toBeNull()
            ->and($mitra->user)->not->toBeNull()
            ->and($mitra->user->role)->toBe('mitra');
    }
});
