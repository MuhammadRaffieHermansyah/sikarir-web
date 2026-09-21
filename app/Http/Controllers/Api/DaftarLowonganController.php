<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDaftarLowonganRequest;
use App\Http\Requests\UpdateDaftarLowonganRequest;
use App\Http\Resources\DaftarLowonganResource;
use App\Models\DaftarLowongan;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class DaftarLowonganController extends Controller
{
    #[OA\Get(
        path: '/api/lowongan',
        summary: 'Ambil semua data daftar lowongan (paginate 15)',
        tags: ['Lowongan'],
        security: [['sanctum' => []]],
        responses: [
            new OA\Response(response: 200, description: 'Daftar lowongan berhasil diambil'),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
    public function index(): JsonResponse
    {
        return DaftarLowonganResource::collection(DaftarLowongan::with($this->relations())->latest()->paginate(15))->response();
    }

    #[OA\Post(
        path: '/api/lowongan',
        summary: 'Buat data lowongan baru',
        tags: ['Lowongan'],
        security: [['sanctum' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['mitra_id', 'judul'],
                properties: [
                    new OA\Property(property: 'mitra_id', type: 'integer'),
                    new OA\Property(property: 'admin_id', type: 'integer'),
                    new OA\Property(property: 'judul', type: 'string'),
                    new OA\Property(property: 'deskripsi', type: 'string'),
                    new OA\Property(property: 'gaji', type: 'number'),
                    new OA\Property(property: 'lokasi', type: 'string'),
                    new OA\Property(property: 'deadline', type: 'string', format: 'date'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Lowongan berhasil dibuat'),
            new OA\Response(response: 422, description: 'Validasi gagal'),
        ]
    )]
    public function store(StoreDaftarLowonganRequest $request): JsonResponse
    {
        $lowongan = DaftarLowongan::create($request->validated());
        return (new DaftarLowonganResource($lowongan))->response()->setStatusCode(201);
    }

    #[OA\Get(
        path: '/api/lowongan/{id}',
        summary: 'Ambil detail lowongan berdasarkan ID',
        tags: ['Lowongan'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'Detail lowongan'),
            new OA\Response(response: 404, description: 'Lowongan tidak ditemukan'),
        ]
    )]
    public function show(int $id): JsonResponse
    {
        $lowongan = DaftarLowongan::with($this->relations())->findOrFail($id);
        return (new DaftarLowonganResource($lowongan))->response();
    }

    #[OA\Put(
        path: '/api/lowongan/{id}',
        summary: 'Update data lowongan',
        tags: ['Lowongan'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'judul', type: 'string'),
                    new OA\Property(property: 'deskripsi', type: 'string'),
                    new OA\Property(property: 'gaji', type: 'number'),
                    new OA\Property(property: 'lokasi', type: 'string'),
                    new OA\Property(property: 'deadline', type: 'string', format: 'date'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Lowongan berhasil diupdate'),
            new OA\Response(response: 404, description: 'Lowongan tidak ditemukan'),
        ]
    )]
    public function update(UpdateDaftarLowonganRequest $request, int $id): JsonResponse
    {
        $lowongan = DaftarLowongan::findOrFail($id);
        $lowongan->update($request->validated());
        return (new DaftarLowonganResource($lowongan->fresh()->load($this->relations())))->response();
    }

    #[OA\Delete(
        path: '/api/lowongan/{id}',
        summary: 'Hapus data lowongan',
        tags: ['Lowongan'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'Lowongan berhasil dihapus'),
            new OA\Response(response: 404, description: 'Lowongan tidak ditemukan'),
        ]
    )]
    public function destroy(int $id): JsonResponse
    {
        $lowongan = DaftarLowongan::findOrFail($id);
        $lowongan->delete();
        return response()->json(['message' => 'Data berhasil dihapus']);
    }

    protected function relations(): array
    {
        return ['mitra', 'admin'];
    }
}
