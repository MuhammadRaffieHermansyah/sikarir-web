<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSertifikatRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return ['id_jadwal' => 'required|exists:jadwal_pelatihan,id_jadwal', 'id_peserta' => 'required|exists:pesertas,id_peserta', 'no_sertifikat' => 'required|string|max:100|unique:sertifikats,no_sertifikat', 'tanggal_terbit' => 'required|date', 'file_sertifikat' => 'nullable|file|mimes:pdf|max:5120', 'id_admin' => 'required|exists:admin_blks,id_admin'];
    }
}
