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
    public function index(): View
    {
        $query = DaftarLowongan::with(['mitra', 'admin.user'])->latest('id_lowongan');

        if (Auth::user()->role === "mitra") {
            $query->where('id_mitra', Auth::user()->id);
        }

        $lowongans = $query->paginate(10);

        return view('lowongan.index', compact('lowongans'));
    }

    public function create(): View
    {
        $mitras  = Mitra::orderBy('nama_perusahaan')->get();
        $admins  = AdminBlk::with('user')->get();
        
        if (Auth::user()->role === "mitra") {
            $mitra = Mitra::where('id_user', Auth::user()->id)->get();
            $id_mitra = $mitra[0]->id_mitra;
            $nama_perusahaan = $mitra[0]->nama_perusahaan;
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
            'status'          => 'required|in:aktif,ditutup,draft',
        ], [
            'id_mitra.required'       => 'Mitra DU/DI wajib dipilih.',
            'id_admin.required'       => 'Admin BLK penanggung jawab wajib dipilih.',
            'judul_lowongan.required' => 'Judul posisi lowongan wajib diisi.',
            'judul_lowongan.unique'   => 'Judul lowongan sudah ada',
            'lokasi.required'         => 'Lokasi wajib diisi',
            'deskripsi.required'      => 'Deskripsi wajib diisi',
            'kualifikasi.required'    => 'Kualifikasi wajib diisi',
            'judul_lowongan.regex'    => 'Judul lowongan hanya boleh mengandung huruf dan spasi.',
            'lokasi.regex'            => 'Lokasi hanya boleh mengandung huruf dan spasi.',
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
            'status'          => 'required|in:aktif,ditutup,draft',
        ], [
            'id_mitra.required'       => 'Mitra DU/DI wajib dipilih.',
            'id_admin.required'       => 'Admin BLK penanggung jawab wajib dipilih.',
            'judul_lowongan.required' => 'Judul posisi lowongan wajib diisi.',
            'lokasi.required'         => 'Lokasi wajib diisi',
            'deskripsi.required'      => 'Deskripsi wajib diisi',
            'kualifikasi.required'    => 'Kualifikasi wajib diisi',
            'judul_lowongan.regex'    => 'Judul lowongan hanya boleh mengandung huruf dan spasi.',
            'lokasi.regex'            => 'Lokasi hanya boleh mengandung huruf dan spasi.',
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
