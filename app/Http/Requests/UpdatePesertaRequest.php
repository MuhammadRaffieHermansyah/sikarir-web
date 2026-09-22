<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePesertaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('peserta');

        return [
            'id_user' => ['sometimes', 'exists:users,id', Rule::unique('pesertas', 'id_user')->ignore($id, 'id_peserta')],
            'id_admin' => 'sometimes|nullable|exists:admin_blks,id_admin',
            'nomor_peserta' => ['sometimes', 'string', 'max:100', Rule::unique('pesertas', 'nomor_peserta')->ignore($id, 'id_peserta')],
            'jenis_kelamin' => 'sometimes|in:Laki-laki,Perempuan',
            'nomor_kk' => 'sometimes|nullable|string|max:30',
            'nomor_wa' => 'sometimes|nullable|string|max:30',
            'tanggal_lahir' => 'sometimes|nullable|date',
            'tempat_lahir' => 'sometimes|nullable|string|max:100',
            'alamat_lengkap' => 'sometimes|nullable|string',
            'pendidikan_terakhir' => 'sometimes|nullable|string|max:100',
            'pendidikan_sekarang' => 'sometimes|nullable|string|max:100',
            'pas_foto' => 'sometimes|nullable|string|max:255',
            'jurusan' => 'sometimes|nullable|string|max:150',
        ];
    }
}
