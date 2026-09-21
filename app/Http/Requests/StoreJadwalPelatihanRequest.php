<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJadwalPelatihanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return ['id_pelatihan' => 'required|exists:daftar_pelatihan,id_pelatihan', 'tanggal_mulai' => 'required|date', 'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai', 'jam_mulai' => 'nullable|date_format:H:i', 'jam_selesai' => 'nullable|date_format:H:i', 'instruktur' => 'nullable|string|max:255', 'tempat' => 'nullable|string|max:255', 'status' => 'nullable|string|max:30'];
    }
}
