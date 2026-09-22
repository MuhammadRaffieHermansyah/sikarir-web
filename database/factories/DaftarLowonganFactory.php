<?php

namespace Database\Factories;

use App\Models\AdminBlk;
use App\Models\DaftarLowongan;
use App\Models\Mitra;
use Illuminate\Database\Eloquent\Factories\Factory;

class DaftarLowonganFactory extends Factory
{
    protected $model = DaftarLowongan::class;

    public function definition(): array
    {
        return [
            'id_mitra' => Mitra::factory(),

            'id_admin' => AdminBlk::factory(),

            'judul_lowongan' => fake()->randomElement([
                'Web Developer',
                'Frontend Developer',
                'Backend Developer',
                'UI/UX Designer',
                'Staff Administrasi',
                'Digital Marketing',
                'Teknisi Komputer',
                'Customer Service',
            ]),

            'lokasi' => fake()->city(),

            'deskripsi' => fake()->paragraph(3),

            'kualifikasi' => fake()->paragraph(2),

            'tanggal_posting' => fake()->dateTimeBetween(
                '-3 months',
                'now'
            )->format('Y-m-d'),

            'status' => fake()->randomElement([
                'aktif',
                'nonaktif',
            ]),
        ];
    }
}