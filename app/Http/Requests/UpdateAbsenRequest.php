<?php

namespace App\Http\Requests;

use Illuminate\Support\Arr;

class UpdateAbsenRequest extends StoreAbsenRequest
{
    /**
     * Rentang tanggal & lampiran hanya didukung saat membuat presensi baru.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $rules = Arr::except(parent::rules(), ['tanggal_selesai', 'lampiran']);

        return array_map(fn ($r) => str_replace('required|', 'sometimes|', $r), $rules);
    }
}
