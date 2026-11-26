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

    $this->get(route('absen.create'))->assertRedirect(route('dashboard'));
    $this->post(route('absen.store'), [])->assertRedirect(route('dashboard'));
    $this->get(route('absen.edit', $absen->id_absen))->assertRedirect(route('dashboard'));
    $this->delete(route('absen.destroy', $absen->id_absen))->assertRedirect(route('dashboard'));
    $this->get(route('absen.rekap'))->assertRedirect(route('dashboard'));

    expect(Absen::find($absen->id_absen))->not->toBeNull();
});

test('peserta tidak bisa mengelola sertifikat dan program pelatihan', function () {
    $sertifikat = Sertifikat::factory()->create(['id_peserta' => $this->peserta->id_peserta]);
    $pelatihan = DaftarPelatihan::factory()->create();
    $this->actingAs($this->peserta->user);

    $this->delete(route('sertifikat.destroy', $sertifikat->id_sertifikat))->assertRedirect(route('dashboard'));
    $this->get(route('sertifikat.create'))->assertRedirect(route('dashboard'));
    $this->delete(route('pelatihan.destroy', $pelatihan->id_pelatihan))->assertRedirect(route('dashboard'));
    $this->get(route('pelatihan.create'))->assertRedirect(route('dashboard'));

    expect(Sertifikat::find($sertifikat->id_sertifikat))->not->toBeNull()
        ->and(DaftarPelatihan::find($pelatihan->id_pelatihan))->not->toBeNull();
});

test('peserta hanya melihat absensi miliknya sendiri', function () {
    $milik = Absen::factory()->create(['id_peserta' => $this->peserta->id_peserta]);
    $orangLain = Absen::factory()->create(['id_peserta' => $this->pesertaLain->id_peserta]);
    $this->actingAs($this->peserta->user);

    $this->get(route('absen.index'))
        ->assertOk()
        ->assertSee(route('absen.show', $milik->id_absen))
        ->assertDontSee(route('absen.show', $orangLain->id_absen));

    $this->get(route('absen.show', $milik->id_absen))->assertOk();
    $this->get(route('absen.show', $orangLain->id_absen))->assertNotFound();
});

test('peserta hanya melihat sertifikat miliknya sendiri', function () {
    $milik = Sertifikat::factory()->create(['id_peserta' => $this->peserta->id_peserta]);
    $orangLain = Sertifikat::factory()->create(['id_peserta' => $this->pesertaLain->id_peserta]);
    $this->actingAs($this->peserta->user);

    $this->get(route('sertifikat.index'))
        ->assertOk()
        ->assertSee($milik->no_sertifikat)
        ->assertDontSee($orangLain->no_sertifikat);

    $this->get(route('sertifikat.show', $orangLain->id_sertifikat))->assertNotFound();
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

test('dashboard peserta hanya menampilkan modul yang boleh diakses', function () {
    $this->actingAs($this->peserta->user)
        ->get(route('dashboard'))
        ->assertOk()
        ->assertDontSee(route('admin-blk.index'))
        ->assertDontSee(route('mitras.index'))
        ->assertSee(route('absen.index'))
        ->assertSee(route('sertifikat.index'));
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
