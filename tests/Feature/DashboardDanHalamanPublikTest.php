<?php

use App\Models\Absen;
use App\Models\AdminBlk;
use App\Models\User;

test('panel presensi admin memakai data nyata, bukan angka contoh', function () {
    $admin = User::factory()->create(['role' => 'admin_blk']);
    Absen::factory()->count(3)->create(['tanggal' => today()->toDateString(), 'status_kehadiran' => 'hadir']);
    Absen::factory()->create(['tanggal' => today()->toDateString(), 'status_kehadiran' => 'izin']);

    $this->actingAs($admin)
        ->get(route('admin-blk.index'))
        ->assertOk()
        ->assertSee('Presensi Hari Ini')
        ->assertDontSee('96.8%')
        ->assertDontSee('34,600');
});

test('panel presensi admin tidak error saat belum ada data absensi', function () {
    $admin = User::factory()->create(['role' => 'admin_blk']);

    $this->actingAs($admin)->get(route('admin-blk.index'))->assertOk()->assertSee('Belum ada data');
});

test('halaman publik tidak punya tombol mati dan memakai nomor WhatsApp dari konfigurasi', function () {
    foreach (['pelatihan.katalog', 'lowongan.katalog'] as $nama) {
        $this->get(route($nama))
            ->assertOk()
            ->assertDontSee('href="#"', false)
            ->assertDontSee('wa.me/#', false);
    }

    $this->get(route('lowongan.katalog'))->assertSee(route('register.mitra'), false);
});

test('halaman daftar dan detail admin BLK tidak error saat ada data', function () {
    $admin = User::factory()->create(['role' => 'admin_blk']);
    $profil = AdminBlk::factory()->create();

    $this->actingAs($admin)->get(route('admin-blk.index'))->assertOk();
    $this->actingAs($admin)->get(route('admin-blk.show', $profil->id_admin))->assertOk();
});
