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

test('mitra cannot create duplicate lowongan title within the same mitra', function () {
    $user = User::factory()->mitra()->create();
    $mitra = Mitra::factory()->create(['id_user' => $user->id]);

    DaftarLowongan::factory()->create([
        'id_mitra'       => $mitra->id_mitra,
        'judul_lowongan' => 'Frontend Developer',
    ]);

    $response = $this->actingAs($user)->post(route('lowongan.store'), [
        'judul_lowongan'  => 'Frontend Developer',
        'lokasi'          => 'Jakarta',
        'deskripsi'       => 'Deskripsi lowongan kedua.',
        'kualifikasi'     => 'Kualifikasi lowongan kedua.',
        'tanggal_posting' => '2026-09-30',
        'status'          => 'aktif',
    ]);

    $response->assertSessionHasErrors('judul_lowongan');
});

test('different mitras can create lowongan with identical title', function () {
    $userA = User::factory()->mitra()->create();
    $mitraA = Mitra::factory()->create(['id_user' => $userA->id]);

    $userB = User::factory()->mitra()->create();
    $mitraB = Mitra::factory()->create(['id_user' => $userB->id]);

    DaftarLowongan::factory()->create([
        'id_mitra'       => $mitraA->id_mitra,
        'judul_lowongan' => 'Mobile Developer',
    ]);

    $response = $this->actingAs($userB)->post(route('lowongan.store'), [
        'judul_lowongan'  => 'Mobile Developer',
        'lokasi'          => 'Bandung',
        'deskripsi'       => 'Deskripsi dari mitra B.',
        'kualifikasi'     => 'Kualifikasi dari mitra B.',
        'tanggal_posting' => '2026-09-30',
        'status'          => 'aktif',
    ]);

    $response->assertRedirect(route('lowongan.index'));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('daftar_lowongan', [
        'id_mitra'       => $mitraB->id_mitra,
        'judul_lowongan' => 'Mobile Developer',
    ]);
});

test('mitra cannot update lowongan to another title that already exists in the same mitra', function () {
    $user = User::factory()->mitra()->create();
    $mitra = Mitra::factory()->create(['id_user' => $user->id]);

    $lowongan1 = DaftarLowongan::factory()->create([
        'id_mitra'       => $mitra->id_mitra,
        'judul_lowongan' => 'DevOps Engineer',
    ]);

    $lowongan2 = DaftarLowongan::factory()->create([
        'id_mitra'       => $mitra->id_mitra,
        'judul_lowongan' => 'Cloud Architect',
    ]);

    // Coba ubah judul lowongan2 menjadi DevOps Engineer (yang sudah dipakai lowongan1 pada mitra yang sama)
    $response = $this->actingAs($user)->put(route('lowongan.update', $lowongan2->id_lowongan), [
        'judul_lowongan'  => 'DevOps Engineer',
        'lokasi'          => 'Surabaya',
        'deskripsi'       => 'Deskripsi diubah.',
        'kualifikasi'     => 'Kualifikasi diubah.',
        'tanggal_posting' => '2026-09-30',
        'status'          => 'aktif',
    ]);

    $response->assertSessionHasErrors('judul_lowongan');
});

