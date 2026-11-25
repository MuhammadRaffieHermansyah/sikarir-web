<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\PersonalAccessToken;

class ProfilePasswordController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $data = $request->validate([
            'password_lama' => ['required', 'string'],
            'password_baru' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'password_baru.min' => 'Password baru minimal 8 karakter.',
            'password_baru.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        $user = $request->user();

        if (! Hash::check($data['password_lama'], $user->password)) {
            throw ValidationException::withMessages(['password_lama' => ['Password lama salah.']]);
        }

        $user->update([
            'password' => $data['password_baru'],
            'must_change_password' => false,
        ]);

        $tokenSaatIni = $user->currentAccessToken();
        $user->tokens()
            ->when($tokenSaatIni instanceof PersonalAccessToken, fn ($q) => $q->where('id', '!=', $tokenSaatIni->id))
            ->delete();

        return response()->json(['message' => 'Password berhasil diubah.']);
    }
}
