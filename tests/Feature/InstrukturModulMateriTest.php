<?php

use App\Models\Instruktur;
use App\Models\JadwalPelatihan;
use App\Models\KelasPelatihan;
use App\Models\Materi;
use App\Models\Modul;
use App\Models\Peserta;
use App\Models\User;
use Database\Seeders\InstrukturAkunSeeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;

beforeEach(function () {
    Storage::fake('public');

    $this->userInstruktur = User::factory()->create(['role' => 'instruktur']);
    $this->instruktur = Instruktur::factory()->create(['id_user' => $this->userInstruktur->id]);
    $this->jadwal = JadwalPelatihan::factory()->create(['id_instruktur' => $this->instruktur->id]);
    $this->peserta = Peserta::factory()->create();
    $this->kelas = KelasPelatihan::factory()->create([
        'id_peserta' => $this->peserta->id_peserta,
        'id_jadwal' => $this->jadwal->id_jadwal,
    ]);
});

test('instruktur melihat kelas yang diampu', function () {
    KelasPelatihan::factory()->create(['id_jadwal' => $this->jadwal->id_jadwal]);
    KelasPelatihan::factory()->create(); // kelas milik instruktur lain

    Sanctum::actingAs($this->userInstruktur);

    $this->getJson('/api/instruktur/kelas')
        ->assertOk()
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.id_jadwal', $this->jadwal->id_jadwal);
});

test('peserta tidak boleh membuka daftar kelas instruktur', function () {
    Sanctum::actingAs($this->peserta->user);

    $this->getJson('/api/instruktur/kelas')->assertForbidden();
});

test('instruktur pengampu menambah dan melihat modul', function () {
    Sanctum::actingAs($this->userInstruktur);

    $this->postJson("/api/kelas-pelatihan/{$this->kelas->id_kelas}/modul", [
        'judul' => 'Dasar HTML',
        'deskripsi' => 'Struktur halaman web',
        'pertemuan_ke' => 1,
    ])->assertCreated()->assertJsonPath('data.judul', 'Dasar HTML');

    $this->getJson("/api/kelas-pelatihan/{$this->kelas->id_kelas}/modul")
        ->assertOk()
        ->assertJsonPath('data.0.judul', 'Dasar HTML')
        ->assertJsonPath('data.0.id_kelas', $this->kelas->id_kelas);
});

test('validasi modul mengembalikan 422', function () {
    Sanctum::actingAs($this->userInstruktur);

    $this->postJson("/api/kelas-pelatihan/{$this->kelas->id_kelas}/modul", ['pertemuan_ke' => 0])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['judul', 'pertemuan_ke']);
});

test('peserta terdaftar dapat membaca modul tetapi tidak menulis', function () {
    Modul::factory()->create(['id_jadwal' => $this->jadwal->id_jadwal]);
    Sanctum::actingAs($this->peserta->user);

    $this->getJson("/api/kelas-pelatihan/{$this->kelas->id_kelas}/modul")->assertOk()->assertJsonCount(1, 'data');
    $this->postJson("/api/kelas-pelatihan/{$this->kelas->id_kelas}/modul", ['judul' => 'X', 'pertemuan_ke' => 1])->assertForbidden();
});

test('pengguna yang bukan pengampu atau peserta ditolak', function () {
    $lain = User::factory()->create(['role' => 'instruktur']);
    Instruktur::factory()->create(['id_user' => $lain->id]);
    Sanctum::actingAs($lain);

    $this->getJson("/api/kelas-pelatihan/{$this->kelas->id_kelas}/modul")->assertForbidden();
    $this->postJson("/api/kelas-pelatihan/{$this->kelas->id_kelas}/modul", ['judul' => 'X', 'pertemuan_ke' => 1])->assertForbidden();
});

test('instruktur menghapus modul beserta materinya', function () {
    $modul = Modul::factory()->create(['id_jadwal' => $this->jadwal->id_jadwal]);
    Materi::factory()->create(['id_modul' => $modul->id_modul]);
    Sanctum::actingAs($this->userInstruktur);

    $this->deleteJson("/api/modul/{$modul->id_modul}")->assertOk();

    expect(Modul::count())->toBe(0)->and(Materi::count())->toBe(0);
});

test('instruktur menambah materi bertipe file, link, dan teks', function () {
    $modul = Modul::factory()->create(['id_jadwal' => $this->jadwal->id_jadwal]);
    Sanctum::actingAs($this->userInstruktur);

    $this->post("/api/modul/{$modul->id_modul}/materi", [
        'judul' => 'Slide', 'tipe' => 'file',
        'file' => UploadedFile::fake()->create('slide.pdf', 100, 'application/pdf'),
    ], ['Accept' => 'application/json'])
        ->assertCreated()
        ->assertJsonPath('data.nama_file', 'slide.pdf');

    $path = Materi::where('tipe', 'file')->value('url');
    Storage::disk('public')->assertExists($path);

    $this->postJson("/api/modul/{$modul->id_modul}/materi", ['judul' => 'Video', 'tipe' => 'link', 'url' => 'https://youtu.be/xxxx'])->assertCreated();
    $this->postJson("/api/modul/{$modul->id_modul}/materi", ['judul' => 'Catatan', 'tipe' => 'teks', 'konten' => 'Isi'])->assertCreated();

    expect($modul->materi()->count())->toBe(3);

    $this->deleteJson('/api/materi/'.Materi::where('tipe', 'file')->value('id_materi'))->assertOk();
    Storage::disk('public')->assertMissing($path);
});

test('validasi materi sesuai tipe', function () {
    $modul = Modul::factory()->create(['id_jadwal' => $this->jadwal->id_jadwal]);
    Sanctum::actingAs($this->userInstruktur);

    $this->postJson("/api/modul/{$modul->id_modul}/materi", ['judul' => 'A', 'tipe' => 'link', 'url' => 'ftp://x'])
        ->assertUnprocessable()->assertJsonValidationErrors('url');
    $this->postJson("/api/modul/{$modul->id_modul}/materi", ['judul' => 'A', 'tipe' => 'teks'])
        ->assertUnprocessable()->assertJsonValidationErrors('konten');
    $this->postJson("/api/modul/{$modul->id_modul}/materi", ['judul' => 'A', 'tipe' => 'file'])
        ->assertUnprocessable()->assertJsonValidationErrors('file');
});

test('non pengampu tidak dapat menambah atau menghapus materi', function () {
    $modul = Modul::factory()->create(['id_jadwal' => $this->jadwal->id_jadwal]);
    $materi = Materi::factory()->create(['id_modul' => $modul->id_modul]);
    Sanctum::actingAs($this->peserta->user);

    $this->postJson("/api/modul/{$modul->id_modul}/materi", ['judul' => 'A', 'tipe' => 'teks', 'konten' => 'x'])->assertForbidden();
    $this->deleteJson("/api/materi/{$materi->id_materi}")->assertForbidden();
});

test('seeder akun instruktur menautkan akun dan mengisi contoh modul', function () {
    $this->seed(InstrukturAkunSeeder::class);

    $user = User::where('email', 'instruktur@sikarir.com')->firstOrFail();

    expect($user->role)->toBe('instruktur')
        ->and($user->instruktur)->not->toBeNull()
        ->and(Modul::count())->toBeGreaterThan(0);
});
