<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PesertaController extends Controller
{
    public function index(): View
    {
        $pesertas = Peserta::with(['user', 'admin'])->latest()->paginate(15);
        return view('pesertas.index', compact('pesertas'));
    }

    public function create(): View
    {
        return view('pesertas.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'user_id'              => 'required|exists:users,id',
            'nik'                  => 'nullable|string|max:20',
            'alamat'               => 'nullable|string',
            'pendidikan_terakhir'  => 'nullable|string|max:100',
            'keahlian'             => 'nullable|string',
        ]);
        Peserta::create($request->all());
        return redirect()->route('pesertas.index')->with('success', 'Data peserta berhasil ditambahkan.');
    }

    public function show(int $id): View
    {
        $peserta = Peserta::with(['user', 'admin'])->findOrFail($id);
        return view('pesertas.show', compact('peserta'));
    }

    public function edit(int $id): View
    {
        $peserta = Peserta::findOrFail($id);
        return view('pesertas.edit', compact('peserta'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'nik'                  => 'nullable|string|max:20',
            'alamat'               => 'nullable|string',
            'pendidikan_terakhir'  => 'nullable|string|max:100',
            'keahlian'             => 'nullable|string',
        ]);
        $peserta = Peserta::findOrFail($id);
        $peserta->update($request->all());
        return redirect()->route('pesertas.index')->with('success', 'Data peserta berhasil diperbarui.');
    }

    public function destroy(int $id): RedirectResponse
    {
        Peserta::findOrFail($id)->delete();
        return redirect()->route('pesertas.index')->with('success', 'Data peserta berhasil dihapus.');
    }
}
