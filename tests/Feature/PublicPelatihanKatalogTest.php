<?php

use App\Models\DaftarPelatihan;

test('katalog program pelatihan menampilkan 6 program terbaru tanpa pagination', function () {
    DaftarPelatihan::factory()->count(10)->create();

    $this->get(route('pelatihan.katalog'))
        ->assertOk()
        ->assertViewHas('pelatihan', fn ($pelatihan) => $pelatihan->count() === 6)
        ->assertDontSee('aria-label="Navigasi halaman"', false);
});
