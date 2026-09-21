<?php

namespace App\Http\Controllers;

use App\Models\AdminBlk;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminBlkController extends Controller
{
    public function index(): View
    {
        $admins = AdminBlk::with('user')->latest()->paginate(15);
        return view('admin-blk.index', compact('admins'));
    }

    public function create(): View
    {
        return view('admin-blk.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'jabatan' => 'nullable|string|max:100',
            'nip'     => 'nullable|string|max:30',
        ]);
        AdminBlk::create($request->all());
        return redirect()->route('admin-blk.index')->with('success', 'Data admin BLK berhasil ditambahkan.');
    }

    public function show(int $id): View
    {
        $admin = AdminBlk::with('user')->findOrFail($id);
        return view('admin-blk.show', compact('admin'));
    }

    public function edit(int $id): View
    {
        $admin = AdminBlk::findOrFail($id);
        return view('admin-blk.edit', compact('admin'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'jabatan' => 'nullable|string|max:100',
            'nip'     => 'nullable|string|max:30',
        ]);
        $admin = AdminBlk::findOrFail($id);
        $admin->update($request->all());
        return redirect()->route('admin-blk.index')->with('success', 'Data admin BLK berhasil diperbarui.');
    }

    public function destroy(int $id): RedirectResponse
    {
        AdminBlk::findOrFail($id)->delete();
        return redirect()->route('admin-blk.index')->with('success', 'Data admin BLK berhasil dihapus.');
    }
}
