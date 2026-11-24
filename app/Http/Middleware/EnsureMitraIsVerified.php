<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureMitraIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user?->role === 'mitra' && ! $user->mitra()->value('is_verified')) {
            return $request->expectsJson() || $request->is('api/*')
                ? response()->json(['message' => 'Akun mitra Anda masih menunggu verifikasi admin.'], 403)
                : redirect()->route('dashboard')->with('error', 'Akun mitra Anda masih menunggu verifikasi admin.');
        }

        return $next($request);
    }
}
