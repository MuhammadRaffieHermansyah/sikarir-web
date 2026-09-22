<?php

namespace App\Http\Controllers;

use App\Models\DaftarLowongan;
use App\Models\Mitra;
use App\Models\AdminBlk;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DaftarLowonganController extends Controller
{
    public function index(): View
    {
        $lowongans = DaftarLowongan::with(['mitra', 'admin.user'])
            ->latest('id_lowongan')
            ->paginate(10);

        return view('lowongan.index', compact('lowongans'));
    }

    public function create(): View
    {
        $mitras  = Mitra::orderBy('nama_perusahaan')->get();
        $admins  = AdminBlk::with('user')->get();
        return view('lowongan.create', compact('mitras', 'admins'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_mitra'        => 'required|exists:mitras,id_mitra',
            'id_admin'        => 'required|exists:admin_blks,id_admin',
            'judul_lowongan'  => 'required|string|max:255',
            'lokasi'          => 'nullable|string|max:255',
            'deskripsi'       => 'nullable|string',
            'kualifikasi'     => 'nullable|string',
            'tanggal_posting' => 'nullable|date',
            'status'          => 'required|in:aktif,ditutup,draft',
        ], [
            'id_mitra.required'       => 'Mitra DU/DI wajib dipilih.',
            'id_admin.required'       => 'Admin BLK penanggung jawab wajib dipilih.',
            'judul_lowongan.required' => 'Judul posisi lowongan wajib diisi.',
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
            'judul_lowongan'  => 'required|string|max:255',
            'lokasi'          => 'nullable|string|max:255',
            'deskripsi'       => 'nullable|string',
            'kualifikasi'     => 'nullable|string',
            'tanggal_posting' => 'nullable|date',
            'status'          => 'required|in:aktif,ditutup,draft',
        ], [
            'id_mitra.required'       => 'Mitra DU/DI wajib dipilih.',
            'id_admin.required'       => 'Admin BLK penanggung jawab wajib dipilih.',
            'judul_lowongan.required' => 'Judul posisi lowongan wajib diisi.',
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
