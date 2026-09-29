<?php

namespace App\Http\Controllers;

use App\Models\Instruktur;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InstrukturController extends Controller
{
    public function index(Request $request): View
    {
        $query = Instruktur::withCount('jadwal');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('bidang_keahlian', 'like', "%{$search}%");
            });
        }

        $instrukturs = $query->orderBy('nama')
                           ->paginate(10)
                           ->withQueryString();

        return view('instruktur.index', compact('instrukturs'));
    }

    public function create(): View
    {
        return view('instruktur.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:150|regex:/^[a-zA-Z\s]+$/',
            'bidang_keahlian' => 'required|string|max:150|regex:/^[a-zA-Z\s]+$/',
        ], [
            'nama.required' => 'Nama instruktur wajib diisi.',
            'nama.max' => 'Nama instruktur maksimal 150 karakter.',
            'nama.regex' => 'Nama instruktur hanya boleh mengandung huruf dan spasi.',
            'bidang_keahlian.required' => 'Bidang keahlian wajib diisi.',
            'bidang_keahlian.max' => 'Bidang keahlian maksimal 150 karakter.',
            'bidang_keahlian.regex' => 'Bidang keahlian hanya boleh mengandung huruf dan spasi.',
        ]);

        Instruktur::create($validated);
        return redirect()->route('instruktur.index')->with('success', 'Data instruktur berhasil ditambahkan.');
    }

    public function show(int $id): View
    {
        $instruktur = Instruktur::with('jadwal.pelatihan')->findOrFail($id);
        return view('instruktur.show', compact('instruktur'));
    }

    public function edit(int $id): View
    {
        $instruktur = Instruktur::findOrFail($id);
        return view('instruktur.edit', compact('instruktur'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $instruktur = Instruktur::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:150|regex:/^[a-zA-Z\s]+$/',
            'bidang_keahlian' => 'required|string|max:150|regex:/^[a-zA-Z\s]+$/',
        ], [
            'nama.required' => 'Nama instruktur wajib diisi.',
            'nama.max' => 'Nama instruktur maksimal 150 karakter.',
            'nama.regex' => 'Nama instruktur hanya boleh mengandung huruf dan spasi.',
            'bidang_keahlian.required' => 'Bidang keahlian wajib diisi.',
            'bidang_keahlian.max' => 'Bidang keahlian maksimal 150 karakter.',
            'bidang_keahlian.regex' => 'Bidang keahlian hanya boleh mengandung huruf dan spasi.',
        ]);

        $instruktur->update($validated);
        return redirect()->route('instruktur.index')->with('success', 'Data instruktur berhasil diperbarui.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $instruktur = Instruktur::findOrFail($id);
        $instruktur->delete();
        return redirect()->route('instruktur.index')->with('success', 'Data instruktur berhasil dihapus.');
    }
}
