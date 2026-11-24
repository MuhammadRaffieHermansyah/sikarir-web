<?php

namespace Database\Factories;

use App\Models\Materi;
use App\Models\Modul;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Materi>
 */
class MateriFactory extends Factory
{
    protected $model = Materi::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_modul' => Modul::factory(),
            'judul' => fake()->sentence(3),
            'tipe' => 'teks',
            'konten' => fake()->paragraph(),
        ];
    }
}
