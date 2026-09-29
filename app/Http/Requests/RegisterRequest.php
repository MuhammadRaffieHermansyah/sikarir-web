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
        return ['name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/', 'email' => 'required|email|max:255|unique:users,email', 'password' => 'required|string|min:8|confirmed', 'role' => 'required|in:peserta,mitra'];
    }

    public function messages(): array
    {
        return [
            'name.regex' => 'Nama hanya boleh mengandung huruf dan spasi.',
        ];
    }
}
