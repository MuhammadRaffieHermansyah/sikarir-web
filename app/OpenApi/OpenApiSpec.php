<?php

namespace App\OpenApi;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: '1.0.0',
    title: 'SIKARIR API',
    description: 'Dokumentasi API untuk aplikasi Sikarir — Sistem Informasi Karir & Pelatihan BLK'
)]
#[OA\Server(
    url: 'http://127.0.0.1:8000',
    description: 'Local Development Server'
)]
#[OA\SecurityScheme(
    securityScheme: 'sanctum',
    type: 'http',
    scheme: 'bearer',
    bearerFormat: 'JWT',
    description: 'Masukkan token yang diperoleh dari endpoint /api/auth/login'
)]
class OpenApiSpec {}
