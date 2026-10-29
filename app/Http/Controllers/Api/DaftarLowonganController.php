<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDaftarLowonganRequest;
use App\Http\Requests\UpdateDaftarLowonganRequest;
use App\Http\Resources\DaftarLowonganResource;
use App\Models\DaftarLowongan;
use App\Models\LamaranLowongan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
                required: ['judul_lowongan'],
                properties: [
                    new OA\Property(property: 'id_mitra', type: 'integer'),
                    new OA\Property(property: 'judul_lowongan', type: 'string'),
                    new OA\Property(property: 'lokasi', type: 'string'),
                    new OA\Property(property: 'deskripsi', type: 'string'),
                    new OA\Property(property: 'kualifikasi', type: 'string'),
                    new OA\Property(property: 'tanggal_posting', type: 'string', format: 'date'),
                    new OA\Property(property: 'status', type: 'string', enum: ['aktif', 'ditutup', 'draft']),
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
        $data = $request->validated();
        if (empty($data['id_mitra']) && auth()->user()?->mitra) {
            $data['id_mitra'] = auth()->user()->mitra->id_mitra;
        }

        $lowongan = DaftarLowongan::create($data);
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
                    new OA\Property(property: 'id_mitra', type: 'integer'),
                    new OA\Property(property: 'judul_lowongan', type: 'string'),
                    new OA\Property(property: 'lokasi', type: 'string'),
                    new OA\Property(property: 'deskripsi', type: 'string'),
                    new OA\Property(property: 'kualifikasi', type: 'string'),
                    new OA\Property(property: 'tanggal_posting', type: 'string', format: 'date'),
                    new OA\Property(property: 'status', type: 'string', enum: ['aktif', 'ditutup', 'draft']),
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

    #[OA\Post(
        path: '/api/lowongan/{id}/lamar',
        summary: 'Kirim lamaran kerja untuk posisi lowongan tertentu',
        tags: ['Lowongan'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: 201, description: 'Lamaran berhasil dikirim'),
            new OA\Response(response: 422, description: 'Profil belum lengkap atau sudah melamar'),
        ]
    )]
    public function lamar(Request $request, int $id): JsonResponse
    {
        $user = $request->user();
        $peserta = $user?->peserta;

        if (!$peserta) {
            return response()->json([
                'message' => 'Akun Anda belum terdaftar sebagai peserta BLK.',
            ], 422);
        }

        if (!$peserta->isProfileComplete()) {
            return response()->json([
                'message' => 'Profil Anda belum lengkap. Silakan lengkapi data diri Anda sebelum melamar lowongan pekerjaan.',
                'need_profile_completion' => true,
            ], 422);
        }

        $lowongan = DaftarLowongan::findOrFail($id);

        if ($lowongan->status !== 'aktif') {
            return response()->json([
                'message' => 'Lowongan ini sudah ditutup atau tidak aktif.',
            ], 422);
        }

        $sudahMelamar = LamaranLowongan::where('id_lowongan', $id)
            ->where('id_peserta', $peserta->id_peserta)
            ->exists();

        if ($sudahMelamar) {
            return response()->json([
                'message' => 'Anda sudah pernah mengajukan lamaran untuk lowongan ini.',
            ], 422);
        }

        $lamaran = LamaranLowongan::create([
            'id_lowongan'     => $id,
            'id_peserta'      => $peserta->id_peserta,
            'tanggal_melamar' => now()->toDateString(),
            'status'          => 'melamar',
            'catatan_pelamar' => $request->input('catatan'),
            'resume_url'      => $request->input('resume_url'),
        ]);

        return response()->json([
            'message' => 'Lamaran Anda berhasil dikirim ke perusahaan.',
            'data'    => $lamaran->load(['lowongan.mitra', 'peserta.user']),
        ], 201);
    }

    #[OA\Get(
        path: '/api/lowongan/my-applications',
        summary: 'Ambil daftar riwayat lamaran yang diajukan oleh peserta login',
        tags: ['Lowongan'],
        security: [['sanctum' => []]],
        responses: [
            new OA\Response(response: 200, description: 'Daftar riwayat lamaran peserta'),
        ]
    )]
    public function myApplications(Request $request): JsonResponse
    {
        $user = $request->user();
        $peserta = $user?->peserta;

        if (!$peserta) {
            return response()->json([
                'message' => 'Data peserta tidak ditemukan.',
                'data'    => [],
            ], 200);
        }

        $lamarans = LamaranLowongan::with([
            'lowongan.mitra',
        ])
        ->where('id_peserta', $peserta->id_peserta)
        ->latest('id_lamaran')
        ->get();

        return response()->json([
            'message' => 'Daftar riwayat lamaran peserta berhasil diambil.',
            'data'    => $lamarans,
        ], 200);
    }

    protected function relations(): array
    {
        return ['mitra'];
    }
}
