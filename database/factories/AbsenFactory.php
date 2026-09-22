<?php

namespace Database\Factories;

use App\Models\Absen;
use App\Models\JadwalPelatihan;
use App\Models\Peserta;
use Illuminate\Database\Eloquent\Factories\Factory;

class AbsenFactory extends Factory
{
    protected $model = Absen::class;

    public function definition(): array
    {
        return [
            'id_jadwal' => JadwalPelatihan::factory(),

            'id_peserta' => Peserta::factory(),

            'tanggal' => fake()->date(),

            'jam_hadir' => fake()->randomElement([
                '07:45:00',
                '08:00:00',
                '08:15:00',
                '08:30:00',
                null,
            ]),

            'status_kehadiran' => fake()->randomElement([
                'hadir',
                'izin',
                'sakit',
                'alpa',
            ]),

            'keterangan' => fake()->optional()->sentence(),
        ];
    }
}
