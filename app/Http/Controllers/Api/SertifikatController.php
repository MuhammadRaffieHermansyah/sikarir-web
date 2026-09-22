<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSertifikatRequest;
use App\Http\Requests\UpdateSertifikatRequest;
use App\Http\Resources\SertifikatResource;
use App\Models\Sertifikat;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use OpenApi\Attributes as OA;

class SertifikatController extends Controller
{
    #[OA\Get(
        path: '/api/sertifikat',
        summary: 'Ambil semua data sertifikat (paginate 15)',
        tags: ['Sertifikat'],
        security: [['sanctum' => []]],
        responses: [
            new OA\Response(response: 200, description: 'Daftar sertifikat berhasil diambil'),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
    public function index(): JsonResponse
    {
        return SertifikatResource::collection(Sertifikat::with(['peserta.user', 'jadwal.pelatihan', 'admin.user'])->latest()->paginate(15))->response();
    }

    #[OA\Post(
        path: '/api/sertifikat',
        summary: 'Upload sertifikat baru untuk peserta',
        tags: ['Sertifikat'],
        security: [['sanctum' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: 'multipart/form-data',
                schema: new OA\Schema(
                    required: ['id_peserta', 'id_jadwal', 'id_admin', 'no_sertifikat', 'tanggal_terbit'],
                    properties: [
                        new OA\Property(property: 'id_peserta', type: 'integer'),
                        new OA\Property(property: 'id_jadwal', type: 'integer'),
                        new OA\Property(property: 'id_admin', type: 'integer'),
                        new OA\Property(property: 'no_sertifikat', type: 'string'),
                        new OA\Property(property: 'tanggal_terbit', type: 'string', format: 'date'),
                        new OA\Property(property: 'file_sertifikat', type: 'string', format: 'binary', description: 'File sertifikat (PDF, maks 5MB)'),
                    ]
                )
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Sertifikat berhasil diupload'),
            new OA\Response(response: 422, description: 'Validasi gagal'),
        ]
    )]
    public function store(StoreSertifikatRequest $request): JsonResponse
    {
        $data = $request->validated();

        if (Sertifikat::where('id_peserta', $data['id_peserta'])->where('id_jadwal', $data['id_jadwal'])->exists()) {
            abort(422, 'Peserta ini sudah memiliki sertifikat untuk jadwal pelatihan tersebut.');
        }

        if ($request->hasFile('file_sertifikat')) {
            $data['file_sertifikat'] = $request->file('file_sertifikat')->store('sertifikat', 'public');
        }
        $item = Sertifikat::create($data);
        return (new SertifikatResource($item->load(['peserta.user', 'jadwal.pelatihan', 'admin.user'])))->response()->setStatusCode(201);
    }

    #[OA\Get(
        path: '/api/sertifikat/{id}',
        summary: 'Ambil detail sertifikat berdasarkan ID',
        tags: ['Sertifikat'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'Detail sertifikat'),
            new OA\Response(response: 404, description: 'Sertifikat tidak ditemukan'),
        ]
    )]
    public function show(int $id): JsonResponse
    {
        return (new SertifikatResource(Sertifikat::with(['peserta.user', 'jadwal.pelatihan', 'admin.user'])->findOrFail($id)))->response();
    }

    #[OA\Post(
        path: '/api/sertifikat/{id}',
        summary: 'Update data sertifikat (gunakan POST dengan _method=PUT untuk upload file)',
        tags: ['Sertifikat'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: 'multipart/form-data',
                schema: new OA\Schema(
                    properties: [
                        new OA\Property(property: 'id_peserta', type: 'integer'),
                        new OA\Property(property: 'id_jadwal', type: 'integer'),
                        new OA\Property(property: 'id_admin', type: 'integer'),
                        new OA\Property(property: 'no_sertifikat', type: 'string'),
                        new OA\Property(property: 'tanggal_terbit', type: 'string', format: 'date'),
                        new OA\Property(property: 'file_sertifikat', type: 'string', format: 'binary'),
                        new OA\Property(property: '_method', type: 'string', default: 'PUT'),
                    ]
                )
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Sertifikat berhasil diupdate'),
            new OA\Response(response: 404, description: 'Sertifikat tidak ditemukan'),
        ]
    )]
    public function update(UpdateSertifikatRequest $request, int $id): JsonResponse
    {
        $item = Sertifikat::findOrFail($id);
        $data = $request->validated();

        $idPeserta = $data['id_peserta'] ?? $item->id_peserta;
        $idJadwal = $data['id_jadwal'] ?? $item->id_jadwal;

        if (Sertifikat::where('id_peserta', $idPeserta)->where('id_jadwal', $idJadwal)->where('id_sertifikat', '!=', $item->id_sertifikat)->exists()) {
            abort(422, 'Peserta ini sudah memiliki sertifikat untuk jadwal pelatihan tersebut.');
        }

        if ($request->hasFile('file_sertifikat')) {
            if ($item->file_sertifikat) Storage::disk('public')->delete($item->file_sertifikat);
            $data['file_sertifikat'] = $request->file('file_sertifikat')->store('sertifikat', 'public');
        }
        $item->update($data);
        return (new SertifikatResource($item->fresh()->load(['peserta.user', 'jadwal.pelatihan', 'admin.user'])))->response();
    }

    #[OA\Delete(
        path: '/api/sertifikat/{id}',
        summary: 'Hapus data sertifikat beserta filenya',
        tags: ['Sertifikat'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'Sertifikat berhasil dihapus'),
            new OA\Response(response: 404, description: 'Sertifikat tidak ditemukan'),
        ]
    )]
    public function destroy(int $id): JsonResponse
    {
        $item = Sertifikat::findOrFail($id);
        if ($item->file_sertifikat) Storage::disk('public')->delete($item->file_sertifikat);
        $item->delete();
        return response()->json(['message' => 'Data berhasil dihapus']);
    }
}
