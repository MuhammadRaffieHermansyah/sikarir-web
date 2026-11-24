<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterMitraRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    public function createMitra(): View
    {
        return view('auth.register-mitra');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'peserta',
        ]);

        $user->ensureRoleProfile($validated['name']);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }

    public function storeMitra(RegisterMitraRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $legalitasPath = $request->file('surat_legalitas')->store('mitra-documents/legalitas');
        $permohonanPath = $request->file('surat_permohonan_kerjasama')->store('mitra-documents/permohonan');

        try {
            $user = DB::transaction(function () use ($data, $legalitasPath, $permohonanPath): User {
                $user = User::create([
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                    'role' => 'mitra',
                ]);

                $user->mitra()->create([
                    'nama' => $data['name'],
                    'nama_perusahaan' => $data['nama_perusahaan'],
                    'surat_legalitas_path' => $legalitasPath,
                    'surat_permohonan_kerjasama_path' => $permohonanPath,
                ]);

                return $user;
            });
        } catch (\Throwable $exception) {
            Storage::delete([$legalitasPath, $permohonanPath]);

            throw $exception;
        }

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Pendaftaran mitra berhasil dikirim. Akun Anda menunggu verifikasi admin.');
    }
}
