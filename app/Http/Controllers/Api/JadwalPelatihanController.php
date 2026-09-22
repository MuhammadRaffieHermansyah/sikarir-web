<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreJadwalPelatihanRequest;
use App\Http\Requests\UpdateJadwalPelatihanRequest;
use App\Http\Resources\JadwalPelatihanResource;
use App\Models\JadwalPelatihan;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class JadwalPelatihanController extends Controller
{
    #[OA\Get(
        path: '/api/jadwal-pelatihan',
        summary: 'Ambil semua jadwal pelatihan (paginate 15)',
        tags: ['Jadwal Pelatihan'],
        security: [['sanctum' => []]],
        responses: [
            new OA\Response(response: 200, description: 'Daftar jadwal pelatihan berhasil diambil'),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
    public function index(): JsonResponse
    {
        return JadwalPelatihanResource::collection(JadwalPelatihan::with($this->relations())->latest()->paginate(15))->response();
    }

    #[OA\Post(
        path: '/api/jadwal-pelatihan',
        summary: 'Buat jadwal pelatihan baru',
        tags: ['Jadwal Pelatihan'],
        security: [['sanctum' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['id_pelatihan', 'tanggal_mulai', 'tanggal_selesai'],
                properties: [
                    new OA\Property(property: 'id_pelatihan', type: 'integer'),
                    new OA\Property(property: 'tanggal_mulai', type: 'string', format: 'date'),
                    new OA\Property(property: 'tanggal_selesai', type: 'string', format: 'date'),
                    new OA\Property(property: 'jam_mulai', type: 'string', example: '08:00'),
                    new OA\Property(property: 'jam_selesai', type: 'string', example: '15:30'),
                    new OA\Property(property: 'instruktur', type: 'string'),
                    new OA\Property(property: 'tempat', type: 'string'),
                    new OA\Property(property: 'status', type: 'string', enum: ['tersedia', 'berlangsung', 'selesai']),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Jadwal pelatihan berhasil dibuat'),
            new OA\Response(response: 422, description: 'Validasi gagal'),
        ]
    )]
    public function store(StoreJadwalPelatihanRequest $request): JsonResponse
    {
        $jadwal = JadwalPelatihan::create($request->validated());
        return (new JadwalPelatihanResource($jadwal))->response()->setStatusCode(201);
    }

    #[OA\Get(
        path: '/api/jadwal-pelatihan/{id}',
        summary: 'Ambil detail jadwal pelatihan berdasarkan ID',
        tags: ['Jadwal Pelatihan'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'Detail jadwal pelatihan'),
            new OA\Response(response: 404, description: 'Jadwal tidak ditemukan'),
        ]
    )]
    public function show(int $id): JsonResponse
    {
        $jadwal = JadwalPelatihan::with($this->relations())->findOrFail($id);
        return (new JadwalPelatihanResource($jadwal))->response();
    }

    #[OA\Put(
        path: '/api/jadwal-pelatihan/{id}',
        summary: 'Update jadwal pelatihan',
        tags: ['Jadwal Pelatihan'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'id_pelatihan', type: 'integer'),
                    new OA\Property(property: 'tanggal_mulai', type: 'string', format: 'date'),
                    new OA\Property(property: 'tanggal_selesai', type: 'string', format: 'date'),
                    new OA\Property(property: 'jam_mulai', type: 'string', example: '08:00'),
                    new OA\Property(property: 'jam_selesai', type: 'string', example: '15:30'),
                    new OA\Property(property: 'instruktur', type: 'string'),
                    new OA\Property(property: 'tempat', type: 'string'),
                    new OA\Property(property: 'status', type: 'string', enum: ['tersedia', 'berlangsung', 'selesai']),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Jadwal berhasil diupdate'),
            new OA\Response(response: 404, description: 'Jadwal tidak ditemukan'),
        ]
    )]
    public function update(UpdateJadwalPelatihanRequest $request, int $id): JsonResponse
    {
        $jadwal = JadwalPelatihan::findOrFail($id);
        $jadwal->update($request->validated());
        return (new JadwalPelatihanResource($jadwal->fresh()->load($this->relations())))->response();
    }

    #[OA\Delete(
        path: '/api/jadwal-pelatihan/{id}',
        summary: 'Hapus jadwal pelatihan',
        tags: ['Jadwal Pelatihan'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'Jadwal berhasil dihapus'),
            new OA\Response(response: 404, description: 'Jadwal tidak ditemukan'),
        ]
    )]
    public function destroy(int $id): JsonResponse
    {
        $jadwal = JadwalPelatihan::findOrFail($id);
        $jadwal->delete();
        return response()->json(['message' => 'Data berhasil dihapus']);
    }

    protected function relations(): array
    {
        return ['pelatihan'];
    }
}
