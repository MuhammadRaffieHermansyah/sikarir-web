<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMitraRequest;
use App\Http\Requests\UpdateMitraRequest;
use App\Http\Resources\MitraResource;
use App\Models\Mitra;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class MitraController extends Controller
{
    #[OA\Get(
        path: '/api/mitras',
        summary: 'Ambil semua data mitra (paginate 15)',
        tags: ['Mitra'],
        security: [['sanctum' => []]],
        responses: [
            new OA\Response(response: 200, description: 'Daftar mitra berhasil diambil'),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
    public function index(): JsonResponse
    {
        return MitraResource::collection(Mitra::with($this->relations())->latest()->paginate(15))->response();
    }

    #[OA\Post(
        path: '/api/mitras',
        summary: 'Buat data mitra baru',
        tags: ['Mitra'],
        security: [['sanctum' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['user_id', 'nama_perusahaan'],
                properties: [
                    new OA\Property(property: 'user_id', type: 'integer'),
                    new OA\Property(property: 'nama_perusahaan', type: 'string'),
                    new OA\Property(property: 'bidang_usaha', type: 'string'),
                    new OA\Property(property: 'alamat', type: 'string'),
                    new OA\Property(property: 'telepon', type: 'string'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Mitra berhasil dibuat'),
            new OA\Response(response: 422, description: 'Validasi gagal'),
        ]
    )]
    public function store(StoreMitraRequest $request): JsonResponse
    {
        $mitra = Mitra::create($request->validated());
        return (new MitraResource($mitra))->response()->setStatusCode(201);
    }

    #[OA\Get(
        path: '/api/mitras/{id}',
        summary: 'Ambil detail mitra berdasarkan ID',
        tags: ['Mitra'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'Detail mitra'),
            new OA\Response(response: 404, description: 'Mitra tidak ditemukan'),
        ]
    )]
    public function show(int $id): JsonResponse
    {
        $mitra = Mitra::with($this->relations())->findOrFail($id);
        return (new MitraResource($mitra))->response();
    }

    #[OA\Put(
        path: '/api/mitras/{id}',
        summary: 'Update data mitra',
        tags: ['Mitra'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'nama_perusahaan', type: 'string'),
                    new OA\Property(property: 'bidang_usaha', type: 'string'),
                    new OA\Property(property: 'alamat', type: 'string'),
                    new OA\Property(property: 'telepon', type: 'string'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Mitra berhasil diupdate'),
            new OA\Response(response: 404, description: 'Mitra tidak ditemukan'),
        ]
    )]
    public function update(UpdateMitraRequest $request, int $id): JsonResponse
    {
        $mitra = Mitra::findOrFail($id);
        $mitra->update($request->validated());
        return (new MitraResource($mitra->fresh()->load($this->relations())))->response();
    }

    #[OA\Delete(
        path: '/api/mitras/{id}',
        summary: 'Hapus data mitra',
        tags: ['Mitra'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'Mitra berhasil dihapus'),
            new OA\Response(response: 404, description: 'Mitra tidak ditemukan'),
        ]
    )]
    public function destroy(int $id): JsonResponse
    {
        $mitra = Mitra::findOrFail($id);
        $mitra->delete();
        return response()->json(['message' => 'Data berhasil dihapus']);
    }

    protected function relations(): array
    {
        return ['user'];
    }
}
