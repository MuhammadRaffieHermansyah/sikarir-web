<?php

namespace App\Http\Controllers;

use App\Models\DaftarLowongan;
use App\Models\Mitra;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DaftarLowonganController extends Controller
{
    public function index(Request $request): View
    {
        // 1. Inisialisasi Query Utama
        $query = DaftarLowongan::with('mitra');

        // 2. Filter Berdasarkan Role User (Jika Mitra, Hanya Lihat Lowongan Miliknya)
        if (Auth::user()->role === 'mitra') {
            $mitra = Auth::user()->mitra;
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

        // 4. Filter Status Lowongan (aktif, draft, ditutup)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 5. Hitung Statistik Metric Card (Di-filter Sesuai Hak Akses Role)
        $baseMetricsQuery = DaftarLowongan::query();
        if (Auth::user()->role === 'mitra') {
            $mitra = Auth::user()->mitra;
            $baseMetricsQuery->where('id_mitra', $mitra ? $mitra->id_mitra : null);
        }

        $countAktif   = (clone $baseMetricsQuery)->where('status', 'aktif')->count();
        $countDraft   = (clone $baseMetricsQuery)->where('status', 'draft')->count();
        $countDitutup = (clone $baseMetricsQuery)->where('status', 'ditutup')->count();

        // 6. Paginate Data & Tahan Query String URL
        $lowongans = $query->latest('id_lowongan')
            ->paginate(10)
            ->withQueryString();

        return view('lowongan.index', compact(
            'lowongans',
            'countAktif',
            'countDraft',
            'countDitutup'
        ));
    }

    public function create()
    {
        if (Auth::user()->role !== 'mitra') {
            return redirect()->back()->with('error', 'Hanya mitra yang dapat membuka lowongan baru.');
        }

        $mitra = Auth::user()->mitra;
        if (!$mitra) {
            return redirect()->route('dashboard')->with('error', 'Profil mitra Anda belum terdaftar.');
        }

        return view('lowongan.create', compact('mitra'));
    }

    public function store(Request $request): RedirectResponse
    {
        if (Auth::user()->role !== 'mitra') {
            return redirect()->back()->with('error', 'Hanya mitra yang dapat membuka lowongan baru.');
        }

        $mitra = Auth::user()->mitra;
        if (!$mitra) {
            return redirect()->back()->with('error', 'Profil mitra tidak ditemukan.');
        }

        $validated = $request->validate([
            'judul_lowongan'  => 'required|string|max:255',
            'lokasi'          => 'required|string|max:255',
            'deskripsi'       => 'required|string',
            'kualifikasi'     => 'required|string',
            'tanggal_posting' => 'nullable|date',
            'status'          => 'required|in:aktif,draft,ditutup',
        ], [
            'judul_lowongan.required' => 'Judul posisi lowongan wajib diisi.',
            'lokasi.required'         => 'Lokasi penempatan wajib diisi.',
            'deskripsi.required'      => 'Deskripsi pekerjaan wajib diisi.',
            'kualifikasi.required'    => 'Kualifikasi & persyaratan wajib diisi.',
            'status.in'               => 'Status lowongan harus aktif, draft, atau ditutup.',
        ]);

        $validated['id_mitra'] = $mitra->id_mitra;
        if (empty($validated['tanggal_posting'])) {
            $validated['tanggal_posting'] = now()->format('Y-m-d');
        }

        DaftarLowongan::create($validated);
        return redirect()->route('lowongan.index')->with('success', 'Lowongan magang industri berhasil dipublikasikan.');
    }

    public function show(int $id): View
    {
        $lowongan = DaftarLowongan::with('mitra')->findOrFail($id);
        return view('lowongan.show', compact('lowongan'));
    }

    public function edit(int $id)
    {
        $lowongan = DaftarLowongan::with('mitra')->findOrFail($id);

        if (Auth::user()->role === 'mitra' && $lowongan->id_mitra !== Auth::user()->mitra?->id_mitra) {
            return redirect()->route('lowongan.index')->with('error', 'Anda tidak memiliki izin untuk mengedit lowongan ini.');
        }

        $mitra = $lowongan->mitra;
        return view('lowongan.edit', compact('lowongan', 'mitra'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $lowongan = DaftarLowongan::findOrFail($id);

        if (Auth::user()->role === 'mitra' && $lowongan->id_mitra !== Auth::user()->mitra?->id_mitra) {
            return redirect()->route('lowongan.index')->with('error', 'Anda tidak memiliki izin untuk mengedit lowongan ini.');
        }

        $validated = $request->validate([
            'judul_lowongan'  => 'required|string|max:255',
            'lokasi'          => 'required|string|max:255',
            'deskripsi'       => 'required|string',
            'kualifikasi'     => 'required|string',
            'tanggal_posting' => 'nullable|date',
            'status'          => 'required|in:aktif,draft,ditutup',
        ], [
            'judul_lowongan.required' => 'Judul posisi lowongan wajib diisi.',
            'lokasi.required'         => 'Lokasi penempatan wajib diisi.',
            'deskripsi.required'      => 'Deskripsi pekerjaan wajib diisi.',
            'kualifikasi.required'    => 'Kualifikasi & persyaratan wajib diisi.',
            'status.in'               => 'Status lowongan harus aktif, draft, atau ditutup.',
        ]);

        $lowongan->update($validated);
        return redirect()->route('lowongan.index')->with('success', 'Lowongan magang industri berhasil diperbarui.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $lowongan = DaftarLowongan::findOrFail($id);

        if (Auth::user()->role === 'mitra' && $lowongan->id_mitra !== Auth::user()->mitra?->id_mitra) {
            return redirect()->route('lowongan.index')->with('error', 'Anda tidak memiliki izin untuk menghapus lowongan ini.');
        }

        $lowongan->delete();
        return redirect()->route('lowongan.index')->with('success', 'Lowongan magang industri berhasil dihapus.');
    }
}
