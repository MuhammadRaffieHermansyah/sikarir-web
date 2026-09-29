<?php

use App\Models\DaftarLowongan;
use App\Models\Mitra;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('mitra can create lowongan and id_mitra is automatically set from authenticated user', function () {
    $user = User::factory()->mitra()->create();
    $mitra = Mitra::factory()->create(['id_user' => $user->id]);

    $response = $this->actingAs($user)->post(route('lowongan.store'), [
        'judul_lowongan'  => 'Fullstack Web Developer',
        'lokasi'          => 'Surabaya',
        'deskripsi'       => 'Mengembangkan aplikasi web berbasis Laravel dan Vue.',
        'kualifikasi'     => 'Minimal lulusan SMK / D3 Informatika.',
        'tanggal_posting' => '2026-09-30',
        'status'          => 'aktif',
    ]);

    $response->assertRedirect(route('lowongan.index'));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('daftar_lowongan', [
        'id_mitra'       => $mitra->id_mitra,
        'judul_lowongan' => 'Fullstack Web Developer',
        'lokasi'         => 'Surabaya',
        'status'         => 'aktif',
    ]);
});

test('mitra can update their own lowongan', function () {
    $user = User::factory()->mitra()->create();
    $mitra = Mitra::factory()->create(['id_user' => $user->id]);
    $lowongan = DaftarLowongan::factory()->create(['id_mitra' => $mitra->id_mitra]);

    $response = $this->actingAs($user)->put(route('lowongan.update', $lowongan->id_lowongan), [
        'judul_lowongan'  => 'Senior Web Developer',
        'lokasi'          => 'Malang',
        'deskripsi'       => 'Deskripsi baru.',
        'kualifikasi'     => 'Kualifikasi baru.',
        'tanggal_posting' => '2026-09-30',
        'status'          => 'draft',
    ]);

    $response->assertRedirect(route('lowongan.index'));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('daftar_lowongan', [
        'id_lowongan'    => $lowongan->id_lowongan,
        'judul_lowongan' => 'Senior Web Developer',
        'status'         => 'draft',
    ]);
});

test('mitra can delete their own lowongan', function () {
    $user = User::factory()->mitra()->create();
    $mitra = Mitra::factory()->create(['id_user' => $user->id]);
    $lowongan = DaftarLowongan::factory()->create(['id_mitra' => $mitra->id_mitra]);

    $response = $this->actingAs($user)->delete(route('lowongan.destroy', $lowongan->id_lowongan));

    $response->assertRedirect(route('lowongan.index'));
    $response->assertSessionHas('success');

    $this->assertDatabaseMissing('daftar_lowongan', [
        'id_lowongan' => $lowongan->id_lowongan,
    ]);
});
