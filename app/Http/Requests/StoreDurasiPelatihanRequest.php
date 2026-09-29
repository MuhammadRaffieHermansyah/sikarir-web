<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDurasiPelatihanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'hari' => [
                'required', 'integer', 'min:1', 'max:366',
                Rule::unique('durasi_pelatihan')->where(fn ($query) => $query->where('jam', $this->jam)),
            ],
            'jam' => 'required|integer|min:1|max:8760',
        ];
    }

    public function messages(): array
    {
        return [
            'hari.unique' => 'Durasi ' . ($this->filled('hari') ? $this->hari : '') . ' Hari / ' . ($this->filled('jam') ? $this->jam : '') . ' Jam sudah tersedia.',
        ];
    }
}