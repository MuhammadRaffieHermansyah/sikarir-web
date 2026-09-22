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
        return ['id_jadwal' => 'required|exists:jadwal_pelatihan,id_jadwal', 'id_peserta' => 'required|exists:pesertas,id_peserta', 'tanggal' => 'required|date', 'jam_hadir' => 'nullable|date_format:H:i', 'status_kehadiran' => 'required|in:hadir,izin,sakit,alpha', 'keterangan' => 'nullable|string|max:255'];
    }
}
