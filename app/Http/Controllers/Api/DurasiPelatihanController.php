<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDurasiPelatihanRequest;
use App\Http\Requests\UpdateDurasiPelatihanRequest;
use App\Http\Resources\DurasiPelatihanResource;
use App\Models\DurasiPelatihan;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class DurasiPelatihanController extends Controller
{
    #[OA\Get(
        path: '/api/durasi-pelatihan',
        summary: 'Ambil semua data durasi pelatihan (paginate 15)',
        tags: ['Durasi Pelatihan'],
        security: [['sanctum' => []]],
        responses: [
            new OA\Response(response: 200, description: 'Daftar durasi pelatihan berhasil diambil'),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
    public function index(): JsonResponse
    {
        return DurasiPelatihanResource::collection(DurasiPelatihan::with($this->relations())->latest()->paginate(15))->response();
    }

    #[OA\Post(
        path: '/api/durasi-pelatihan',
        summary: 'Buat data durasi pelatihan baru',
        tags: ['Durasi Pelatihan'],
        security: [['sanctum' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['hari', 'jam'],
                properties: [
                    new OA\Property(property: 'hari', type: 'integer', description: 'Jumlah hari'),
                    new OA\Property(property: 'jam', type: 'integer', description: 'Jumlah jam'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Durasi pelatihan berhasil dibuat'),
            new OA\Response(response: 422, description: 'Validasi gagal'),
        ]
    )]
    public function store(StoreDurasiPelatihanRequest $request): JsonResponse
    {
        $durasi = DurasiPelatihan::create($request->validated());
        return (new DurasiPelatihanResource($durasi))->response()->setStatusCode(201);
    }

    #[OA\Get(
        path: '/api/durasi-pelatihan/{id}',
        summary: 'Ambil detail durasi pelatihan berdasarkan ID',
        tags: ['Durasi Pelatihan'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'Detail durasi pelatihan'),
            new OA\Response(response: 404, description: 'Durasi pelatihan tidak ditemukan'),
        ]
    )]
    public function show(int $id): JsonResponse
    {
        $durasi = DurasiPelatihan::with($this->relations())->findOrFail($id);
        return (new DurasiPelatihanResource($durasi))->response();
    }

    #[OA\Put(
        path: '/api/durasi-pelatihan/{id}',
        summary: 'Update data durasi pelatihan',
        tags: ['Durasi Pelatihan'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'hari', type: 'integer', description: 'Jumlah hari'),
                    new OA\Property(property: 'jam', type: 'integer', description: 'Jumlah jam'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Durasi pelatihan berhasil diupdate'),
            new OA\Response(response: 404, description: 'Durasi pelatihan tidak ditemukan'),
        ]
    )]
    public function update(UpdateDurasiPelatihanRequest $request, int $id): JsonResponse
    {
        $durasi = DurasiPelatihan::findOrFail($id);
        $durasi->update($request->validated());
        return (new DurasiPelatihanResource($durasi->fresh()->load($this->relations())))->response();
    }

    #[OA\Delete(
        path: '/api/durasi-pelatihan/{id}',
        summary: 'Hapus data durasi pelatihan',
        tags: ['Durasi Pelatihan'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'Durasi pelatihan berhasil dihapus'),
            new OA\Response(response: 404, description: 'Durasi pelatihan tidak ditemukan'),
        ]
    )]
    public function destroy(int $id): JsonResponse
    {
        $durasi = DurasiPelatihan::findOrFail($id);
        $durasi->delete();
        return response()->json(['message' => 'Data berhasil dihapus']);
    }

    protected function relations(): array
    {
        return ['pelatihan'];
    }
}