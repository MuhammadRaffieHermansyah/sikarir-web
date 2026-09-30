<?php

namespace Database\Factories;

use App\Models\RuanganWorkshop;
use Illuminate\Database\Eloquent\Factories\Factory;

class RuanganWorkshopFactory extends Factory
{
    protected $model = RuanganWorkshop::class;

    public function definition(): array
    {
        return [
            'nama_ruangan' => fake()->unique()->randomElement([
                'Ruang Pelatihan 1',
                'Ruang Pelatihan 2',
                'Laboratorium Komputer',
                'Aula BLK',
            ]),
        ];
    }
}
