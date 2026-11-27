<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JadwalPelatihan;
use App\Models\KelasPelatihan;
use App\Models\SesiPresensi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

/**
 * Sesi presensi yang dikontrol instruktur. Sesi menempel ke jadwal
 * (seperti modul) dan diakses lewat id_kelas.
 */
class SesiPresensiController extends Controller
{
    public function index(Request $request, int $idKelas): JsonResponse
    {
        $jadwal = $this->jadwalDariKelas($idKelas);
        abort_unless($jadwal->diampuOleh($request->user()), 403, 'Hanya instruktur pengampu yang dapat melihat sesi presensi.');

        $sesi = SesiPresensi::where('id_jadwal', $jadwal->id_jadwal)
            ->withCount(['absensi as jumlah_hadir' => fn ($q) => $q->where('status_kehadiran', 'hadir')])
            ->orderBy('pertemuan_ke')
            ->get();

        return response()->json([
            'data' => $sesi->map(fn (SesiPresensi $item) => self::format($item, $idKelas, $item->statusPeserta()))->values(),
        ]);
    }

    /** Daftar peserta kelas beserta status kehadirannya pada satu sesi (rekap instruktur). */
    public function peserta(Request $request, int $idSesi): JsonResponse
    {
        $sesi = SesiPresensi::with('jadwal')->findOrFail($idSesi);
        abort_unless($sesi->jadwal->diampuOleh($request->user()), 403, 'Hanya instruktur pengampu yang dapat melihat rekap sesi.');

        $status = $sesi->statusPeserta();
        $sesi->loadCount(['absensi as jumlah_hadir' => fn ($q) => $q->where('status_kehadiran', 'hadir')]);

        return response()->json([
            'data' => [
                'sesi' => self::format($sesi, KelasPelatihan::where('id_jadwal', $sesi->id_jadwal)->min('id_kelas'), $status),
                'peserta' => $status,
            ],
        ]);
    }

    public function store(Request $request, int $idKelas): JsonResponse
    {
        $jadwal = $this->jadwalDariKelas($idKelas);
        abort_unless($jadwal->diampuOleh($request->user()), 403, 'Hanya instruktur pengampu yang dapat membuat sesi presensi.');

        $data = $request->validate([
            'pertemuan_ke' => [
                'required', 'integer', 'min:1',
                Rule::unique('sesi_presensi', 'pertemuan_ke')->where('id_jadwal', $jadwal->id_jadwal),
            ],
            'tanggal' => ['required', 'date_format:Y-m-d', 'after_or_equal:today'],
            'jam_mulai' => ['required', 'date_format:H:i'],
            'jam_selesai' => ['required', 'date_format:H:i', 'after:jam_mulai'],
            'lokasi_latitude' => ['nullable', 'numeric', 'between:-90,90', 'required_with:lokasi_longitude'],
            'lokasi_longitude' => ['nullable', 'numeric', 'between:-180,180', 'required_with:lokasi_latitude'],
            'radius_meter' => ['required', 'integer', 'between:10,5000'],
        ], [
            'pertemuan_ke.required' => 'Pertemuan ke- wajib diisi.',
            'pertemuan_ke.min' => 'Pertemuan ke- minimal 1.',
            'pertemuan_ke.unique' => 'Sesi untuk pertemuan ini sudah ada.',
            'tanggal.after_or_equal' => 'Tanggal sesi tidak boleh sebelum hari ini.',
            'jam_selesai.after' => 'Jam selesai harus setelah jam mulai.',
            'radius_meter.between' => 'Radius harus antara 10 dan 5000 meter.',
        ]);

        $sesi = SesiPresensi::create([
            ...$data,
            'id_jadwal' => $jadwal->id_jadwal,
            'id_instruktur' => $jadwal->id_instruktur,
            'absen_dibuka' => false,
        ]);

        return response()->json([
            'message' => 'Sesi presensi berhasil dibuat',
            'data' => self::format($sesi->fresh(), $idKelas),
        ], 201);
    }

    public function update(Request $request, int $idSesi): JsonResponse
    {
        $sesi = SesiPresensi::with('jadwal')->findOrFail($idSesi);
        abort_unless($sesi->jadwal->diampuOleh($request->user()), 403, 'Hanya instruktur pengampu yang dapat mengubah sesi presensi.');

        $data = $request->validate(['absen_dibuka' => ['required', 'boolean']]);

        if ($data['absen_dibuka'] && $sesi->tanggal->lt(today())) {
            $pesan = 'Sesi yang tanggalnya sudah lewat tidak dapat dibuka.';

            return response()->json(['message' => $pesan, 'errors' => ['absen_dibuka' => [$pesan]]], 422);
        }

        $sesi->update(['absen_dibuka' => (bool) $data['absen_dibuka']]);
        $sesi->loadCount(['absensi as jumlah_hadir' => fn ($q) => $q->where('status_kehadiran', 'hadir')]);

        return response()->json([
            'message' => $sesi->absen_dibuka ? 'Presensi dibuka' : 'Presensi ditutup',
            'data' => self::format($sesi, KelasPelatihan::where('id_jadwal', $sesi->id_jadwal)->min('id_kelas'), $sesi->statusPeserta()),
        ]);
    }

    public function destroy(Request $request, int $idSesi): JsonResponse
    {
        $sesi = SesiPresensi::with('jadwal')->findOrFail($idSesi);
        abort_unless($sesi->jadwal->diampuOleh($request->user()), 403, 'Hanya instruktur pengampu yang dapat menghapus sesi presensi.');

        if ($sesi->absensi()->exists()) {
            return response()->json(['message' => 'Sesi sudah memiliki data kehadiran dan tidak dapat dihapus.'], 422);
        }

        $sesi->delete();

        return response()->json(['message' => 'Sesi presensi berhasil dihapus']);
    }

    /** Sesi yang sedang dibuka hari ini untuk kelas; 404 bila tidak ada. */
    public function aktif(Request $request, int $idKelas): JsonResponse
    {
        $jadwal = $this->jadwalDariKelas($idKelas);
        $user = $request->user();
        abort_unless($jadwal->diikutiOleh($user) || $jadwal->diampuOleh($user), 403, 'Anda tidak terdaftar di kelas ini.');

        $sesi = SesiPresensi::where('id_jadwal', $jadwal->id_jadwal)
            ->where('absen_dibuka', true)
            ->whereDate('tanggal', today())
            ->orderByDesc('pertemuan_ke')
            ->first();

        if (! $sesi) {
            return response()->json(['message' => 'Presensi belum dibuka oleh instruktur.', 'data' => null], 404);
        }

        return response()->json(['data' => self::format($sesi, $idKelas)]);
    }

    private function jadwalDariKelas(int $idKelas): JadwalPelatihan
    {
        return KelasPelatihan::with('jadwal')->findOrFail($idKelas)->jadwal;
    }

    /**
     * @return array<string, mixed>
     */
    public static function format(SesiPresensi $sesi, ?int $idKelas, ?Collection $statusPeserta = null): array
    {
        $rekap = [];
        if ($statusPeserta !== null) {
            $jumlah = $statusPeserta->countBy('status');
            $rekap = [
                'jumlah_peserta' => $statusPeserta->count(),
                'jumlah_izin' => (int) ($jumlah['izin'] ?? 0),
                'jumlah_sakit' => (int) ($jumlah['sakit'] ?? 0),
                'jumlah_alpha' => (int) ($jumlah['alpha'] ?? 0),
                'jumlah_belum' => (int) ($jumlah['belum'] ?? 0),
            ];
        }

        return [
            'id_sesi' => $sesi->id_sesi,
            'id_kelas' => $idKelas,
            'id_jadwal' => $sesi->id_jadwal,
            'pertemuan_ke' => $sesi->pertemuan_ke,
            'tanggal' => $sesi->tanggal->toDateString(),
            'jam_mulai' => substr((string) $sesi->jam_mulai, 0, 5),
            'jam_selesai' => substr((string) $sesi->jam_selesai, 0, 5),
            'lokasi_latitude' => $sesi->lokasi_latitude !== null ? (float) $sesi->lokasi_latitude : null,
            'lokasi_longitude' => $sesi->lokasi_longitude !== null ? (float) $sesi->lokasi_longitude : null,
            'radius_meter' => $sesi->radius_meter,
            'absen_dibuka' => (bool) $sesi->absen_dibuka,
            'jumlah_hadir' => (int) ($sesi->jumlah_hadir ?? 0),
            ...$rekap,
        ];
    }
}
