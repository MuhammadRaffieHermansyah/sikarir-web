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
        $kelas = KelasPelatihan::with(['peserta.user', 'jadwal.pelatihan'])->latest()->paginate(15);
        return view('kelas-pelatihan.index', compact('kelas'));
    }

    public function create(): View
    {
        $pesertas = Peserta::with('user')->get();
        $jadwals  = JadwalPelatihan::with('pelatihan')->where('status', 'tersedia')->get();
        return view('kelas-pelatihan.create', compact('pesertas', 'jadwals'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'id_peserta' => 'required|exists:pesertas,id',
            'id_jadwal'  => 'required|exists:jadwal_pelatihans,id',
        ]);
        $data = $request->only(['id_peserta', 'id_jadwal']);
        try {
            DB::transaction(function () use ($data) {
                $jadwal = JadwalPelatihan::with('pelatihan')->lockForUpdate()->findOrFail($data['id_jadwal']);
                if ($jadwal->status !== 'tersedia') abort(422, 'Jadwal pelatihan tidak tersedia.');
                if (KelasPelatihan::where('id_peserta', $data['id_peserta'])->where('id_jadwal', $data['id_jadwal'])->exists()) abort(422, 'Peserta sudah terdaftar pada jadwal ini.');
                $count = KelasPelatihan::where('id_jadwal', $data['id_jadwal'])->count();
                if ($count >= $jadwal->pelatihan->kuota) abort(422, 'Kuota pelatihan sudah penuh.');
                KelasPelatihan::create($data);
            });
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
        return redirect()->route('kelas-pelatihan.index')->with('success', 'Peserta berhasil didaftarkan ke kelas pelatihan.');
    }

    public function show(int $id): View
    {
        $kelas = KelasPelatihan::with(['peserta.user', 'jadwal.pelatihan'])->findOrFail($id);
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
        $request->validate([
            'id_peserta' => 'required|exists:pesertas,id',
            'id_jadwal'  => 'required|exists:jadwal_pelatihans,id',
        ]);
        $kelas = KelasPelatihan::findOrFail($id);
        $kelas->update($request->only(['id_peserta', 'id_jadwal']));
        return redirect()->route('kelas-pelatihan.index')->with('success', 'Data kelas pelatihan berhasil diperbarui.');
    }

    public function destroy(int $id): RedirectResponse
    {
        KelasPelatihan::findOrFail($id)->delete();
        return redirect()->route('kelas-pelatihan.index')->with('success', 'Data kelas pelatihan berhasil dihapus.');
    }
}
