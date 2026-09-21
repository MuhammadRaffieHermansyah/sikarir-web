<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdminBlkRequest;
use App\Http\Requests\UpdateAdminBlkRequest;
use App\Http\Resources\AdminBlkResource;
use App\Models\AdminBlk;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class AdminBlkController extends Controller
{
    #[OA\Get(
        path: '/api/admin-blk',
        summary: 'Ambil semua data admin BLK (paginate 15)',
        tags: ['Admin BLK'],
        security: [['sanctum' => []]],
        responses: [
            new OA\Response(response: 200, description: 'Daftar admin BLK berhasil diambil'),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
    public function index(): JsonResponse
    {
        return AdminBlkResource::collection(AdminBlk::with($this->relations())->latest()->paginate(15))->response();
    }

    #[OA\Post(
        path: '/api/admin-blk',
        summary: 'Buat data admin BLK baru',
        tags: ['Admin BLK'],
        security: [['sanctum' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['user_id'],
                properties: [
                    new OA\Property(property: 'user_id', type: 'integer'),
                    new OA\Property(property: 'jabatan', type: 'string'),
                    new OA\Property(property: 'nip', type: 'string'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Admin BLK berhasil dibuat'),
            new OA\Response(response: 422, description: 'Validasi gagal'),
        ]
    )]
    public function store(StoreAdminBlkRequest $request): JsonResponse
    {
        $admin = AdminBlk::create($request->validated());
        return (new AdminBlkResource($admin))->response()->setStatusCode(201);
    }

    #[OA\Get(
        path: '/api/admin-blk/{id}',
        summary: 'Ambil detail admin BLK berdasarkan ID',
        tags: ['Admin BLK'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'Detail admin BLK'),
            new OA\Response(response: 404, description: 'Admin BLK tidak ditemukan'),
        ]
    )]
    public function show(int $id): JsonResponse
    {
        $admin = AdminBlk::with($this->relations())->findOrFail($id);
        return (new AdminBlkResource($admin))->response();
    }

    #[OA\Put(
        path: '/api/admin-blk/{id}',
        summary: 'Update data admin BLK',
        tags: ['Admin BLK'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'jabatan', type: 'string'),
                    new OA\Property(property: 'nip', type: 'string'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Admin BLK berhasil diupdate'),
            new OA\Response(response: 404, description: 'Admin BLK tidak ditemukan'),
        ]
    )]
    public function update(UpdateAdminBlkRequest $request, int $id): JsonResponse
    {
        $admin = AdminBlk::findOrFail($id);
        $admin->update($request->validated());
        return (new AdminBlkResource($admin->fresh()->load($this->relations())))->response();
    }

    #[OA\Delete(
        path: '/api/admin-blk/{id}',
        summary: 'Hapus data admin BLK',
        tags: ['Admin BLK'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'Admin BLK berhasil dihapus'),
            new OA\Response(response: 404, description: 'Admin BLK tidak ditemukan'),
        ]
    )]
    public function destroy(int $id): JsonResponse
    {
        $admin = AdminBlk::findOrFail($id);
        $admin->delete();
        return response()->json(['message' => 'Data berhasil dihapus']);
    }

    protected function relations(): array
    {
        return ['user'];
    }
}
