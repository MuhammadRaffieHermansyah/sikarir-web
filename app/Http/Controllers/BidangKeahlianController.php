<?php

namespace App\Http\Controllers;

use App\Models\BidangKeahlian;
use App\Models\Instruktur;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class BidangKeahlianController extends Controller
{
    public function index(Request $request): View
    {
        $query = BidangKeahlian::query()->withCount('instruktur');

        if ($request->filled('search')) {
            $query->where('nama', 'like', "%{$request->search}%");
        }

        $bidangKeahlians = $query->orderBy('nama')
            ->paginate(10)
            ->withQueryString();

        return view('bidang-keahlian.index', compact('bidangKeahlians'));
    }

    public function create(): View
    {
        return view('bidang-keahlian.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules(), $this->messages());

        BidangKeahlian::create($validated);

        if ($request->input('from') === 'instruktur') {
            return redirect()->route('instruktur.create')
                ->with('success', 'Bidang keahlian berhasil ditambahkan. Silakan pilih pada form instruktur.');
        }

        return redirect()->route('bidang-keahlian.index')->with('success', 'Bidang keahlian berhasil ditambahkan.');
    }

    public function show(int $id): RedirectResponse
    {
        return redirect()->route('bidang-keahlian.edit', $id);
    }

    public function edit(int $id): View
    {
        $bidangKeahlian = BidangKeahlian::withCount('instruktur')->findOrFail($id);

        return view('bidang-keahlian.edit', compact('bidangKeahlian'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $bidangKeahlian = BidangKeahlian::findOrFail($id);

        $validated = $request->validate($this->rules($bidangKeahlian->id), $this->messages());

        DB::transaction(function () use ($bidangKeahlian, $validated): void {
            // Instruktur menyimpan nama bidang, jadi ikut diganti saat nama master berubah.
            Instruktur::where('bidang_keahlian', $bidangKeahlian->nama)
                ->update(['bidang_keahlian' => $validated['nama']]);

            $bidangKeahlian->update($validated);
        });

        return redirect()->route('bidang-keahlian.index')->with('success', 'Bidang keahlian berhasil diperbarui.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $bidangKeahlian = BidangKeahlian::withCount('instruktur')->findOrFail($id);

        if ($bidangKeahlian->instruktur_count > 0) {
            return redirect()->route('bidang-keahlian.index')
                ->with('error', "Bidang keahlian \"{$bidangKeahlian->nama}\" masih dipakai {$bidangKeahlian->instruktur_count} instruktur, tidak bisa dihapus.");
        }

        $bidangKeahlian->delete();

        return redirect()->route('bidang-keahlian.index')->with('success', 'Bidang keahlian berhasil dihapus.');
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    private function rules(?int $ignoreId = null): array
    {
        return [
            'nama' => [
                'required',
                'string',
                'max:150',
                'regex:/^[\pL\pN\s().,&\x27\/+\-]+$/u',
                Rule::unique('bidang_keahlian', 'nama')->ignore($ignoreId),
            ],
        ];
    }

    /**
     * @return array<string, string>
     */
    private function messages(): array
    {
        return [
            'nama.required' => 'Nama bidang keahlian wajib diisi.',
            'nama.max' => 'Nama bidang keahlian maksimal 150 karakter.',
            'nama.regex' => 'Nama bidang keahlian hanya boleh berisi huruf, angka, spasi, dan tanda baca umum.',
            'nama.unique' => 'Bidang keahlian tersebut sudah terdaftar.',
        ];
    }
}
