<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\KelasPelatihanResource;
use App\Models\JadwalPelatihan;
use App\Models\KelasPelatihan;
use App\Models\Modul;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ModulController extends Controller
{
    /**
     * Daftar kelas yang diampu instruktur login (satu entri per jadwal).
     */
    public function kelasInstruktur(Request $request): JsonResponse
    {
        $user = $request->user();
        abort_unless($user->role === 'instruktur', 403, 'Akses ditolak.');

        $idInstruktur = $user->instruktur?->id;

        $idKelas = $idInstruktur === null ? [] : KelasPelatihan::query()
            ->whereHas('jadwal', fn ($q) => $q->where('id_instruktur', $idInstruktur))
            ->selectRaw('MIN(id_kelas) as id_kelas')
            ->groupBy('id_jadwal')
            ->pluck('id_kelas');

        $kelas = KelasPelatihan::with(['jadwal.pelatihan', 'jadwal.instruktur', 'jadwal.ruanganWorkshop'])
            ->whereIn('id_kelas', $idKelas)
            ->latest('id_kelas')
            ->get();

        return response()->json([
            'message' => 'Daftar kelas yang diampu berhasil diambil',
            'data' => KelasPelatihanResource::collection($kelas),
        ]);
    }

    public function index(Request $request, int $idKelas): JsonResponse
    {
        $jadwal = $this->jadwalDariKelas($idKelas);
        $user = $request->user();

        abort_unless($jadwal->diampuOleh($user) || $jadwal->diikutiOleh($user), 403, 'Anda tidak memiliki akses ke kelas ini.');

        $modul = $jadwal->modul()->with('materi')->orderBy('pertemuan_ke')->orderBy('id_modul')->get();

        return response()->json([
            'data' => $modul->map(fn (Modul $item) => $this->format($item, $idKelas))->values(),
        ]);
    }

    public function store(Request $request, int $idKelas): JsonResponse
    {
        $jadwal = $this->jadwalDariKelas($idKelas);
        abort_unless($jadwal->diampuOleh($request->user()), 403, 'Hanya instruktur pengampu yang dapat menambah modul.');

        $data = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'pertemuan_ke' => ['required', 'integer', 'min:1'],
        ], [
            'judul.required' => 'Judul wajib diisi.',
            'pertemuan_ke.required' => 'Pertemuan ke- wajib diisi.',
            'pertemuan_ke.min' => 'Pertemuan ke- minimal 1.',
        ]);

        $modul = $jadwal->modul()->create($data)->load('materi');

        return response()->json([
            'message' => 'Modul berhasil ditambahkan',
            'data' => $this->format($modul, $idKelas),
        ], 201);
    }

    public function destroy(Request $request, int $idModul): JsonResponse
    {
        $modul = Modul::with(['jadwal', 'materi'])->findOrFail($idModul);
        abort_unless($modul->jadwal->diampuOleh($request->user()), 403, 'Hanya instruktur pengampu yang dapat menghapus modul.');

        $berkas = $modul->materi->where('tipe', 'file')->pluck('url')->filter()->all();
        $modul->delete();
        Storage::disk('public')->delete($berkas);

        return response()->json(['message' => 'Modul berhasil dihapus']);
    }

    private function jadwalDariKelas(int $idKelas): JadwalPelatihan
    {
        return KelasPelatihan::with('jadwal')->findOrFail($idKelas)->jadwal;
    }

    /**
     * @return array<string, mixed>
     */
    private function format(Modul $modul, int $idKelas): array
    {
        return [
            'id_modul' => $modul->id_modul,
            'id_kelas' => $idKelas,
            'judul' => $modul->judul,
            'deskripsi' => $modul->deskripsi,
            'pertemuan_ke' => $modul->pertemuan_ke,
            'materi' => $modul->materi->map(fn ($materi) => MateriController::format($materi))->values(),
        ];
    }
}
