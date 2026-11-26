<?php

use App\Models\AdminBlk;
use App\Models\Mitra;
use App\Models\Peserta;
use App\Models\User;

/**
 * Form bersarang diabaikan browser: isi form hapus (termasuk _method=DELETE) ikut terkirim
 * saat tombol Simpan diklik. Pastikan form simpan tidak memuat form lain dan tidak ada
 * _method=DELETE di dalamnya.
 */
function pastikanFormSimpanTidakBersarang(string $html, string $aksiUpdate, string $aksiHapus): void
{
    $awal = strpos($html, 'action="'.$aksiUpdate.'"');
    expect($awal)->not->toBeFalse();

    $akhir = strpos($html, '</form>', $awal);
    $isiFormSimpan = substr($html, $awal, $akhir - $awal);

    expect($isiFormSimpan)->not->toContain('<form')
        ->and($isiFormSimpan)->not->toContain('name="_method" value="DELETE"')
        ->and($html)->toContain('action="'.$aksiHapus.'"');
}

beforeEach(function () {
    $this->admin = User::factory()->adminBlk()->create();
    AdminBlk::factory()->create(['id_user' => $this->admin->id]);
});

test('halaman edit peserta: tombol hapus tidak ikut form simpan', function () {
    $peserta = Peserta::factory()->create();
    $url = route('pesertas.update', $peserta->id_peserta);

    $html = $this->actingAs($this->admin)->get(route('pesertas.edit', $peserta->id_peserta))->assertOk()->getContent();

    pastikanFormSimpanTidakBersarang($html, $url, route('pesertas.destroy', $peserta->id_peserta));
    expect($html)->toContain('form="form-hapus-peserta"');
});

test('halaman edit mitra: tombol hapus tidak ikut form simpan', function () {
    $mitra = Mitra::factory()->create();

    $html = $this->actingAs($this->admin)->get(route('mitras.edit', $mitra->id_mitra))->assertOk()->getContent();

    pastikanFormSimpanTidakBersarang($html, route('mitras.update', $mitra->id_mitra), route('mitras.destroy', $mitra->id_mitra));
    expect($html)->toContain('form="form-hapus-mitra"');
});

test('halaman edit admin BLK: tombol hapus tidak ikut form simpan', function () {
    $adminLain = AdminBlk::factory()->create();

    $html = $this->actingAs($this->admin)->get(route('admin-blk.edit', $adminLain->id_admin))->assertOk()->getContent();

    pastikanFormSimpanTidakBersarang($html, route('admin-blk.update', $adminLain->id_admin), route('admin-blk.destroy', $adminLain->id_admin));
    expect($html)->toContain('form="form-hapus-admin"');
});

test('menyimpan perubahan peserta tidak menghapus data', function () {
    $peserta = Peserta::factory()->create();

    $this->actingAs($this->admin)
        ->put(route('pesertas.update', $peserta->id_peserta), ['nama' => 'Nama Baru Peserta'])
        ->assertSessionDoesntHaveErrors(['_method']);

    expect(Peserta::find($peserta->id_peserta))->not->toBeNull();
});
