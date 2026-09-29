<?php

namespace App\Http\Controllers;

use App\Models\DurasiPelatihan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class DurasiPelatihanController extends Controller
{
    public function index(Request $request): View
    {
        $query = DurasiPelatihan::withCount('pelatihan');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('hari', 'like', "%{$search}%")
                  ->orWhere('jam', 'like', "%{$search}%");
            });
        }

        $durations = $query->orderBy('hari')
                           ->orderBy('jam')
                           ->paginate(10)
                           ->withQueryString();

        return view('durasi-pelatihan.index', compact('durations'));
    }

    public function create(): View
    {
        return view('durasi-pelatihan.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'hari' => [
                'required', 'integer', 'min:1', 'max:366',
                Rule::unique('durasi_pelatihan')->where(fn ($query) => $query->where('jam', $request->jam)),
            ],
            'jam' => 'required|integer|min:1|max:8760',
        ], [
            'hari.required' => 'Jumlah hari wajib diisi.',
            'hari.min'      => 'Jumlah hari minimal 1.',
            'hari.unique'   => 'Durasi ' . $request->hari . ' Hari / ' . $request->jam . ' Jam sudah tersedia.',
            'jam.required'  => 'Jumlah jam wajib diisi.',
            'jam.min'       => 'Jumlah jam minimal 1.',
        ]);

        DurasiPelatihan::create($validated);
        return redirect()->route('durasi-pelatihan.index')->with('success', 'Data durasi pelatihan berhasil ditambahkan.');
    }

    public function show(int $id): View
    {
        $durasi = DurasiPelatihan::with('pelatihan')->findOrFail($id);
        return view('durasi-pelatihan.show', compact('durasi'));
    }

    public function edit(int $id): View
    {
        $durasi = DurasiPelatihan::findOrFail($id);
        return view('durasi-pelatihan.edit', compact('durasi'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $durasi = DurasiPelatihan::findOrFail($id);

        $validated = $request->validate([
            'hari' => [
                'required', 'integer', 'min:1', 'max:366',
                Rule::unique('durasi_pelatihan')
                    ->where(fn ($query) => $query->where('jam', $request->jam))
                    ->ignore($durasi->id_durasi),
            ],
            'jam' => 'required|integer|min:1|max:8760',
        ], [
            'hari.required' => 'Jumlah hari wajib diisi.',
            'hari.min'      => 'Jumlah hari minimal 1.',
            'hari.unique'   => 'Durasi ' . $request->hari . ' Hari / ' . $request->jam . ' Jam sudah tersedia.',
            'jam.required'  => 'Jumlah jam wajib diisi.',
            'jam.min'       => 'Jumlah jam minimal 1.',
        ]);

        $durasi->update($validated);
        return redirect()->route('durasi-pelatihan.index')->with('success', 'Data durasi pelatihan berhasil diperbarui.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $durasi = DurasiPelatihan::findOrFail($id);
        $durasi->delete();
        return redirect()->route('durasi-pelatihan.index')->with('success', 'Data durasi pelatihan berhasil dihapus.');
    }
}