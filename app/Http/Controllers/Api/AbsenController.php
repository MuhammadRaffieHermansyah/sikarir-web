<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAbsenRequest;
use App\Http\Requests\UpdateAbsenRequest;
use App\Http\Resources\AbsenResource;
use App\Models\Absen;
use App\Models\HariLibur;
use App\Models\JadwalPelatihan;
use App\Models\KelasPelatihan;
use App\Models\Peserta;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use OpenApi\Attributes as OA;

class AbsenController extends Controller
{
    // Radius default jika jadwal belum dikonfigurasi (meter)
    private const DEFAULT_RADIUS = 100;

    // Batas panjang rentang izin/sakit (hari kalender)
    private const MAX_RENTANG_HARI = 14;

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
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        $query = Absen::with($this->relations())->latest('tanggal');

        // Jika user adalah peserta, filter hanya data miliknya
        if ($user && $user->peserta) {
            $query->where('id_peserta', $user->peserta->id_peserta);
        }

        return AbsenResource::collection(
            $query->paginate(15)
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
            return response()->json(['message' => 'Data peserta tidak ditemukan.', 'data' => null], 200);
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

        if (! $peserta) {
            return response()->json(['message' => 'Data peserta tidak ditemukan.', 'data' => null], 200);
        }

        $query = Absen::with(['jadwal.pelatihan'])->where('id_peserta', $peserta->id_peserta);

        if ($request->filled('id_jadwal')) {
            $query->where('id_jadwal', $request->id_jadwal);
        }

        $records = $query->latest('tanggal')->get();

        $totalHadir = $records->where('status_kehadiran', 'hadir')->count();
        $totalIzin = $records->where('status_kehadiran', 'izin')->count();
        $totalSakit = $records->where('status_kehadiran', 'sakit')->count();
        $totalAlpha = $records->whereIn('status_kehadiran', ['alpha', 'alpa'])->count();
        $totalSesi = $records->count();
        $persentase = $totalSesi > 0 ? round(($totalHadir / $totalSesi) * 100, 1) : 0;
        $statusLulus = $persentase >= 80 ? 'Memenuhi Syarat Sertifikasi' : 'Kehadiran Belum Memenuhi Syarat';

        $perJadwal = $records->groupBy('id_jadwal')->map(function ($items) {
            $jadwal = $items->first()->jadwal;
            $hadir = $items->where('status_kehadiran', 'hadir')->count();
            $total = $items->count();
            $pct = $total > 0 ? round(($hadir / $total) * 100, 1) : 0;

            return [
                'id_jadwal' => $jadwal->id_jadwal ?? null,
                'nama_pelatihan' => $jadwal->pelatihan->nama_pelatihan ?? 'Pelatihan',
                'total_hadir' => $hadir,
                'total_sesi' => $total,
                'persentase' => $pct,
                'status' => $pct >= 80 ? 'Memenuhi Syarat' : 'Perlu Ditingkatkan',
            ];
        })->values();

        return response()->json([
            'message' => 'Rekapitulasi kehadiran peserta berhasil diambil',
            'data' => [
                'peserta' => [
                    'id_peserta' => $peserta->id_peserta,
                    'nomor_peserta' => $peserta->nomor_peserta,
                    'nama' => $user->name,
                ],
                'summary' => [
                    'total_hadir' => $totalHadir,
                    'total_izin' => $totalIzin,
                    'total_sakit' => $totalSakit,
                    'total_alpha' => $totalAlpha,
                    'total_sesi' => $totalSesi,
                    'persentase_hadir' => $persentase,
                    'syarat_persentase' => 80,
                    'status_kelayakan' => $statusLulus,
                    'memenuhi_syarat' => $persentase >= 80,
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
                required: ['tanggal', 'status_kehadiran'],
                properties: [
                    new OA\Property(property: 'id_peserta', type: 'integer'),
                    new OA\Property(property: 'id_jadwal', type: 'integer'),
                    new OA\Property(property: 'tanggal', type: 'string', format: 'date'),
                    new OA\Property(property: 'jam_hadir', type: 'string', example: '08:00'),
                    new OA\Property(property: 'status_kehadiran', type: 'string', enum: ['hadir', 'izin', 'sakit', 'alpha']),
                    new OA\Property(property: 'keterangan', type: 'string'),
                    new OA\Property(property: 'latitude', type: 'number', format: 'float', example: -8.1763),
                    new OA\Property(property: 'longitude', type: 'number', format: 'float', example: 113.7007),
                    new OA\Property(property: 'tanggal_selesai', type: 'string', format: 'date', description: 'Khusus izin/sakit: akhir rentang (maks. 14 hari). Satu catatan dibuat per hari pelatihan; akhir pekan, hari libur, dan hari di luar jadwal dilewati.'),
                    new OA\Property(property: 'lampiran', type: 'string', format: 'binary', description: 'Khusus izin/sakit: JPG/PNG/PDF maks. 2 MB (kirim sebagai multipart/form-data).'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Absensi berhasil dicatat (rentang izin/sakit mengembalikan daftar catatan)'),
            new OA\Response(response: 403, description: 'Lokasi tidak valid (di luar radius)'),
            new OA\Response(response: 422, description: 'Validasi gagal'),
        ]
    )]
    public function store(StoreAbsenRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = $request->user();

        // 1. Resolve id_peserta
        $peserta = $user?->peserta;
        if ($peserta) {
            $data['id_peserta'] = $peserta->id_peserta;
        } elseif (! empty($data['id_peserta'])) {
            $found = Peserta::find($data['id_peserta']) ?? Peserta::where('id_user', $data['id_peserta'])->first();
            if ($found) {
                $data['id_peserta'] = $found->id_peserta;
            } else {
                return response()->json(['message' => 'Data peserta tidak valid.'], 422);
            }
        } else {
            return response()->json(['message' => 'Data peserta tidak ditemukan. Silakan lengkapi profil terlebih dahulu.'], 422);
        }

        // 2. Resolve id_jadwal jika kosong atau tidak valid
        if (empty($data['id_jadwal']) || ! JadwalPelatihan::where('id_jadwal', $data['id_jadwal'])->exists()) {
            $activeKelas = KelasPelatihan::where('id_peserta', $data['id_peserta'])->latest('id_kelas')->first();
            if ($activeKelas) {
                $data['id_jadwal'] = $activeKelas->id_jadwal;
            } else {
                $defaultJadwal = JadwalPelatihan::whereIn('status', ['berlangsung', 'tersedia'])->first() ?? JadwalPelatihan::first();
                $data['id_jadwal'] = $defaultJadwal?->id_jadwal ?? 1;
            }
        }

        // 3. Normalisasi status_kehadiran ('alpa' -> 'alpha')
        if (isset($data['status_kehadiran']) && $data['status_kehadiran'] === 'alpa') {
            $data['status_kehadiran'] = 'alpha';
        }

        // 4. Format jam_hadir
        if (empty($data['jam_hadir'])) {
            $data['jam_hadir'] = now()->format('H:i');
        } elseif (strlen($data['jam_hadir']) > 5) {
            $data['jam_hadir'] = substr($data['jam_hadir'], 0, 5);
        }

        // Rentang tanggal & berkas bukan kolom langsung; tangani terpisah.
        $tanggalSelesai = $data['tanggal_selesai'] ?? null;
        unset($data['tanggal_selesai'], $data['lampiran']);

        if ($tanggalSelesai !== null
            && Carbon::parse($tanggalSelesai)->toDateString() !== Carbon::parse($data['tanggal'])->toDateString()) {
            return $this->storeRentang($request, $data, $tanggalSelesai);
        }

        // 5. Cek duplikasi presensi
        $exists = Absen::where('id_peserta', $data['id_peserta'])
            ->where('id_jadwal', $data['id_jadwal'])
            ->whereDate('tanggal', $data['tanggal'])
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'Presensi Anda untuk jadwal ini pada tanggal tersebut sudah tercatat.',
            ], 422);
        }

        // 6. Validasi lokasi GPS jika status "hadir"
        if ($data['status_kehadiran'] === 'hadir') {
            $locationResult = $this->validateLocation($data);
            if ($locationResult['error']) {
                return response()->json([
                    'message' => $locationResult['message'],
                    'jarak_meter' => $locationResult['jarak_meter'] ?? null,
                    'radius_meter' => $locationResult['radius_meter'] ?? null,
                ], 403);
            }
            $data['jarak_meter'] = $locationResult['jarak_meter'];
        }

        // 7. Simpan lampiran (hanya sampai sini jika semua validasi lolos)
        if ($request->hasFile('lampiran')) {
            $data['lampiran'] = $request->file('lampiran')->store('absen-lampiran', 'public');
        }

        $absen = Absen::create($data);

        return (new AbsenResource($absen->load($this->relations())))->response()->setStatusCode(201);
    }

    /**
     * Catat izin/sakit untuk rentang tanggal: satu catatan per hari pelatihan.
     * Akhir pekan, hari libur, hari di luar periode jadwal, dan tanggal yang
     * sudah tercatat dilewati.
     *
     * @param  array<string, mixed>  $data
     */
    private function storeRentang(Request $request, array $data, string $tanggalSelesai): JsonResponse
    {
        $mulai = Carbon::parse($data['tanggal'])->startOfDay();
        $selesai = Carbon::parse($tanggalSelesai)->startOfDay();

        if ($mulai->diffInDays($selesai) + 1 > self::MAX_RENTANG_HARI) {
            return response()->json([
                'message' => 'Rentang izin/sakit maksimal '.self::MAX_RENTANG_HARI.' hari.',
            ], 422);
        }

        $hariPelatihan = $this->hariPelatihanDalamRentang((int) $data['id_jadwal'], $mulai, $selesai);

        if ($hariPelatihan === []) {
            return response()->json([
                'message' => 'Rentang tanggal tidak memuat hari pelatihan (akhir pekan, hari libur, atau di luar jadwal).',
            ], 422);
        }

        $sudahAda = Absen::where('id_peserta', $data['id_peserta'])
            ->where('id_jadwal', $data['id_jadwal'])
            ->where(function ($query) use ($hariPelatihan): void {
                foreach ($hariPelatihan as $tanggal) {
                    $query->orWhereDate('tanggal', $tanggal);
                }
            })
            ->pluck('tanggal')
            ->map(fn ($tanggal) => Carbon::parse($tanggal)->toDateString())
            ->all();

        $hariBaru = array_values(array_diff($hariPelatihan, $sudahAda));

        if ($hariBaru === []) {
            return response()->json([
                'message' => 'Presensi Anda untuk seluruh hari pada rentang tersebut sudah tercatat.',
            ], 422);
        }

        if ($request->hasFile('lampiran')) {
            $data['lampiran'] = $request->file('lampiran')->store('absen-lampiran', 'public');
        }

        $ids = DB::transaction(fn () => collect($hariBaru)
            ->map(fn (string $tanggal) => Absen::create([...$data, 'tanggal' => $tanggal])->getKey())
            ->all());

        $dicatat = Absen::with($this->relations())->whereIn('id_absen', $ids)->orderBy('tanggal')->get();

        return AbsenResource::collection($dicatat)
            ->additional([
                'message' => sprintf('%d hari presensi berhasil dicatat.', count($hariBaru)),
                'dilewati' => $sudahAda,
            ])
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Tanggal (Y-m-d) pada rentang yang merupakan hari pelatihan: Senin–Jumat,
     * bukan hari libur, dan berada dalam periode jadwal bila periode diketahui.
     *
     * @return list<string>
     */
    private function hariPelatihanDalamRentang(int $idJadwal, Carbon $mulai, Carbon $selesai): array
    {
        $jadwal = JadwalPelatihan::find($idJadwal);
        $hariLibur = HariLibur::whereBetween('tanggal', [$mulai->toDateString(), $selesai->toDateString()])
            ->pluck('tanggal')
            ->map(fn ($tanggal) => Carbon::parse($tanggal)->toDateString())
            ->all();

        $hari = [];
        foreach (CarbonPeriod::create($mulai, $selesai) as $tanggal) {
            $iso = $tanggal->toDateString();

            if ($tanggal->isWeekend() || in_array($iso, $hariLibur, true)) {
                continue;
            }
            if ($jadwal?->tanggal_mulai && $tanggal->lt($jadwal->tanggal_mulai->startOfDay())) {
                continue;
            }
            if ($jadwal?->tanggal_selesai && $tanggal->gt($jadwal->tanggal_selesai->endOfDay())) {
                continue;
            }

            $hari[] = $iso;
        }

        return $hari;
    }

    #[OA\Post(
        path: '/api/absen/{id}/pulang',
        summary: 'Catat presensi pulang (jam keluar memakai waktu server, lokasi GPS divalidasi)',
        tags: ['Absen'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['latitude', 'longitude'],
                properties: [
                    new OA\Property(property: 'latitude', type: 'number', format: 'float', example: -8.1763),
                    new OA\Property(property: 'longitude', type: 'number', format: 'float', example: 113.7007),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Presensi pulang berhasil dicatat'),
            new OA\Response(response: 403, description: 'Bukan presensi milik peserta, atau lokasi di luar radius'),
            new OA\Response(response: 422, description: 'Status bukan hadir, bukan hari ini, atau sudah pulang'),
        ]
    )]
    public function pulang(Request $request, int $id): JsonResponse
    {
        $absen = Absen::findOrFail($id);
        $peserta = $request->user()?->peserta;

        if (! $peserta || (int) $absen->id_peserta !== (int) $peserta->id_peserta) {
            return response()->json(['message' => 'Anda tidak berhak mengubah presensi ini.'], 403);
        }

        $validated = $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        if ($absen->status_kehadiran !== 'hadir') {
            return response()->json(['message' => 'Presensi pulang hanya untuk presensi berstatus hadir.'], 422);
        }

        if (! $absen->tanggal->isToday()) {
            return response()->json(['message' => 'Presensi pulang hanya dapat dilakukan pada hari yang sama.'], 422);
        }

        if ($absen->jam_keluar !== null) {
            return response()->json(['message' => 'Presensi pulang sudah tercatat.'], 422);
        }

        $locationResult = $this->validateLocation([
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'id_jadwal' => $absen->id_jadwal,
        ]);

        if ($locationResult['error']) {
            return response()->json([
                'message' => $locationResult['message'],
                'jarak_meter' => $locationResult['jarak_meter'] ?? null,
                'radius_meter' => $locationResult['radius_meter'] ?? null,
            ], 403);
        }

        $absen->update([
            'jam_keluar' => now()->format('H:i'),
            'latitude_keluar' => $validated['latitude'],
            'longitude_keluar' => $validated['longitude'],
            'jarak_keluar_meter' => $locationResult['jarak_meter'],
        ]);

        return (new AbsenResource($absen->fresh()->load($this->relations())))->response();
    }

    #[OA\Get(
        path: '/api/absen/{id}',
        summary: 'Ambil detail absensi berdasarkan ID',
        tags: ['Absen'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
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
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
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
        $data = $request->validated();

        $idPeserta = $data['id_peserta'] ?? $absen->id_peserta;
        $idJadwal = $data['id_jadwal'] ?? $absen->id_jadwal;
        $tanggal = $data['tanggal'] ?? $absen->tanggal->format('Y-m-d');

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
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Absensi berhasil dihapus'),
            new OA\Response(response: 404, description: 'Absensi tidak ditemukan'),
        ]
    )]
    public function destroy(int $id): JsonResponse
    {
        $absen = Absen::findOrFail($id);
        $lampiran = $absen->lampiran;
        $absen->delete();

        // Lampiran bisa dipakai bersama oleh catatan rentang; hapus file jika tak terpakai lagi.
        if ($lampiran && ! Absen::where('lampiran', $lampiran)->exists()) {
            Storage::disk('public')->delete($lampiran);
        }

        return response()->json(['message' => 'Data berhasil dihapus']);
    }

    // ───────────────────────────── helpers ──────────────────────────────────

    protected function relations(): array
    {
        return ['peserta.user', 'jadwal.pelatihan', 'jadwal.ruanganWorkshop'];
    }

    /**
     * Validasi apakah koordinat peserta berada dalam radius lokasi jadwal.
     *
     * @return array{error: bool, message: string, jarak_meter: ?float, radius_meter: ?int}
     */
    private function validateLocation(array $data): array
    {
        $lat = $data['latitude'] ?? null;
        $lng = $data['longitude'] ?? null;

        if ($lat === null || $lng === null) {
            return [
                'error' => true,
                'message' => 'Koordinat GPS diperlukan untuk presensi hadir. Pastikan lokasi perangkat diaktifkan.',
                'jarak_meter' => null,
                'radius_meter' => null,
            ];
        }

        $jadwal = JadwalPelatihan::find($data['id_jadwal']);

        if (! $jadwal || $jadwal->lokasi_latitude === null || $jadwal->lokasi_longitude === null) {
            return ['error' => false, 'message' => 'OK', 'jarak_meter' => null, 'radius_meter' => null];
        }

        $jarakMeter = $this->hitungJarak(
            (float) $lat, (float) $lng,
            (float) $jadwal->lokasi_latitude, (float) $jadwal->lokasi_longitude
        );

        $radiusMeter = $jadwal->radius_meter ?? self::DEFAULT_RADIUS;

        if ($jarakMeter > $radiusMeter) {
            return [
                'error' => true,
                'message' => sprintf(
                    'Anda berada %.0f meter dari lokasi pelatihan. Presensi hanya diizinkan dalam radius %d meter.',
                    $jarakMeter,
                    $radiusMeter
                ),
                'jarak_meter' => round($jarakMeter, 2),
                'radius_meter' => $radiusMeter,
            ];
        }

        return [
            'error' => false,
            'message' => 'OK',
            'jarak_meter' => round($jarakMeter, 2),
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
