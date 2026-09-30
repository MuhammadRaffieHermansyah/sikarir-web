<?php

namespace App\Http\Requests;

use App\Models\DaftarLowongan;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDaftarLowonganRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $lowonganId = $this->route('id') ?? $this->route('lowongan');
        $idMitra = $this->input('id_mitra');

        if (!$idMitra && $lowonganId) {
            $lowongan = is_numeric($lowonganId) ? DaftarLowongan::find($lowonganId) : null;
            $idMitra = $lowongan?->id_mitra ?? auth()->user()?->mitra?->id_mitra;
        }

        return [
            'id_mitra'        => 'sometimes|nullable|exists:mitras,id_mitra',
            'judul_lowongan'  => [
                'sometimes',
                'required',
                'string',
                'max:255',
                $idMitra
                    ? Rule::unique('daftar_lowongan', 'judul_lowongan')->where('id_mitra', $idMitra)->ignore($lowonganId, 'id_lowongan')
                    : 'nullable',
            ],
            'lokasi'          => 'sometimes|nullable|string|max:255',
            'deskripsi'       => 'sometimes|nullable|string',
            'kualifikasi'     => 'sometimes|nullable|string',
            'tanggal_posting' => 'sometimes|nullable|date',
            'status'          => 'sometimes|nullable|in:aktif,ditutup,draft',
        ];
    }
}