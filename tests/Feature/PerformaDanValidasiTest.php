<?php

use App\Models\Absen;
use App\Models\DaftarLowongan;
use App\Models\DaftarPelatihan;
use App\Models\Instruktur;
use App\Models\JadwalPelatihan;
use App\Models\KelasPelatihan;
use App\Models\Mitra;
use App\Models\Peserta;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $this->admin = User::factory()->create(['role' => 'admin_blk']);
});

function jumlahQuery(Closure $aksi): int
{
    DB::flushQueryLog();
    DB::enableQueryLog();
    $aksi();
    $jumlah = count(DB::getQueryLog());
    DB::disableQueryLog();

    return $jumlah;
}

test('upload gambar pelatihan diperkecil ke webp dan dibuatkan thumbnail', function () {
    Storage::fake('public');
    $instruktur = Instruktur::factory()->create();

    $this->actingAs($this->admin)->post(route('pelatihan.store'), [
        'id_instruktur' => $instruktur->id,
        'nama_pelatihan' => 'Teknik Las Dasar',
        'kuota' => 10,
        'gambar' => UploadedFile::fake()->image('besar.jpg', 3000, 2000),
    ])->assertSessionHasNoErrors();

    $pelatihan = DaftarPelatihan::firstWhere('nama_pelatihan', 'Teknik Las Dasar');

    expect($pelatihan->gambar)->toEndWith('.webp');
    Storage::disk('public')->assertExists($pelatihan->gambar);

    [$lebar] = getimagesizefromstring(Storage::disk('public')->get($pelatihan->gambar));
    expect($lebar)->toBeLessThanOrEqual(1280);

    expect($pelatihan->gambar_thumb_url)->toContain('-thumb.webp');
    [$lebarThumb] = getimagesizefromstring(Storage::disk('public')->get(str_replace('.webp', '-thumb.webp', $pelatihan->gambar)));
    expect($lebarThumb)->toBeLessThanOrEqual(640);
});

test('logo mitra svg ditolak karena berpotensi xss', function () {
    $user = User::factory()->mitra()->create();

    $this->actingAs($this->admin)->post(route('mitras.store'), [
        'logo_perusahaan' => UploadedFile::fake()->createWithContent('logo.svg', '<svg xmlns="http://www.w3.org/2000/svg"></svg>'),
        'id_user' => $user->id,
    ])->assertSessionHasErrors('logo_perusahaan');
});

test('daftar mitra tidak memuat semua lowongan (tanpa n+1)', function () {
    Mitra::factory()->count(3)->create()->each(fn ($m) => DaftarLowongan::factory()->count(3)->create(['id_mitra' => $m->id_mitra]));
    $sedikit = jumlahQuery(fn () => $this->actingAs($this->admin)->get(route('mitras.index'))->assertOk());

    Mitra::factory()->count(6)->create()->each(fn ($m) => DaftarLowongan::factory()->count(3)->create(['id_mitra' => $m->id_mitra]));
    $banyak = jumlahQuery(fn () => $this->actingAs($this->admin)->get(route('mitras.index'))->assertOk());

    expect($banyak)->toBeLessThanOrEqual($sedikit);
});

test('dropdown akun peserta hanya berisi user peserta tanpa profil dan tanpa n+1', function () {
    User::factory()->count(3)->create(['role' => 'peserta']);
    User::factory()->mitra()->create(['email' => 'mitra-saja@example.test']);
    $sedikit = jumlahQuery(fn () => $this->actingAs($this->admin)->get(route('pesertas.create'))->assertOk()->assertDontSee('mitra-saja@example.test'));

    User::factory()->count(8)->create(['role' => 'peserta']);
    $banyak = jumlahQuery(fn () => $this->actingAs($this->admin)->get(route('pesertas.create'))->assertOk());

    expect($banyak)->toBeLessThanOrEqual($sedikit);
});

test('pencarian tidak menganggap persen sebagai wildcard', function () {
    $mitra = Mitra::factory()->create();
    DaftarLowongan::factory()->create(['id_mitra' => $mitra->id_mitra, 'status' => 'aktif', 'judul_lowongan' => 'Operator Mesin']);

    $this->get(route('lowongan.katalog', ['q' => '%']))->assertOk()->assertDontSee('Operator Mesin');
    $this->get(route('lowongan.katalog', ['q' => 'Operator']))->assertOk()->assertSee('Operator Mesin');
});

test('mitra tidak bisa melihat detail lowongan milik mitra lain', function () {
    $userA = User::factory()->mitra()->create();
    Mitra::factory()->create(['id_user' => $userA->id, 'is_verified' => true]);
    $lowonganLain = DaftarLowongan::factory()->create(['status' => 'draft']);

    $this->actingAs($userA)->get(route('lowongan.show', $lowonganLain->id_lowongan))->assertForbidden();
});

test('presensi ditolak bila peserta belum terdaftar di kelas atau tanggal di luar periode', function () {
    $peserta = Peserta::factory()->create();
    $jadwal = JadwalPelatihan::factory()->create(['tanggal_mulai' => '2026-11-01', 'tanggal_selesai' => '2026-11-10']);
    $payload = [
        'id_peserta' => $peserta->id_peserta,
        'id_jadwal' => $jadwal->id_jadwal,
        'tanggal' => '2026-11-03',
        'status_kehadiran' => 'hadir',
    ];

    $this->actingAs($this->admin)->post(route('absen.store'), $payload)->assertSessionHasErrors('id_peserta');

    KelasPelatihan::factory()->create(['id_peserta' => $peserta->id_peserta, 'id_jadwal' => $jadwal->id_jadwal]);

    $this->post(route('absen.store'), ['tanggal' => '2027-11-03'] + $payload)->assertSessionHasErrors('tanggal');
    $this->post(route('absen.store'), $payload)->assertSessionHasNoErrors();

    expect(Absen::where('id_peserta', $peserta->id_peserta)->count())->toBe(1);
});

test('jam selesai jadwal harus setelah jam mulai', function () {
    $jadwal = JadwalPelatihan::factory()->create();

    $this->actingAs($this->admin)->put(route('jadwal-pelatihan.update', $jadwal->id_jadwal), [
        'id_pelatihan' => $jadwal->id_pelatihan,
        'tanggal_mulai' => '2026-12-01',
        'tanggal_selesai' => '2026-12-05',
        'jam_mulai' => '15:00',
        'jam_selesai' => '08:00',
        'id_instruktur' => $jadwal->id_instruktur,
        'id_ruangan_workshop' => $jadwal->id_ruangan_workshop,
        'status' => 'tersedia',
    ])->assertSessionHasErrors('jam_selesai');
});
