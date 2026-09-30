<?php

namespace Database\Seeders;

use App\Models\RuanganWorkshop;
use Illuminate\Database\Seeder;

class RuanganWorkshopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ruangans = [
            'Ruang Pelatihan 1',
            'Ruang Pelatihan 2',
            'Laboratorium Komputer',
            'Aula BLK',
        ];

        foreach ($ruangans as $nama) {
            RuanganWorkshop::create(['nama_ruangan' => $nama]);
        }
    }
}
