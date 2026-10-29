<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAbsenRequest;
use App\Http\Requests\UpdateAbsenRequest;
use App\Http\Resources\AbsenResource;
use App\Models\Absen;
use App\Models\JadwalPelatihan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class AbsenController extends Controller
{
    // Radius default jika jadwal belum dikonfigurasi (meter)
    private const DEFAULT_RADIUS = 100;

    #[OA\Get(
        path: '/api/absen',
        summary: 'Ambil semua data absensi (paginate 15)',
        tags: ['Absen'],
        security: [['sanctum' => []]],
        responses: [
            new OA\Response(response: 200, description: 'Daftar absensi berhasil diambil'),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
    public function index(): JsonResponse
    {
        return AbsenResource::collection(
            Absen::with($this->relations())->latest()->paginate(15)
        )->response();
    }

    #[OA\Get(
        path: '/api/absen/today',
        summary: 'Ambil data absensi hari ini untuk peserta yang sedang login',
        tags: ['Absen'],
        security: [['sanctum' => []]],
        responses: [
            new OA\Response(response: 200, description: 'Data absensi hari ini'),
            new OA\Response(response: 404, description: 'Belum absen hari ini'),
        ]
    )]
    public function today(Request $request): JsonResponse
    {
        $user = $request->user();
        $peserta = $user->peserta ?? null;

        if (! $peserta) {
            return response()->json(['message' => 'Data peserta tidak ditemukan.'], 404);
        }

        $absen = Absen::with($this->relations())
            ->where('id_peserta', $peserta->id_peserta)
            ->where('tanggal', now()->toDateString())
            ->first();

        if (! $absen) {
            return response()->json(['message' => 'Belum ada data absensi hari ini.', 'data' => null], 200);
        }

        return (new AbsenResource($absen))->response();
    }

    #[OA\Get(
        path: '/api/absen/rekap',
        summary: 'Ambil rekapitulasi kehadiran dan status kelayakan sertifikasi peserta login',
        tags: ['Absen'],
        security: [['sanctum' => []]],
        responses: [
            new OA\Response(response: 200, description: 'Rekapitulasi absensi peserta'),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
    public function rekap(Request $request): JsonResponse
    {
        $user = $request->user();
        $peserta = $user->peserta ?? null;

        if (!$peserta) {
            return response()->json(['message' => 'Data peserta tidak ditemukan.'], 404);
        }

        $query = Absen::with(['jadwal.pelatihan'])->where('id_peserta', $peserta->id_peserta);

        if ($request->filled('id_jadwal')) {
            $query->where('id_jadwal', $request->id_jadwal);
        }

        $records = $query->latest('tanggal')->get();

        $totalHadir   = $records->where('status_kehadiran', 'hadir')->count();
        $totalIzin    = $records->where('status_kehadiran', 'izin')->count();
        $totalSakit   = $records->where('status_kehadiran', 'sakit')->count();
        $totalAlpha   = $records->where('status_kehadiran', 'alpha')->count();
        $totalSesi    = $records->count();
        $persentase   = $totalSesi > 0 ? round(($totalHadir / $totalSesi) * 100, 1) : 0;
        $statusLulus  = $persentase >= 80 ? 'Memenuhi Syarat Sertifikasi' : 'Kehadiran Belum Memenuhi Syarat';

        $perJadwal = $records->groupBy('id_jadwal')->map(function ($items) {
            $jadwal = $items->first()->jadwal;
            $hadir  = $items->where('status_kehadiran', 'hadir')->count();
            $total  = $items->count();
            $pct    = $total > 0 ? round(($hadir / $total) * 100, 1) : 0;

            return [
                'id_jadwal'       => $jadwal->id_jadwal ?? null,
                'nama_pelatihan'  => $jadwal->pelatihan->nama_pelatihan ?? 'Pelatihan',
                'total_hadir'     => $hadir,
                'total_sesi'      => $total,
                'persentase'      => $pct,
                'status'          => $pct >= 80 ? 'Memenuhi Syarat' : 'Perlu Ditingkatkan',
            ];
        })->values();

        return response()->json([
            'message' => 'Rekapitulasi kehadiran peserta berhasil diambil',
            'data' => [
                'peserta' => [
                    'id_peserta'    => $peserta->id_peserta,
                    'nomor_peserta' => $peserta->nomor_peserta,
                    'nama'          => $user->name,
                ],
                'summary' => [
                    'total_hadir'        => $totalHadir,
                    'total_izin'         => $totalIzin,
                    'total_sakit'        => $totalSakit,
                    'total_alpha'        => $totalAlpha,
                    'total_sesi'         => $totalSesi,
                    'persentase_hadir'   => $persentase,
                    'syarat_persentase'  => 80,
                    'status_kelayakan'   => $statusLulus,
                    'memenuhi_syarat'    => $persentase >= 80,
                ],
                'per_jadwal' => $perJadwal,
            ],
        ]);
    }

    #[OA\Post(
        path: '/api/absen',
        summary: 'Catat data absensi baru dengan validasi lokasi GPS',
        tags: ['Absen'],
        security: [['sanctum' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['id_peserta', 'id_jadwal', 'tanggal', 'status_kehadiran'],
                properties: [
                    new OA\Property(property: 'id_peserta', type: 'integer'),
                    new OA\Property(property: 'id_jadwal', type: 'integer'),
                    new OA\Property(property: 'tanggal', type: 'string', format: 'date'),
                    new OA\Property(property: 'jam_hadir', type: 'string', example: '08:00'),
                    new OA\Property(property: 'status_kehadiran', type: 'string', enum: ['hadir', 'izin', 'sakit', 'alpha']),
                    new OA\Property(property: 'keterangan', type: 'string'),
                    new OA\Property(property: 'latitude', type: 'number', format: 'float', example: -8.1763),
                    new OA\Property(property: 'longitude', type: 'number', format: 'float', example: 113.7007),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Absensi berhasil dicatat'),
            new OA\Response(response: 403, description: 'Lokasi tidak valid (di luar radius)'),
            new OA\Response(response: 422, description: 'Validasi gagal'),
        ]
    )]
    public function store(StoreAbsenRequest $request): JsonResponse
    {
        $data = $request->validated();

        // Cek duplikasi presensi
        $exists = Absen::where('id_peserta', $data['id_peserta'])
            ->where('id_jadwal', $data['id_jadwal'])
            ->where('tanggal', $data['tanggal'])
            ->exists();

        if ($exists) {
            abort(422, 'Data presensi untuk peserta ini pada tanggal tersebut sudah tercatat.');
        }

        // Validasi lokasi GPS jika status "hadir"
        if ($data['status_kehadiran'] === 'hadir') {
            $locationResult = $this->validateLocation($data);
            if ($locationResult['error']) {
                return response()->json([
                    'message' => $locationResult['message'],
                    'jarak_meter' => $locationResult['jarak_meter'] ?? null,
                    'radius_meter' => $locationResult['radius_meter'] ?? null,
                ], 403);
            }
            // Simpan jarak
            $data['jarak_meter'] = $locationResult['jarak_meter'];
        }

        $absen = Absen::create($data);
        return (new AbsenResource($absen))->response()->setStatusCode(201);
    }

    #[OA\Get(
        path: '/api/absen/{id}',
        summary: 'Ambil detail absensi berdasarkan ID',
        tags: ['Absen'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'Detail absensi'),
            new OA\Response(response: 404, description: 'Absensi tidak ditemukan'),
        ]
    )]
    public function show(int $id): JsonResponse
    {
        $absen = Absen::with($this->relations())->findOrFail($id);
        return (new AbsenResource($absen))->response();
    }

    #[OA\Put(
        path: '/api/absen/{id}',
        summary: 'Update data absensi',
        tags: ['Absen'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'id_peserta', type: 'integer'),
                    new OA\Property(property: 'id_jadwal', type: 'integer'),
                    new OA\Property(property: 'tanggal', type: 'string', format: 'date'),
                    new OA\Property(property: 'jam_hadir', type: 'string', example: '08:00'),
                    new OA\Property(property: 'status_kehadiran', type: 'string', enum: ['hadir', 'izin', 'sakit', 'alpha']),
                    new OA\Property(property: 'keterangan', type: 'string'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Absensi berhasil diupdate'),
            new OA\Response(response: 404, description: 'Absensi tidak ditemukan'),
        ]
    )]
    public function update(UpdateAbsenRequest $request, int $id): JsonResponse
    {
        $absen = Absen::findOrFail($id);
        $data  = $request->validated();

        $idPeserta = $data['id_peserta'] ?? $absen->id_peserta;
        $idJadwal  = $data['id_jadwal']  ?? $absen->id_jadwal;
        $tanggal   = $data['tanggal']    ?? $absen->tanggal->format('Y-m-d');

        $exists = Absen::where('id_peserta', $idPeserta)
            ->where('id_jadwal', $idJadwal)
            ->where('tanggal', $tanggal)
            ->where('id_absen', '!=', $absen->id_absen)
            ->exists();

        if ($exists) {
            abort(422, 'Data presensi untuk peserta ini pada tanggal tersebut sudah tercatat.');
        }

        $absen->update($data);
        return (new AbsenResource($absen->fresh()->load($this->relations())))->response();
    }

    #[OA\Delete(
        path: '/api/absen/{id}',
        summary: 'Hapus data absensi',
        tags: ['Absen'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'Absensi berhasil dihapus'),
            new OA\Response(response: 404, description: 'Absensi tidak ditemukan'),
        ]
    )]
    public function destroy(int $id): JsonResponse
    {
        $absen = Absen::findOrFail($id);
        $absen->delete();
        return response()->json(['message' => 'Data berhasil dihapus']);
    }

    // ───────────────────────────── helpers ──────────────────────────────────

    protected function relations(): array
    {
        return ['peserta', 'jadwal'];
    }

    /**
     * Validasi apakah koordinat peserta berada dalam radius lokasi jadwal.
     *
     * @return array{error: bool, message: string, jarak_meter: ?float, radius_meter: ?int}
     */
    private function validateLocation(array $data): array
    {
        $lat = $data['latitude']  ?? null;
        $lng = $data['longitude'] ?? null;

        // Jika tidak ada koordinat, tolak
        if ($lat === null || $lng === null) {
            return [
                'error'   => true,
                'message' => 'Koordinat GPS diperlukan untuk presensi hadir. Pastikan lokasi perangkat diaktifkan.',
                'jarak_meter'  => null,
                'radius_meter' => null,
            ];
        }

        // Ambil koordinat lokasi dari jadwal
        $jadwal = JadwalPelatihan::find($data['id_jadwal']);

        if (! $jadwal || $jadwal->lokasi_latitude === null || $jadwal->lokasi_longitude === null) {
            // Jadwal belum diatur lokasi → izinkan (admin belum set lokasi)
            return ['error' => false, 'message' => 'OK', 'jarak_meter' => null, 'radius_meter' => null];
        }

        $jarakMeter = $this->hitungJarak(
            (float) $lat, (float) $lng,
            (float) $jadwal->lokasi_latitude, (float) $jadwal->lokasi_longitude
        );

        $radiusMeter = $jadwal->radius_meter ?? self::DEFAULT_RADIUS;

        if ($jarakMeter > $radiusMeter) {
            return [
                'error'        => true,
                'message'      => sprintf(
                    'Anda berada %.0f meter dari lokasi pelatihan. Presensi hanya diizinkan dalam radius %d meter.',
                    $jarakMeter,
                    $radiusMeter
                ),
                'jarak_meter'  => round($jarakMeter, 2),
                'radius_meter' => $radiusMeter,
            ];
        }

        return [
            'error'        => false,
            'message'      => 'OK',
            'jarak_meter'  => round($jarakMeter, 2),
            'radius_meter' => $radiusMeter,
        ];
    }

    /**
     * Haversine formula: menghitung jarak (meter) antara dua titik GPS.
     */
    private function hitungJarak(float $lat1, float $lng1, float $lat2, float $lng2): float
    {
        $earthRadius = 6371000; // meter

        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);

        $a = sin($dLat / 2) ** 2
            + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLng / 2) ** 2;

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}
