<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Web hanya untuk admin BLK dan mitra. Peserta dan instruktur memakai aplikasi mobile,
 * jadi sesi web mereka diakhiri dan diarahkan kembali ke halaman masuk.
 */
class PastikanAksesWeb
{
    public const PESAN_KHUSUS_APLIKASI = 'Akun peserta dan instruktur hanya bisa dipakai di aplikasi mobile siKarir. Website ini khusus admin BLK dan mitra.';

    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && ! $user->canAccessWeb()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Akses ditolak.'], 403);
            }

            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->withErrors(['email' => self::PESAN_KHUSUS_APLIKASI]);
        }

        return $next($request);
    }
}
