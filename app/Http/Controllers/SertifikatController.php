<?php

namespace App\Http\Controllers;

use App\Models\Sertifikat;
use App\Models\Peserta;
use App\Models\JadwalPelatihan;
use App\Models\AdminBlk;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SertifikatController extends Controller
{
    public function index(): View
    {
        $sertifikats = Sertifikat::with(['peserta.user', 'jadwal.pelatihan', 'admin.user'])->latest()->paginate(15);
        return view('sertifikat.index', compact('sertifikats'));
    }

    public function create(): View
    {
        $pesertas = Peserta::with('user')->get();
        $jadwals  = JadwalPelatihan::with('pelatihan')->get();
        $admins   = AdminBlk::with('user')->get();
        return view('sertifikat.create', compact('pesertas', 'jadwals', 'admins'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'peserta_id'       => 'required|exists:pesertas,id',
            'jadwal_id'        => 'required|exists:jadwal_pelatihans,id',
            'admin_id'         => 'nullable|exists:admin_blks,id',
            'nomor_sertifikat' => 'nullable|string|max:100',
            'tanggal_terbit'   => 'nullable|date',
            'file_sertifikat'  => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);
        $data = $request->except('file_sertifikat');
        if ($request->hasFile('file_sertifikat')) {
            $data['file_sertifikat'] = $request->file('file_sertifikat')->store('sertifikat', 'public');
        }
        Sertifikat::create($data);
        return redirect()->route('sertifikat.index')->with('success', 'Sertifikat berhasil ditambahkan.');
    }

    public function show(int $id): View
    {
        $sertifikat = Sertifikat::with(['peserta.user', 'jadwal.pelatihan', 'admin.user'])->findOrFail($id);
        return view('sertifikat.show', compact('sertifikat'));
    }

    public function edit(int $id): View
    {
        $sertifikat = Sertifikat::findOrFail($id);
        $pesertas   = Peserta::with('user')->get();
        $jadwals    = JadwalPelatihan::with('pelatihan')->get();
        $admins     = AdminBlk::with('user')->get();
        return view('sertifikat.edit', compact('sertifikat', 'pesertas', 'jadwals', 'admins'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'nomor_sertifikat' => 'nullable|string|max:100',
            'tanggal_terbit'   => 'nullable|date',
            'file_sertifikat'  => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);
        $sertifikat = Sertifikat::findOrFail($id);
        $data = $request->except('file_sertifikat');
        if ($request->hasFile('file_sertifikat')) {
            if ($sertifikat->file_sertifikat) Storage::disk('public')->delete($sertifikat->file_sertifikat);
            $data['file_sertifikat'] = $request->file('file_sertifikat')->store('sertifikat', 'public');
        }
        $sertifikat->update($data);
        return redirect()->route('sertifikat.index')->with('success', 'Sertifikat berhasil diperbarui.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $sertifikat = Sertifikat::findOrFail($id);
        if ($sertifikat->file_sertifikat) Storage::disk('public')->delete($sertifikat->file_sertifikat);
        $sertifikat->delete();
        return redirect()->route('sertifikat.index')->with('success', 'Sertifikat berhasil dihapus.');
    }
}
