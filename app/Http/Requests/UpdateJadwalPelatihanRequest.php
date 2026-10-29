<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJadwalPelatihanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_pelatihan'        => 'sometimes|required|exists:daftar_pelatihan,id_pelatihan',
            'tanggal_mulai'       => 'sometimes|required|date',
            'tanggal_selesai'     => 'sometimes|required|date|after_or_equal:tanggal_mulai',
            'jam_mulai'           => 'nullable|date_format:H:i',
            'jam_selesai'         => 'nullable|date_format:H:i',
            'id_instruktur'       => 'nullable|exists:instruktur,id',
            'tempat'              => 'nullable|string|max:255',
            'status'              => 'nullable|in:tersedia,berlangsung,selesai',
            'lokasi_latitude'     => 'nullable|numeric|between:-90,90',
            'lokasi_longitude'    => 'nullable|numeric|between:-180,180',
            'radius_meter'        => 'nullable|integer|min:10|max:10000',
        ];
    }
}
