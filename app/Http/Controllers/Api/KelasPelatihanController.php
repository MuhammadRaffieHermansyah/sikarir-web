<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreKelasPelatihanRequest;
use App\Http\Requests\UpdateKelasPelatihanRequest;
use App\Http\Resources\KelasPelatihanResource;
use App\Models\KelasPelatihan;
use App\Models\JadwalPelatihan;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use OpenApi\Attributes as OA;

class KelasPelatihanController extends Controller
{
    #[OA\Get(
        path: '/api/kelas-pelatihan',
        summary: 'Ambil semua data kelas pelatihan (paginate 15)',
        tags: ['Kelas Pelatihan'],
        security: [['sanctum' => []]],
        responses: [
            new OA\Response(response: 200, description: 'Daftar kelas pelatihan berhasil diambil'),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
    public function index(): JsonResponse
    {
        return KelasPelatihanResource::collection(KelasPelatihan::with(['peserta.user', 'jadwal.pelatihan'])->latest()->paginate(15))->response();
    }

    #[OA\Post(
        path: '/api/kelas-pelatihan',
        summary: 'Daftarkan peserta ke kelas pelatihan',
        tags: ['Kelas Pelatihan'],
        security: [['sanctum' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['id_peserta', 'id_jadwal'],
                properties: [
                    new OA\Property(property: 'id_peserta', type: 'integer', description: 'ID peserta yang akan didaftarkan'),
                    new OA\Property(property: 'id_jadwal', type: 'integer', description: 'ID jadwal pelatihan yang dituju'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Peserta berhasil didaftarkan ke kelas'),
            new OA\Response(response: 422, description: 'Jadwal tidak tersedia / kuota penuh / peserta sudah terdaftar'),
        ]
    )]
    public function store(StoreKelasPelatihanRequest $request): JsonResponse
    {
        $data = $request->validated();
        $item = DB::transaction(function () use ($data) {
            $jadwal = JadwalPelatihan::with('pelatihan')->lockForUpdate()->findOrFail($data['id_jadwal']);
            if ($jadwal->status !== 'tersedia') abort(422, 'Jadwal pelatihan tidak tersedia.');
            if (KelasPelatihan::where('id_peserta', $data['id_peserta'])->where('id_jadwal', $data['id_jadwal'])->exists()) abort(422, 'Peserta sudah terdaftar pada jadwal ini.');
            $count = KelasPelatihan::where('id_jadwal', $data['id_jadwal'])->count();
            if ($count >= $jadwal->pelatihan->kuota) abort(422, 'Kuota pelatihan sudah penuh.');
            return KelasPelatihan::create($data);
        });
        return (new KelasPelatihanResource($item->load(['peserta.user', 'jadwal.pelatihan'])))->response()->setStatusCode(201);
    }

    #[OA\Get(
        path: '/api/kelas-pelatihan/{id}',
        summary: 'Ambil detail kelas pelatihan berdasarkan ID',
        tags: ['Kelas Pelatihan'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'Detail kelas pelatihan'),
            new OA\Response(response: 404, description: 'Kelas tidak ditemukan'),
        ]
    )]
    public function show(int $id): JsonResponse
    {
        return (new KelasPelatihanResource(KelasPelatihan::with(['peserta.user', 'jadwal.pelatihan'])->findOrFail($id)))->response();
    }

    #[OA\Put(
        path: '/api/kelas-pelatihan/{id}',
        summary: 'Update data kelas pelatihan',
        tags: ['Kelas Pelatihan'],
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
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Kelas berhasil diupdate'),
            new OA\Response(response: 404, description: 'Kelas tidak ditemukan'),
        ]
    )]
    public function update(UpdateKelasPelatihanRequest $request, int $id): JsonResponse
    {
        $item = KelasPelatihan::findOrFail($id);
        $data = $request->validated();

        $idPeserta = $data['id_peserta'] ?? $item->id_peserta;
        $idJadwal = $data['id_jadwal'] ?? $item->id_jadwal;

        if (($idPeserta != $item->id_peserta || $idJadwal != $item->id_jadwal) &&
            KelasPelatihan::where('id_peserta', $idPeserta)->where('id_jadwal', $idJadwal)->where('id_kelas', '!=', $item->id_kelas)->exists()) {
            abort(422, 'Peserta sudah terdaftar pada jadwal ini.');
        }

        if ($idJadwal != $item->id_jadwal) {
            $jadwal = JadwalPelatihan::with('pelatihan')->findOrFail($idJadwal);
            if ($jadwal->status !== 'tersedia') abort(422, 'Jadwal pelatihan tujuan tidak tersedia.');
            $count = KelasPelatihan::where('id_jadwal', $idJadwal)->count();
            if ($jadwal->pelatihan && $count >= $jadwal->pelatihan->kuota) abort(422, 'Kuota pelatihan tujuan sudah penuh.');
        }

        $item->update($data);
        return (new KelasPelatihanResource($item->fresh()->load(['peserta.user', 'jadwal.pelatihan'])))->response();
    }

    #[OA\Delete(
        path: '/api/kelas-pelatihan/{id}',
        summary: 'Hapus data kelas pelatihan',
        tags: ['Kelas Pelatihan'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'Kelas berhasil dihapus'),
            new OA\Response(response: 404, description: 'Kelas tidak ditemukan'),
        ]
    )]
    public function destroy(int $id): JsonResponse
    {
        KelasPelatihan::findOrFail($id)->delete();
        return response()->json(['message' => 'Data berhasil dihapus']);
    }
}
