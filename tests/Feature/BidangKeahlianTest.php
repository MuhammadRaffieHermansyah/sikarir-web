<?php

use App\Models\BidangKeahlian;
use App\Models\Instruktur;
use App\Models\User;

beforeEach(function () {
    $this->admin = User::factory()->create(['role' => 'admin_blk']);
});

test('admin bisa menambah bidang keahlian dan menolak nama ganda', function () {
    $this->actingAs($this->admin)
        ->post(route('bidang-keahlian.store'), ['nama' => 'Teknik Las'])
        ->assertRedirect(route('bidang-keahlian.index'));

    expect(BidangKeahlian::where('nama', 'Teknik Las')->exists())->toBeTrue();

    $this->actingAs($this->admin)
        ->post(route('bidang-keahlian.store'), ['nama' => 'Teknik Las'])
        ->assertSessionHasErrors('nama');
});

test('form tambah instruktur menampilkan dropdown bidang keahlian dari master', function () {
    BidangKeahlian::factory()->create(['nama' => 'Tata Boga']);

    $this->actingAs($this->admin)
        ->get(route('instruktur.create'))
        ->assertOk()
        ->assertSee('<option value="Tata Boga"', false);
});

test('instruktur hanya bisa memakai bidang keahlian yang ada di master', function () {
    BidangKeahlian::factory()->create(['nama' => 'Tata Boga']);

    $this->actingAs($this->admin)
        ->post(route('instruktur.store'), ['nama' => 'Rudi Hartono', 'bidang_keahlian' => 'Bidang Asal-asalan'])
        ->assertSessionHasErrors('bidang_keahlian');

    $this->actingAs($this->admin)
        ->post(route('instruktur.store'), ['nama' => 'Rudi Hartono', 'bidang_keahlian' => 'Tata Boga'])
        ->assertSessionDoesntHaveErrors();

    expect(Instruktur::where('nama', 'Rudi Hartono')->value('bidang_keahlian'))->toBe('Tata Boga');
});

test('mengganti nama bidang keahlian ikut memperbarui instruktur', function () {
    $bidang = BidangKeahlian::factory()->create(['nama' => 'Busana']);
    $instruktur = Instruktur::factory()->create(['bidang_keahlian' => 'Busana']);

    $this->actingAs($this->admin)
        ->put(route('bidang-keahlian.update', $bidang->id), ['nama' => 'Tata Busana'])
        ->assertRedirect(route('bidang-keahlian.index'));

    expect($instruktur->fresh()->bidang_keahlian)->toBe('Tata Busana');
});

test('bidang keahlian yang masih dipakai instruktur tidak bisa dihapus', function () {
    $bidang = BidangKeahlian::factory()->create(['nama' => 'Otomotif']);
    Instruktur::factory()->create(['bidang_keahlian' => 'Otomotif']);

    $this->actingAs($this->admin)
        ->delete(route('bidang-keahlian.destroy', $bidang->id))
        ->assertSessionHas('error');

    expect($bidang->fresh())->not->toBeNull();

    $kosong = BidangKeahlian::factory()->create(['nama' => 'Elektronika']);

    $this->actingAs($this->admin)
        ->delete(route('bidang-keahlian.destroy', $kosong->id))
        ->assertSessionHas('success');

    expect($kosong->fresh())->toBeNull();
});

test('selain admin BLK tidak bisa membuka master bidang keahlian', function () {
    $peserta = User::factory()->create(['role' => 'peserta']);

    $this->actingAs($peserta)
        ->get(route('bidang-keahlian.index'))
        ->assertRedirect();
});
