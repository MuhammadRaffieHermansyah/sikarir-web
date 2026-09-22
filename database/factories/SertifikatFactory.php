<?php

namespace Database\Factories;

use App\Models\AdminBlk;
use App\Models\JadwalPelatihan;
use App\Models\Peserta;
use App\Models\Sertifikat;
use Illuminate\Database\Eloquent\Factories\Factory;

class SertifikatFactory extends Factory
{
    protected $model = Sertifikat::class;

    public function definition(): array
    {
        return [
            'id_jadwal' => JadwalPelatihan::factory(),

            'id_peserta' => Peserta::factory(),

            'no_sertifikat' => 'SRT-' . fake()->unique()->numerify('########'),

            'tanggal_terbit' => fake()->dateTimeBetween(
                '-1 year',
                'now'
            )->format('Y-m-d'),

            'file_sertifikat' => null,

            'id_admin' => AdminBlk::factory(),
        ];
    }
}
