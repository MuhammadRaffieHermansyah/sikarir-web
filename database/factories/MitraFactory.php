<?php

namespace Database\Factories;

use App\Models\Mitra;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MitraFactory extends Factory
{
    protected $model = Mitra::class;

    public function definition(): array
    {
        return [
            'id_user' => null,

            'nama_perusahaan' => fake()->company(),

            'jenis_mitra' => fake()->randomElement([
                'Perusahaan',
                'Instansi Pemerintah',
                'Lembaga Pendidikan',
                'BUMN',
                'UMKM',
            ]),

            'logo_perusahaan' => null,

            'provinsi' => 'Jawa Timur',

            'kota' => fake()->randomElement([
                'Jember',
                'Banyuwangi',
                'Bondowoso',
                'Lumajang',
                'Probolinggo',
                'Surabaya',
                'Malang',
            ]),

            'alamat' => fake()->address(),

            'no_telp' => fake()->numerify('08##########'),

            'no_izin' => fake()->numerify('IZIN-########'),

            'jabatan_pic' => fake()->randomElement([
                'HRD',
                'Manager HRD',
                'Staff HRD',
                'Direktur',
                'Supervisor',
            ]),

            'bidang_usaha' => fake()->randomElement([
                'Teknologi Informasi',
                'Manufaktur',
                'Perdagangan',
                'Jasa',
                'Perbankan',
                'Konstruksi',
                'Pariwisata',
            ]),
        ];
    }
}
