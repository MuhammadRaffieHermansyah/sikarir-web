<?php

use App\Models\Instruktur;
use App\Models\Peserta;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;

beforeEach(function () {
    Storage::fake('public');

    $this->user = User::factory()->create(['role' => 'instruktur']);
    $this->instruktur = Instruktur::factory()->create(['id_user' => $this->user->id, 'nama' => 'Budi']);
});

test('instruktur melihat profilnya dari token', function () {
    Sanctum::actingAs($this->user);

    $this->getJson('/api/instruktur/me')
        ->assertOk()
        ->assertJsonPath('data.id_instruktur', $this->instruktur->id)
        ->assertJsonPath('data.id_user', $this->user->id)
        ->assertJsonPath('data.email', $this->user->email);
});

test('instruktur mengubah profil, nama akun ikut berubah, email dan role diabaikan', function () {
    Sanctum::actingAs($this->user);
    $emailAwal = $this->user->email;

    $this->postJson('/api/instruktur/me', [
        'nama' => 'Budi Santoso',
        'nomor_wa' => '08123456789',
        'bio' => 'Instruktur web dev 8 tahun.',
        'keahlian' => 'HTML, CSS, Laravel',
        'email' => 'lain@example.com',
        'role' => 'admin_blk',
    ])->assertOk()->assertJsonPath('data.nama', 'Budi Santoso')->assertJsonPath('data.keahlian', 'HTML, CSS, Laravel');

    $this->user->refresh();
    expect($this->user->name)->toBe('Budi Santoso')
        ->and($this->user->email)->toBe($emailAwal)
        ->and($this->user->role)->toBe('instruktur');
});

test('instruktur mengunggah foto dan foto lama dihapus', function () {
    Sanctum::actingAs($this->user);

    $this->post('/api/instruktur/me', ['nama' => 'Budi', 'foto' => UploadedFile::fake()->image('a.jpg')], ['Accept' => 'application/json'])->assertOk();
    $pertama = $this->user->fresh()->foto;
    Storage::disk('public')->assertExists($pertama);

    $this->post('/api/instruktur/me', ['nama' => 'Budi', 'foto' => UploadedFile::fake()->image('b.png')], ['Accept' => 'application/json'])->assertOk();
    Storage::disk('public')->assertMissing($pertama);
    Storage::disk('public')->assertExists($this->user->fresh()->foto);
});

test('validasi profil instruktur', function () {
    Sanctum::actingAs($this->user);

    $this->postJson('/api/instruktur/me', ['nama' => '', 'nomor_wa' => 'abc', 'bio' => str_repeat('x', 501)])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['nama', 'nomor_wa', 'bio']);
});

test('peserta tidak dapat mengakses profil instruktur', function () {
    Sanctum::actingAs(Peserta::factory()->create()->user);

    $this->getJson('/api/instruktur/me')->assertForbidden();
});

test('ganti password berhasil dan mencabut token lain', function () {
    $this->user->update(['password' => 'rahasia123', 'must_change_password' => true]);
    $this->user->createToken('lain');
    $token = $this->user->createToken('saat-ini')->plainTextToken;

    $this->withToken($token)->putJson('/api/profile/password', [
        'password_lama' => 'rahasia123',
        'password_baru' => 'baru12345',
        'password_baru_confirmation' => 'baru12345',
    ])->assertOk()->assertJsonPath('message', 'Password berhasil diubah.');

    $this->user->refresh();
    expect(Hash::check('baru12345', $this->user->password))->toBeTrue()
        ->and($this->user->must_change_password)->toBeFalse()
        ->and($this->user->tokens()->count())->toBe(1);
});

test('ganti password gagal bila password lama salah atau konfirmasi tidak cocok', function () {
    $this->user->update(['password' => 'rahasia123']);
    Sanctum::actingAs($this->user);

    $this->putJson('/api/profile/password', [
        'password_lama' => 'salah',
        'password_baru' => 'baru12345',
        'password_baru_confirmation' => 'baru12345',
    ])->assertUnprocessable()->assertJsonValidationErrors('password_lama');

    $this->putJson('/api/profile/password', [
        'password_lama' => 'rahasia123',
        'password_baru' => 'baru12345',
        'password_baru_confirmation' => 'beda',
    ])->assertUnprocessable()->assertJsonValidationErrors('password_baru');
});

test('auth me menyertakan role, foto, dan must_change_password', function () {
    Sanctum::actingAs($this->user->fresh());

    $this->getJson('/api/auth/me')
        ->assertOk()
        ->assertJsonPath('data.role', 'instruktur')
        ->assertJsonPath('data.must_change_password', false)
        ->assertJsonStructure(['data' => ['foto']]);
});

test('peserta mengubah nama akun lewat profil dan nomor peserta tidak berubah', function () {
    $peserta = Peserta::factory()->create();
    $nomorAwal = $peserta->nomor_peserta;
    Sanctum::actingAs($peserta->user);

    $this->postJson('/api/pesertas/me', [
        'name' => 'Nama Baru',
        'nomor_peserta' => 'HACK-1',
        'jenis_kelamin' => 'Laki-laki',
        'nomor_kk' => '3509120101990002',
        'nomor_wa' => '081234567890',
        'tanggal_lahir' => '2001-05-15',
        'tempat_lahir' => 'Jember',
        'alamat_lengkap' => 'Jl. Contoh',
        'pendidikan_terakhir' => 'SMK',
    ])->assertOk()
        ->assertJsonPath('data.user.name', 'Nama Baru')
        ->assertJsonMissingPath('data.nama');

    expect($peserta->user->fresh()->name)->toBe('Nama Baru')
        ->and($peserta->fresh()->nomor_peserta)->toBe($nomorAwal);
});
