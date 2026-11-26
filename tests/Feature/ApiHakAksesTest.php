<?php

use App\Models\Absen;
use App\Models\AdminBlk;
use App\Models\DaftarLowongan;
use App\Models\DaftarPelatihan;
use App\Models\DurasiPelatihan;
use App\Models\Instruktur;
use App\Models\JadwalPelatihan;
use App\Models\KelasPelatihan;
use App\Models\Mitra;
use App\Models\Peserta;
use App\Models\Sertifikat;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

beforeEach(function () {
    $this->admin = AdminBlk::factory()->create()->user;
    $this->peserta = Peserta::factory()->create();
    $this->pesertaLain = Peserta::factory()->create();
    $this->jadwal = JadwalPelatihan::factory()->create(['status' => 'tersedia']);
    $this->kelas = KelasPelatihan::factory()->create([
        'id_peserta' => $this->peserta->id_peserta,
        'id_jadwal' => $this->jadwal->id_jadwal,
        'status' => 'terdaftar',
    ]);
    $this->kelasLain = KelasPelatihan::factory()->create(['id_peserta' => $this->pesertaLain->id_peserta]);
});

dataset('endpoint khusus admin', [
    'buat sertifikat' => ['post', '/api/sertifikat'],
    'buat sertifikat (alias)' => ['post', '/api/sertifikasi'],
    'daftar sertifikat' => ['get', '/api/sertifikat'],
    'buat pelatihan' => ['post', '/api/pelatihan'],
    'buat pelatihan (alias)' => ['post', '/api/daftar-pelatihan'],
    'buat jadwal' => ['post', '/api/jadwal-pelatihan'],
    'buat jadwal (alias)' => ['post', '/api/jadwal'],
    'buat admin' => ['post', '/api/admin-blk'],
    'daftar admin' => ['get', '/api/admin-blk'],
    'buat instruktur' => ['post', '/api/instruktur'],
    'daftar instruktur' => ['get', '/api/instruktur'],
    'buat mitra' => ['post', '/api/mitras'],
    'buat mitra (alias)' => ['post', '/api/mitra'],
    'durasi pelatihan' => ['get', '/api/durasi-pelatihan'],
    'buat durasi pelatihan' => ['post', '/api/durasi-pelatihan'],
    'daftar peserta' => ['get', '/api/pesertas'],
    'daftar peserta (alias)' => ['get', '/api/peserta'],
    'buat peserta' => ['post', '/api/pesertas'],
    'semua kelas' => ['get', '/api/kelas-pelatihan'],
    'semua kelas (alias)' => ['get', '/api/kelas'],
]);

test('peserta ditolak di endpoint khusus admin', function (string $method, string $uri) {
    Sanctum::actingAs($this->peserta->user);

    $this->json($method, $uri, [])->assertForbidden();
})->with('endpoint khusus admin');

test('mitra dan instruktur juga ditolak di endpoint khusus admin', function (string $method, string $uri) {
    Sanctum::actingAs(Mitra::factory()->create()->user);
    $this->json($method, $uri, [])->assertForbidden();

    Sanctum::actingAs(User::factory()->create(['role' => 'instruktur']));
    $this->json($method, $uri, [])->assertForbidden();
})->with('endpoint khusus admin');

test('admin tetap bisa membaca endpoint khusus admin', function () {
    Sanctum::actingAs($this->admin);

    $this->getJson('/api/pesertas')->assertOk();
    $this->getJson('/api/kelas-pelatihan')->assertOk();
    $this->getJson('/api/sertifikat')->assertOk();
    $this->getJson('/api/instruktur')->assertOk();
    $this->getJson('/api/admin-blk')->assertOk();
    $this->getJson('/api/durasi-pelatihan')->assertOk();
});

test('peserta tidak bisa mengubah atau menghapus data master', function () {
    $pelatihan = DaftarPelatihan::factory()->create();
    $durasi = DurasiPelatihan::factory()->create();
    $mitra = Mitra::factory()->create(['is_verified' => false]);
    Sanctum::actingAs($this->peserta->user);

    $this->deleteJson("/api/pelatihan/{$pelatihan->id_pelatihan}")->assertForbidden();
    $this->deleteJson("/api/jadwal-pelatihan/{$this->jadwal->id_jadwal}")->assertForbidden();
    $this->deleteJson("/api/durasi-pelatihan/{$durasi->getKey()}")->assertForbidden();
    $this->putJson("/api/mitras/{$mitra->id_mitra}", ['is_verified' => true])->assertForbidden();
    $this->deleteJson("/api/pesertas/{$this->pesertaLain->id_peserta}")->assertForbidden();
    $this->putJson("/api/peserta/{$this->pesertaLain->id_peserta}", ['nomor_wa' => '0800'])->assertForbidden();

    expect(DaftarPelatihan::find($pelatihan->id_pelatihan))->not->toBeNull()
        ->and($mitra->fresh()->is_verified)->toBeFalsy()
        ->and(Peserta::find($this->pesertaLain->id_peserta))->not->toBeNull();
});

test('peserta tidak bisa meluluskan diri atau menerbitkan sertifikat sendiri', function () {
    Sanctum::actingAs($this->peserta->user);

    $this->putJson("/api/kelas-pelatihan/{$this->kelas->id_kelas}", [
        'id_peserta' => $this->peserta->id_peserta,
        'id_jadwal' => $this->jadwal->id_jadwal,
        'status' => 'lulus',
    ])->assertForbidden();
    $this->putJson("/api/kelas/{$this->kelas->id_kelas}", ['status' => 'lulus'])->assertForbidden();
    $this->deleteJson("/api/kelas-pelatihan/{$this->kelasLain->id_kelas}")->assertForbidden();

    $this->postJson('/api/sertifikat', [
        'id_peserta' => $this->peserta->id_peserta,
        'id_jadwal' => $this->jadwal->id_jadwal,
        'id_admin' => 1,
        'no_sertifikat' => 'PALSU-1',
        'tanggal_terbit' => now()->toDateString(),
    ])->assertForbidden();

    expect($this->kelas->fresh()->status)->toBe('terdaftar')
        ->and(Sertifikat::where('no_sertifikat', 'PALSU-1')->exists())->toBeFalse()
        ->and(KelasPelatihan::find($this->kelasLain->id_kelas))->not->toBeNull();
});

test('detail kelas hanya untuk peserta pemilik, instruktur pengampu, dan admin', function () {
    Sanctum::actingAs($this->peserta->user);
    $this->getJson("/api/kelas-pelatihan/{$this->kelas->id_kelas}")->assertOk();
    $this->getJson("/api/kelas-pelatihan/{$this->kelasLain->id_kelas}")->assertForbidden();

    $userInstruktur = User::factory()->create(['role' => 'instruktur']);
    $instruktur = Instruktur::factory()->create(['id_user' => $userInstruktur->id]);
    $this->jadwal->update(['id_instruktur' => $instruktur->id]);
    Sanctum::actingAs($userInstruktur);
    $this->getJson("/api/kelas-pelatihan/{$this->kelas->id_kelas}")->assertOk();
    $this->getJson("/api/kelas-pelatihan/{$this->kelasLain->id_kelas}")->assertForbidden();

    Sanctum::actingAs($this->admin);
    $this->getJson("/api/kelas-pelatihan/{$this->kelasLain->id_kelas}")->assertOk();
});

test('peserta mendaftar pelatihan selalu untuk dirinya sendiri', function () {
    $jadwalBaru = JadwalPelatihan::factory()->create(['status' => 'tersedia']);
    $jadwalBaru->pelatihan->update(['kuota' => 10]);
    $peserta = Peserta::factory()->create();
    $peserta->update(['nomor_kk' => '3509120101990002', 'nomor_wa' => '081234567890',
        'tanggal_lahir' => '2001-05-15', 'tempat_lahir' => 'Jember', 'jenis_kelamin' => 'Laki-laki',
        'alamat_lengkap' => 'Jl. Contoh', 'pendidikan_terakhir' => 'SMA', 'status_pendidikan' => 'sudah_lulus',
        'pas_foto' => 'pas_foto/a.jpg']);
    Sanctum::actingAs($peserta->user);

    $this->postJson('/api/kelas-pelatihan', [
        'id_jadwal' => $jadwalBaru->id_jadwal,
        'id_peserta' => $this->pesertaLain->id_peserta,
    ])->assertCreated();

    expect(KelasPelatihan::where('id_jadwal', $jadwalBaru->id_jadwal)->pluck('id_peserta')->all())
        ->toBe([$peserta->id_peserta]);
});

test('mitra dan instruktur tidak bisa mendaftar pelatihan', function () {
    Sanctum::actingAs(Mitra::factory()->create()->user);
    $this->postJson('/api/kelas-pelatihan', [
        'id_jadwal' => $this->jadwal->id_jadwal,
        'id_peserta' => $this->pesertaLain->id_peserta,
    ])->assertForbidden();
});

test('absensi orang lain tidak bisa dilihat, diubah, atau dihapus peserta', function () {
    $milik = Absen::factory()->create(['id_peserta' => $this->peserta->id_peserta]);
    $orangLain = Absen::factory()->create(['id_peserta' => $this->pesertaLain->id_peserta]);
    Sanctum::actingAs($this->peserta->user);

    $this->getJson("/api/absen/{$milik->id_absen}")->assertOk();
    $this->getJson("/api/absen/{$orangLain->id_absen}")->assertForbidden();
    $this->putJson("/api/absen/{$orangLain->id_absen}", ['status_kehadiran' => 'alpha'])->assertForbidden();
    $this->putJson("/api/absen/{$milik->id_absen}", ['status_kehadiran' => 'hadir'])->assertForbidden();
    $this->deleteJson("/api/absensi/{$orangLain->id_absen}")->assertForbidden();

    expect(Absen::find($orangLain->id_absen))->not->toBeNull();
});

test('mitra dan instruktur tidak bisa melihat atau mencatat absensi', function () {
    Absen::factory()->create(['id_peserta' => $this->pesertaLain->id_peserta]);
    Sanctum::actingAs(Mitra::factory()->create()->user);

    $this->getJson('/api/absen')->assertForbidden();
    $this->postJson('/api/absen', [
        'id_peserta' => $this->pesertaLain->id_peserta,
        'id_jadwal' => $this->jadwal->id_jadwal,
        'tanggal' => now()->toDateString(),
        'status_kehadiran' => 'izin',
    ])->assertForbidden();

    Sanctum::actingAs(User::factory()->create(['role' => 'instruktur']));
    $this->getJson('/api/absen')->assertForbidden();
});

test('sertifikat orang lain tidak bisa dilihat peserta', function () {
    $milik = Sertifikat::factory()->create(['id_peserta' => $this->peserta->id_peserta]);
    $orangLain = Sertifikat::factory()->create(['id_peserta' => $this->pesertaLain->id_peserta]);
    Sanctum::actingAs($this->peserta->user);

    $this->getJson("/api/sertifikat/{$milik->id_sertifikat}")->assertOk();
    $this->getJson("/api/sertifikat/{$orangLain->id_sertifikat}")->assertForbidden();
    $this->getJson('/api/sertifikat/me')->assertOk()->assertJsonCount(1, 'data');
});

test('mitra hanya bisa mengubah dan menghapus lowongan miliknya', function () {
    $mitra = Mitra::factory()->create(['is_verified' => true]);
    $milik = DaftarLowongan::factory()->create(['id_mitra' => $mitra->id_mitra]);
    $orangLain = DaftarLowongan::factory()->create();
    Sanctum::actingAs($mitra->user);

    $this->putJson("/api/lowongan/{$orangLain->id_lowongan}", ['judul_lowongan' => 'Dibajak'])->assertForbidden();
    $this->deleteJson("/api/lowongan/{$orangLain->id_lowongan}")->assertForbidden();
    $this->deleteJson("/api/lowongan/{$milik->id_lowongan}")->assertOk();

    expect(DaftarLowongan::find($orangLain->id_lowongan))->not->toBeNull()
        ->and($orangLain->fresh()->judul_lowongan)->not->toBe('Dibajak');
});

test('login dan register API dibatasi percobaannya', function () {
    foreach (range(1, 10) as $i) {
        $this->postJson('/api/auth/login', ['email' => 'tidak-ada@contoh.test', 'password' => 'salah1234'])
            ->assertStatus(422);
    }

    $this->postJson('/api/auth/login', ['email' => 'tidak-ada@contoh.test', 'password' => 'salah1234'])
        ->assertStatus(429);
});
