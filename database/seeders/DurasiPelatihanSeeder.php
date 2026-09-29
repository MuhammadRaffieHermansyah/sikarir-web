<?php

namespace Database\Seeders;

use App\Models\DurasiPelatihan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DurasiPelatihanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $durations = [
            ['hari' => 1, 'jam' => 8],
            ['hari' => 3, 'jam' => 24],
            ['hari' => 5, 'jam' => 40],
            ['hari' => 10, 'jam' => 80],
            ['hari' => 15, 'jam' => 120],
            ['hari' => 20, 'jam' => 160],
        ];

        foreach ($durations as $durasi) {
            DurasiPelatihan::firstOrCreate(
                ['hari' => $durasi['hari'], 'jam' => $durasi['jam']]
            );
        }
    }
}