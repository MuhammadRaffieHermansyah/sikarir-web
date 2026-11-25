<?php

namespace App\Console\Commands;

use App\Http\Controllers\Concerns\OptimizesImages;
use App\Models\DaftarLowongan;
use App\Models\DaftarPelatihan;
use App\Models\Mitra;
use App\Models\Peserta;
use App\Models\User;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

#[Signature('app:optimize-stored-images {--dry-run : Hanya tampilkan perkiraan penghematan tanpa mengubah file}')]
#[Description('Perkecil resolusi & konversi ke WebP untuk gambar lama yang sudah tersimpan di storage public')]
class OptimizeStoredImages extends Command
{
    use OptimizesImages;

    /**
     * @var array<int, array{0: class-string<Model>, 1: string, 2: int, 3: int}>
     */
    private const TARGETS = [
        [DaftarPelatihan::class, 'gambar', 1280, 640],
        [DaftarLowongan::class, 'gambar', 1280, 640],
        [Mitra::class, 'logo_perusahaan', 512, 0],
        [Peserta::class, 'pas_foto', 800, 0],
        [User::class, 'foto', 800, 0],
    ];

    public function handle(): int
    {
        $disk = Storage::disk('public');
        $dryRun = (bool) $this->option('dry-run');
        $hemat = 0;
        $diproses = 0;

        foreach (self::TARGETS as [$model, $kolom, $maksimal, $thumbnail]) {
            $model::query()->whereNotNull($kolom)->where($kolom, '!=', '')->each(function ($record) use ($disk, $dryRun, $kolom, $maksimal, $thumbnail, &$hemat, &$diproses) {
                $lama = $record->{$kolom};
                if (! $disk->exists($lama) || Str::endsWith(strtolower($lama), '.svg')) {
                    return;
                }

                $contents = $this->optimizeImage($disk->path($lama), $maksimal, $maksimal);
                if ($contents === null) {
                    return;
                }

                $hemat += $disk->size($lama) - strlen($contents);
                $diproses++;

                if ($dryRun) {
                    return;
                }

                $baru = trim(dirname($lama), '/.').'/'.Str::random(40).'.webp';
                $disk->put($baru, $contents);
                if ($thumbnail > 0) {
                    $this->storeThumbnail($disk->path($lama), $baru, $thumbnail);
                }
                $record->forceFill([$kolom => $baru])->saveQuietly();
                $this->deleteImage($lama);
            });
        }

        $this->info(sprintf('%d gambar %s, perkiraan hemat %.1f KB.', $diproses, $dryRun ? 'dapat dioptimalkan' : 'dioptimalkan', $hemat / 1024));

        return self::SUCCESS;
    }
}
