<?php

use App\Models\Instruktur;
use App\Models\Peserta;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;

beforeEach(function () {
    $this->admin = User::factory()->adminBlk()->create();
    $this->peserta = Peserta::factory()->create();
});

test('admin mereset sandi peserta dan melihat sandi sementara satu kali', function () {
    $userPeserta = $this->peserta->user;
    $userPeserta->createToken('hp-lama');

    $response = $this->actingAs($this->admin)
        ->patch(route('users.reset-password', $userPeserta))
        ->assertRedirect()
        ->assertSessionHas('sandi_sementara');

    $sandi = session('sandi_sementara')['sandi'];
    $userPeserta->refresh();

    expect(strlen($sandi))->toBeGreaterThanOrEqual(8)
        ->and(Hash::check($sandi, $userPeserta->password))->toBeTrue()
        ->and($userPeserta->must_change_password)->toBeTrue()
        ->and($userPeserta->tokens()->count())->toBe(0);
});

test('peserta bisa login lewat API dengan sandi sementara dan diminta menggantinya', function () {
    $this->actingAs($this->admin)->patch(route('users.reset-password', $this->peserta->user));
    $sandi = session('sandi_sementara')['sandi'];

    $this->postJson('/api/auth/login', ['email' => $this->peserta->user->email, 'password' => $sandi])
        ->assertOk()
        ->assertJsonPath('data.must_change_password', true);
});

test('admin bisa mereset sandi instruktur yang punya akun', function () {
    $userInstruktur = User::factory()->create(['role' => 'instruktur']);
    Instruktur::factory()->create(['id_user' => $userInstruktur->id]);

    $this->actingAs($this->admin)
        ->patch(route('users.reset-password', $userInstruktur))
        ->assertSessionHas('sandi_sementara');

    expect($userInstruktur->fresh()->must_change_password)->toBeTrue();
});

test('sandi akun admin tidak bisa direset lewat fitur ini', function () {
    $adminLain = User::factory()->adminBlk()->create();
    $hashLama = $adminLain->password;

    $this->actingAs($this->admin)
        ->patch(route('users.reset-password', $adminLain))
        ->assertForbidden();

    expect($adminLain->fresh()->password)->toBe($hashLama);
});

test('selain admin tidak bisa mereset sandi orang lain', function () {
    $pesertaLain = Peserta::factory()->create();
    $hashLama = $pesertaLain->user->password;

    $this->actingAs(User::factory()->mitra()->create())
        ->patch(route('users.reset-password', $pesertaLain->user))
        ->assertRedirect(route('dashboard'));

    expect($pesertaLain->user->fresh()->password)->toBe($hashLama);
});

test('halaman detail peserta menampilkan tombol reset sandi dan sandi sementara', function () {
    $this->actingAs($this->admin)
        ->get(route('pesertas.show', $this->peserta->id_peserta))
        ->assertOk()
        ->assertSee(route('users.reset-password', $this->peserta->user));

    $this->patch(route('users.reset-password', $this->peserta->user));
    $sandi = session('sandi_sementara')['sandi'];

    $this->get(route('pesertas.show', $this->peserta->id_peserta))
        ->assertSee($sandi);
});

test('mengganti sandi lewat API mematikan tanda wajib ganti sandi', function () {
    $user = $this->peserta->user;
    $user->update(['password' => 'SandiSementara1', 'must_change_password' => true]);

    Sanctum::actingAs($user);
    $this->putJson('/api/profile/password', [
        'password_lama' => 'SandiSementara1',
        'password_baru' => 'SandiBaru12345',
        'password_baru_confirmation' => 'SandiBaru12345',
    ])->assertOk();

    expect($user->fresh()->must_change_password)->toBeFalse();
});
