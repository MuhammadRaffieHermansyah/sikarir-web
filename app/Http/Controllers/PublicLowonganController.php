<?php

namespace App\Http\Controllers;

use App\Models\DaftarLowongan;
use App\Models\Mitra;
use Illuminate\Http\Request;

class PublicLowonganController extends Controller
{
    public function index(Request $request)
    {
        $query = DaftarLowongan::with('mitra')->where('status', 'aktif');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($w) use ($q) {
                $w->where('judul_lowongan', 'like', "%{$q}%")
                    ->orWhere('deskripsi', 'like', "%{$q}%")
                    ->orWhere('kualifikasi', 'like', "%{$q}%")
                    ->orWhere('lokasi', 'like', "%{$q}%")
                    ->orWhereHas('mitra', fn ($m) => $m->where('nama_perusahaan', 'like', "%{$q}%"));
            });
        }

        if ($request->filled('wilayah')) {
            $query->where('lokasi', $request->wilayah);
        }

        $lowongan = $query->latest('id_lowongan')->paginate(7)->withQueryString();

        // Isi dropdown wilayah dari data lowongan aktif
        $daftarLokasi = DaftarLowongan::where('status', 'aktif')
            ->whereNotNull('lokasi')
            ->where('lokasi', '!=', '')
            ->distinct()
            ->orderBy('lokasi')
            ->pluck('lokasi');

        $totalMitra = Mitra::whereHas('lowongan', fn ($q) => $q->where('status', 'aktif'))->count();

        return view('public.lowongan-katalog', compact('lowongan', 'daftarLokasi', 'totalMitra'));
    }

    public function show(int $id)
    {
        // Hanya lowongan aktif yang boleh dibuka publik, selain itu 404
        $lowongan = DaftarLowongan::with('mitra.user')
            ->where('status', 'aktif')
            ->findOrFail($id);

        $lainnya = DaftarLowongan::with('mitra')
            ->where('status', 'aktif')
            ->where('id_lowongan', '!=', $id)
            ->latest('id_lowongan')
            ->take(3)
            ->get();

        return view('public.lowongan-detail', compact('lowongan', 'lainnya'));
    }
}
