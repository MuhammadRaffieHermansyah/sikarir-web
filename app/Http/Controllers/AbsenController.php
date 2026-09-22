<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\Peserta;
use App\Models\JadwalPelatihan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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
        $validated = $request->validate([
            'id_peserta'       => 'required|exists:pesertas,id_peserta',
            'id_jadwal'        => 'required|exists:jadwal_pelatihan,id_jadwal',
            'tanggal'          => [
                'required',
                'date',
                Rule::unique('absens')->where(fn ($query) => $query
                    ->where('id_peserta', $request->input('id_peserta'))
                    ->where('id_jadwal', $request->input('id_jadwal'))),
            ],
            'jam_hadir'        => 'nullable|date_format:H:i',
            'status_kehadiran' => 'required|in:hadir,izin,sakit,alpha',
            'keterangan'       => 'nullable|string|max:255',
        ], [
            'id_peserta.required'       => 'Siswa peserta wajib dipilih.',
            'id_jadwal.required'        => 'Batch jadwal kelas wajib dipilih.',
            'tanggal.required'          => 'Tanggal presensi wajib diisi.',
            'tanggal.unique'            => 'Data presensi untuk siswa ini pada tanggal tersebut sudah tercatat.',
            'jam_hadir.date_format'     => 'Format jam hadir tidak valid (contoh: 08:00).',
            'status_kehadiran.required' => 'Status kehadiran wajib ditentukan.',
            'status_kehadiran.in'       => 'Status kehadiran tidak valid.',
        ]);

        Absen::create($validated);
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

        $validated = $request->validate([
            'id_peserta'       => 'required|exists:pesertas,id_peserta',
            'id_jadwal'        => 'required|exists:jadwal_pelatihan,id_jadwal',
            'tanggal'          => [
                'required',
                'date',
                Rule::unique('absens')->where(fn ($query) => $query
                    ->where('id_peserta', $request->input('id_peserta'))
                    ->where('id_jadwal', $request->input('id_jadwal'))
                )->ignore($absen->id_absen, 'id_absen'),
            ],
            'jam_hadir'        => 'nullable|date_format:H:i',
            'status_kehadiran' => 'required|in:hadir,izin,sakit,alpha',
            'keterangan'       => 'nullable|string|max:255',
        ], [
            'tanggal.unique'        => 'Data presensi untuk siswa ini pada tanggal tersebut sudah tercatat.',
            'jam_hadir.date_format' => 'Format jam hadir tidak valid (contoh: 08:00).',
            'status_kehadiran.in'   => 'Status kehadiran tidak valid.',
        ]);

        $absen->update($validated);
        return redirect()->route('absen.index')->with('success', 'Catatan presensi harian berhasil diperbarui.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $absen = Absen::findOrFail($id);
        $absen->delete();
        return redirect()->route('absen.index')->with('success', 'Catatan presensi harian berhasil dihapus.');
    }
}
