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

        $statistics = [
            'aktif' => (clone $lowonganQuery)->where('status', 'aktif')->count(),
            'draft' => (clone $lowonganQuery)->where('status', 'draft')->count(),
            'ditutup' => (clone $lowonganQuery)->where('status', 'ditutup')->count(),
            'pelamar' => LamaranLowongan::query()
                ->whereHas('lowongan', fn ($query) => $query->where('id_mitra', $mitra->id_mitra))
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
