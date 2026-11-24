<?php

namespace Database\Factories;

use App\Models\JadwalPelatihan;
use App\Models\Modul;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Modul>
 */
class ModulFactory extends Factory
{
    protected $model = Modul::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_jadwal' => JadwalPelatihan::factory(),
            'judul' => fake()->sentence(3),
            'deskripsi' => fake()->sentence(),
            'pertemuan_ke' => fake()->numberBetween(1, 10),
        ];
    }
}
