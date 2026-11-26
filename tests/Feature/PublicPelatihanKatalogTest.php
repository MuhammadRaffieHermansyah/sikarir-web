<?php

use App\Models\DaftarPelatihan;

test('katalog program pelatihan renders pagination', function () {
    DaftarPelatihan::factory()->count(10)->create();

    $this->get(route('pelatihan.katalog'))
        ->assertOk()
        ->assertSee('aria-label="Navigasi halaman"', false);
});
