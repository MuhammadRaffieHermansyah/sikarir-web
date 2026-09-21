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
                required: ['peserta_id', 'jadwal_id', 'tanggal', 'status'],
                properties: [
                    new OA\Property(property: 'peserta_id', type: 'integer'),
                    new OA\Property(property: 'jadwal_id', type: 'integer'),
                    new OA\Property(property: 'tanggal', type: 'string', format: 'date'),
                    new OA\Property(property: 'status', type: 'string', enum: ['hadir', 'izin', 'alpha']),
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
        $absen = Absen::create($request->validated());
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
                    new OA\Property(property: 'tanggal', type: 'string', format: 'date'),
                    new OA\Property(property: 'status', type: 'string', enum: ['hadir', 'izin', 'alpha']),
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
        $absen->update($request->validated());
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
