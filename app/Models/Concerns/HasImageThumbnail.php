<?php

namespace App\Models\Concerns;

use Illuminate\Support\Facades\Storage;

trait HasImageThumbnail
{
    /**
     * URL thumbnail ringan untuk daftar/kartu; kembali ke gambar asli bila thumbnail belum ada
     * (data lama yang diunggah sebelum fitur thumbnail).
     */
    public function getGambarThumbUrlAttribute(): ?string
    {
        if (! $this->gambar) {
            return null;
        }

        $thumb = preg_replace('/\.webp$/', '-thumb.webp', $this->gambar, -1, $found);

        if ($found && Storage::disk('public')->exists($thumb)) {
            return asset('storage/'.$thumb);
        }

        return $this->gambar_url;
    }
}
