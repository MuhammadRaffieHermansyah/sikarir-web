<?php

namespace App\OpenApi;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: '1.0.0',
    title: 'SIKARIR API',
    description: 'Dokumentasi REST API SIKARIR'
)]
#[OA\Server(
    url: 'http://127.0.0.1:8000',
    description: 'Local Development Server'
)]
class OpenApiSpec
{
}