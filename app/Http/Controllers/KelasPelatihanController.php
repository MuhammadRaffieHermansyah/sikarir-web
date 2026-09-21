<?php

namespace App\Http\Controllers;

use App\Models\KelasPelatihan;
use App\Models\Peserta;
use App\Models\JadwalPelatihan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class KelasPelatihanController extends Controller
{
    public function index(): View
    {
        $kelas = KelasPelatihan::with(['peserta.user', 'jadwal.pelatihan'])
            ->latest('id_kelas')
            ->paginate(10);

        return view('kelas-pelatihan.index', compact('kelas'));
    }

    public function create(): View
    {
        $pesertas = Peserta::with('user')->orderBy('nomor_peserta')->get();
        $jadwals  = JadwalPelatihan::with('pelatihan')->orderBy('id_jadwal', 'desc')->get();
        return view('kelas-pelatihan.create', compact('pesertas', 'jadwals'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'id_peserta' => 'required|exists:pesertas,id_peserta',
            'id_jadwal'  => 'required|exists:jadwal_pelatihan,id_jadwal',
            'status'     => 'nullable|string|max:30',
        ], [
            'id_peserta.required' => 'Siswa peserta pelatihan wajib dipilih.',
            'id_jadwal.required'  => 'Batch jadwal kelas wajib dipilih.',
        ]);

        $data = $request->only(['id_peserta', 'id_jadwal', 'status']);
        $data['status'] = $data['status'] ?? 'terdaftar';

        try {
            DB::transaction(function () use ($data) {
                $jadwal = JadwalPelatihan::with('pelatihan')->lockForUpdate()->findOrFail($data['id_jadwal']);
                
                if (KelasPelatihan::where('id_peserta', $data['id_peserta'])->where('id_jadwal', $data['id_jadwal'])->exists()) {
                    throw new \Exception('Peserta ini sudah terdaftar pada batch jadwal kelas yang dipilih.');
                }
                
                $count = KelasPelatihan::where('id_jadwal', $data['id_jadwal'])->count();
                if ($jadwal->pelatihan && $count >= $jadwal->pelatihan->kuota) {
                    throw new \Exception('Kapasitas kuota untuk kelas pelatihan ini sudah penuh (Maks: ' . $jadwal->pelatihan->kuota . ' siswa).');
                }

                KelasPelatihan::create($data);
            });
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }

        return redirect()->route('kelas-pelatihan.index')->with('success', 'Siswa berhasil didaftarkan ke dalam kelas pelatihan.');
    }

    public function show(int $id): View
    {
        $kelas = KelasPelatihan::with(['peserta.user', 'jadwal.pelatihan', 'peserta.absensi', 'peserta.sertifikat'])->findOrFail($id);
        return view('kelas-pelatihan.show', compact('kelas'));
    }

    public function edit(int $id): View
    {
        $kelas    = KelasPelatihan::findOrFail($id);
        $pesertas = Peserta::with('user')->get();
        $jadwals  = JadwalPelatihan::with('pelatihan')->get();
        return view('kelas-pelatihan.edit', compact('kelas', 'pesertas', 'jadwals'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $kelas = KelasPelatihan::findOrFail($id);

        $request->validate([
            'id_peserta' => 'required|exists:pesertas,id_peserta',
            'id_jadwal'  => 'required|exists:jadwal_pelatihan,id_jadwal',
            'status'     => 'required|string|max:30',
        ], [
            'id_peserta.required' => 'Siswa peserta pelatihan wajib dipilih.',
            'id_jadwal.required'  => 'Batch jadwal kelas wajib dipilih.',
        ]);

        // Check if combination changed and already exists
        if (($kelas->id_peserta != $request->id_peserta || $kelas->id_jadwal != $request->id_jadwal) &&
            KelasPelatihan::where('id_peserta', $request->id_peserta)->where('id_jadwal', $request->id_jadwal)->where('id_kelas', '!=', $id)->exists()) {
            return back()->withInput()->withErrors(['error' => 'Peserta sudah terdaftar pada batch jadwal kelas ini.']);
        }

        $kelas->update($request->only(['id_peserta', 'id_jadwal', 'status']));
        return redirect()->route('kelas-pelatihan.index')->with('success', 'Data pendaftaran kelas pelatihan berhasil diperbarui.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $kelas = KelasPelatihan::findOrFail($id);
        $kelas->delete();
        return redirect()->route('kelas-pelatihan.index')->with('success', 'Data pendaftaran kelas pelatihan berhasil dihapus.');
    }
}
