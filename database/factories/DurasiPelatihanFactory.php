<?php

namespace Database\Factories;

use App\Models\DurasiPelatihan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DurasiPelatihan>
 */
class DurasiPelatihanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'hari' => fake()->numberBetween(1, 30),
            'jam' => fake()->numberBetween(1, 200),
        ];
    }
}
