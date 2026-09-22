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
        $absens = Absen::with(['peserta.user', 'jadwal.pelatihan'])
            ->latest('id_absen')
            ->paginate(10);

        return view('absen.index', compact('absens'));
    }

    public function create(): View
    {
        $pesertas = Peserta::with('user')->orderBy('nomor_peserta')->get();
        $jadwals  = JadwalPelatihan::with('pelatihan')->orderBy('id_jadwal', 'desc')->get();
        return view('absen.create', compact('pesertas', 'jadwals'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'id_peserta'       => 'required|exists:pesertas,id_peserta',
            'id_jadwal'        => 'required|exists:jadwal_pelatihan,id_jadwal',
            'tanggal'          => 'required|date',
            'jam_hadir'        => 'nullable|string',
            'status_kehadiran' => 'required|in:hadir,izin,alpha,sakit',
            'keterangan'       => 'nullable|string',
        ], [
            'id_peserta.required'       => 'Siswa peserta wajib dipilih.',
            'id_jadwal.required'        => 'Batch jadwal kelas wajib dipilih.',
            'tanggal.required'          => 'Tanggal presensi wajib diisi.',
            'status_kehadiran.required' => 'Status kehadiran wajib ditentukan.',
        ]);

        // Prevent duplicate attendance per day
        $exists = Absen::where('id_peserta', $request->id_peserta)
            ->where('id_jadwal', $request->id_jadwal)
            ->where('tanggal', $request->tanggal)
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors(['error' => 'Data presensi untuk siswa ini pada tanggal tersebut sudah tercatat.']);
        }

        Absen::create($request->all());
        return redirect()->route('absen.index')->with('success', 'Catatan presensi harian berhasil disimpan.');
    }

    public function show(int $id): View
    {
        $absen = Absen::with(['peserta.user', 'jadwal.pelatihan'])->findOrFail($id);
        return view('absen.show', compact('absen'));
    }

    public function edit(int $id): View
    {
        $absen    = Absen::findOrFail($id);
        $pesertas = Peserta::with('user')->orderBy('nomor_peserta')->get();
        $jadwals  = JadwalPelatihan::with('pelatihan')->get();
        return view('absen.edit', compact('absen', 'pesertas', 'jadwals'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $absen = Absen::findOrFail($id);

        $request->validate([
            'id_peserta'       => 'required|exists:pesertas,id_peserta',
            'id_jadwal'        => 'required|exists:jadwal_pelatihan,id_jadwal',
            'tanggal'          => 'required|date',
            'jam_hadir'        => 'nullable|string',
            'status_kehadiran' => 'required|in:hadir,izin,alpha,sakit',
            'keterangan'       => 'nullable|string',
        ]);

        $absen->update($request->all());
        return redirect()->route('absen.index')->with('success', 'Catatan presensi harian berhasil diperbarui.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $absen = Absen::findOrFail($id);
        $absen->delete();
        return redirect()->route('absen.index')->with('success', 'Catatan presensi harian berhasil dihapus.');
    }
}
