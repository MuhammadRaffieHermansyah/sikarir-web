<?php

use App\Models\Absen;
use App\Models\Instruktur;
use App\Models\JadwalPelatihan;
use App\Models\KelasPelatihan;
use App\Models\Peserta;
use App\Models\SesiPresensi;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

beforeEach(function () {
    $this->userInstruktur = User::factory()->create(['role' => 'instruktur']);
    $this->instruktur = Instruktur::factory()->create(['id_user' => $this->userInstruktur->id]);
    $this->jadwal = JadwalPelatihan::factory()->create(['id_instruktur' => $this->instruktur->id]);

    $this->peserta = collect(['Ani', 'Budi', 'Citra', 'Dodi'])->map(function (string $nama) {
        $peserta = Peserta::factory()->create(['nama' => $nama]);
        KelasPelatihan::factory()->create([
            'id_peserta' => $peserta->id_peserta,
            'id_jadwal' => $this->jadwal->id_jadwal,
        ]);

        return $peserta;
    })->keyBy('nama');
});

function sesiInstrukturRekap(array $override = []): SesiPresensi
{
    return SesiPresensi::create([
        'id_jadwal' => test()->jadwal->id_jadwal,
        'pertemuan_ke' => 1,
        'tanggal' => today()->subDay()->toDateString(),
        'jam_mulai' => '08:00',
        'jam_selesai' => '15:00',
        'radius_meter' => 100,
        'absen_dibuka' => false,
        ...$override,
    ]);
}

function catatAbsenSesi(SesiPresensi $sesi, Peserta $peserta, string $status, bool $tanpaSesi = false): Absen
{
    return Absen::create([
        'id_jadwal' => $sesi->id_jadwal,
        'id_sesi' => $tanpaSesi ? null : $sesi->id_sesi,
        'id_peserta' => $peserta->id_peserta,
        'tanggal' => $sesi->tanggal->toDateString(),
        'jam_hadir' => $status === 'hadir' ? '08:05:00' : null,
        'status_kehadiran' => $status,
    ]);
}

test('instruktur melihat nama dan status tiap peserta pada sesi yang sudah selesai', function () {
    $sesi = sesiInstrukturRekap();
    catatAbsenSesi($sesi, $this->peserta['Ani'], 'hadir');
    catatAbsenSesi($sesi, $this->peserta['Budi'], 'izin', tanpaSesi: true);
    catatAbsenSesi($sesi, $this->peserta['Citra'], 'sakit', tanpaSesi: true);

    Sanctum::actingAs($this->userInstruktur);

    $this->getJson("/api/sesi-presensi/{$sesi->id_sesi}/peserta")
        ->assertOk()
        ->assertJsonPath('data.peserta.0.nama', 'Ani')
        ->assertJsonPath('data.peserta.0.status', 'hadir')
        ->assertJsonPath('data.peserta.0.jam_hadir', '08:05')
        ->assertJsonPath('data.peserta.1.status', 'izin')
        ->assertJsonPath('data.peserta.2.status', 'sakit')
        ->assertJsonPath('data.peserta.3.nama', 'Dodi')
        ->assertJsonPath('data.peserta.3.status', 'alpha')
        ->assertJsonPath('data.sesi.jumlah_hadir', 1)
        ->assertJsonPath('data.sesi.jumlah_izin', 1)
        ->assertJsonPath('data.sesi.jumlah_sakit', 1)
        ->assertJsonPath('data.sesi.jumlah_alpha', 1)
        ->assertJsonPath('data.sesi.jumlah_peserta', 4);
});

test('sesi yang masih berjalan menandai peserta tanpa catatan sebagai belum presensi', function () {
    $sesi = sesiInstrukturRekap(['tanggal' => today()->toDateString(), 'absen_dibuka' => true]);
    catatAbsenSesi($sesi, $this->peserta['Ani'], 'hadir');

    Sanctum::actingAs($this->userInstruktur);

    $this->getJson("/api/sesi-presensi/{$sesi->id_sesi}/peserta")
        ->assertOk()
        ->assertJsonPath('data.peserta.1.status', 'belum')
        ->assertJsonPath('data.sesi.jumlah_alpha', 0)
        ->assertJsonPath('data.sesi.jumlah_belum', 3);
});

test('catatan dari sesi lain di tanggal yang sama tidak terhitung', function () {
    $sesiPagi = sesiInstrukturRekap();
    $sesiSore = sesiInstrukturRekap(['pertemuan_ke' => 2, 'jam_mulai' => '15:30', 'jam_selesai' => '17:00']);
    catatAbsenSesi($sesiPagi, $this->peserta['Ani'], 'hadir');

    Sanctum::actingAs($this->userInstruktur);

    $this->getJson("/api/sesi-presensi/{$sesiSore->id_sesi}/peserta")
        ->assertOk()
        ->assertJsonPath('data.peserta.0.nama', 'Ani')
        ->assertJsonPath('data.peserta.0.status', 'alpha');
});

test('daftar sesi instruktur memuat jumlah izin, sakit, dan alpha', function () {
    $sesi = sesiInstrukturRekap();
    catatAbsenSesi($sesi, $this->peserta['Ani'], 'hadir');
    catatAbsenSesi($sesi, $this->peserta['Budi'], 'izin', tanpaSesi: true);
    $kelas = KelasPelatihan::where('id_jadwal', $this->jadwal->id_jadwal)->first();

    Sanctum::actingAs($this->userInstruktur);

    $this->getJson("/api/kelas-pelatihan/{$kelas->id_kelas}/sesi-presensi")
        ->assertOk()
        ->assertJsonPath('data.0.jumlah_hadir', 1)
        ->assertJsonPath('data.0.jumlah_izin', 1)
        ->assertJsonPath('data.0.jumlah_alpha', 2)
        ->assertJsonPath('data.0.jumlah_peserta', 4);
});

test('instruktur lain dan peserta tidak boleh melihat rekap sesi', function () {
    $sesi = sesiInstrukturRekap();

    Sanctum::actingAs(User::factory()->create(['role' => 'instruktur']));
    $this->getJson("/api/sesi-presensi/{$sesi->id_sesi}/peserta")->assertForbidden();

    Sanctum::actingAs($this->peserta['Ani']->user ?? User::factory()->create(['role' => 'peserta']));
    $this->getJson("/api/sesi-presensi/{$sesi->id_sesi}/peserta")->assertForbidden();
});
