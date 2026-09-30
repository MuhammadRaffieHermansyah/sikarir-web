<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDaftarLowonganRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        $idMitra = $this->input('id_mitra') ?? auth()->user()?->mitra?->id_mitra;

        return [
            'id_mitra'        => 'nullable|exists:mitras,id_mitra',
            'judul_lowongan'  => [
                'required',
                'string',
                'max:255',
                $idMitra
                    ? Rule::unique('daftar_lowongan', 'judul_lowongan')->where('id_mitra', $idMitra)
                    : 'nullable',
            ],
            'lokasi'          => 'nullable|string|max:255',
            'deskripsi'       => 'nullable|string',
            'kualifikasi'     => 'nullable|string',
            'tanggal_posting' => 'nullable|date',
            'status'          => 'nullable|in:aktif,ditutup,draft',
        ];
    }
}
