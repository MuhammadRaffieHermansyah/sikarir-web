<?php

namespace App\Http\Controllers;

use App\Models\DaftarPelatihan;
use App\Models\JadwalPelatihan;
use Illuminate\Http\Request;

class PublicPelatihanController extends Controller
{
    public function index(Request $request)
    {
        $tanggalHariIni = today();
        $pelatihan = $this->queryKatalog($request, $tanggalHariIni)
            ->latest('id_pelatihan')
            ->take(6)
            ->get();
        $kalenderPelatihan = JadwalPelatihan::query()
            ->with(['pelatihan:id_pelatihan,nama_pelatihan', 'ruanganWorkshop:id,nama_ruangan'])
            ->whereDate('tanggal_selesai', '>=', $tanggalHariIni)
            ->latest('id_jadwal')
            ->take(3)
            ->get();

        return view('public.pelatihan-katalog', compact('pelatihan', 'kalenderPelatihan'));
    }

    public function hasil(Request $request)
    {
        $pelatihan = $this->queryKatalog($request, today())
            ->latest('id_pelatihan')
            ->take(6)
            ->get();

        return response()->json([
            'count' => $pelatihan->count(),
            'html' => view('public.partials.pelatihan-grid', compact('pelatihan'))->render(),
        ]);
    }

    private function queryKatalog(Request $request, $tanggalHariIni)
    {
        $jadwalTerbuka = fn ($q) => $q->where('status', 'tersedia')
            ->whereDate('tanggal_mulai', '>=', $tanggalHariIni);

        $query = DaftarPelatihan::with([
            'durasi',
            'jadwal' => fn ($q) => $jadwalTerbuka($q)->orderBy('tanggal_mulai'),
        ]);

        if ($request->filled('q')) {
            $like = $this->likePattern($request->string('q')->toString());
            $query->where(fn ($w) => $w->where('nama_pelatihan', 'like', $like)
                ->orWhere('deskripsi_pelatihan', 'like', $like));
        }

        if ($request->input('status') === 'buka') {
            $query->whereHas('jadwal', $jadwalTerbuka);
        } elseif ($request->input('status') === 'tutup') {
            $query->whereDoesntHave('jadwal', $jadwalTerbuka);
        }

        return $query;
    }
}
