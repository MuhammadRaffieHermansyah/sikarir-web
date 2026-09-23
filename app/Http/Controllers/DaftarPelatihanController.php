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

        return view('pelatihan.index', compact('pelatihans'));
    }

    public function create(): View
    {
        $admins = AdminBlk::with('user')->get();
        return view('pelatihan.create', compact('admins'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_admin'            => 'required|exists:admin_blks,id_admin',
            'nama_pelatihan'      => 'required|unique:daftar_pelatihan,nama_pelatihan|string|max:70',
            'deskripsi_pelatihan' => 'nullable|string',
            'kuota'               => 'required|integer|min:1',
            'durasi_lp'           => 'string|max:100',
        ], [
            'id_admin.required'       => 'Admin BLK penanggung jawab wajib dipilih.',
            'nama_pelatihan.required' => 'Nama kejuruan / program pelatihan wajib diisi.',
            'nama_pelatihan.unique'   => 'Nama kejuruan / program pelatihan sudah ada.',
            'nama_pelatihan.max'      => 'Nama kejuruan / program pelatihan maksimal 40 karakter.',
            'kuota.required'          => 'Kapasitas kuota peserta wajib ditentukan.',
            'kuota.min'               => 'Kuota minimal 1 orang peserta.',
        ]);

        DaftarPelatihan::create($validated);
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

        $validated = $request->validate([
            'id_admin'            => 'required|exists:admin_blks,id_admin',
            'nama_pelatihan'      => 'required|unique:daftar_pelatihan,nama_pelatihan|string|max:70',
            'deskripsi_pelatihan' => 'nullable|string',
            'kuota'               => 'required|integer|min:1',
            'durasi_lp'           => 'string|max:100',
        ], [
            'id_admin.required'       => 'Admin BLK penanggung jawab wajib dipilih.',
            'nama_pelatihan.required' => 'Nama kejuruan / program pelatihan wajib diisi.',
            'nama_pelatihan.unique'   => 'Nama kejuruan / program pelatihan sudah ada.',
            'nama_pelatihan.max'      => 'Nama kejuruan / program pelatihan maksimal 40 karakter.',
            'kuota.required'          => 'Kapasitas kuota peserta wajib ditentukan.',
            'kuota.min'               => 'Kuota minimal 1 orang peserta.',
        ]);

        $pelatihan->update($validated);
        return redirect()->route('pelatihan.index')->with('success', 'Program kejuruan pelatihan vokasi berhasil diperbarui.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $pelatihan = DaftarPelatihan::findOrFail($id);
        $pelatihan->delete();
        return redirect()->route('pelatihan.index')->with('success', 'Program kejuruan pelatihan vokasi berhasil dihapus.');
    }
}
