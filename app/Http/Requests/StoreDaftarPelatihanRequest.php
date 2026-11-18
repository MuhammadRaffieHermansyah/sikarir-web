<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDaftarPelatihanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return ['id_instruktur' => 'required|exists:instruktur,id', 'nama_pelatihan' => 'required|string|max:255', 'deskripsi_pelatihan' => 'nullable|string', 'id_durasi' => 'nullable|exists:durasi_pelatihan,id_durasi', 'kuota' => 'required|integer|min:1'];
    }
}
