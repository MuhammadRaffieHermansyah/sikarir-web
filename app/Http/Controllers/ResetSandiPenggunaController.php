<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

/**
 * Admin BLK mengatur ulang sandi peserta, instruktur, atau mitra yang lupa sandi.
 * Sandi sementara ditampilkan sekali ke admin untuk diserahkan langsung ke pemilik akun.
 */
class ResetSandiPenggunaController extends Controller
{
    public function __invoke(User $user): RedirectResponse
    {
        abort_if($user->role === 'admin_blk', 403, 'Sandi akun admin tidak dapat direset lewat fitur ini.');

        $sandiSementara = Str::password(10, symbols: false);

        $user->update([
            'password' => $sandiSementara,
            'must_change_password' => true,
        ]);

        // Keluarkan semua sesi aplikasi lama agar hanya sandi baru yang berlaku.
        $user->tokens()->delete();

        return back()
            ->with('sandi_sementara', ['email' => $user->email, 'sandi' => $sandiSementara])
            ->with('success', 'Sandi berhasil direset. Serahkan sandi sementara kepada pemilik akun.');
    }
}
