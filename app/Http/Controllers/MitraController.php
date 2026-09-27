<?php

namespace App\Http\Controllers;

use App\Models\Mitra;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MitraController extends Controller
{
    public function index(Request $request): View
    {
        $query = Mitra::with(['user', 'lowongan']);

        // Filter Pencarian (Nama Perusahaan, Bidang Usaha, Kota, Provinsi, No Telp)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_perusahaan', 'like', "%{$search}%")
                  ->orWhere('bidang_usaha', 'like', "%{$search}%")
                  ->orWhere('kota', 'like', "%{$search}%")
                  ->orWhere('provinsi', 'like', "%{$search}%")
                  ->orWhere('no_telp', 'like', "%{$search}%")
                  ->orWhere('jabatan_pic', 'like', "%{$search}%");
            });
        }

        // Filter Berdasarkan Jenis Mitra
        if ($request->filled('jenis_mitra')) {
            $query->where('jenis_mitra', $request->jenis_mitra);
        }

        // Ambil daftar jenis mitra unik untuk opsi dropdown filter
        $jenisMitraList = Mitra::distinct()->whereNotNull('jenis_mitra')->pluck('jenis_mitra');

        // Ambil data terbaru dengan pagination & pertahankan query string URL
        $mitras = $query->latest('id_mitra')
                        ->paginate(10)
                        ->withQueryString();

        return view('mitras.index', compact('mitras', 'jenisMitraList'));
    }

    public function create(): View
    {
        $users = User::orderBy('name')->get();
        return view('mitras.create', compact('users'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_perusahaan' => 'required|unique:mitras,nama_perusahaan|string|max:255',
            'id_user'         => 'required|exists:users,id|unique:mitras,id_user',
            'jenis_mitra'     => 'required|string|max:100',
            'bidang_usaha'    => 'required|string|max:255',
            'no_telp'         => 'required|string|max:30',
            'no_izin'         => 'required|string|max:100',
            'jabatan_pic'     => 'required|string|max:100',
            'provinsi'        => 'required|string|max:100',
            'kota'            => 'required|string|max:100',
            'alamat'          => 'required|string',
        ], [
            'nama_perusahaan.required' => 'Nama perusahaan wajib diisi.',
            'nama_perusahaan.unique'   => 'Nama perusahaan sudah terdaftar.',
            'id_user.unique'           => 'Akun pengguna ini sudah ditautkan ke mitra lain.',
            'jenis_mitra.required'     => 'Jenis mitra wajib diisi.',
            'bidang_usaha.required'    => 'Bidang usaha wajib diisi.',
            'no_telp.required'         => 'Nomor telepon wajib diisi.',
            'no_izin.required'         => 'Nomor izin wajib diisi.',
            'jabatan_pic.required'     => 'Jabatan PIC wajib diisi.',
            'provinsi.required'        => 'Provinsi wajib diisi.',
            'kota.required'            => 'Kota wajib diisi.',
            'alamat.required'          => 'Alamat wajib diisi.',
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