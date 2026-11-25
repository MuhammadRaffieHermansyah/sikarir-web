<?php

namespace App\Http\Controllers;

use App\Models\DaftarPelatihan;
use Illuminate\Http\Request;

class PublicPelatihanController extends Controller
{
    public function index(Request $request)
    {
        $query = DaftarPelatihan::with([
            'durasi',
            'jadwal' => fn ($q) => $q->where('status', 'tersedia')
                ->where('tanggal_mulai', '>=', today())
                ->orderBy('tanggal_mulai'),
        ]);

        if ($request->filled('q')) {
            $like = $this->likePattern($request->string('q')->toString());
            $query->where(function ($w) use ($like) {
                $w->where('nama_pelatihan', 'like', $like)
                    ->orWhere('deskripsi_pelatihan', 'like', $like);
            });
        }

        $pelatihan = $query->latest('id_pelatihan')->paginate(9)->withQueryString();

        return view('public.pelatihan-katalog', compact('pelatihan'));
    }
}
