<?php

namespace Database\Factories;

use App\Models\DaftarLowongan;
use App\Models\LamaranLowongan;
use App\Models\Peserta;
use Illuminate\Database\Eloquent\Factories\Factory;

class LamaranLowonganFactory extends Factory
{
    protected $model = LamaranLowongan::class;

    public function definition(): array
    {
        return [
            'id_lowongan' => DaftarLowongan::factory(),
            'id_peserta' => Peserta::factory(),
            'tanggal_melamar' => fake()->dateTimeBetween('-1 month', 'now')->format('Y-m-d'),
            'status' => fake()->randomElement(['melamar', 'diproses', 'wawancara', 'diterima', 'ditolak']),
            'catatan_pelamar' => fake()->optional()->sentence(),
            'catatan_mitra' => fake()->optional()->sentence(),
            'resume_url' => 'https://example.com/resumes/' . fake()->uuid() . '.pdf',
        ];
    }
}

