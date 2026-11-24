<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterMitraRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'nama_perusahaan' => ['required', 'string', 'max:255', 'unique:mitras,nama_perusahaan'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'surat_legalitas' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:2048'],
            'surat_permohonan_kerjasama' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'surat_legalitas.mimes' => 'Surat legalitas harus berformat PDF, DOC, atau DOCX.',
            'surat_permohonan_kerjasama.mimes' => 'Surat permohonan kerja sama harus berformat PDF, DOC, atau DOCX.',
            'surat_legalitas.max' => 'Ukuran surat legalitas maksimal 2 MB.',
            'surat_permohonan_kerjasama.max' => 'Ukuran surat permohonan kerja sama maksimal 2 MB.',
        ];
    }
}
