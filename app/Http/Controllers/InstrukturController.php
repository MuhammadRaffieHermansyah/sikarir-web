<?php

namespace App\Http\Controllers;

use App\Models\BidangKeahlian;
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
        $bidangKeahlians = BidangKeahlian::orderBy('nama')->get();

        return view('instruktur.create', compact('bidangKeahlians'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:150|regex:/^[\pL\s.,\x27\-]+$/u|unique:instruktur,nama',
            'bidang_keahlian' => 'required|string|exists:bidang_keahlian,nama',
        ], [
            'nama.required' => 'Nama instruktur wajib diisi.',
            'nama.max' => 'Nama instruktur maksimal 150 karakter.',
            'nama.regex' => 'Nama instruktur hanya boleh berisi huruf, spasi, dan tanda . , - \'.',
            'nama.unique' => 'Nama instruktur sudah terdaftar.',
            'bidang_keahlian.required' => 'Bidang keahlian wajib dipilih.',
            'bidang_keahlian.exists' => 'Pilih bidang keahlian dari daftar master data.',
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
        $bidangKeahlians = BidangKeahlian::orderBy('nama')->get();

        return view('instruktur.edit', compact('instruktur', 'bidangKeahlians'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $instruktur = Instruktur::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:150|regex:/^[\pL\s.,\x27\-]+$/u',
            'bidang_keahlian' => 'required|string|exists:bidang_keahlian,nama',
        ], [
            'nama.required' => 'Nama instruktur wajib diisi.',
            'nama.max' => 'Nama instruktur maksimal 150 karakter.',
            'nama.regex' => 'Nama instruktur hanya boleh berisi huruf, spasi, dan tanda . , - \'.',
            'bidang_keahlian.required' => 'Bidang keahlian wajib dipilih.',
            'bidang_keahlian.exists' => 'Pilih bidang keahlian dari daftar master data.',
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
