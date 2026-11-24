<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInstrukturRequest;
use App\Http\Requests\UpdateInstrukturRequest;
use App\Http\Resources\InstrukturResource;
use App\Models\Instruktur;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use OpenApi\Attributes as OA;

class InstrukturController extends Controller
{
    #[OA\Get(
        path: '/api/instruktur',
        summary: 'Ambil semua data instruktur (paginate 15)',
        tags: ['Instruktur'],
        security: [['sanctum' => []]],
        responses: [
            new OA\Response(response: 200, description: 'Daftar instruktur berhasil diambil'),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
    public function index(): JsonResponse
    {
        return InstrukturResource::collection(Instruktur::with($this->relations())->latest()->paginate(15))->response();
    }

    #[OA\Post(
        path: '/api/instruktur',
        summary: 'Buat data instruktur baru',
        tags: ['Instruktur'],
        security: [['sanctum' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['nama', 'bidang_keahlian'],
                properties: [
                    new OA\Property(property: 'nama', type: 'string', description: 'Nama instruktur'),
                    new OA\Property(property: 'bidang_keahlian', type: 'string', description: 'Bidang keahlian instruktur'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Instruktur berhasil dibuat'),
            new OA\Response(response: 422, description: 'Validasi gagal'),
        ]
    )]
    public function store(StoreInstrukturRequest $request): JsonResponse
    {
        $instruktur = Instruktur::create($request->validated());

        return (new InstrukturResource($instruktur->load($this->relations())))->response()->setStatusCode(201);
    }

    #[OA\Get(
        path: '/api/instruktur/{id}',
        summary: 'Ambil detail instruktur berdasarkan ID',
        tags: ['Instruktur'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Detail instruktur'),
            new OA\Response(response: 404, description: 'Instruktur tidak ditemukan'),
        ]
    )]
    public function show(int $id): JsonResponse
    {
        $instruktur = Instruktur::with($this->relations())->findOrFail($id);

        return (new InstrukturResource($instruktur))->response();
    }

    #[OA\Put(
        path: '/api/instruktur/{id}',
        summary: 'Update data instruktur',
        tags: ['Instruktur'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'nama', type: 'string', description: 'Nama instruktur'),
                    new OA\Property(property: 'bidang_keahlian', type: 'string', description: 'Bidang keahlian instruktur'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Instruktur berhasil diupdate'),
            new OA\Response(response: 404, description: 'Instruktur tidak ditemukan'),
        ]
    )]
    public function update(UpdateInstrukturRequest $request, int $id): JsonResponse
    {
        $instruktur = Instruktur::findOrFail($id);
        $instruktur->update($request->validated());

        return (new InstrukturResource($instruktur->fresh()->load($this->relations())))->response();
    }

    #[OA\Delete(
        path: '/api/instruktur/{id}',
        summary: 'Hapus data instruktur',
        tags: ['Instruktur'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Instruktur berhasil dihapus'),
            new OA\Response(response: 404, description: 'Instruktur tidak ditemukan'),
        ]
    )]
    public function destroy(int $id): JsonResponse
    {
        $instruktur = Instruktur::findOrFail($id);
        $instruktur->delete();

        return response()->json(['message' => 'Data berhasil dihapus']);
    }

    public function me(Request $request): JsonResponse
    {
        return response()->json(['data' => $this->formatProfil($this->instrukturLogin($request))]);
    }

    public function updateMe(Request $request): JsonResponse
    {
        $user = $request->user();
        $instruktur = $this->instrukturLogin($request);

        $data = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'nomor_wa' => ['nullable', 'regex:/^[0-9]{8,15}$/'],
            'bio' => ['nullable', 'string', 'max:500'],
            'keahlian' => ['nullable', 'string', 'max:200'],
            'foto' => ['nullable', 'file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'nomor_wa.regex' => 'Nomor WA tidak valid.',
        ]);

        $pathFoto = $request->hasFile('foto')
            ? $request->file('foto')->store('foto', 'public')
            : null;
        $fotoLama = $user->foto;

        DB::transaction(function () use ($user, $instruktur, $data, $pathFoto) {
            $user->update(array_filter(['name' => $data['nama'], 'foto' => $pathFoto]));
            $instruktur->update([
                'nama' => $data['nama'],
                'nomor_wa' => $data['nomor_wa'] ?? null,
                'bio' => $data['bio'] ?? null,
                'keahlian' => $data['keahlian'] ?? null,
            ]);
        });

        if ($pathFoto !== null && $fotoLama) {
            Storage::disk('public')->delete($fotoLama);
        }

        return response()->json(['data' => $this->formatProfil($instruktur->fresh())]);
    }

    protected function instrukturLogin(Request $request): Instruktur
    {
        $user = $request->user();

        return Instruktur::firstOrCreate(
            ['id_user' => $user->id],
            ['nama' => $user->name, 'bidang_keahlian' => '-']
        );
    }

    /**
     * @return array<string, mixed>
     */
    protected function formatProfil(Instruktur $instruktur): array
    {
        $user = $instruktur->user;

        return [
            'id_instruktur' => $instruktur->id,
            'id_user' => $instruktur->id_user,
            'nama' => $instruktur->nama,
            'email' => $user?->email,
            'nomor_wa' => $instruktur->nomor_wa,
            'bio' => $instruktur->bio,
            'keahlian' => $instruktur->keahlian,
            'foto' => $user?->foto,
        ];
    }

    protected function relations(): array
    {
        return ['jadwal'];
    }
}
