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
        $jadwals = JadwalPelatihan::with(['pelatihan', 'kelas.peserta.user'])
            ->latest('id_jadwal')
            ->paginate(10);

        return view('jadwal-pelatihan.index', compact('jadwals'));
    }

    public function create(): View
    {
        $pelatihans = DaftarPelatihan::orderBy('nama_pelatihan')->get();
        return view('jadwal-pelatihan.create', compact('pelatihans'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_pelatihan'    => 'required|exists:daftar_pelatihan,id_pelatihan',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'jam_mulai'       => 'nullable|date_format:H:i',
            'jam_selesai'     => 'nullable|date_format:H:i',
            'instruktur'      => 'nullable|string|max:150',
            'tempat'          => 'nullable|string|max:255',
            'status'          => 'required|in:tersedia,berlangsung,selesai',
        ], [
            'id_pelatihan.required'           => 'Program pelatihan wajib dipilih.',
            'tanggal_mulai.required'          => 'Tanggal mulai pelatihan wajib diisi.',
            'tanggal_selesai.required'        => 'Tanggal selesai pelatihan wajib diisi.',
            'tanggal_selesai.after_or_equal'  => 'Tanggal selesai harus sama atau setelah tanggal mulai.',
            'jam_mulai.date_format'           => 'Format jam mulai tidak valid (contoh: 08:00).',
            'jam_selesai.date_format'         => 'Format jam selesai tidak valid (contoh: 15:30).',
        ]);

        JadwalPelatihan::create($validated);
        return redirect()->route('jadwal-pelatihan.index')->with('success', 'Batch jadwal pelatihan berhasil ditambahkan.');
    }

    public function show(int $id): View
    {
        $jadwal = JadwalPelatihan::with(['pelatihan.admin.user', 'kelas.peserta.user', 'absensi', 'sertifikat'])->findOrFail($id);
        return view('jadwal-pelatihan.show', compact('jadwal'));
    }

    public function edit(int $id): View
    {
        $jadwal     = JadwalPelatihan::findOrFail($id);
        $pelatihans = DaftarPelatihan::orderBy('nama_pelatihan')->get();
        return view('jadwal-pelatihan.edit', compact('jadwal', 'pelatihans'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $jadwal = JadwalPelatihan::findOrFail($id);

        $validated = $request->validate([
            'id_pelatihan'    => 'required|exists:daftar_pelatihan,id_pelatihan',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'jam_mulai'       => 'nullable|date_format:H:i',
            'jam_selesai'     => 'nullable|date_format:H:i',
            'instruktur'      => 'nullable|string|max:150',
            'tempat'          => 'nullable|string|max:255',
            'status'          => 'required|in:tersedia,berlangsung,selesai',
        ], [
            'id_pelatihan.required'           => 'Program pelatihan wajib dipilih.',
            'tanggal_mulai.required'          => 'Tanggal mulai pelatihan wajib diisi.',
            'tanggal_selesai.required'        => 'Tanggal selesai pelatihan wajib diisi.',
            'tanggal_selesai.after_or_equal'  => 'Tanggal selesai harus sama atau setelah tanggal mulai.',
            'jam_mulai.date_format'           => 'Format jam mulai tidak valid (contoh: 08:00).',
            'jam_selesai.date_format'         => 'Format jam selesai tidak valid (contoh: 15:30).',
        ]);

        $jadwal->update($validated);
        return redirect()->route('jadwal-pelatihan.index')->with('success', 'Batch jadwal pelatihan berhasil diperbarui.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $jadwal = JadwalPelatihan::findOrFail($id);
        $jadwal->delete();
        return redirect()->route('jadwal-pelatihan.index')->with('success', 'Batch jadwal pelatihan berhasil dihapus.');
    }
}
