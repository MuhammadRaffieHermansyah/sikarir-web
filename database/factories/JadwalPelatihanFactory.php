<?php

namespace Database\Factories;

use App\Models\DaftarPelatihan;
use App\Models\JadwalPelatihan;
use Illuminate\Database\Eloquent\Factories\Factory;

class JadwalPelatihanFactory extends Factory
{
    protected $model = JadwalPelatihan::class;

    public function definition(): array
    {
        $tanggalMulai = fake()->dateTimeBetween(
            'now',
            '+3 months'
        );

        $tanggalSelesai = (clone $tanggalMulai);
        $tanggalSelesai->modify('+30 days');

        return [
            'id_pelatihan' => DaftarPelatihan::factory(),

            'tanggal_mulai' => $tanggalMulai->format('Y-m-d'),

            'tanggal_selesai' => $tanggalSelesai->format('Y-m-d'),

            'jam_mulai' => fake()->randomElement([
                '08:00:00',
                '08:30:00',
                '09:00:00',
            ]),

            'jam_selesai' => fake()->randomElement([
                '15:00:00',
                '16:00:00',
                '16:30:00',
            ]),

            'instruktur' => fake()->name(),

            'tempat' => fake()->randomElement([
                'Ruang Pelatihan 1',
                'Ruang Pelatihan 2',
                'Laboratorium Komputer',
                'Aula BLK',
            ]),

            'status' => fake()->randomElement([
                'tersedia',
                'berlangsung',
                'selesai',
            ]),
        ];
    }
}
