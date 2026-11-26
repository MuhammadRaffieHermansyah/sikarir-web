<?php

test('halaman daftar mengarahkan peserta ke aplikasi mobile dan mitra ke form mitra', function () {
    $this->get('/register')
        ->assertOk()
        ->assertSee('Daftar lewat aplikasi siKarir')
        ->assertSee(route('register.mitra'))
        ->assertDontSee('name="password_confirmation"', false);
});

test('akun peserta tidak bisa dibuat lewat web', function () {
    $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ])->assertMethodNotAllowed();

    $this->assertGuest();
    $this->assertDatabaseMissing('users', ['email' => 'test@example.com']);
});
