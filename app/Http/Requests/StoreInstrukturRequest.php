<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInstrukturRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => 'required|string|max:150|regex:/^[\pL\s.,\x27\-]+$/u',
            'bidang_keahlian' => 'required|string|max:150|regex:/^[\pL\pN\s().,&\x27\/+\-]+$/u',
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama instruktur wajib diisi.',
            'nama.max' => 'Nama instruktur maksimal 150 karakter.',
            'nama.regex' => 'Nama instruktur hanya boleh berisi huruf, spasi, dan tanda . , - \'.',
            'bidang_keahlian.required' => 'Bidang keahlian wajib diisi.',
            'bidang_keahlian.max' => 'Bidang keahlian maksimal 150 karakter.',
            'bidang_keahlian.regex' => 'Bidang keahlian hanya boleh berisi huruf, angka, spasi, dan tanda baca umum.',
        ];
    }
}
