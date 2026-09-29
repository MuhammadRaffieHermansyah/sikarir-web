<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDaftarLowonganRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'id_mitra'        => 'nullable|exists:mitras,id_mitra',
            'judul_lowongan'  => 'required|string|max:255',
            'lokasi'          => 'nullable|string|max:255',
            'deskripsi'       => 'nullable|string',
            'kualifikasi'     => 'nullable|string',
            'tanggal_posting' => 'nullable|date',
            'status'          => 'nullable|in:aktif,ditutup,draft',
        ];
    }
}
