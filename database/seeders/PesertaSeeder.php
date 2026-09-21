<?php

namespace Database\Seeders;

use App\Models\Peserta;
use App\Models\User;
use Illuminate\Database\Seeder;

class PesertaSeeder extends Seeder
{
    public function run(): void
    {
        $u = User::updateOrCreate(['email' => 'peserta@sikarir.test'], ['name' => 'Peserta Demo', 'password' => 'password', 'role' => 'peserta']);
        Peserta::firstOrCreate(['id_user' => $u->id], ['nomor_peserta' => 'PST-0001', 'jenis_kelamin' => 'Laki-laki', 'nomor_wa' => '081234567890', 'pendidikan_terakhir' => 'SMK', 'jurusan' => 'Rekayasa Perangkat Lunak']);
    }
}
