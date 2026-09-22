<?php

namespace App\Http\Controllers;

use App\Models\DaftarPelatihan;
use App\Models\AdminBlk;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DaftarPelatihanController extends Controller
{
    public function index(): View
    {
        $pelatihans = DaftarPelatihan::with(['admin.user', 'jadwal'])
            ->latest('id_pelatihan')
            ->paginate(10);
        dd($pelatihans);
        return view('pelatihan.index', compact('pelatihans'));
    }

    public function create(): View
    {
        $admins = AdminBlk::with('user')->get();
        return view('pelatihan.create', compact('admins'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'id_admin'            => 'nullable|exists:admin_blks,id_admin',
            'nama_pelatihan'      => 'required|string|max:255',
            'deskripsi_pelatihan' => 'nullable|string',
            'kuota'               => 'required|integer|min:1',
            'durasi_lp'           => 'nullable|string|max:100',
        ], [
            'nama_pelatihan.required' => 'Nama kejuruan / program pelatihan wajib diisi.',
            'kuota.required'          => 'Kapasitas kuota peserta wajib ditentukan.',
            'kuota.min'               => 'Kuota minimal 1 orang peserta.',
        ]);

        DaftarPelatihan::create($request->all());
        return redirect()->route('pelatihan.index')->with('success', 'Program kejuruan pelatihan vokasi berhasil ditambahkan.');
    }

    public function show(int $id): View
    {
        $pelatihan = DaftarPelatihan::with(['admin.user', 'jadwal.kelas.peserta.user'])->findOrFail($id);
        return view('pelatihan.show', compact('pelatihan'));
    }

    public function edit(int $id): View
    {
        $pelatihan = DaftarPelatihan::findOrFail($id);
        $admins    = AdminBlk::with('user')->get();
        return view('pelatihan.edit', compact('pelatihan', 'admins'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $pelatihan = DaftarPelatihan::findOrFail($id);

        $request->validate([
            'id_admin'            => 'nullable|exists:admin_blks,id_admin',
            'nama_pelatihan'      => 'required|string|max:255',
            'deskripsi_pelatihan' => 'nullable|string',
            'kuota'               => 'required|integer|min:1',
            'durasi_lp'           => 'nullable|string|max:100',
        ], [
            'nama_pelatihan.required' => 'Nama kejuruan / program pelatihan wajib diisi.',
            'kuota.required'          => 'Kapasitas kuota peserta wajib ditentukan.',
            'kuota.min'               => 'Kuota minimal 1 orang peserta.',
        ]);

        $pelatihan->update($request->all());
        return redirect()->route('pelatihan.index')->with('success', 'Program kejuruan pelatihan vokasi berhasil diperbarui.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $pelatihan = DaftarPelatihan::findOrFail($id);
        $pelatihan->delete();
        return redirect()->route('pelatihan.index')->with('success', 'Program kejuruan pelatihan vokasi berhasil dihapus.');
    }
}
