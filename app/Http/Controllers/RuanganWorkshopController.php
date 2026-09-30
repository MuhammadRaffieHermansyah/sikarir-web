<?php

namespace App\Http\Controllers;

use App\Models\RuanganWorkshop;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class RuanganWorkshopController extends Controller
{
    public function index(Request $request): View
    {
        $query = RuanganWorkshop::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(
                'nama_ruangan',
                'like',
                "%{$search}%"
            );
        }

        $ruanganWorkshops = $query
            ->orderBy('nama_ruangan')
            ->paginate(10)
            ->withQueryString();

        return view(
            'ruangan-workshop.index',
            compact('ruanganWorkshops')
        );
    }

    public function create(): View
    {
        return view('ruangan-workshop.create');
    }

    public function store(Request $request): RedirectResponse
{
    $validated = $request->validate([
        'nama_ruangan' => [
            'required',
            'string',
            'max:150',
            'regex:/^(?=.*[a-zA-Z])[a-zA-Z0-9\s]+$/',
            'unique:ruangan_workshops,nama_ruangan',
        ],
    ], [
        'nama_ruangan.required' =>
            'Nama ruangan wajib diisi.',

        'nama_ruangan.max' =>
            'Nama ruangan maksimal 150 karakter.',

        'nama_ruangan.regex' =>
            'Nama ruangan hanya boleh mengandung huruf, angka, dan spasi.',

        'nama_ruangan.unique' =>
            'Nama ruangan tersebut sudah tersedia.',
    ]);

    RuanganWorkshop::create($validated);

    return redirect()
        ->route('jadwal-pelatihan.create')
        ->with(
            'success',
            'Ruangan workshop berhasil ditambahkan.'
        );
}

    public function show(int $id): View
    {
        $ruanganWorkshop = RuanganWorkshop::findOrFail($id);

        return view(
            'ruangan-workshop.show',
            compact('ruanganWorkshop')
        );
    }

    public function edit(int $id): View
    {
        $ruanganWorkshop = RuanganWorkshop::findOrFail($id);

        return view(
            'ruangan-workshop.edit',
            compact('ruanganWorkshop')
        );
    }

    public function update(
        Request $request,
        int $id
    ): RedirectResponse {
        $ruanganWorkshop = RuanganWorkshop::findOrFail($id);

        $validated = $request->validate([
            'nama_ruangan' => [
                'required',
                'string',
                'max:150',
                'regex:/^(?=.*[a-zA-Z])[a-zA-Z0-9\s]+$/',

                Rule::unique(
                    'ruangan_workshops',
                    'nama_ruangan'
                )->ignore($ruanganWorkshop->id),
            ],
        ], [
            'nama_ruangan.required' =>
                'Nama ruangan wajib diisi.',

            'nama_ruangan.max' =>
                'Nama ruangan maksimal 150 karakter.',

            'nama_ruangan.regex' =>
                'Nama ruangan hanya boleh mengandung huruf, angka, dan spasi.',

            'nama_ruangan.unique' =>
                'Nama ruangan tersebut sudah tersedia.',
        ]);

        $ruanganWorkshop->update($validated);

        return redirect()
            ->route('ruangan-workshop.index')
            ->with(
                'success',
                'Data ruangan workshop berhasil diperbarui.'
            );
    }

    public function destroy(int $id): RedirectResponse
    {
        $ruanganWorkshop = RuanganWorkshop::findOrFail($id);

        $ruanganWorkshop->delete();

        return redirect()
            ->route('ruangan-workshop.index')
            ->with(
                'success',
                'Data ruangan workshop berhasil dihapus.'
            );
    }
}