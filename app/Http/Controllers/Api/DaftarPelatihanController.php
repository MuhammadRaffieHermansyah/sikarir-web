<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDaftarPelatihanRequest;
use App\Http\Requests\UpdateDaftarPelatihanRequest;
use App\Http\Resources\DaftarPelatihanResource;
use App\Models\DaftarPelatihan;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class DaftarPelatihanController extends Controller
{
    #[OA\Get(
        path: '/api/pelatihan',
        summary: 'Ambil semua data pelatihan (paginate 15)',
        tags: ['Pelatihan'],
        security: [['sanctum' => []]],
        responses: [
            new OA\Response(response: 200, description: 'Daftar pelatihan berhasil diambil'),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
    public function index(): JsonResponse
    {
        return DaftarPelatihanResource::collection(DaftarPelatihan::with($this->relations())->latest()->paginate(15))->response();
    }

    #[OA\Post(
        path: '/api/pelatihan',
        summary: 'Buat data pelatihan baru',
        tags: ['Pelatihan'],
        security: [['sanctum' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['id_admin', 'nama_pelatihan', 'kuota'],
                properties: [
                    new OA\Property(property: 'id_admin', type: 'integer'),
                    new OA\Property(property: 'nama_pelatihan', type: 'string'),
                    new OA\Property(property: 'deskripsi_pelatihan', type: 'string'),
                    new OA\Property(property: 'durasi_lp', type: 'string'),
                    new OA\Property(property: 'kuota', type: 'integer'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Pelatihan berhasil dibuat'),
            new OA\Response(response: 422, description: 'Validasi gagal'),
        ]
    )]
    public function store(StoreDaftarPelatihanRequest $request): JsonResponse
    {
        $pelatihan = DaftarPelatihan::create($request->validated());
        return (new DaftarPelatihanResource($pelatihan))->response()->setStatusCode(201);
    }

    #[OA\Get(
        path: '/api/pelatihan/{id}',
        summary: 'Ambil detail pelatihan berdasarkan ID',
        tags: ['Pelatihan'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'Detail pelatihan'),
            new OA\Response(response: 404, description: 'Pelatihan tidak ditemukan'),
        ]
    )]
    public function show(int $id): JsonResponse
    {
        $pelatihan = DaftarPelatihan::with($this->relations())->findOrFail($id);
        return (new DaftarPelatihanResource($pelatihan))->response();
    }

    #[OA\Put(
        path: '/api/pelatihan/{id}',
        summary: 'Update data pelatihan',
        tags: ['Pelatihan'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'id_admin', type: 'integer'),
                    new OA\Property(property: 'nama_pelatihan', type: 'string'),
                    new OA\Property(property: 'deskripsi_pelatihan', type: 'string'),
                    new OA\Property(property: 'durasi_lp', type: 'string'),
                    new OA\Property(property: 'kuota', type: 'integer'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Pelatihan berhasil diupdate'),
            new OA\Response(response: 404, description: 'Pelatihan tidak ditemukan'),
        ]
    )]
    public function update(UpdateDaftarPelatihanRequest $request, int $id): JsonResponse
    {
        $pelatihan = DaftarPelatihan::findOrFail($id);
        $pelatihan->update($request->validated());
        return (new DaftarPelatihanResource($pelatihan->fresh()->load($this->relations())))->response();
    }

    #[OA\Delete(
        path: '/api/pelatihan/{id}',
        summary: 'Hapus data pelatihan',
        tags: ['Pelatihan'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'Pelatihan berhasil dihapus'),
            new OA\Response(response: 404, description: 'Pelatihan tidak ditemukan'),
        ]
    )]
    public function destroy(int $id): JsonResponse
    {
        $pelatihan = DaftarPelatihan::findOrFail($id);
        $pelatihan->delete();
        return response()->json(['message' => 'Data berhasil dihapus']);
    }

    protected function relations(): array
    {
        return ['admin'];
    }
}
