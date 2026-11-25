<?php

namespace App\Http\Controllers;

use App\Models\DaftarLowongan;
use App\Models\LamaranLowongan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        /** @var User $user */
        $user = $request->user();

        if ($user->role !== 'mitra') {
            return view('dashboard');
        }

        $mitra = $user->load('mitra')->mitra;

        if (! $mitra || ! $mitra->is_verified) {
            return view('dashboard.mitra', [
                'mitra' => $mitra,
                'isVerified' => false,
                'statistics' => null,
                'lowongans' => collect(),
            ]);
        }

        $lowonganQuery = DaftarLowongan::query()->where('id_mitra', $mitra->id_mitra);

        $statusCounts = (clone $lowonganQuery)
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $statistics = [
            'aktif' => (int) ($statusCounts['aktif'] ?? 0),
            'draft' => (int) ($statusCounts['draft'] ?? 0),
            'ditutup' => (int) ($statusCounts['ditutup'] ?? 0),
            'pelamar' => LamaranLowongan::query()
                ->whereIn('id_lowongan', DaftarLowongan::select('id_lowongan')->where('id_mitra', $mitra->id_mitra))
                ->count(),
        ];

        $lowongans = $lowonganQuery
            ->withCount('lamaran')
            ->latest('id_lowongan')
            ->take(5)
            ->get();

        return view('dashboard.mitra', compact('mitra', 'statistics', 'lowongans') + ['isVerified' => true]);
    }
}
