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

    #[OA\Get(
        path: '/api/pesertas/me',
        summary: 'Ambil profil peserta untuk user yang sedang login',
        tags: ['Peserta'],
        security: [['sanctum' => []]],
        responses: [
            new OA\Response(response: 200, description: 'Data peserta user login'),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
    public function me(\Illuminate\Http\Request $request): JsonResponse
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $peserta = Peserta::firstOrCreate(
            ['id_user' => $user->id],
            [
                'nomor_peserta' => 'PST-' . date('Ymd') . '-' . str_pad($user->id, 4, '0', STR_PAD_LEFT),
                'jenis_kelamin' => 'Laki-laki',
            ]
        );

        return (new PesertaResource($peserta->load($this->relations())))->response();
    }

    #[OA\Put(
        path: '/api/pesertas/me',
        summary: 'Lengkapi atau update data diri peserta yang sedang login',
        tags: ['Peserta'],
        security: [['sanctum' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['jenis_kelamin', 'nomor_kk', 'nomor_wa', 'tanggal_lahir', 'tempat_lahir', 'alamat_lengkap', 'pendidikan_terakhir'],
                properties: [
                    new OA\Property(property: 'jenis_kelamin', type: 'string', enum: ['Laki-laki', 'Perempuan']),
                    new OA\Property(property: 'nomor_kk', type: 'string', example: '3509123456789001'),
                    new OA\Property(property: 'nomor_wa', type: 'string', example: '081234567890'),
                    new OA\Property(property: 'tanggal_lahir', type: 'string', format: 'date', example: '2002-05-15'),
                    new OA\Property(property: 'tempat_lahir', type: 'string', example: 'Jember'),
                    new OA\Property(property: 'alamat_lengkap', type: 'string', example: 'Jl. Basuki Rahmat No. 10, Jember'),
                    new OA\Property(property: 'pendidikan_terakhir', type: 'string', example: 'SMA / SMK'),
                    new OA\Property(property: 'pendidikan_sekarang', type: 'string', example: 'Mahasiswa'),
                    new OA\Property(property: 'jurusan', type: 'string', example: 'Teknik Komputer & Jaringan'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Data diri peserta berhasil diperbarui'),
            new OA\Response(response: 422, description: 'Validasi gagal'),
        ]
    )]
    public function updateMe(\Illuminate\Http\Request $request): JsonResponse
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $validated = $request->validate([
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'nomor_kk' => 'required|string|max:30',
            'nomor_wa' => 'required|string|max:30',
            'tanggal_lahir' => 'required|date',
            'tempat_lahir' => 'required|string|max:100',
            'alamat_lengkap' => 'required|string',
            'pendidikan_terakhir' => 'required|string|max:100',
            'pendidikan_sekarang' => 'nullable|string|max:100',
            'jurusan' => 'nullable|string|max:150',
            'pas_foto' => 'nullable|string',
        ]);

        $peserta = Peserta::firstOrCreate(
            ['id_user' => $user->id],
            [
                'nomor_peserta' => 'PST-' . date('Ymd') . '-' . str_pad($user->id, 4, '0', STR_PAD_LEFT),
                'jenis_kelamin' => $validated['jenis_kelamin'],
            ]
        );

        $peserta->update($validated);

        return (new PesertaResource($peserta->fresh()->load($this->relations())))->response();
    }

    #[OA\Post(
        path: '/api/pesertas',
        summary: 'Buat data peserta baru',
        tags: ['Peserta'],
        security: [['sanctum' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['id_user', 'nomor_peserta', 'jenis_kelamin'],
                properties: [
                    new OA\Property(property: 'id_user', type: 'integer'),
                    new OA\Property(property: 'id_admin', type: 'integer'),
                    new OA\Property(property: 'nomor_peserta', type: 'string'),
                    new OA\Property(property: 'jenis_kelamin', type: 'string', enum: ['Laki-laki', 'Perempuan']),
                    new OA\Property(property: 'nomor_kk', type: 'string'),
                    new OA\Property(property: 'nomor_wa', type: 'string'),
                    new OA\Property(property: 'tanggal_lahir', type: 'string', format: 'date'),
                    new OA\Property(property: 'tempat_lahir', type: 'string'),
                    new OA\Property(property: 'alamat_lengkap', type: 'string'),
                    new OA\Property(property: 'pendidikan_terakhir', type: 'string'),
                    new OA\Property(property: 'pendidikan_sekarang', type: 'string'),
                    new OA\Property(property: 'jurusan', type: 'string'),
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
                    new OA\Property(property: 'id_user', type: 'integer'),
                    new OA\Property(property: 'id_admin', type: 'integer'),
                    new OA\Property(property: 'nomor_peserta', type: 'string'),
                    new OA\Property(property: 'jenis_kelamin', type: 'string', enum: ['Laki-laki', 'Perempuan']),
                    new OA\Property(property: 'nomor_kk', type: 'string'),
                    new OA\Property(property: 'nomor_wa', type: 'string'),
                    new OA\Property(property: 'tanggal_lahir', type: 'string', format: 'date'),
                    new OA\Property(property: 'tempat_lahir', type: 'string'),
                    new OA\Property(property: 'alamat_lengkap', type: 'string'),
                    new OA\Property(property: 'pendidikan_terakhir', type: 'string'),
                    new OA\Property(property: 'pendidikan_sekarang', type: 'string'),
                    new OA\Property(property: 'jurusan', type: 'string'),
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
