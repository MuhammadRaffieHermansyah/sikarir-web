<?php

use App\Models\Absen;
use App\Models\HariLibur;
use App\Models\JadwalPelatihan;
use App\Models\Peserta;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\TestResponse;
use Laravel\Sanctum\Sanctum;

// Titik pusat jadwal pada factory/test: -8.1763, 113.7007 (radius 100 m).
const PUSAT_LAT = -8.1763;
const PUSAT_LNG = 113.7007;

beforeEach(function () {
    // Selasa, 24 November 2026 pukul 09:30 (waktu server).
    $this->travelTo(Carbon\Carbon::parse('2026-11-24 09:30:00'));
    Storage::fake('public');

    $this->peserta = Peserta::factory()->create();
    $this->jadwal = JadwalPelatihan::factory()->create([
        'tanggal_mulai' => '2026-11-01',
        'tanggal_selesai' => '2026-12-31',
        'lokasi_latitude' => PUSAT_LAT,
        'lokasi_longitude' => PUSAT_LNG,
        'radius_meter' => 100,
        'status' => 'berlangsung',
    ]);

    Sanctum::actingAs($this->peserta->user);
});

/**
 * @param  array<string, mixed>  $overrides
 */
function absenHariIni(object $test, array $overrides = []): Absen
{
    return Absen::factory()->create([
        'id_peserta' => $test->peserta->id_peserta,
        'id_jadwal' => $test->jadwal->id_jadwal,
        'tanggal' => '2026-11-24',
        'jam_hadir' => '08:00',
        'status_kehadiran' => 'hadir',
        'jam_keluar' => null,
        ...$overrides,
    ]);
}

/**
 * @param  array<string, mixed>  $overrides
 * @return array<string, mixed>
 */
function izinPayload(object $test, array $overrides = []): array
{
    return [
        'id_jadwal' => $test->jadwal->id_jadwal,
        'tanggal' => '2026-11-24',
        'status_kehadiran' => 'izin',
        'keterangan' => 'Urusan keluarga',
        ...$overrides,
    ];
}

function postForm(object $test, string $uri, array $data): TestResponse
{
    return $test->post($uri, $data, ['Accept' => 'application/json']);
}

describe('presensi pulang', function () {
    it('mencatat jam keluar dari waktu server beserta jarak GPS', function () {
        $absen = absenHariIni($this);

        $this->postJson("/api/absen/{$absen->id_absen}/pulang", [
            'latitude' => PUSAT_LAT + 0.0003, // ± 33 m dari pusat
            'longitude' => PUSAT_LNG,
        ])
            ->assertOk()
            ->assertJsonPath('data.id_absen', $absen->id_absen);

        $absen->refresh();
        expect($absen->jam_keluar)->toStartWith('09:30')
            ->and((float) $absen->jarak_keluar_meter)->toBeGreaterThan(20)->toBeLessThan(50)
            ->and((float) $absen->latitude_keluar)->toBe(round(PUSAT_LAT + 0.0003, 7));
    });

    it('menolak presensi pulang di luar radius lokasi', function () {
        $absen = absenHariIni($this);

        $this->postJson("/api/absen/{$absen->id_absen}/pulang", [
            'latitude' => PUSAT_LAT + 0.01, // ± 1,1 km
            'longitude' => PUSAT_LNG,
        ])
            ->assertForbidden()
            ->assertJsonPath('radius_meter', 100);

        expect($absen->fresh()->jam_keluar)->toBeNull();
    });

    it('menolak presensi pulang yang sudah tercatat', function () {
        $absen = absenHariIni($this, ['jam_keluar' => '16:00']);

        $this->postJson("/api/absen/{$absen->id_absen}/pulang", [
            'latitude' => PUSAT_LAT,
            'longitude' => PUSAT_LNG,
        ])->assertUnprocessable();

        expect($absen->fresh()->jam_keluar)->toStartWith('16:00');
    });

    it('menolak presensi pulang untuk status selain hadir', function () {
        $absen = absenHariIni($this, ['status_kehadiran' => 'izin']);

        $this->postJson("/api/absen/{$absen->id_absen}/pulang", [
            'latitude' => PUSAT_LAT,
            'longitude' => PUSAT_LNG,
        ])->assertUnprocessable();
    });

    it('menolak presensi pulang untuk catatan hari lain', function () {
        $absen = absenHariIni($this, ['tanggal' => '2026-11-23']);

        $this->postJson("/api/absen/{$absen->id_absen}/pulang", [
            'latitude' => PUSAT_LAT,
            'longitude' => PUSAT_LNG,
        ])->assertUnprocessable();
    });

    it('menolak presensi milik peserta lain', function () {
        $absenLain = Absen::factory()->create([
            'id_peserta' => Peserta::factory()->create()->id_peserta,
            'id_jadwal' => $this->jadwal->id_jadwal,
            'tanggal' => '2026-11-24',
            'status_kehadiran' => 'hadir',
            'jam_keluar' => null,
        ]);

        $this->postJson("/api/absen/{$absenLain->id_absen}/pulang", [
            'latitude' => PUSAT_LAT,
            'longitude' => PUSAT_LNG,
        ])->assertForbidden();

        expect($absenLain->fresh()->jam_keluar)->toBeNull();
    });

    it('mewajibkan koordinat GPS', function () {
        $absen = absenHariIni($this);

        $this->postJson("/api/absen/{$absen->id_absen}/pulang", [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['latitude', 'longitude']);
    });
});

describe('lampiran izin/sakit', function () {
    it('menyimpan lampiran dan mengembalikan lampiran_url', function () {
        $response = postForm($this, '/api/absen', izinPayload($this, [
            'status_kehadiran' => 'sakit',
            'lampiran' => UploadedFile::fake()->create('surat-dokter.pdf', 200, 'application/pdf'),
        ]))->assertCreated();

        $absen = Absen::findOrFail($response->json('data.id_absen'));
        expect($absen->lampiran)->toStartWith('absen-lampiran/');
        Storage::disk('public')->assertExists($absen->lampiran);
        expect($response->json('data.lampiran_url'))->toContain($absen->lampiran);
    });

    it('tetap bisa dicatat tanpa lampiran', function () {
        postForm($this, '/api/absen', izinPayload($this))
            ->assertCreated()
            ->assertJsonPath('data.lampiran_url', null);
    });

    it('menolak jenis berkas selain JPG, PNG, dan PDF', function () {
        postForm($this, '/api/absen', izinPayload($this, [
            'lampiran' => UploadedFile::fake()->create('malware.exe', 10, 'application/octet-stream'),
        ]))->assertUnprocessable()->assertJsonValidationErrors('lampiran');

        expect(Absen::count())->toBe(0);
    });

    it('menolak lampiran lebih dari 2 MB', function () {
        postForm($this, '/api/absen', izinPayload($this, [
            'lampiran' => UploadedFile::fake()->create('besar.pdf', 3000, 'application/pdf'),
        ]))->assertUnprocessable()->assertJsonValidationErrors('lampiran');
    });

    it('menolak lampiran pada presensi hadir', function () {
        postForm($this, '/api/absen', [
            'id_jadwal' => $this->jadwal->id_jadwal,
            'tanggal' => '2026-11-24',
            'status_kehadiran' => 'hadir',
            'latitude' => PUSAT_LAT,
            'longitude' => PUSAT_LNG,
            'lampiran' => UploadedFile::fake()->create('surat.pdf', 10, 'application/pdf'),
        ])->assertUnprocessable()->assertJsonValidationErrors('lampiran');
    });

    it('tidak menyimpan berkas bila presensi ditolak karena duplikat', function () {
        absenHariIni($this, ['status_kehadiran' => 'izin']);

        postForm($this, '/api/absen', izinPayload($this, [
            'lampiran' => UploadedFile::fake()->create('surat.pdf', 10, 'application/pdf'),
        ]))->assertUnprocessable();

        expect(Storage::disk('public')->allFiles())->toBeEmpty();
    });

    it('menghapus berkas hanya setelah catatan terakhir yang memakainya dihapus', function () {
        $response = postForm($this, '/api/absen', izinPayload($this, [
            'tanggal' => '2026-11-26', // Kamis
            'tanggal_selesai' => '2026-11-27', // Jumat
            'lampiran' => UploadedFile::fake()->create('surat.pdf', 10, 'application/pdf'),
        ]))->assertCreated();

        [$pertama, $kedua] = $response->json('data');
        $path = Absen::findOrFail($pertama['id_absen'])->lampiran;
        Storage::disk('public')->assertExists($path);

        $this->deleteJson("/api/absen/{$pertama['id_absen']}")->assertOk();
        Storage::disk('public')->assertExists($path);

        $this->deleteJson("/api/absen/{$kedua['id_absen']}")->assertOk();
        Storage::disk('public')->assertMissing($path);
    });
});

describe('rentang tanggal izin/sakit', function () {
    it('membuat satu catatan per hari pelatihan dan melewati akhir pekan, hari libur, serta tanggal yang sudah ada', function () {
        HariLibur::create(['tanggal' => '2026-11-25', 'keterangan' => 'Cuti bersama', 'sumber' => 'manual']);
        absenHariIni($this, ['status_kehadiran' => 'izin']); // Selasa 24 sudah tercatat

        $response = postForm($this, '/api/absen', izinPayload($this, [
            'tanggal' => '2026-11-23', // Senin
            'tanggal_selesai' => '2026-11-29', // Minggu
        ]))->assertCreated();

        // Senin 23, (Selasa 24 sudah ada), (Rabu 25 libur), Kamis 26, Jumat 27, (Sabtu/Minggu)
        expect(collect($response->json('data'))->pluck('tanggal')->all())
            ->toBe(['2026-11-23', '2026-11-26', '2026-11-27'])
            ->and($response->json('dilewati'))->toBe(['2026-11-24'])
            ->and($response->json('message'))->toContain('3 hari');

        expect(Absen::where('status_kehadiran', 'izin')->count())->toBe(4);
    });

    it('melewati hari di luar periode jadwal', function () {
        $this->jadwal->update(['tanggal_mulai' => '2026-11-26', 'tanggal_selesai' => '2026-11-26']);

        $response = postForm($this, '/api/absen', izinPayload($this, [
            'tanggal' => '2026-11-24',
            'tanggal_selesai' => '2026-11-27',
        ]))->assertCreated();

        expect(collect($response->json('data'))->pluck('tanggal')->all())->toBe(['2026-11-26']);
    });

    it('menolak rentang lebih dari 14 hari', function () {
        postForm($this, '/api/absen', izinPayload($this, [
            'tanggal' => '2026-11-02',
            'tanggal_selesai' => '2026-11-16', // 15 hari
        ]))->assertUnprocessable();

        expect(Absen::count())->toBe(0);
    });

    it('menolak rentang yang hanya berisi akhir pekan', function () {
        postForm($this, '/api/absen', izinPayload($this, [
            'tanggal' => '2026-11-28',
            'tanggal_selesai' => '2026-11-29',
        ]))->assertUnprocessable();
    });

    it('menolak tanggal selesai sebelum tanggal mulai', function () {
        postForm($this, '/api/absen', izinPayload($this, [
            'tanggal' => '2026-11-26',
            'tanggal_selesai' => '2026-11-24',
        ]))->assertUnprocessable()->assertJsonValidationErrors('tanggal_selesai');
    });

    it('menolak rentang untuk presensi hadir', function () {
        postForm($this, '/api/absen', [
            'id_jadwal' => $this->jadwal->id_jadwal,
            'tanggal' => '2026-11-24',
            'tanggal_selesai' => '2026-11-26',
            'status_kehadiran' => 'hadir',
            'latitude' => PUSAT_LAT,
            'longitude' => PUSAT_LNG,
        ])->assertUnprocessable()->assertJsonValidationErrors('tanggal_selesai');
    });

    it('menolak bila seluruh hari pada rentang sudah tercatat', function () {
        absenHariIni($this, ['status_kehadiran' => 'izin']);

        postForm($this, '/api/absen', izinPayload($this, [
            'tanggal' => '2026-11-24',
            'tanggal_selesai' => '2026-11-25',
        ]))->assertCreated(); // Rabu 25 masih baru

        postForm($this, '/api/absen', izinPayload($this, [
            'tanggal' => '2026-11-24',
            'tanggal_selesai' => '2026-11-25',
        ]))->assertUnprocessable();
    });

    it('memperlakukan tanggal_selesai yang sama dengan tanggal sebagai satu hari biasa', function () {
        postForm($this, '/api/absen', izinPayload($this, ['tanggal_selesai' => '2026-11-24']))
            ->assertCreated()
            ->assertJsonPath('data.tanggal', '2026-11-24');
    });
});
