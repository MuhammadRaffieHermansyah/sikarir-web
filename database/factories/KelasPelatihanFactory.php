<?php

namespace Database\Factories;

use App\Models\KelasPelatihan;
use App\Models\Peserta;
use App\Models\JadwalPelatihan;
use Illuminate\Database\Eloquent\Factories\Factory;

class KelasPelatihanFactory extends Factory
{
    protected $model = KelasPelatihan::class;

    public function definition(): array
    {
        return [
            'id_peserta' => Peserta::factory(),

            'id_jadwal' => JadwalPelatihan::factory(),

            'status' => fake()->randomElement([
                'terdaftar',
                'aktif',
                'selesai',
                'dibatalkan',
            ]),
        ];
    }
}
