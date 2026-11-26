<?php

use App\Models\Absen;
use App\Models\AdminBlk;
use App\Models\DaftarPelatihan;
use App\Models\JadwalPelatihan;
use App\Models\DaftarLowongan;
use App\Models\RuanganWorkshop;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

test('panel presensi admin memakai data nyata, bukan angka contoh', function () {
    $admin = User::factory()->create(['role' => 'admin_blk']);
    Absen::factory()->count(3)->create(['tanggal' => today()->toDateString(), 'status_kehadiran' => 'hadir']);
    Absen::factory()->create(['tanggal' => today()->toDateString(), 'status_kehadiran' => 'izin']);

    $this->actingAs($admin)
        ->get(route('admin-blk.index'))
        ->assertOk()
        ->assertSee('Presensi Hari Ini')
        ->assertDontSee('96.8%')
        ->assertDontSee('34,600');
});

test('panel presensi admin tidak error saat belum ada data absensi', function () {
    $admin = User::factory()->create(['role' => 'admin_blk']);

    $this->actingAs($admin)->get(route('admin-blk.index'))->assertOk()->assertSee('Belum ada data');
});

test('halaman publik tidak punya tombol mati dan memakai nomor WhatsApp dari konfigurasi', function () {
    foreach (['pelatihan.katalog', 'lowongan.katalog'] as $nama) {
        $this->get(route($nama))
            ->assertOk()
            ->assertDontSee('href="#"', false)
            ->assertDontSee('wa.me/#', false);
    }

    $this->get(route('lowongan.katalog'))->assertSee(route('register.mitra'), false);
});

test('katalog pelatihan memfilter status dari jadwal nyata dan membatasi hasil terbaru', function () {
    $programTerbuka = DaftarPelatihan::factory()->create(['nama_pelatihan' => 'Program Terbuka']);
    $programTanpaJadwalBuka = DaftarPelatihan::factory()->create(['nama_pelatihan' => 'Program Tidak Terbuka']);

    JadwalPelatihan::factory()->create([
        'id_pelatihan' => $programTerbuka->id_pelatihan,
        'tanggal_mulai' => today()->addWeek(),
        'tanggal_selesai' => today()->addWeeks(5),
        'status' => 'tersedia',
    ]);
    JadwalPelatihan::factory()->create([
        'id_pelatihan' => $programTanpaJadwalBuka->id_pelatihan,
        'tanggal_mulai' => today()->addWeek(),
        'tanggal_selesai' => today()->addWeeks(5),
        'status' => 'berlangsung',
    ]);

    $this->get(route('pelatihan.katalog', ['status' => 'buka']))
        ->assertOk()
        ->assertViewHas('pelatihan', fn ($hasil) => $hasil->count() === 1
            && $hasil->first()->is($programTerbuka));

    $this->get(route('pelatihan.katalog', ['status' => 'tutup']))
        ->assertOk()
        ->assertViewHas('pelatihan', fn ($hasil) => $hasil->count() === 1
            && $hasil->first()->is($programTanpaJadwalBuka));
});

test('endpoint katalog mengirim hasil pencarian terbaru secara real time', function () {
    $programDicari = DaftarPelatihan::factory()->create(['nama_pelatihan' => 'Pelatihan Pencarian Langsung']);
    DaftarPelatihan::factory()->count(6)->create();

    $this->getJson(route('pelatihan.katalog.hasil', ['q' => 'Pencarian Langsung']))
        ->assertOk()
        ->assertJsonPath('count', 1)
        ->assertJsonPath('html', fn ($html) => str_contains($html, $programDicari->nama_pelatihan));

    $this->get(route('pelatihan.katalog'))
        ->assertOk()
        ->assertViewHas('pelatihan', fn ($hasil) => $hasil->count() === 6);
});

test('kalender katalog hanya menampilkan tiga jadwal terbaru yang masih relevan', function () {
    $pelatihan = DaftarPelatihan::factory()->create();
    $ruangan = RuanganWorkshop::factory()->create();
    JadwalPelatihan::factory()->count(4)->create([
        'id_pelatihan' => $pelatihan->id_pelatihan,
        'id_ruangan_workshop' => $ruangan->id,
        'tanggal_mulai' => today()->addWeek(),
        'tanggal_selesai' => today()->addWeeks(5),
    ]);
    JadwalPelatihan::factory()->create([
        'id_pelatihan' => $pelatihan->id_pelatihan,
        'id_ruangan_workshop' => $ruangan->id,
        'tanggal_mulai' => today()->subMonths(2),
        'tanggal_selesai' => today()->subMonth(),
    ]);

    $this->get(route('pelatihan.katalog'))
        ->assertOk()
        ->assertViewHas('kalenderPelatihan', fn ($hasil) => $hasil->count() === 3);
});

test('katalog lowongan memakai lokasi string dan mengarahkan ke info lengkap publik', function () {
    Cache::forget('public.lowongan.lokasi.v3');
    $lowongan = DaftarLowongan::factory()->create([
        'judul_lowongan' => 'Teknisi Pengujian',
        'lokasi' => 'Jember',
        'deskripsi' => 'Menangani pengujian mesin.',
        'kualifikasi' => 'Memahami dasar teknik mesin.',
        'status' => 'aktif',
    ]);

    $this->get(route('lowongan.katalog'))
        ->assertOk()
        ->assertSee('Jember')
        ->assertSee('Info Selengkapnya')
        ->assertDontSee('Lamar Cepat')
        ->assertDontSee('Alur Penyaluran BKK')
        ->assertDontSee('LSP P1 BLK Jember')
        ->assertSee(route('lowongan.detail', $lowongan->id_lowongan), false);

    $this->get(route('lowongan.detail', $lowongan->id_lowongan))
        ->assertOk()
        ->assertSee('Teknisi Pengujian')
        ->assertSee('Menangani pengujian mesin.')
        ->assertSee('Memahami dasar teknik mesin.');
});

test('katalog lowongan menampilkan tiga data per halaman dan mempertahankan anchor hasil', function () {
    Cache::forget('public.lowongan.lokasi.v3');
    foreach (range(1, 4) as $nomor) {
        DaftarLowongan::factory()->create([
            'judul_lowongan' => "Posisi Pagination {$nomor}",
            'status' => 'aktif',
        ]);
    }

    $this->get(route('lowongan.katalog'))
        ->assertOk()
        ->assertViewHas('lowongan', fn ($hasil) => $hasil->perPage() === 3 && $hasil->hasPages())
        ->assertSee('id="daftar-lowongan"', false)
        ->assertSee('page=2#daftar-lowongan', false)
        ->assertSee('action="'.route('lowongan.katalog').'#daftar-lowongan"', false);
});

test('halaman daftar dan detail admin BLK tidak error saat ada data', function () {
    $admin = User::factory()->create(['role' => 'admin_blk']);
    $profil = AdminBlk::factory()->create();

    $this->actingAs($admin)->get(route('admin-blk.index'))->assertOk();
    $this->actingAs($admin)->get(route('admin-blk.show', $profil->id_admin))->assertOk();
});

test('header dan halaman cetak tidak lagi memuat teks contoh', function () {
    $admin = User::factory()->create(['role' => 'admin_blk']);

    $this->actingAs($admin)->get(route('admin-blk.index'))
        ->assertOk()
        ->assertDontSee('Gelombang II')
        ->assertDontSee('Semua Balai');

    $this->actingAs($admin)->get(route('absen.cetak'))
        ->assertOk()
        ->assertDontSee('Bambang Soeprapto')
        ->assertDontSee('logo_sikarir.png', false);
});

test('peserta dan instruktur tidak membuka dashboard web', function (string $role) {
    $this->actingAs(User::factory()->create(['role' => $role]))->get(route('dashboard'))
        ->assertRedirect(route('login'));

    $this->assertGuest();
})->with(['peserta', 'instruktur']);
