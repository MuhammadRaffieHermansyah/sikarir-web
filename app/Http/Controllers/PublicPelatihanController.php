<?php

namespace App\Http\Controllers;

use App\Models\DaftarPelatihan;
use Illuminate\Http\Request;

class PublicPelatihanController extends Controller
{
    public function index(Request $request)
    {
        $query = DaftarPelatihan::with(['durasi', 'jadwal']);

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($w) use ($q) {
                $w->where('nama_pelatihan', 'like', "%{$q}%")
                    ->orWhere('deskripsi_pelatihan', 'like', "%{$q}%");
            });
        }

        $pelatihan = $query->latest('id_pelatihan')->paginate(9)->withQueryString();

        return view('public.pelatihan-katalog', compact('pelatihan'));
    }
}
