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
    $this->jadwal = JadwalPelatihan::factory()->create([
        'id_instruktur' => $this->instruktur->id,
        'lokasi_latitude' => null,
        'lokasi_longitude' => null,
    ]);
    $this->peserta = Peserta::factory()->create();
    $this->kelas = KelasPelatihan::factory()->create([
        'id_peserta' => $this->peserta->id_peserta,
        'id_jadwal' => $this->jadwal->id_jadwal,
    ]);
    $this->body = [
        'pertemuan_ke' => 1,
        'tanggal' => today()->toDateString(),
        'jam_mulai' => '08:00',
        'jam_selesai' => '15:00',
        'lokasi_latitude' => -8.15753,
        'lokasi_longitude' => 113.7229492,
        'radius_meter' => 100,
    ];
});

function buatSesi(array $override = []): SesiPresensi
{
    return SesiPresensi::create([
        'id_jadwal' => test()->jadwal->id_jadwal,
        'pertemuan_ke' => 1,
        'tanggal' => today()->toDateString(),
        'jam_mulai' => '08:00',
        'jam_selesai' => '15:00',
        'lokasi_latitude' => -8.15753,
        'lokasi_longitude' => 113.7229492,
        'radius_meter' => 100,
        'absen_dibuka' => false,
        ...$override,
    ]);
}

test('instruktur pengampu membuat dan melihat sesi presensi', function () {
    Sanctum::actingAs($this->userInstruktur);

    $this->postJson("/api/kelas-pelatihan/{$this->kelas->id_kelas}/sesi-presensi", $this->body)
        ->assertCreated()
        ->assertJsonPath('data.pertemuan_ke', 1)
        ->assertJsonPath('data.jam_mulai', '08:00')
        ->assertJsonPath('data.absen_dibuka', false)
        ->assertJsonPath('data.id_kelas', $this->kelas->id_kelas);

    $this->getJson("/api/kelas-pelatihan/{$this->kelas->id_kelas}/sesi-presensi")
        ->assertOk()
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.jumlah_hadir', 0);
});

test('pertemuan ganda dan tanggal lampau ditolak 422', function () {
    Sanctum::actingAs($this->userInstruktur);
    buatSesi();

    $this->postJson("/api/kelas-pelatihan/{$this->kelas->id_kelas}/sesi-presensi", [
        ...$this->body,
        'tanggal' => today()->subDay()->toDateString(),
        'jam_selesai' => '07:00',
    ])->assertUnprocessable()->assertJsonValidationErrors(['pertemuan_ke', 'tanggal', 'jam_selesai']);
});

test('instruktur lain dan peserta tidak boleh mengelola sesi', function () {
    $lain = User::factory()->create(['role' => 'instruktur']);
    Instruktur::factory()->create(['id_user' => $lain->id]);
    $sesi = buatSesi();

    Sanctum::actingAs($lain);
    $this->postJson("/api/kelas-pelatihan/{$this->kelas->id_kelas}/sesi-presensi", $this->body)->assertForbidden();
    $this->patchJson("/api/sesi-presensi/{$sesi->id_sesi}", ['absen_dibuka' => true])->assertForbidden();

    Sanctum::actingAs($this->peserta->user);
    $this->getJson("/api/kelas-pelatihan/{$this->kelas->id_kelas}/sesi-presensi")->assertForbidden();
    $this->deleteJson("/api/sesi-presensi/{$sesi->id_sesi}")->assertForbidden();
});

test('peserta melihat sesi aktif hanya setelah dibuka', function () {
    $sesi = buatSesi();

    Sanctum::actingAs($this->peserta->user);
    $this->getJson("/api/kelas-pelatihan/{$this->kelas->id_kelas}/sesi-presensi/aktif")->assertNotFound();

    Sanctum::actingAs($this->userInstruktur);
    $this->patchJson("/api/sesi-presensi/{$sesi->id_sesi}", ['absen_dibuka' => true])
        ->assertOk()->assertJsonPath('data.absen_dibuka', true);

    Sanctum::actingAs($this->peserta->user);
    $this->getJson("/api/kelas-pelatihan/{$this->kelas->id_kelas}/sesi-presensi/aktif")
        ->assertOk()->assertJsonPath('data.id_sesi', $sesi->id_sesi);
});

test('sesi bertanggal lampau tidak bisa dibuka', function () {
    $sesi = buatSesi(['tanggal' => today()->subDay()->toDateString()]);
    Sanctum::actingAs($this->userInstruktur);

    $this->patchJson("/api/sesi-presensi/{$sesi->id_sesi}", ['absen_dibuka' => true])->assertUnprocessable();
});

test('presensi hadir mengikuti status sesi', function () {
    $sesi = buatSesi();
    Sanctum::actingAs($this->peserta->user);

    $hadir = fn (array $extra = []) => $this->postJson('/api/absen', [
        'id_jadwal' => $this->jadwal->id_jadwal,
        'tanggal' => today()->toDateString(),
        'status_kehadiran' => 'hadir',
        'latitude' => -8.1576,
        'longitude' => 113.7230,
        ...$extra,
    ]);

    $hadir()->assertUnprocessable()->assertJsonValidationErrors(['id_sesi']);
    $hadir(['id_sesi' => $sesi->id_sesi])->assertForbidden();

    $sesi->update(['absen_dibuka' => true]);
    $hadir(['id_sesi' => $sesi->id_sesi, 'latitude' => -8.17, 'longitude' => 113.70])->assertForbidden();
    $hadir(['id_sesi' => (string) $sesi->id_sesi])->assertCreated();

    expect(Absen::where('id_sesi', $sesi->id_sesi)->count())->toBe(1);

    Sanctum::actingAs($this->userInstruktur);
    $this->getJson("/api/kelas-pelatihan/{$this->kelas->id_kelas}/sesi-presensi")
        ->assertJsonPath('data.0.jumlah_hadir', 1);
    $this->deleteJson("/api/sesi-presensi/{$sesi->id_sesi}")->assertUnprocessable();
});

test('izin tetap bisa tanpa sesi', function () {
    buatSesi();
    Sanctum::actingAs($this->peserta->user);

    $this->postJson('/api/absen', [
        'id_jadwal' => $this->jadwal->id_jadwal,
        'tanggal' => today()->toDateString(),
        'status_kehadiran' => 'izin',
        'keterangan' => 'Keperluan keluarga',
    ])->assertCreated();
});

test('instruktur menghapus sesi tanpa kehadiran', function () {
    $sesi = buatSesi();
    Sanctum::actingAs($this->userInstruktur);

    $this->deleteJson("/api/sesi-presensi/{$sesi->id_sesi}")->assertOk();
    expect(SesiPresensi::count())->toBe(0);
});
