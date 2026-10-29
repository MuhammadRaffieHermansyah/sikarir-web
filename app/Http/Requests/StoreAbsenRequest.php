<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAbsenRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_jadwal'        => 'nullable',
            'id_peserta'       => 'nullable',
            'tanggal'          => 'required|date',
            'jam_hadir'        => 'nullable|string',
            'status_kehadiran' => 'required|in:hadir,izin,sakit,alpha,alpa',
            'keterangan'       => 'nullable|string|max:255',
            // Kolom lokasi GPS (opsional / tervalidasi jika hadir)
            'latitude'         => 'nullable|numeric|between:-90,90',
            'longitude'        => 'nullable|numeric|between:-180,180',
        ];
    }
}
