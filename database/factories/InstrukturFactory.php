<?php

namespace Database\Factories;

use App\Models\Instruktur;
use Illuminate\Database\Eloquent\Factories\Factory;

class InstrukturFactory extends Factory
{
    protected $model = Instruktur::class;

    public function definition(): array
    {
        return [
            'nama' => fake()->name(),
            'bidang_keahlian' => fake()->randomElement([
                'Teknik Komputer',
                'Jaringan',
                'Otomotif',
                'Tata Boga',
                'Busana',
                'Elektronika',
            ]),
        ];
    }
}
