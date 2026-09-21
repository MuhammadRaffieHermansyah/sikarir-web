<?php

namespace App\Http\Controllers;

use App\Models\Mitra;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MitraController extends Controller
{
    public function index(): View
    {
        $mitras = Mitra::with('user')->latest()->paginate(15);
        return view('mitras.index', compact('mitras'));
    }

    public function create(): View
    {
        return view('mitras.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
            'bidang_usaha'    => 'nullable|string|max:255',
            'alamat'          => 'nullable|string',
            'telepon'         => 'nullable|string|max:20',
        ]);
        Mitra::create($request->all());
        return redirect()->route('mitras.index')->with('success', 'Data mitra berhasil ditambahkan.');
    }

    public function show(int $id): View
    {
        $mitra = Mitra::with('user')->findOrFail($id);
        return view('mitras.show', compact('mitra'));
    }

    public function edit(int $id): View
    {
        $mitra = Mitra::findOrFail($id);
        return view('mitras.edit', compact('mitra'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
            'bidang_usaha'    => 'nullable|string|max:255',
            'alamat'          => 'nullable|string',
            'telepon'         => 'nullable|string|max:20',
        ]);
        $mitra = Mitra::findOrFail($id);
        $mitra->update($request->all());
        return redirect()->route('mitras.index')->with('success', 'Data mitra berhasil diperbarui.');
    }

    public function destroy(int $id): RedirectResponse
    {
        Mitra::findOrFail($id)->delete();
        return redirect()->route('mitras.index')->with('success', 'Data mitra berhasil dihapus.');
    }
}
