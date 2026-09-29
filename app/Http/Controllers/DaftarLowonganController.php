<?php

namespace App\Http\Controllers;

use App\Models\DaftarLowongan;
use App\Models\Mitra;
use App\Models\AdminBlk;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DaftarLowonganController extends Controller
{
    public function index(Request $request): View
    {
        // 1. Inisialisasi Query Utama
        $query = DaftarLowongan::with(['mitra', 'admin.user']);

        // 2. Filter Berdasarkan Role User (Jika Mitra, Hanya Lihat Lowongan Miliknya)
        if (Auth::user()->role === "mitra") {
            $mitra = Mitra::where('id_user', Auth::user()->id)->first();
            $idMitra = $mitra ? $mitra->id_mitra : null;

            $query->where('id_mitra', $idMitra);
        }

        // 3. Filter Pencarian Keyword (Judul Lowongan, Lokasi, Nama Perusahaan Mitra)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul_lowongan', 'like', "%{$search}%")
                  ->orWhere('lokasi', 'like', "%{$search}%")
                  ->orWhereHas('mitra', function ($sub) use ($search) {
                      $sub->where('nama_perusahaan', 'like', "%{$search}%");
                  });
            });
        }

        // 4. Filter Status Lowongan (aktif, nonaktif)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 5. Hitung Statistik Metric Card (Di-filter Sesuai Hak Akses Role Juga)
        $baseMetricsQuery = DaftarLowongan::query();
        if (Auth::user()->role === "mitra") {
            $mitra = Mitra::where('id_user', Auth::user()->id)->first();
            $baseMetricsQuery->where('id_mitra', $mitra ? $mitra->id_mitra : null);
        }

        $countAktif    = (clone $baseMetricsQuery)->where('status', 'aktif')->count();
        $countNonaktif = (clone $baseMetricsQuery)->where('status', 'nonaktif')->count();

        // 6. Paginate Data & Tahan Query String URL
        $lowongans = $query->latest('id_lowongan')
                           ->paginate(10)
                           ->withQueryString();

        return view('lowongan.index', compact(
            'lowongans',
            'countAktif',
            'countNonaktif'
        ));
    }

    public function create(): View
    {
        $mitras  = Mitra::orderBy('nama_perusahaan')->get();
        $admins  = AdminBlk::with('user')->get();
        
        $id_mitra = null;
        $nama_perusahaan = null;

        if (Auth::user()->role === "mitra") {
            $mitra = Mitra::where('id_user', Auth::user()->id)->first();
            if ($mitra) {
                $id_mitra = $mitra->id_mitra;
                $nama_perusahaan = $mitra->nama_perusahaan;
            }
        }

        return view('lowongan.create', compact('mitras', 'admins', 'id_mitra', 'nama_perusahaan'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_mitra'        => 'required|exists:mitras,id_mitra',
            'id_admin'        => 'required|exists:admin_blks,id_admin',
            'judul_lowongan'  => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/|unique:daftar_lowongan,judul_lowongan',
            'lokasi'          => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'deskripsi'       => 'required|string',
            'kualifikasi'     => 'required|string',
            'tanggal_posting' => 'nullable|date',
            'status'          => 'required|in:aktif,nonaktif',
        ], [
            'id_mitra.required'       => 'Mitra DU/DI wajib dipilih.',
            'id_admin.required'       => 'Admin BLK penanggung jawab wajib dipilih.',
            'judul_lowongan.required' => 'Judul posisi lowongan wajib diisi.',
            'judul_lowongan.unique'   => 'Judul lowongan sudah ada.',
            'lokasi.required'         => 'Lokasi wajib diisi.',
            'deskripsi.required'      => 'Deskripsi wajib diisi.',
            'kualifikasi.required'    => 'Kualifikasi wajib diisi.',
            'judul_lowongan.regex'    => 'Judul lowongan hanya boleh mengandung huruf dan spasi.',
            'lokasi.regex'            => 'Lokasi hanya boleh mengandung huruf dan spasi.',
            'status.in'               => 'Status lowongan harus aktif atau nonaktif.',
        ]);

        DaftarLowongan::create($validated);
        return redirect()->route('lowongan.index')->with('success', 'Lowongan magang industri berhasil dipublikasikan.');
    }

    public function show(int $id): View
    {
        $lowongan = DaftarLowongan::with(['mitra', 'admin.user'])->findOrFail($id);
        return view('lowongan.show', compact('lowongan'));
    }

    public function edit(int $id): View
    {
        $lowongan = DaftarLowongan::findOrFail($id);
        $mitras   = Mitra::orderBy('nama_perusahaan')->get();
        $admins   = AdminBlk::with('user')->get();
        return view('lowongan.edit', compact('lowongan', 'mitras', 'admins'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $lowongan = DaftarLowongan::findOrFail($id);

        $validated = $request->validate([
            'id_mitra'        => 'required|exists:mitras,id_mitra',
            'id_admin'        => 'required|exists:admin_blks,id_admin',
            'judul_lowongan'  => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'lokasi'          => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'deskripsi'       => 'required|string',
            'kualifikasi'     => 'required|string',
            'tanggal_posting' => 'nullable|date',
            'status'          => 'required|in:aktif,nonaktif',
        ], [
            'id_mitra.required'       => 'Mitra DU/DI wajib dipilih.',
            'id_admin.required'       => 'Admin BLK penanggung jawab wajib dipilih.',
            'judul_lowongan.required' => 'Judul posisi lowongan wajib diisi.',
            'lokasi.required'         => 'Lokasi wajib diisi.',
            'deskripsi.required'      => 'Deskripsi wajib diisi.',
            'kualifikasi.required'    => 'Kualifikasi wajib diisi.',
            'judul_lowongan.regex'    => 'Judul lowongan hanya boleh mengandung huruf dan spasi.',
            'lokasi.regex'            => 'Lokasi hanya boleh mengandung huruf dan spasi.',
            'status.in'               => 'Status lowongan harus aktif atau nonaktif.',
        ]);

        $lowongan->update($validated);
        return redirect()->route('lowongan.index')->with('success', 'Lowongan magang industri berhasil diperbarui.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $lowongan = DaftarLowongan::findOrFail($id);
        $lowongan->delete();
        return redirect()->route('lowongan.index')->with('success', 'Lowongan magang industri berhasil dihapus.');
    }
}