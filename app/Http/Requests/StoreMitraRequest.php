<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMitraRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return ['id_user' => 'nullable|exists:users,id', 'nama_perusahaan' => 'required|string|max:255', 'jenis_mitra' => 'nullable|string|max:100', 'logo_perusahaan' => 'nullable|string|max:255', 'provinsi' => 'nullable|string|max:100', 'kota' => 'nullable|string|max:100', 'alamat' => 'nullable|string', 'no_telp' => 'nullable|string|max:30', 'no_izin' => 'nullable|string|max:100', 'jabatan_pic' => 'nullable|string|max:100', 'bidang_usaha' => 'nullable|string|max:150'];
    }
}
