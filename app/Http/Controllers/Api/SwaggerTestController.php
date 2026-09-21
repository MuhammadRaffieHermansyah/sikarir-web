<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class SwaggerTestController extends Controller
{
    #[OA\Get(
        path: '/api/swagger-test',
        summary: 'Tes Swagger API',
        tags: ['Testing'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Swagger berhasil membaca endpoint'
            )
        ]
    )]
    public function index(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Swagger berhasil!',
        ]);
    }
}