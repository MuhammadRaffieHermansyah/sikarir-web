<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\OptimizesImages;

abstract class Controller
{
    use OptimizesImages;

    /**
     * Ubah kata kunci pencarian menjadi pola LIKE yang aman: karakter khusus
     * (% _ \) di-escape agar input pengguna tidak dianggap wildcard.
     */
    protected function likePattern(string $term): string
    {
        $escaped = addcslashes(trim($term), '\%_');

        return "%{$escaped}%";
    }
}
