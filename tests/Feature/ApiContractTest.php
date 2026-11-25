<?php

use App\Http\Resources\AbsenResource;
use App\Http\Resources\AdminBlkResource;
use App\Http\Resources\DaftarLowonganResource;
use App\Http\Resources\DaftarPelatihanResource;
use App\Http\Resources\JadwalPelatihanResource;
use App\Http\Resources\KelasPelatihanResource;
use App\Http\Resources\MitraResource;
use App\Http\Resources\PesertaResource;
use App\Http\Resources\SertifikatResource;
use App\Http\Resources\UserResource;
use App\Models\Absen;
use App\Models\AdminBlk;
use App\Models\DaftarLowongan;
use App\Models\DaftarPelatihan;
use App\Models\JadwalPelatihan;
use App\Models\KelasPelatihan;
use App\Models\LamaranLowongan;
use App\Models\Mitra;
use App\Models\Peserta;
use App\Models\RuanganWorkshop;
use App\Models\Sertifikat;
use App\Models\User;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/**
 * Collect every key path of a JSON payload so an added or removed field is detectable.
 *
 * @return list<string>
 */
function apiContractPaths(mixed $payload, string $prefix = ''): array
{
    if ($payload instanceof Arrayable) {
        $payload = $payload->toArray();
    }

    if (! is_array($payload)) {
        return [$prefix];
    }

    $paths = [];

    foreach ($payload as $key => $value) {
        $path = is_int($key)
            ? $prefix.'[]'
            : ($prefix === '' ? (string) $key : $prefix.'.'.$key);

        $paths = array_merge($paths, apiContractPaths($value, $path));
    }

    return $paths;
}

/**
 * Build the same payload that the mobile API serializes for every endpoint that exposes a person name.
 *
 * @return array<string, list<string>>
 */
function apiContractSnapshot(): array
{
    $adminUser = User::factory()->adminBlk()->create();
    $admin = AdminBlk::create(['id_user' => $adminUser->id, 'nama' => 'Admin Uji']);

    $mitraUser = User::factory()->mitra()->create();
    $mitra = Mitra::factory()->create(['id_user' => $mitraUser->id, 'nama' => 'Mitra Uji', 'nama_perusahaan' => 'PT Uji']);

    $pesertaUser = User::factory()->peserta()->create();
    $peserta = Peserta::factory()->create(['id_user' => $pesertaUser->id, 'nama' => 'Peserta Uji']);

    $lowongan = DaftarLowongan::factory()->create(['id_mitra' => $mitra->id_mitra]);
    $lamaran = LamaranLowongan::factory()->create([
        'id_lowongan' => $lowongan->id_lowongan,
        'id_peserta' => $peserta->id_peserta,
    ]);

    $ruangan = RuanganWorkshop::create(['nama_ruangan' => 'Ruang Uji']);
    $pelatihan = DaftarPelatihan::factory()->create(['id_admin' => $admin->id_admin]);
    $jadwal = JadwalPelatihan::factory()->create([
        'id_pelatihan' => $pelatihan->id_pelatihan,
        'id_ruangan_workshop' => $ruangan->id,
    ]);
    $kelas = KelasPelatihan::factory()->create([
        'id_peserta' => $peserta->id_peserta,
        'id_jadwal' => $jadwal->id_jadwal,
    ]);
    $absen = Absen::factory()->create([
        'id_peserta' => $peserta->id_peserta,
        'id_jadwal' => $jadwal->id_jadwal,
    ]);
    $sertifikat = Sertifikat::factory()->create([
        'id_peserta' => $peserta->id_peserta,
        'id_jadwal' => $jadwal->id_jadwal,
        'id_admin' => $admin->id_admin,
    ]);

    $snapshot = [
        'user_raw_register' => apiContractPaths($pesertaUser->load('peserta')->toArray()),
        'user_raw_me' => apiContractPaths($pesertaUser->load(['peserta', 'mitra', 'adminBlk'])->toArray()),
        'user_resource' => apiContractPaths((new UserResource($pesertaUser->load('peserta')))->resolve()),
        'peserta_resource' => apiContractPaths((new PesertaResource($peserta->load('user')))->resolve()),
        'mitra_resource' => apiContractPaths((new MitraResource($mitra->load('user')))->resolve()),
        'admin_blk_resource' => apiContractPaths((new AdminBlkResource($admin->load('user')))->resolve()),
        'daftar_lowongan_resource' => apiContractPaths((new DaftarLowonganResource($lowongan->load('mitra')))->resolve()),
        'daftar_pelatihan_resource' => apiContractPaths((new DaftarPelatihanResource($pelatihan->load(['admin', 'instruktur', 'durasi'])))->resolve()),
        'jadwal_pelatihan_resource' => apiContractPaths((new JadwalPelatihanResource($jadwal->load(['pelatihan', 'instruktur'])))->resolve()),
        'kelas_pelatihan_resource' => apiContractPaths((new KelasPelatihanResource($kelas->load(['peserta.user', 'jadwal.pelatihan'])))->resolve()),
        'sertifikat_resource' => apiContractPaths((new SertifikatResource($sertifikat->load(['peserta.user', 'jadwal.pelatihan', 'admin.user'])))->resolve()),
        'absen_resource' => apiContractPaths((new AbsenResource($absen->load(['peserta.user', 'jadwal.pelatihan'])))->resolve()),
        'lamaran_raw' => apiContractPaths($lamaran->load(['lowongan.mitra', 'peserta.user'])->toArray()),
    ];

    foreach ($snapshot as $name => $paths) {
        sort($paths);
        $snapshot[$name] = $paths;
    }

    ksort($snapshot);

    return $snapshot;
}

test('api responses keep the same field set after the name column moves to role tables', function () {
    $expected = require base_path('tests/Fixtures/api-contract-snapshot.php');

    expect(apiContractSnapshot())->toBe($expected);
});

test('the api never exposes the internal nama column', function () {
    $snapshot = apiContractSnapshot();

    foreach ($snapshot as $paths) {
        expect($paths)->not->toContain('nama');
    }
});
