<?php

use App\Models\DaftarPelatihan;
use App\Models\DurasiPelatihan;
use App\Models\User;

test('endpoint durasi lama dengan jam tetap 08:00-15:30 sudah dihapus', function () {
    $pelatihan = DaftarPelatihan::factory()->create();

    $this->actingAs(User::factory()->adminBlk()->create())
        ->get("/internal/pelatihan/{$pelatihan->id_pelatihan}/durasi")
        ->assertNotFound();
});

test('form jadwal membaca hari dan jam dari durasi program', function () {
    $durasi = DurasiPelatihan::factory()->create(['hari' => 20, 'jam' => 160]);
    DaftarPelatihan::factory()->create(['id_durasi' => $durasi->id_durasi]);

    $this->actingAs(User::factory()->adminBlk()->create())
        ->get(route('jadwal-pelatihan.create'))
        ->assertOk()
        ->assertSee('data-hari="20"', false)
        ->assertSee('data-jam="160"', false);
});
