<?php

use App\Models\KelasPelatihan;
use App\Models\LamaranLowongan;
use App\Models\Mitra;
use App\Models\Peserta;
use App\Models\Sertifikat;
use App\Models\User;

beforeEach(function () {
    $this->admin = User::factory()->create(['role' => 'admin_blk']);
});

test('admin bisa membuka halaman laporan', function () {
    $this->actingAs($this->admin)
        ->get(route('laporan.index'))
        ->assertOk()
        ->assertSee(route('laporan.peserta'))
        ->assertSee(route('laporan.lamaran'));
});

test('mitra tidak bisa membuka laporan atau mengunduh export', function (string $route) {
    $mitra = Mitra::factory()->create();

    $this->actingAs($mitra->user)->get(route($route))->assertRedirect(route('dashboard'));
})->with(['laporan.index', 'laporan.peserta', 'laporan.pendaftaran', 'laporan.sertifikat', 'laporan.lamaran']);

test('export data peserta berisi peserta', function () {
    $peserta = Peserta::factory()->create();

    $response = $this->actingAs($this->admin)->get(route('laporan.peserta'));

    $response->assertOk()->assertDownload();
    expect($response->headers->get('content-type'))->toContain('spreadsheetml')
        ->and(xlsxSheetXml($response))->toContain($peserta->nomor_peserta)->toContain('Laporan Data Peserta');
});

test('export pendaftaran hanya berisi jadwal yang difilter', function () {
    $kelas = KelasPelatihan::factory()->create();
    $kelasLain = KelasPelatihan::factory()->create();

    $xml = $this->actingAs($this->admin)
        ->get(route('laporan.pendaftaran', ['id_jadwal' => $kelas->id_jadwal]))
        ->assertOk();
    $xml = xlsxSheetXml($xml);

    expect($xml)->toContain($kelas->peserta->nomor_peserta);
    expect($xml)
        ->not->toContain($kelasLain->peserta->nomor_peserta);
});

test('export sertifikat berisi nomor sertifikat', function () {
    $sertifikat = Sertifikat::factory()->create();

    $xml = xlsxSheetXml($this->actingAs($this->admin)->get(route('laporan.sertifikat'))->assertOk());

    expect($xml)->toContain($sertifikat->no_sertifikat);
});

test('export lamaran bisa difilter per status', function () {
    $diterima = LamaranLowongan::factory()->create(['status' => 'diterima']);
    $ditolak = LamaranLowongan::factory()->create(['status' => 'ditolak']);

    $xml = $this->actingAs($this->admin)
        ->get(route('laporan.lamaran', ['status' => 'diterima']))
        ->assertOk();
    $xml = xlsxSheetXml($xml);

    expect($xml)->toContain($diterima->peserta->nomor_peserta);
    expect($xml)
        ->not->toContain($ditolak->peserta->nomor_peserta);
});

test('nilai yang diawali tanda sama dengan disimpan sebagai teks, bukan rumus', function () {
    Peserta::factory()->create(['nama' => '=HYPERLINK("x")']);

    $xml = xlsxSheetXml($this->actingAs($this->admin)->get(route('laporan.peserta')));

    expect($xml)->toContain('=HYPERLINK(&quot;x&quot;)')->not->toContain('<f>');
});
