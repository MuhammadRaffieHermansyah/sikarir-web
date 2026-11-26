<?php

namespace Database\Seeders;

use App\Models\BidangKeahlian;
use Illuminate\Database\Seeder;

class BidangKeahlianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bidangKeahlian = [
            'Teknik Kendaraan Ringan',
            'Teknik Komputer dan Jaringan',
            'Rekayasa Perangkat Lunak',
            'Desain Grafis',
            'Administrasi Perkantoran',
            'Akuntansi',
            'Teknik Elektro',
            'Multimedia',
            'Teknik Mesin',
            'Bahasa Inggris',
            'Tata Boga',
            'Tata Busana',
            'Teknik Las',
        ];

        foreach ($bidangKeahlian as $nama) {
            BidangKeahlian::firstOrCreate(['nama' => $nama]);
        }
    }
}
