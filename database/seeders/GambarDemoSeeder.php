<?php

namespace Database\Seeders;

use App\Models\DaftarLowongan;
use App\Models\DaftarPelatihan;
use App\Models\Mitra;
use App\Models\Peserta;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Menyalin gambar demo dari database/seeders/images ke storage publik
 * (storage/app/public) lalu memasangnya ke data pelatihan, lowongan,
 * logo mitra, pas foto peserta, dan foto instruktur.
 *
 * Gambar diperkecil & dikonversi ke WebP (plus thumbnail untuk daftar/kartu)
 * seperti proses unggah di aplikasi. Tidak butuh internet saat seeding.
 * Aman dijalankan berulang kali (nama file tetap, tidak menumpuk).
 */
class GambarDemoSeeder extends Seeder
{
    /**
     * Kata kunci judul => berkas sumber (relatif terhadap database/seeders/images).
     * Urutan penting: kata kunci yang lebih spesifik ditaruh lebih dulu.
     *
     * @var array<string, string>
     */
    private const PELATIHAN = [
        'ui/ux' => 'pelatihan/desain-grafis',
        'web & mobile' => 'pelatihan/web-mobile',
        'teknik las' => 'pelatihan/las-industri',
        'kendaraan listrik' => 'pelatihan/teknisi-ev',
        'digital marketing' => 'pelatihan/digital-marketing',
        'administrasi perkantoran' => 'pelatihan/administrasi',
        'jaringan komputer' => 'pelatihan/jaringan',
        'otomotif' => 'pelatihan/otomotif',
    ];

    /** @var array<string, string> */
    private const LOWONGAN = [
        'web & ui' => 'lowongan/web-developer',
        'draftsman' => 'lowongan/draftsman',
        'administrasi gudang' => 'lowongan/admin-gudang',
        'fiber optic' => 'lowongan/fiber-optic',
        'welder' => 'lowongan/welder',
        'customer service' => 'lowongan/customer-service',
        'otomotif' => 'pelatihan/otomotif',
        'digital marketing' => 'pelatihan/digital-marketing',
    ];

    /** @var array<string, string> */
    private const LOGO_MITRA = [
        'midtrans' => 'logos/midtrans',
        'astra' => 'logos/astra',
        'kalbe' => 'logos/kalbe',
        'telkom' => 'logos/telkom',
        'komatsu' => 'logos/komatsu',
    ];

    public function run(): void
    {
        $this->pastikanStorageLink();

        $this->seedPelatihan();
        $this->seedLowongan();
        $this->seedLogoMitra();
        $this->seedFotoPeserta();
        $this->seedFotoInstruktur();
    }

    private function seedPelatihan(): void
    {
        foreach (DaftarPelatihan::orderBy('id_pelatihan')->get() as $index => $pelatihan) {
            $sumber = $this->cariSumber(self::PELATIHAN, $pelatihan->nama_pelatihan, 'pelatihan', $index);
            $pelatihan->update(['gambar' => $this->simpan($sumber, 'pelatihan', 1280, 640)]);
        }
    }

    private function seedLowongan(): void
    {
        foreach (DaftarLowongan::orderBy('id_lowongan')->get() as $index => $lowongan) {
            $sumber = $this->cariSumber(self::LOWONGAN, $lowongan->judul_lowongan, 'lowongan', $index);
            $lowongan->update(['gambar' => $this->simpan($sumber, 'lowongan', 1280, 640)]);
        }
    }

    private function seedLogoMitra(): void
    {
        foreach (Mitra::orderBy('id_mitra')->get() as $index => $mitra) {
            $sumber = $this->cariSumber(self::LOGO_MITRA, $mitra->nama_perusahaan, 'logos', $index);
            $mitra->update(['logo_perusahaan' => $this->simpan($sumber, 'logos/mitras', 512)]);
        }
    }

    private function seedFotoPeserta(): void
    {
        foreach (Peserta::orderBy('id_peserta')->get() as $index => $peserta) {
            $sumber = $this->urutan('pas_foto', $index);
            $peserta->update(['pas_foto' => $this->simpan($sumber, 'pas_foto', 400)]);
        }
    }

    private function seedFotoInstruktur(): void
    {
        $sumber = $this->urutan('foto', 0);

        if ($sumber === null) {
            return;
        }

        foreach (User::where('role', 'instruktur')->get() as $user) {
            $user->update(['foto' => $this->simpan($sumber, 'foto', 400)]);
        }
    }

    /**
     * @param  array<string, string>  $peta
     */
    private function cariSumber(array $peta, string $judul, string $folderCadangan, int $index): ?string
    {
        $judul = Str::lower($judul);

        foreach ($peta as $kataKunci => $berkas) {
            if (str_contains($judul, $kataKunci)) {
                return $berkas;
            }
        }

        return $this->urutan($folderCadangan, $index);
    }

    /**
     * Ambil berkas ke-$index (berputar) dari sebuah folder gambar.
     */
    private function urutan(string $folder, int $index): ?string
    {
        $berkas = collect(File::glob($this->sumberPath($folder.'/*.jpg')))
            ->map(fn (string $path): string => $folder.'/'.pathinfo($path, PATHINFO_FILENAME))
            ->sort()
            ->values();

        return $berkas->isEmpty() ? null : $berkas[$index % $berkas->count()];
    }

    private function sumberPath(string $relatif): string
    {
        return database_path('seeders/images/'.$relatif);
    }

    /**
     * Simpan ke disk public sebagai WebP (+ thumbnail bila diminta).
     *
     * @return string|null Path relatif di disk public, atau null bila sumber tidak ada.
     */
    private function simpan(?string $sumber, string $tujuan, int $maksimal, int $thumbnail = 0): ?string
    {
        $file = $sumber === null ? null : $this->sumberPath($sumber.'.jpg');

        if ($file === null || ! File::exists($file)) {
            $this->command?->warn('Gambar sumber tidak ditemukan: '.($sumber ?? '(kosong)'));

            return null;
        }

        $nama = 'seed-'.basename($sumber);
        $disk = Storage::disk('public');

        $webp = $this->keWebp($file, $maksimal);

        if ($webp === null) {
            $path = $tujuan.'/'.$nama.'.jpg';
            $disk->put($path, File::get($file));

            return $path;
        }

        $path = $tujuan.'/'.$nama.'.webp';
        $disk->put($path, $webp);

        if ($thumbnail > 0) {
            $disk->put($tujuan.'/'.$nama.'-thumb.webp', $this->keWebp($file, $thumbnail) ?? $webp);
        }

        return $path;
    }

    /**
     * Perkecil (tanpa memperbesar) lalu encode ke WebP; null bila GD tidak mendukung.
     */
    private function keWebp(string $file, int $maksimal): ?string
    {
        if (! function_exists('imagewebp') || ! function_exists('imagecreatefromjpeg')) {
            return null;
        }

        $gambar = @imagecreatefromjpeg($file);

        if ($gambar === false) {
            return null;
        }

        $lebar = imagesx($gambar);
        $tinggi = imagesy($gambar);
        $rasio = min(1, $maksimal / max($lebar, $tinggi));

        if ($rasio < 1) {
            $gambar = imagescale($gambar, max(1, (int) round($lebar * $rasio)), max(1, (int) round($tinggi * $rasio)));
        }

        ob_start();
        imagewebp($gambar, null, 80);
        $isi = (string) ob_get_clean();

        return $isi === '' ? null : $isi;
    }

    /**
     * Pastikan public/storage -> storage/app/public sudah ada agar gambar tampil di web & mobile.
     */
    private function pastikanStorageLink(): void
    {
        if (file_exists(public_path('storage'))) {
            return;
        }

        try {
            Artisan::call('storage:link');
        } catch (\Throwable $e) {
            $this->command?->warn('Gagal membuat storage link, jalankan manual: php artisan storage:link ('.$e->getMessage().')');
        }
    }
}
