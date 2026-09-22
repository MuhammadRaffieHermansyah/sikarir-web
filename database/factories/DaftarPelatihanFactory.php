<?php

namespace Database\Factories;

use App\Models\AdminBlk;
use App\Models\DaftarPelatihan;
use Illuminate\Database\Eloquent\Factories\Factory;

class DaftarPelatihanFactory extends Factory
{
    protected $model = DaftarPelatihan::class;

    public function definition(): array
    {
        return [
            'id_admin' => AdminBlk::factory(),

            'nama_pelatihan' => fake()->randomElement([
                'Pelatihan Web Development',
                'Pelatihan Digital Marketing',
                'Pelatihan Desain Grafis',
                'Pelatihan Microsoft Office',
                'Pelatihan Teknik Komputer',
                'Pelatihan UI/UX Design',
                'Pelatihan Bahasa Inggris',
                'Pelatihan Administrasi Perkantoran',
            ]),

            'deskripsi_pelatihan' => fake()->paragraph(3),

            'durasi_lp' => fake()->randomElement([
                '40 JP',
                '80 JP',
                '120 JP',
                '160 JP',
            ]),

            'kuota' => fake()->numberBetween(10, 30),
        ];
    }
}
