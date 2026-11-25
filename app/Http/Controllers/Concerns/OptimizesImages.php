<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait OptimizesImages
{
    /**
     * Simpan gambar upload ke disk public setelah diperkecil (scale down) dan
     * dikonversi ke WebP, sehingga halaman tidak memuat foto beresolusi asli
     * dari kamera/HP. Bila GD tidak mendukung formatnya (mis. GIF animasi),
     * file disimpan apa adanya.
     */
    protected function storeImage(UploadedFile $file, string $directory, int $maxWidth = 1280, int $maxHeight = 1280, int $thumbnailWidth = 0): string
    {
        $optimized = $this->optimizeImage((string) $file->getRealPath(), $maxWidth, $maxHeight, (int) $file->getSize());

        if ($optimized === null) {
            return $file->store($directory, 'public');
        }

        $path = trim($directory, '/').'/'.Str::random(40).'.webp';
        Storage::disk('public')->put($path, $optimized);

        if ($thumbnailWidth > 0) {
            $this->storeThumbnail((string) $file->getRealPath(), $path, $thumbnailWidth);
        }

        return $path;
    }

    /**
     * Buat thumbnail `<nama>-thumb.webp` di samping gambar utama (dipakai di daftar/kartu).
     */
    protected function storeThumbnail(string $source, string $path, int $width): void
    {
        $thumb = $this->optimizeImage($source, $width, $width, PHP_INT_MAX);

        if ($thumb !== null) {
            Storage::disk('public')->put(preg_replace('/\.webp$/', '-thumb.webp', $path), $thumb);
        }
    }

    /**
     * Hapus gambar beserta thumbnail-nya (bila ada).
     */
    protected function deleteImage(?string $path): void
    {
        if (! $path) {
            return;
        }

        Storage::disk('public')->delete([$path, preg_replace('/\.webp$/', '-thumb.webp', $path)]);
    }

    /**
     * Perkecil gambar ke batas lebar/tinggi dan encode ke WebP.
     *
     * @return string|null Isi WebP, atau null bila gambar tidak perlu/tidak bisa dioptimalkan.
     */
    protected function optimizeImage(string $source, int $maxWidth, int $maxHeight, ?int $originalSize = null): ?string
    {
        $info = $source !== '' ? @getimagesize($source) : false;

        $loader = match ($info[2] ?? null) {
            IMAGETYPE_JPEG => 'imagecreatefromjpeg',
            IMAGETYPE_PNG => 'imagecreatefrompng',
            IMAGETYPE_WEBP => 'imagecreatefromwebp',
            default => null,
        };

        if ($loader === null || ! function_exists($loader) || ! function_exists('imagewebp')) {
            return null;
        }

        $image = @$loader($source);
        if ($image === false) {
            return null;
        }

        if ($info[2] === IMAGETYPE_JPEG && function_exists('exif_read_data')) {
            $orientation = @exif_read_data($source)['Orientation'] ?? 1;
            $angle = [3 => 180, 6 => -90, 8 => 90][$orientation] ?? 0;
            if ($angle !== 0 && ($rotated = imagerotate($image, $angle, 0)) !== false) {
                $image = $rotated;
            }
        }

        $width = imagesx($image);
        $height = imagesy($image);
        $ratio = min(1, $maxWidth / $width, $maxHeight / $height);
        $resized = $ratio < 1;

        if ($resized) {
            $scaled = imagescale($image, max(1, (int) round($width * $ratio)), max(1, (int) round($height * $ratio)), IMG_BICUBIC);
            if ($scaled !== false) {
                $image = $scaled;
            }
        }

        imagepalettetotruecolor($image);
        imagealphablending($image, false);
        imagesavealpha($image, true);

        ob_start();
        imagewebp($image, null, 82);
        $contents = (string) ob_get_clean();

        $originalSize ??= (int) @filesize($source);

        if ($contents === '' || (! $resized && strlen($contents) >= $originalSize)) {
            return null;
        }

        return $contents;
    }
}
