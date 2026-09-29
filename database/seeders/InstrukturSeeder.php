<?php

namespace Database\Seeders;

use App\Models\Instruktur;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InstrukturSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $instrukturs = [
            ['nama' => 'Bambang Hermanto', 'bidang_keahlian' => 'Teknik Kendaraan Ringan'],
            ['nama' => 'Siti Aminah', 'bidang_keahlian' => 'Teknik Komputer dan Jaringan'],
            ['nama' => 'Dedi Susanto', 'bidang_keahlian' => 'Rekayasa Perangkat Lunak'],
            ['nama' => 'Rina Wulandari', 'bidang_keahlian' => 'Desain Grafis'],
            ['nama' => 'Ahmad Fauzi', 'bidang_keahlian' => 'Administrasi Perkantoran'],
            ['nama' => 'Dewi Lestari', 'bidang_keahlian' => 'Akuntansi'],
            ['nama' => 'Hendra Gunawan', 'bidang_keahlian' => 'Teknik Elektro'],
            ['nama' => 'Nurul Hidayah', 'bidang_keahlian' => 'Multimedia'],
            ['nama' => 'Agus Prasetyo', 'bidang_keahlian' => 'Teknik Mesin'],
            ['nama' => 'Maya Sari', 'bidang_keahlian' => 'Bahasa Inggris'],
        ];

        foreach ($instrukturs as $instruktur) {
            Instruktur::firstOrCreate(
                ['nama' => $instruktur['nama']],
                ['bidang_keahlian' => $instruktur['bidang_keahlian']]
            );
        }
    }
}
