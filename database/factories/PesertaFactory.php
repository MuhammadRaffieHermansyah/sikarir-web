<?php

namespace Database\Factories;

use App\Models\Peserta;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PesertaFactory extends Factory
{
    protected $model = Peserta::class;

    public function definition(): array
    {
        $jenisKelamin = fake()->randomElement([
            'Laki-laki',
            'Perempuan',
        ]);

        return [
            'id_user' => User::factory(),

            'id_admin' => null,

            'nomor_peserta' => 'PST-' . fake()->unique()->numerify('######'),

            'jenis_kelamin' => $jenisKelamin,

            'nomor_kk' => fake()->numerify('35################'),

            'nomor_wa' => fake()->numerify('08##########'),

            'tanggal_lahir' => fake()->date(
                'Y-m-d',
                '-18 years'
            ),

            'tempat_lahir' => fake()->city(),

            'alamat_lengkap' => fake()->address(),

            'pendidikan_terakhir' => fake()->randomElement([
                'SMA',
                'SMK',
                'D3',
                'D4',
                'S1',
            ]),

            'pendidikan_sekarang' => fake()->randomElement([
                'Tidak sedang kuliah',
                'Mahasiswa',
            ]),

            'pas_foto' => null,

            'jurusan' => fake()->randomElement([
                'Teknik Komputer dan Jaringan',
                'Rekayasa Perangkat Lunak',
                'Teknik Informatika',
                'Multimedia',
                'Akuntansi',
                'Administrasi Perkantoran',
            ]),
        ];
    }
}