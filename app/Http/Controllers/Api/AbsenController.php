<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAbsenRequest;
use App\Http\Requests\UpdateAbsenRequest;
use App\Http\Resources\AbsenResource;
use App\Models\Absen;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class AbsenController extends Controller
{
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
        return AbsenResource::collection(Absen::with($this->relations())->latest()->paginate(15))->response();
    }

    #[OA\Post(
        path: '/api/absen',
        summary: 'Catat data absensi baru',
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
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Absensi berhasil dicatat'),
            new OA\Response(response: 422, description: 'Validasi gagal'),
        ]
    )]
    public function store(StoreAbsenRequest $request): JsonResponse
    {
        $data = $request->validated();

        $exists = Absen::where('id_peserta', $data['id_peserta'])
            ->where('id_jadwal', $data['id_jadwal'])
            ->where('tanggal', $data['tanggal'])
            ->exists();

        if ($exists) {
            abort(422, 'Data presensi untuk peserta ini pada tanggal tersebut sudah tercatat.');
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

    protected function relations(): array
    {
        return ['peserta', 'jadwal'];
    }
}
