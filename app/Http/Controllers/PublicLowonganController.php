<?php

namespace App\Http\Controllers;

use App\Models\DaftarLowongan;
use App\Models\Mitra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PublicLowonganController extends Controller
{
    public function index(Request $request)
    {
        $query = DaftarLowongan::with('mitra:id_mitra,nama_perusahaan,bidang_usaha')->where('status', 'aktif');

        if ($request->filled('q')) {
            $like = $this->likePattern($request->string('q')->toString());
            $query->where(function ($w) use ($like) {
                $w->where('judul_lowongan', 'like', $like)
                    ->orWhere('deskripsi', 'like', $like)
                    ->orWhere('kualifikasi', 'like', $like)
                    ->orWhere('lokasi', 'like', $like)
                    ->orWhereIn('id_mitra', Mitra::select('id_mitra')->where('nama_perusahaan', 'like', $like));
            });
        }

        if ($request->filled('wilayah')) {
            $query->where('lokasi', $request->wilayah);
        }

        $lowongan = $query->latest('id_lowongan')
            ->paginate(3)
            ->withQueryString()
            ->fragment('daftar-lowongan');

        // Cache hanya menyimpan array primitif agar tidak bergantung pada serialisasi Collection.
        $daftarLokasi = Cache::remember('public.lowongan.lokasi.v3', 120, fn () => DaftarLowongan::where('status', 'aktif')
            ->whereNotNull('lokasi')
            ->where('lokasi', '!=', '')
            ->orderBy('lokasi')
            ->pluck('lokasi')
            ->map(fn ($lokasi) => trim((string) $lokasi))
            ->filter()
            ->unique()
            ->values()
            ->all());

        $totalMitra = Cache::remember('public.lowongan.total-mitra', 120, fn () => DaftarLowongan::where('status', 'aktif')->distinct()->count('id_mitra'));

        return view('public.lowongan-katalog', compact('lowongan', 'daftarLokasi', 'totalMitra'));
    }

    public function show(int $id)
    {
        // Hanya lowongan aktif yang boleh dibuka publik, selain itu 404
        $lowongan = DaftarLowongan::with('mitra.user')
            ->where('status', 'aktif')
            ->findOrFail($id);

        $lainnya = DaftarLowongan::with('mitra:id_mitra,nama_perusahaan,bidang_usaha')
            ->where('status', 'aktif')
            ->where('id_lowongan', '!=', $id)
            ->latest('id_lowongan')
            ->take(3)
            ->get();

        return view('public.lowongan-detail', compact('lowongan', 'lainnya'));
    }
}
