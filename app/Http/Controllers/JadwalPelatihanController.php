<?php

namespace App\Http\Controllers;

use App\Models\JadwalPelatihan;
use App\Models\DaftarPelatihan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JadwalPelatihanController extends Controller
{
    public function index(): View
    {
        $jadwals = JadwalPelatihan::with('pelatihan')->latest()->paginate(15);
        return view('jadwal-pelatihan.index', compact('jadwals'));
    }

    public function create(): View
    {
        $pelatihans = DaftarPelatihan::all();
        return view('jadwal-pelatihan.create', compact('pelatihans'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'pelatihan_id'    => 'required|exists:daftar_pelatihans,id',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'lokasi'          => 'nullable|string|max:255',
            'status'          => 'nullable|in:tersedia,penuh,selesai',
        ]);
        JadwalPelatihan::create($request->all());
        return redirect()->route('jadwal-pelatihan.index')->with('success', 'Jadwal pelatihan berhasil ditambahkan.');
    }

    public function show(int $id): View
    {
        $jadwal = JadwalPelatihan::with('pelatihan')->findOrFail($id);
        return view('jadwal-pelatihan.show', compact('jadwal'));
    }

    public function edit(int $id): View
    {
        $jadwal = JadwalPelatihan::findOrFail($id);
        $pelatihans = DaftarPelatihan::all();
        return view('jadwal-pelatihan.edit', compact('jadwal', 'pelatihans'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'lokasi'          => 'nullable|string|max:255',
            'status'          => 'nullable|in:tersedia,penuh,selesai',
        ]);
        $jadwal = JadwalPelatihan::findOrFail($id);
        $jadwal->update($request->all());
        return redirect()->route('jadwal-pelatihan.index')->with('success', 'Jadwal pelatihan berhasil diperbarui.');
    }

    public function destroy(int $id): RedirectResponse
    {
        JadwalPelatihan::findOrFail($id)->delete();
        return redirect()->route('jadwal-pelatihan.index')->with('success', 'Jadwal pelatihan berhasil dihapus.');
    }
}
