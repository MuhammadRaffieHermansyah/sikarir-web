<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $user = User::create($data);
        return response()->json(['message' => 'Registrasi berhasil', 'data' => $user, 'token' => $user->createToken('sikarir')->plainTextToken], 201);
    }
    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        $user = User::where('email', $data['email'])->first();
        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages(['email' => ['Email atau password salah.']]);
        }
        return response()->json(['message' => 'Login berhasil', 'data' => $user, 'token' => $user->createToken('sikarir')->plainTextToken]);
    }
    public function me(Request $request)
    {
        return response()->json(['data' => $request->user()->load(['peserta', 'mitra', 'adminBlk'])]);
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()?->delete();
        return response()->json(['message' => 'Logout berhasil']);
    }
}
