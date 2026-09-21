<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePesertaRequest;
use App\Http\Requests\UpdatePesertaRequest;
use App\Http\Resources\PesertaResource;
use App\Models\Peserta;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class PesertaController extends Controller
{
    #[OA\Get(
        path: '/api/pesertas',
        summary: 'Ambil semua data peserta (paginate 15)',
        tags: ['Peserta'],
        security: [['sanctum' => []]],
        responses: [
            new OA\Response(response: 200, description: 'Daftar peserta berhasil diambil'),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
    public function index(): JsonResponse
    {
        return PesertaResource::collection(Peserta::with($this->relations())->latest()->paginate(15))->response();
    }

    #[OA\Post(
        path: '/api/pesertas',
        summary: 'Buat data peserta baru',
        tags: ['Peserta'],
        security: [['sanctum' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['user_id'],
                properties: [
                    new OA\Property(property: 'user_id', type: 'integer'),
                    new OA\Property(property: 'nik', type: 'string'),
                    new OA\Property(property: 'alamat', type: 'string'),
                    new OA\Property(property: 'pendidikan_terakhir', type: 'string'),
                    new OA\Property(property: 'keahlian', type: 'string'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Peserta berhasil dibuat'),
            new OA\Response(response: 422, description: 'Validasi gagal'),
        ]
    )]
    public function store(StorePesertaRequest $request): JsonResponse
    {
        $peserta = Peserta::create($request->validated());
        return (new PesertaResource($peserta))->response()->setStatusCode(201);
    }

    #[OA\Get(
        path: '/api/pesertas/{id}',
        summary: 'Ambil detail peserta berdasarkan ID',
        tags: ['Peserta'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'Detail peserta'),
            new OA\Response(response: 404, description: 'Peserta tidak ditemukan'),
        ]
    )]
    public function show(int $id): JsonResponse
    {
        $peserta = Peserta::with($this->relations())->findOrFail($id);
        return (new PesertaResource($peserta))->response();
    }

    #[OA\Put(
        path: '/api/pesertas/{id}',
        summary: 'Update data peserta',
        tags: ['Peserta'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'nik', type: 'string'),
                    new OA\Property(property: 'alamat', type: 'string'),
                    new OA\Property(property: 'pendidikan_terakhir', type: 'string'),
                    new OA\Property(property: 'keahlian', type: 'string'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Peserta berhasil diupdate'),
            new OA\Response(response: 404, description: 'Peserta tidak ditemukan'),
        ]
    )]
    public function update(UpdatePesertaRequest $request, int $id): JsonResponse
    {
        $peserta = Peserta::findOrFail($id);
        $peserta->update($request->validated());
        return (new PesertaResource($peserta->fresh()->load($this->relations())))->response();
    }

    #[OA\Delete(
        path: '/api/pesertas/{id}',
        summary: 'Hapus data peserta',
        tags: ['Peserta'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'Peserta berhasil dihapus'),
            new OA\Response(response: 404, description: 'Peserta tidak ditemukan'),
        ]
    )]
    public function destroy(int $id): JsonResponse
    {
        $peserta = Peserta::findOrFail($id);
        $peserta->delete();
        return response()->json(['message' => 'Data berhasil dihapus']);
    }

    protected function relations(): array
    {
        return ['user', 'admin'];
    }
}
