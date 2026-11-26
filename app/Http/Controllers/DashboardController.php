<?php

namespace App\Http\Controllers;

use App\Models\DaftarLowongan;
use App\Models\DaftarPelatihan;
use App\Models\Instruktur;
use App\Models\JadwalPelatihan;
use App\Models\LamaranLowongan;
use App\Models\Mitra;
use App\Models\Peserta;
use App\Models\Sertifikat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        /** @var User $user */
        $user = $request->user();

        if ($user->role !== 'mitra') {
            $stats = [];

            if ($user->role === 'admin_blk') {
                $stats = Cache::remember('dashboard-stat-cards', 300, function (): array {
                    return [
                        'peserta' => Peserta::count(),
                        'instruktur' => Instruktur::count(),
                        'mitra' => Mitra::count(),
                        'pelatihan' => DaftarPelatihan::count(),
                        'sertifikat' => Sertifikat::count(),
                    ];
                });

                // Angka yang perlu ditindaklanjuti admin tidak di-cache agar langsung berubah setelah aksi.
                $stats += [
                    'mitra_menunggu' => Mitra::where('is_verified', false)->count(),
                    'pelatihan_berjalan' => JadwalPelatihan::where('status', 'berlangsung')->count(),
                    'lamaran_masuk' => LamaranLowongan::count(),
                    'lamaran_minggu_ini' => LamaranLowongan::where('created_at', '>=', now()->subDays(7))->count(),
                ];
            }

            return view('dashboard', compact('stats'));
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
