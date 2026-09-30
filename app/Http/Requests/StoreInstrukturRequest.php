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
            'nama' => 'required|string|max:150|regex:/^[a-zA-Z\s]+$/',
            'bidang_keahlian' => 'required|string|max:150|regex:/^[a-zA-Z\s]+$/',
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama instruktur wajib diisi.',
            'nama.max' => 'Nama instruktur maksimal 150 karakter.',
            'nama.regex' => 'Nama instruktur hanya boleh mengandung huruf dan spasi.',
            'bidang_keahlian.required' => 'Bidang keahlian wajib diisi.',
            'bidang_keahlian.max' => 'Bidang keahlian maksimal 150 karakter.',
            'bidang_keahlian.regex' => 'Bidang keahlian hanya boleh mengandung huruf dan spasi.',
        ];
    }
}
