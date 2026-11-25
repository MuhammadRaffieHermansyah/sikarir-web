<?php

namespace App\Http\Controllers;

use App\Models\DaftarLowongan;
use App\Models\Mitra;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class DaftarLowonganController extends Controller
{
    public function index(Request $request): View
    {
        // 1. Inisialisasi Query Utama
        $query = DaftarLowongan::with('mitra:id_mitra,nama_perusahaan,logo_perusahaan');

        // 2. Filter Berdasarkan Role User (Jika Mitra, Hanya Lihat Lowongan Miliknya)
        if (Auth::user()->role === 'mitra') {
            $mitra = Auth::user()->mitra;
            $idMitra = $mitra ? $mitra->id_mitra : null;
            $query->where('id_mitra', $idMitra);
        }

        // 3. Filter Pencarian Keyword
        if ($request->filled('search')) {
            $like = $this->likePattern($request->string('search')->toString());
            $query->where(function ($q) use ($like) {
                $q->where('judul_lowongan', 'like', $like)
                    ->orWhere('lokasi', 'like', $like)
                    ->orWhereIn('id_mitra', Mitra::select('id_mitra')->where('nama_perusahaan', 'like', $like));
            });
        }

        // 4. Filter Status Lowongan
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 5. Hitung Statistik
        $baseMetricsQuery = DaftarLowongan::query();
        if (Auth::user()->role === 'mitra') {
            $mitra = Auth::user()->mitra;
            $baseMetricsQuery->where('id_mitra', $mitra ? $mitra->id_mitra : null);
        }

        $statusCounts = $baseMetricsQuery->selectRaw('status, COUNT(*) as total')->groupBy('status')->pluck('total', 'status');
        $countAktif = (int) ($statusCounts['aktif'] ?? 0);
        $countDraft = (int) ($statusCounts['draft'] ?? 0);
        $countDitutup = (int) ($statusCounts['ditutup'] ?? 0);

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
        if (! $mitra) {
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
        if (! $mitra) {
            return redirect()->back()->with('error', 'Profil mitra tidak ditemukan.');
        }

        $validated = $request->validate([
            'judul_lowongan' => [
                'required', 'string', 'max:100',
                'regex:/^[\pL\pN\s().,&\x27\/+\-]+$/u',
                Rule::unique('daftar_lowongan', 'judul_lowongan')->where(function ($query) use ($mitra) {
                    return $query->where('id_mitra', $mitra->id_mitra);
                }),
            ],
            'lokasi' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kualifikasi' => 'required|string',
            'tanggal_posting' => 'nullable|date',
            'status' => 'required|in:aktif,draft,ditutup',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'judul_lowongan.required' => 'Judul posisi lowongan wajib diisi.',
            'judul_lowongan.unique' => 'Perusahaan Anda sudah memiliki lowongan dengan judul tersebut.',
            'judul_lowongan.max' => 'Judul posisi lowongan maksimal 100 karakter.',
            'lokasi.required' => 'Lokasi penempatan wajib diisi.',
            'deskripsi.required' => 'Deskripsi pekerjaan wajib diisi.',
            'kualifikasi.required' => 'Kualifikasi & persyaratan wajib diisi.',
            'status.in' => 'Status lowongan harus aktif, draft, atau ditutup.',
            'judul_lowongan.regex' => 'Judul lowongan hanya boleh berisi huruf, angka, spasi, dan tanda baca umum.',
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus JPG, PNG, atau WEBP.',
            'gambar.max' => 'Ukuran gambar maksimal 2 MB.',
        ]);

        $validated['id_mitra'] = $mitra->id_mitra;
        if (empty($validated['tanggal_posting'])) {
            $validated['tanggal_posting'] = now()->format('Y-m-d');
        }
        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $this->storeImage($request->file('gambar'), 'lowongan', 1280, 1280, 640);
        }
        DaftarLowongan::create($validated);

        return redirect()->route('lowongan.index')->with('success', 'Lowongan magang industri berhasil dipublikasikan.');
    }

    public function show(int $id): View
    {
        $lowongan = DaftarLowongan::with('mitra.user')->findOrFail($id);

        if (Auth::user()->role === 'mitra' && $lowongan->id_mitra !== Auth::user()->mitra?->id_mitra) {
            abort(403, 'Anda tidak memiliki izin untuk melihat lowongan ini.');
        }

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
            'judul_lowongan' => [
                'required', 'string', 'max:100',
                'regex:/^[\pL\pN\s().,&\x27\/+\-]+$/u',
                Rule::unique('daftar_lowongan', 'judul_lowongan')
                    ->where(function ($query) use ($lowongan) {
                        return $query->where('id_mitra', $lowongan->id_mitra);
                    })
                    ->ignore($lowongan->id_lowongan, 'id_lowongan'),
            ],
            'lokasi' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kualifikasi' => 'required|string',
            'tanggal_posting' => 'nullable|date',
            'status' => 'required|in:aktif,draft,ditutup',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'judul_lowongan.required' => 'Judul posisi lowongan wajib diisi.',
            'judul_lowongan.unique' => 'Perusahaan Anda sudah memiliki lowongan lain dengan judul tersebut.',
            'judul_lowongan.max' => 'Judul posisi lowongan maksimal 100 karakter.',
            'lokasi.required' => 'Lokasi penempatan wajib diisi.',
            'deskripsi.required' => 'Deskripsi pekerjaan wajib diisi.',
            'kualifikasi.required' => 'Kualifikasi & persyaratan wajib diisi.',
            'status.in' => 'Status lowongan harus aktif, draft, atau ditutup.',
            'judul_lowongan.regex' => 'Judul lowongan hanya boleh berisi huruf, angka, spasi, dan tanda baca umum.',
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus JPG, PNG, atau WEBP.',
            'gambar.max' => 'Ukuran gambar maksimal 2 MB.',
        ]);

        if ($request->hasFile('gambar')) {
            if ($lowongan->gambar) {
                $this->deleteImage($lowongan->gambar);
            }
            $validated['gambar'] = $this->storeImage($request->file('gambar'), 'lowongan', 1280, 1280, 640);
        } elseif ($request->boolean('hapus_gambar') && $lowongan->gambar) {
            $this->deleteImage($lowongan->gambar);
            $validated['gambar'] = null;
        }
        $lowongan->update($validated);

        return redirect()->route('lowongan.index')->with('success', 'Lowongan magang industri berhasil diperbarui.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $lowongan = DaftarLowongan::findOrFail($id);

        if (Auth::user()->role === 'mitra' && $lowongan->id_mitra !== Auth::user()->mitra?->id_mitra) {
            return redirect()->route('lowongan.index')->with('error', 'Anda tidak memiliki izin untuk menghapus lowongan ini.');
        }
        if ($lowongan->gambar) {
            $this->deleteImage($lowongan->gambar);
        }
        $lowongan->delete();

        return redirect()->route('lowongan.index')->with('success', 'Lowongan magang industri berhasil dihapus.');
    }
}
