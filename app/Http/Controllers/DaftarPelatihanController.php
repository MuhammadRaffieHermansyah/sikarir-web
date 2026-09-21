<?php

namespace App\Http\Controllers;

use App\Models\DaftarPelatihan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DaftarPelatihanController extends Controller
{
    public function index(): View
    {
        $pelatihans = DaftarPelatihan::with('admin')->latest()->paginate(15);
        return view('pelatihan.index', compact('pelatihans'));
    }

    public function create(): View
    {
        return view('pelatihan.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'admin_id'        => 'nullable|exists:admin_blks,id',
            'nama_pelatihan'  => 'required|string|max:255',
            'deskripsi'       => 'nullable|string',
            'kuota'           => 'required|integer|min:1',
            'durasi'          => 'nullable|string|max:100',
        ]);
        DaftarPelatihan::create($request->all());
        return redirect()->route('pelatihan.index')->with('success', 'Pelatihan berhasil ditambahkan.');
    }

    public function show(int $id): View
    {
        $pelatihan = DaftarPelatihan::with('admin')->findOrFail($id);
        return view('pelatihan.show', compact('pelatihan'));
    }

    public function edit(int $id): View
    {
        $pelatihan = DaftarPelatihan::findOrFail($id);
        return view('pelatihan.edit', compact('pelatihan'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'nama_pelatihan' => 'required|string|max:255',
            'deskripsi'      => 'nullable|string',
            'kuota'          => 'required|integer|min:1',
            'durasi'         => 'nullable|string|max:100',
        ]);
        $pelatihan = DaftarPelatihan::findOrFail($id);
        $pelatihan->update($request->all());
        return redirect()->route('pelatihan.index')->with('success', 'Pelatihan berhasil diperbarui.');
    }

    public function destroy(int $id): RedirectResponse
    {
        DaftarPelatihan::findOrFail($id)->delete();
        return redirect()->route('pelatihan.index')->with('success', 'Pelatihan berhasil dihapus.');
    }
}
