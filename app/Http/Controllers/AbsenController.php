<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\Peserta;
use App\Models\JadwalPelatihan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AbsenController extends Controller
{
    public function index(): View
    {
        $absens = Absen::with(['peserta.user', 'jadwal.pelatihan'])->latest()->paginate(15);
        return view('absen.index', compact('absens'));
    }

    public function create(): View
    {
        $pesertas = Peserta::with('user')->get();
        $jadwals  = JadwalPelatihan::with('pelatihan')->get();
        return view('absen.create', compact('pesertas', 'jadwals'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'peserta_id'  => 'required|exists:pesertas,id',
            'jadwal_id'   => 'required|exists:jadwal_pelatihans,id',
            'tanggal'     => 'required|date',
            'status'      => 'required|in:hadir,izin,alpha',
            'keterangan'  => 'nullable|string',
        ]);
        Absen::create($request->all());
        return redirect()->route('absen.index')->with('success', 'Data absensi berhasil dicatat.');
    }

    public function show(int $id): View
    {
        $absen = Absen::with(['peserta.user', 'jadwal.pelatihan'])->findOrFail($id);
        return view('absen.show', compact('absen'));
    }

    public function edit(int $id): View
    {
        $absen    = Absen::findOrFail($id);
        $pesertas = Peserta::with('user')->get();
        $jadwals  = JadwalPelatihan::with('pelatihan')->get();
        return view('absen.edit', compact('absen', 'pesertas', 'jadwals'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'tanggal'    => 'required|date',
            'status'     => 'required|in:hadir,izin,alpha',
            'keterangan' => 'nullable|string',
        ]);
        $absen = Absen::findOrFail($id);
        $absen->update($request->all());
        return redirect()->route('absen.index')->with('success', 'Data absensi berhasil diperbarui.');
    }

    public function destroy(int $id): RedirectResponse
    {
        Absen::findOrFail($id)->delete();
        return redirect()->route('absen.index')->with('success', 'Data absensi berhasil dihapus.');
    }
}
