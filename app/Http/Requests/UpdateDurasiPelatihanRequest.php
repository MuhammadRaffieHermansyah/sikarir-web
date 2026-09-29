<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class UpdateDurasiPelatihanRequest extends StoreDurasiPelatihanRequest
{
    public function rules(): array
    {
        $id = $this->route('durasi_pelatihan');

        return [
            'hari' => [
                'sometimes', 'integer', 'min:1', 'max:366',
                Rule::unique('durasi_pelatihan')
                    ->where(fn ($query) => $query->where('jam', $this->jam))
                    ->ignore($id),
            ],
            'jam' => 'sometimes|integer|min:1|max:8760',
        ];
    }
}