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
        $sertifikats = Sertifikat::with(['peserta.user', 'jadwal.pelatihan', 'admin.user'])
            ->latest('id_sertifikat')
            ->paginate(10);

        return view('sertifikat.index', compact('sertifikats'));
    }

    public function create(): View
    {
        $pesertas = Peserta::with('user')->orderBy('nomor_peserta')->get();
        $jadwals  = JadwalPelatihan::with('pelatihan')->orderBy('id_jadwal', 'desc')->get();
        $admins   = AdminBlk::with('user')->get();
        return view('sertifikat.create', compact('pesertas', 'jadwals', 'admins'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_peserta'      => 'required|exists:pesertas,id_peserta',
            'id_jadwal'       => 'required|exists:jadwal_pelatihan,id_jadwal',
            'id_admin'        => 'required|exists:admin_blks,id_admin',
            'no_sertifikat'   => 'required|string|max:100|unique:sertifikats,no_sertifikat',
            'tanggal_terbit'  => 'required|date',
            'file_sertifikat' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], [
            'id_peserta.required'     => 'Siswa penerima sertifikat wajib dipilih.',
            'id_jadwal.required'      => 'Batch kelas yang diselesaikan wajib dipilih.',
            'id_admin.required'       => 'Admin BLK penandatangan wajib dipilih.',
            'no_sertifikat.required'  => 'Nomor seri sertifikat wajib diisi.',
            'no_sertifikat.unique'    => 'Nomor seri sertifikat sudah digunakan.',
            'tanggal_terbit.required' => 'Tanggal penerbitan sertifikat wajib diisi.',
        ]);

        // Check if peserta already has sertifikat for this jadwal
        if (Sertifikat::where('id_peserta', $validated['id_peserta'])->where('id_jadwal', $validated['id_jadwal'])->exists()) {
            return back()->withInput()->withErrors(['error' => 'Siswa ini sudah memiliki sertifikat untuk program pelatihan tersebut.']);
        }

        if ($request->hasFile('file_sertifikat')) {
            $validated['file_sertifikat'] = $request->file('file_sertifikat')->store('sertifikat', 'public');
        }

        Sertifikat::create($validated);
        return redirect()->route('sertifikat.index')->with('success', 'Sertifikat kompetensi vokasi berhasil diterbitkan.');
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
        $sertifikat = Sertifikat::findOrFail($id);

        $validated = $request->validate([
            'id_peserta'      => 'required|exists:pesertas,id_peserta',
            'id_jadwal'       => 'required|exists:jadwal_pelatihan,id_jadwal',
            'id_admin'        => 'required|exists:admin_blks,id_admin',
            'no_sertifikat'   => 'required|string|max:100|unique:sertifikats,no_sertifikat,' . $sertifikat->id_sertifikat . ',id_sertifikat',
            'tanggal_terbit'  => 'required|date',
            'file_sertifikat' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        // Prevent moving to a (peserta, jadwal) combination that already has a sertifikat
        $comboExists = Sertifikat::where('id_peserta', $validated['id_peserta'])
            ->where('id_jadwal', $validated['id_jadwal'])
            ->where('id_sertifikat', '!=', $sertifikat->id_sertifikat)
            ->exists();

        if ($comboExists) {
            return back()->withInput()->withErrors(['error' => 'Siswa ini sudah memiliki sertifikat untuk program pelatihan tersebut.']);
        }

        if ($request->hasFile('file_sertifikat')) {
            if ($sertifikat->file_sertifikat) Storage::disk('public')->delete($sertifikat->file_sertifikat);
            $validated['file_sertifikat'] = $request->file('file_sertifikat')->store('sertifikat', 'public');
        }

        $sertifikat->update($validated);
        return redirect()->route('sertifikat.index')->with('success', 'Data sertifikat kompetensi berhasil diperbarui.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $sertifikat = Sertifikat::findOrFail($id);
        if ($sertifikat->file_sertifikat) Storage::disk('public')->delete($sertifikat->file_sertifikat);
        $sertifikat->delete();
        return redirect()->route('sertifikat.index')->with('success', 'Data sertifikat kompetensi berhasil dihapus.');
    }
}
