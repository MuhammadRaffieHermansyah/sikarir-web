<?php

use App\Models\KelasPelatihan;
use App\Models\LamaranLowongan;
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

test('selain admin tidak bisa membuka laporan atau mengunduh export', function (string $route) {
    $peserta = Peserta::factory()->create();
    $peserta->user->update(['role' => 'peserta']);

    $this->actingAs($peserta->user)->get(route($route))->assertRedirect(route('dashboard'));
})->with(['laporan.index', 'laporan.peserta', 'laporan.pendaftaran', 'laporan.sertifikat', 'laporan.lamaran']);

test('export data peserta berisi peserta', function () {
    $peserta = Peserta::factory()->create();

    $response = $this->actingAs($this->admin)->get(route('laporan.peserta'));

    $response->assertOk()->assertDownload();
    expect($response->headers->get('content-type'))->toContain('text/csv')
        ->and($response->streamedContent())->toContain($peserta->nomor_peserta);
});

test('export pendaftaran hanya berisi jadwal yang difilter', function () {
    $kelas = KelasPelatihan::factory()->create();
    $kelasLain = KelasPelatihan::factory()->create();

    $csv = $this->actingAs($this->admin)
        ->get(route('laporan.pendaftaran', ['id_jadwal' => $kelas->id_jadwal]))
        ->assertOk()
        ->streamedContent();

    expect($csv)->toContain($kelas->peserta->nomor_peserta);
    expect($csv)
        ->not->toContain($kelasLain->peserta->nomor_peserta);
});

test('export sertifikat berisi nomor sertifikat', function () {
    $sertifikat = Sertifikat::factory()->create();

    $csv = $this->actingAs($this->admin)->get(route('laporan.sertifikat'))->assertOk()->streamedContent();

    expect($csv)->toContain($sertifikat->no_sertifikat);
});

test('export lamaran bisa difilter per status', function () {
    $diterima = LamaranLowongan::factory()->create(['status' => 'diterima']);
    $ditolak = LamaranLowongan::factory()->create(['status' => 'ditolak']);

    $csv = $this->actingAs($this->admin)
        ->get(route('laporan.lamaran', ['status' => 'diterima']))
        ->assertOk()
        ->streamedContent();

    expect($csv)->toContain($diterima->peserta->nomor_peserta);
    expect($csv)
        ->not->toContain($ditolak->peserta->nomor_peserta);
});

test('nilai yang diawali tanda sama dengan diamankan dari formula injection', function () {
    Peserta::factory()->create(['nama' => '=HYPERLINK("x")']);

    $csv = $this->actingAs($this->admin)->get(route('laporan.peserta'))->streamedContent();

    expect($csv)->toContain("'=HYPERLINK");
});
