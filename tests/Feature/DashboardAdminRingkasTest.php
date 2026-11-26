<?php

use App\Models\JadwalPelatihan;
use App\Models\LamaranLowongan;
use App\Models\Mitra;
use App\Models\User;

beforeEach(function () {
    $this->admin = User::factory()->adminBlk()->create();
});

test('dashboard admin menampilkan mitra menunggu, pelatihan berjalan, dan lamaran masuk', function () {
    Mitra::factory()->count(2)->create(['is_verified' => false]);
    Mitra::factory()->create(['is_verified' => true]);
    JadwalPelatihan::factory()->count(3)->create(['status' => 'berlangsung']);
    JadwalPelatihan::factory()->create(['status' => 'selesai']);
    LamaranLowongan::factory()->count(4)->create();
    LamaranLowongan::factory()->create()->forceFill(['created_at' => now()->subDays(10)])->save();

    $this->actingAs($this->admin)
        ->get(route('dashboard'))
        ->assertOk()
        ->assertViewHas('stats', fn (array $stats): bool => $stats['mitra_menunggu'] === 2
            && $stats['pelatihan_berjalan'] === 3
            && $stats['lamaran_masuk'] === 5
            && $stats['lamaran_minggu_ini'] === 4)
        ->assertSee('Mitra Menunggu Verifikasi')
        ->assertSee('Perlu ditinjau')
        ->assertSee(route('mitras.index', ['verifikasi' => 'menunggu']), false)
        ->assertSee(route('jadwal-pelatihan.index', ['status' => 'berlangsung']), false)
        ->assertSee('4 dalam 7 hari terakhir');
});

test('angka mitra menunggu langsung berubah setelah mitra diverifikasi', function () {
    $mitra = Mitra::factory()->create(['is_verified' => false]);
    $this->actingAs($this->admin)->get(route('dashboard'))
        ->assertViewHas('stats', fn (array $stats): bool => $stats['mitra_menunggu'] === 1);

    $mitra->update(['is_verified' => true]);

    $this->get(route('dashboard'))
        ->assertViewHas('stats', fn (array $stats): bool => $stats['mitra_menunggu'] === 0)
        ->assertDontSee('Perlu ditinjau');
});

test('daftar mitra bisa difilter yang menunggu verifikasi', function () {
    $menunggu = Mitra::factory()->create(['is_verified' => false, 'nama_perusahaan' => 'PT Menunggu Verifikasi']);
    Mitra::factory()->create(['is_verified' => true, 'nama_perusahaan' => 'PT Sudah Terverifikasi']);

    $this->actingAs($this->admin)
        ->get(route('mitras.index', ['verifikasi' => 'menunggu']))
        ->assertOk()
        ->assertSee($menunggu->nama_perusahaan)
        ->assertDontSee('PT Sudah Terverifikasi');
});

test('dashboard mitra tidak menampilkan ringkasan admin', function () {
    $user = User::factory()->mitra()->create();
    Mitra::factory()->create(['id_user' => $user->id, 'is_verified' => true]);

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertOk()
        ->assertDontSee('Mitra Menunggu Verifikasi');
});
