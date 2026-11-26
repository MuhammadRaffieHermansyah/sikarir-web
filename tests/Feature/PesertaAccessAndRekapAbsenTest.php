<?php

use App\Models\Absen;
use App\Models\DaftarPelatihan;
use App\Models\Instruktur;
use App\Models\JadwalPelatihan;
use App\Models\Peserta;
use App\Models\Sertifikat;
use App\Models\User;

beforeEach(function () {
    $this->admin = User::factory()->create(['role' => 'admin_blk']);
    $this->peserta = Peserta::factory()->create();
    $this->peserta->user->update(['role' => 'peserta']);
    $this->pesertaLain = Peserta::factory()->create();
});

test('peserta tidak bisa membuat, mengubah, atau menghapus absensi', function () {
    $absen = Absen::factory()->create(['id_peserta' => $this->peserta->id_peserta]);
    $this->actingAs($this->peserta->user);

    $this->get(route('absen.create'))->assertRedirect(route('login'));
    $this->post(route('absen.store'), [])->assertRedirect(route('login'));
    $this->get(route('absen.edit', $absen->id_absen))->assertRedirect(route('login'));
    $this->delete(route('absen.destroy', $absen->id_absen))->assertRedirect(route('login'));
    $this->get(route('absen.rekap'))->assertRedirect(route('login'));

    expect(Absen::find($absen->id_absen))->not->toBeNull();
});

test('peserta tidak bisa mengelola sertifikat dan program pelatihan', function () {
    $sertifikat = Sertifikat::factory()->create(['id_peserta' => $this->peserta->id_peserta]);
    $pelatihan = DaftarPelatihan::factory()->create();
    $this->actingAs($this->peserta->user);

    $this->delete(route('sertifikat.destroy', $sertifikat->id_sertifikat))->assertRedirect(route('login'));
    $this->get(route('sertifikat.create'))->assertRedirect(route('login'));
    $this->delete(route('pelatihan.destroy', $pelatihan->id_pelatihan))->assertRedirect(route('login'));
    $this->get(route('pelatihan.create'))->assertRedirect(route('login'));

    expect(Sertifikat::find($sertifikat->id_sertifikat))->not->toBeNull()
        ->and(DaftarPelatihan::find($pelatihan->id_pelatihan))->not->toBeNull();
});

test('peserta melihat presensi dan sertifikatnya lewat aplikasi, bukan web', function () {
    Absen::factory()->create(['id_peserta' => $this->peserta->id_peserta]);
    Sertifikat::factory()->create(['id_peserta' => $this->peserta->id_peserta]);

    foreach ([route('absen.index'), route('sertifikat.index'), route('pelatihan.index')] as $url) {
        $this->actingAs($this->peserta->user)->get($url)->assertRedirect(route('login'));
        $this->assertGuest();
    }
});

test('admin bisa membuka halaman rekap absensi dengan statistik yang benar', function () {
    $jadwal = JadwalPelatihan::factory()->create();
    foreach ([['hadir', '2026-11-01'], ['hadir', '2026-11-02'], ['hadir', '2026-11-03'], ['alpha', '2026-11-04']] as [$status, $tanggal]) {
        Absen::factory()->create([
            'id_peserta' => $this->peserta->id_peserta,
            'id_jadwal' => $jadwal->id_jadwal,
            'status_kehadiran' => $status,
            'tanggal' => $tanggal,
        ]);
    }

    $this->actingAs($this->admin)
        ->get(route('absen.rekap', ['id_jadwal' => $jadwal->id_jadwal]))
        ->assertOk()
        ->assertViewHas('totalHadir', 3)
        ->assertViewHas('totalAlpha', 1)
        ->assertViewHas('persenHadir', 75.0)
        ->assertSee('Perlu Perhatian');
});

test('rekap absensi menolak rentang tanggal terbalik', function () {
    $this->actingAs($this->admin)
        ->get(route('absen.rekap', ['tanggal_mulai' => '2026-11-10', 'tanggal_selesai' => '2026-11-01']))
        ->assertSessionHasErrors('tanggal_selesai');
});

test('admin bisa export excel dan membuka halaman cetak', function () {
    Absen::factory()->create([
        'id_peserta' => $this->peserta->id_peserta,
        'status_kehadiran' => 'hadir',
    ]);

    $excel = $this->actingAs($this->admin)->get(route('absen.export'));
    $excel->assertOk()->assertDownload();
    expect($excel->headers->get('content-type'))->toContain('spreadsheetml')
        ->and(xlsxSheetXml($excel))->toContain($this->peserta->nomor_peserta);

    $this->actingAs($this->admin)->get(route('absen.cetak'))->assertOk();
});

test('validasi menerima alamat dan nama pelatihan dengan angka serta tanda baca', function () {
    $this->actingAs($this->admin)
        ->post(route('pelatihan.store'), [
            'id_instruktur' => Instruktur::factory()->create()->id,
            'nama_pelatihan' => 'Teknisi AC 2 (Dasar)',
            'kuota' => 10,
        ])
        ->assertSessionDoesntHaveErrors('nama_pelatihan');
});
