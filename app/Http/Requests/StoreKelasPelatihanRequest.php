<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKelasPelatihanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return ['id_peserta' => 'required|exists:pesertas,id_peserta', 'id_jadwal' => 'required|exists:jadwal_pelatihan,id_jadwal', 'status' => 'nullable|string|max:30'];
    }
}
