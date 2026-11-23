<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|regex:/^[a-zA-Z\s\.,\'\-]+$/',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'password_confirmation' => 'nullable|string|same:password',
            'role' => 'nullable|in:peserta,mitra',
            'nama_perusahaan' => 'required_if:role,mitra|string|max:255|unique:mitras,nama_perusahaan',
            'surat_legalitas' => 'required_if:role,mitra|file|mimes:pdf,doc,docx|max:2048',
            'surat_permohonan_kerjasama' => 'required_if:role,mitra|file|mimes:pdf,doc,docx|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'name.regex' => 'Nama hanya boleh mengandung huruf dan spasi.',
            'surat_legalitas.required_if' => 'Surat legalitas wajib diunggah untuk pendaftaran mitra.',
            'surat_permohonan_kerjasama.required_if' => 'Surat permohonan kerja sama wajib diunggah untuk pendaftaran mitra.',
        ];
    }
}
