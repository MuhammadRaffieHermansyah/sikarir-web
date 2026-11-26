<?php

use App\Models\Absen;
use App\Models\JadwalPelatihan;
use App\Models\KelasPelatihan;
use App\Models\Peserta;
use App\Models\SesiPresensi;
use App\Models\User;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\Sanctum;

beforeEach(function () {
    Carbon::setTestNow('2026-11-26 10:00:00');
    $this->jadwal = JadwalPelatihan::factory()->create();
    $this->peserta = Peserta::factory()->create();
    $this->peserta->user->update(['role' => 'peserta']);
    KelasPelatihan::factory()->create([
        'id_peserta' => $this->peserta->id_peserta,
        'id_jadwal' => $this->jadwal->id_jadwal,
    ]);
});

function sesiRekap(int $pertemuan, string $tanggal, array $override = []): SesiPresensi
{
    return SesiPresensi::create([
        'id_jadwal' => test()->jadwal->id_jadwal,
        'pertemuan_ke' => $pertemuan,
        'tanggal' => $tanggal,
        'jam_mulai' => '08:00',
        'jam_selesai' => '09:00',
        'absen_dibuka' => false,
        ...$override,
    ]);
}

function catatPresensi(?SesiPresensi $sesi, string $status, ?string $tanggal = null): Absen
{
    return Absen::factory()->create([
        'id_peserta' => test()->peserta->id_peserta,
        'id_jadwal' => test()->jadwal->id_jadwal,
        'id_sesi' => $sesi?->id_sesi,
        'tanggal' => $tanggal ?? $sesi->tanggal->toDateString(),
        'status_kehadiran' => $status,
    ]);
}

/**
 * Tiga sesi lewat (hadir, izin di tanggal sesi, tanpa catatan), satu sesi hari ini yang
 * sudah selesai tanpa catatan, satu sesi hari ini yang masih dibuka, satu sesi besok.
 */
function siapkanEnamSesi(): void
{
    catatPresensi(sesiRekap(1, '2026-11-20'), 'hadir');
    sesiRekap(2, '2026-11-21');
    catatPresensi(null, 'izin', '2026-11-21');
    sesiRekap(3, '2026-11-22');
    sesiRekap(4, '2026-11-26');
    sesiRekap(5, '2026-11-26', ['pertemuan_ke' => 5, 'jam_selesai' => '15:00', 'absen_dibuka' => true]);
    sesiRekap(6, '2026-11-27');
}

test('sesi selesai tanpa catatan presensi dihitung alpha di rekap peserta', function () {
    siapkanEnamSesi();
    Sanctum::actingAs($this->peserta->user);

    $this->getJson('/api/absen/rekap')
        ->assertOk()
        ->assertJsonPath('data.summary.total_hadir', 1)
        ->assertJsonPath('data.summary.total_izin', 1)
        ->assertJsonPath('data.summary.total_alpha', 2)
        ->assertJsonPath('data.summary.total_sesi', 4)
        ->assertJsonPath('data.summary.persentase_hadir', 25)
        ->assertJsonPath('data.summary.memenuhi_syarat', false)
        ->assertJsonPath('data.per_jadwal.0.total_sesi', 4)
        ->assertJsonPath('data.per_jadwal.0.total_hadir', 1);
});

test('peserta yang belum pernah presensi tetap muncul dengan alpha', function () {
    sesiRekap(1, '2026-11-20');
    sesiRekap(2, '2026-11-21');
    Sanctum::actingAs($this->peserta->user);

    $this->getJson('/api/absen/rekap')
        ->assertOk()
        ->assertJsonPath('data.summary.total_alpha', 2)
        ->assertJsonPath('data.summary.total_sesi', 2)
        ->assertJsonPath('data.summary.persentase_hadir', 0)
        ->assertJsonCount(1, 'data.per_jadwal');
});

test('alpha tidak dihitung untuk peserta yang tidak terdaftar di kelas', function () {
    sesiRekap(1, '2026-11-20');
    $lain = Peserta::factory()->create();
    $lain->user->update(['role' => 'peserta']);
    Sanctum::actingAs($lain->user);

    $this->getJson('/api/absen/rekap')
        ->assertOk()
        ->assertJsonPath('data.summary.total_alpha', 0)
        ->assertJsonPath('data.summary.total_sesi', 0);
});

test('rekap admin di web ikut menghitung alpha otomatis', function () {
    siapkanEnamSesi();

    $this->actingAs(User::factory()->adminBlk()->create())
        ->get(route('absen.rekap', ['id_jadwal' => $this->jadwal->id_jadwal]))
        ->assertOk()
        ->assertViewHas('totalHadir', 1)
        ->assertViewHas('totalAlpha', 2)
        ->assertViewHas('persenHadir', 25.0)
        ->assertViewHas('rekapPeserta', fn ($rekap) => $rekap->first()->total === 4);
});

test('filter status hadir di rekap admin tidak menambah alpha otomatis', function () {
    siapkanEnamSesi();

    $this->actingAs(User::factory()->adminBlk()->create())
        ->get(route('absen.rekap', ['id_jadwal' => $this->jadwal->id_jadwal, 'status' => 'hadir']))
        ->assertOk()
        ->assertViewHas('totalAlpha', 0)
        ->assertViewHas('persenHadir', 100.0);
});
