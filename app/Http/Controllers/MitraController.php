<?php

namespace App\Http\Controllers;

use App\Models\Mitra;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MitraController extends Controller
{
    public function index(): View
    {
        $mitras = Mitra::with(['user', 'lowongan'])->latest('id_mitra')->paginate(10);
        return view('mitras.index', compact('mitras'));
    }

    public function create(): View
    {
        $users = User::orderBy('name')->get();
        return view('mitras.create', compact('users'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
            'id_user'         => 'nullable|exists:users,id|unique:mitras,id_user',
            'jenis_mitra'     => 'nullable|string|max:100',
            'bidang_usaha'    => 'nullable|string|max:255',
            'no_telp'         => 'nullable|string|max:30',
            'no_izin'         => 'nullable|string|max:100',
            'jabatan_pic'     => 'nullable|string|max:100',
            'provinsi'        => 'nullable|string|max:100',
            'kota'            => 'nullable|string|max:100',
            'alamat'          => 'nullable|string',
        ], [
            'nama_perusahaan.required' => 'Nama perusahaan wajib diisi.',
            'id_user.unique'           => 'Akun pengguna ini sudah ditautkan ke mitra lain.',
        ]);

        Mitra::create($validated);
        return redirect()->route('mitras.index')->with('success', 'Data mitra DU/DI berhasil ditambahkan.');
    }

    public function show(int $id): View
    {
        $mitra = Mitra::with(['user', 'lowongan.admin.user'])->findOrFail($id);
        return view('mitras.show', compact('mitra'));
    }

    public function edit(int $id): View
    {
        $mitra = Mitra::with('user')->findOrFail($id);
        $users = User::orderBy('name')->get();
        return view('mitras.edit', compact('mitra', 'users'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $mitra = Mitra::findOrFail($id);

        $validated = $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
            'id_user'         => 'nullable|exists:users,id|unique:mitras,id_user,' . $mitra->id_mitra . ',id_mitra',
            'jenis_mitra'     => 'nullable|string|max:100',
            'bidang_usaha'    => 'nullable|string|max:255',
            'no_telp'         => 'nullable|string|max:30',
            'no_izin'         => 'nullable|string|max:100',
            'jabatan_pic'     => 'nullable|string|max:100',
            'provinsi'        => 'nullable|string|max:100',
            'kota'            => 'nullable|string|max:100',
            'alamat'          => 'nullable|string',
        ], [
            'nama_perusahaan.required' => 'Nama perusahaan wajib diisi.',
            'id_user.unique'           => 'Akun pengguna ini sudah ditautkan ke mitra lain.',
        ]);

        $mitra->update($validated);
        return redirect()->route('mitras.index')->with('success', 'Data mitra DU/DI berhasil diperbarui.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $mitra = Mitra::findOrFail($id);
        $mitra->delete();
        return redirect()->route('mitras.index')->with('success', 'Data mitra DU/DI berhasil dihapus.');
    }
}

