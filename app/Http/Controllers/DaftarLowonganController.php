<?php

namespace App\Http\Controllers;

use App\Models\DaftarLowongan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DaftarLowonganController extends Controller
{
    public function index(): View
    {
        $lowongans = DaftarLowongan::with(['mitra', 'admin'])->latest()->paginate(15);
        return view('lowongan.index', compact('lowongans'));
    }

    public function create(): View
    {
        return view('lowongan.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'mitra_id'  => 'required|exists:mitras,id',
            'admin_id'  => 'nullable|exists:admin_blks,id',
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'gaji'      => 'nullable|numeric',
            'lokasi'    => 'nullable|string|max:255',
            'deadline'  => 'nullable|date',
        ]);
        DaftarLowongan::create($request->all());
        return redirect()->route('lowongan.index')->with('success', 'Lowongan berhasil ditambahkan.');
    }

    public function show(int $id): View
    {
        $lowongan = DaftarLowongan::with(['mitra', 'admin'])->findOrFail($id);
        return view('lowongan.show', compact('lowongan'));
    }

    public function edit(int $id): View
    {
        $lowongan = DaftarLowongan::findOrFail($id);
        return view('lowongan.edit', compact('lowongan'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'gaji'      => 'nullable|numeric',
            'lokasi'    => 'nullable|string|max:255',
            'deadline'  => 'nullable|date',
        ]);
        $lowongan = DaftarLowongan::findOrFail($id);
        $lowongan->update($request->all());
        return redirect()->route('lowongan.index')->with('success', 'Lowongan berhasil diperbarui.');
    }

    public function destroy(int $id): RedirectResponse
    {
        DaftarLowongan::findOrFail($id)->delete();
        return redirect()->route('lowongan.index')->with('success', 'Lowongan berhasil dihapus.');
    }
}
