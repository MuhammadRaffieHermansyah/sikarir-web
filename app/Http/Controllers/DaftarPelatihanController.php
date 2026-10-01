<?php

namespace App\Http\Controllers;

use App\Models\DaftarPelatihan;
use App\Models\AdminBlk;
use App\Models\DurasiPelatihan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DaftarPelatihanController extends Controller
{
    public function index(Request $request): View
    {
        $query = DaftarPelatihan::with(['admin.user', 'jadwal', 'durasi']);

        // Filter Pencarian Keyword (Nama Pelatihan atau Deskripsi)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_pelatihan', 'like', "%{$search}%")
                    ->orWhere('deskripsi_pelatihan', 'like', "%{$search}%");
            });
        }

        // Paginate data & tahan URL parameter
        $pelatihans = $query->latest('id_pelatihan')
            ->paginate(10)
            ->withQueryString();

        return view('pelatihan.index', compact('pelatihans'));
    }

    public function create(): View
    {
        $admins    = AdminBlk::with('user')->get();
        $durations = DurasiPelatihan::orderBy('hari')->get();
        return view('pelatihan.create', compact('admins', 'durations'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_admin'            => 'required|exists:admin_blks,id_admin',
            'nama_pelatihan'      => 'required|unique:daftar_pelatihan,nama_pelatihan|string|max:70|regex:/^[a-zA-Z\s]+$/',
            'deskripsi_pelatihan' => 'nullable|string',
            'kuota'               => 'required|integer|min:1',
            'id_durasi'           => 'nullable|exists:durasi_pelatihan,id_durasi',
        ], [
            'id_admin.required'       => 'Admin BLK penanggung jawab wajib dipilih.',
            'nama_pelatihan.required' => 'Nama kejuruan / program pelatihan wajib diisi.',
            'nama_pelatihan.unique'   => 'Nama kejuruan / program pelatihan sudah ada.',
            'nama_pelatihan.max'      => 'Nama kejuruan / program pelatihan maksimal 40 karakter.',
            'kuota.required'          => 'Kapasitas kuota peserta wajib ditentukan.',
            'kuota.min'               => 'Kuota minimal 1 orang peserta.',
            'nama_pelatihan.regex'    => 'Nama kejuruan / program pelatihan hanya boleh mengandung huruf dan spasi.',
        ]);

        DaftarPelatihan::create($validated);
        return redirect()->route('pelatihan.index')->with('success', 'Program kejuruan pelatihan vokasi berhasil ditambahkan.');
    }

    public function show(int $id): View
    {
        $pelatihan = DaftarPelatihan::with(['admin.user', 'durasi', 'jadwal.kelas.peserta.user'])->findOrFail($id);
        return view('pelatihan.show', compact('pelatihan'));
    }

    public function edit(int $id): View
    {
        $pelatihan = DaftarPelatihan::with('durasi')->findOrFail($id);
        $admins    = AdminBlk::with('user')->get();
        $durations = DurasiPelatihan::orderBy('hari')->get();
        return view('pelatihan.edit', compact('pelatihan', 'admins', 'durations'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $pelatihan = DaftarPelatihan::findOrFail($id);

        $validated = $request->validate([
            'id_admin'            => 'required|exists:admin_blks,id_admin',
            'nama_pelatihan'      => 'required|string|max:70|regex:/^[a-zA-Z\s]+$/',
            'deskripsi_pelatihan' => 'nullable|string',
            'kuota'               => 'required|integer|min:1',
            'id_durasi'           => 'nullable|exists:durasi_pelatihan,id_durasi',
        ], [
            'id_admin.required'       => 'Admin BLK penanggung jawab wajib dipilih.',
            'nama_pelatihan.required' => 'Nama kejuruan / program pelatihan wajib diisi.',
            'nama_pelatihan.max'      => 'Nama kejuruan / program pelatihan maksimal 40 karakter.',
            'kuota.required'          => 'Kapasitas kuota peserta wajib ditentukan.',
            'kuota.min'               => 'Kuota minimal 1 orang peserta.',
            'nama_pelatihan.regex'    => 'Nama kejuruan / program pelatihan hanya boleh mengandung huruf dan spasi.',
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
