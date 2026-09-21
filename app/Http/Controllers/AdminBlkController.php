<?php

namespace App\Http\Controllers;

use App\Models\AdminBlk;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminBlkController extends Controller
{
    public function index(): View
    {
        $admins = AdminBlk::with(['user', 'pelatihan', 'lowongan', 'peserta', 'sertifikat'])
            ->latest('id_admin')
            ->paginate(10);

        return view('admin-blk.index', compact('admins'));
    }

    public function create(): View
    {
        $users = User::orderBy('name')->get();
        return view('admin-blk.create', compact('users'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'id_user' => 'required|exists:users,id|unique:admin_blks,id_user',
        ], [
            'id_user.required' => 'Pengguna wajib dipilih.',
            'id_user.exists'   => 'Pengguna tidak ditemukan.',
            'id_user.unique'   => 'Pengguna ini sudah terdaftar sebagai Administrator BLK.',
        ]);

        AdminBlk::create([
            'id_user' => $request->id_user,
        ]);

        return redirect()->route('admin-blk.index')->with('success', 'Data administrator BLK berhasil ditambahkan.');
    }

    public function show(int $id): View
    {
        $admin = AdminBlk::with(['user', 'peserta', 'lowongan', 'pelatihan', 'sertifikat'])->findOrFail($id);
        return view('admin-blk.show', compact('admin'));
    }

    public function edit(int $id): View
    {
        $admin = AdminBlk::with('user')->findOrFail($id);
        $users = User::orderBy('name')->get();
        return view('admin-blk.edit', compact('admin', 'users'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $admin = AdminBlk::findOrFail($id);

        $request->validate([
            'id_user' => 'required|exists:users,id|unique:admin_blks,id_user,' . $admin->id_admin . ',id_admin',
        ], [
            'id_user.required' => 'Pengguna wajib dipilih.',
            'id_user.exists'   => 'Pengguna tidak ditemukan.',
            'id_user.unique'   => 'Pengguna ini sudah terdaftar sebagai Administrator BLK lain.',
        ]);

        $admin->update([
            'id_user' => $request->id_user,
        ]);

        return redirect()->route('admin-blk.index')->with('success', 'Data administrator BLK berhasil diperbarui.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $admin = AdminBlk::findOrFail($id);
        $admin->delete();
        return redirect()->route('admin-blk.index')->with('success', 'Data administrator BLK berhasil dihapus.');
    }
}

