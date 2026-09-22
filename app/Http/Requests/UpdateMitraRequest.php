<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMitraRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('mitra');

        return [
            'id_user' => ['sometimes', 'nullable', 'exists:users,id', Rule::unique('mitras', 'id_user')->ignore($id, 'id_mitra')],
            'nama_perusahaan' => 'sometimes|string|max:255',
            'jenis_mitra' => 'sometimes|nullable|string|max:100',
            'logo_perusahaan' => 'sometimes|nullable|string|max:255',
            'provinsi' => 'sometimes|nullable|string|max:100',
            'kota' => 'sometimes|nullable|string|max:100',
            'alamat' => 'sometimes|nullable|string',
            'no_telp' => 'sometimes|nullable|string|max:30',
            'no_izin' => 'sometimes|nullable|string|max:100',
            'jabatan_pic' => 'sometimes|nullable|string|max:100',
            'bidang_usaha' => 'sometimes|nullable|string|max:150',
        ];
    }
}
