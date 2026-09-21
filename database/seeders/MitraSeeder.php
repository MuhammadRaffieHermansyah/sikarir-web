<?php

namespace Database\Seeders;

use App\Models\Mitra;
use App\Models\User;
use Illuminate\Database\Seeder;

class MitraSeeder extends Seeder
{
    public function run(): void
    {
        $u = User::updateOrCreate(['email' => 'mitra@sikarir.test'], ['name' => 'Mitra Demo', 'password' => 'password', 'role' => 'mitra']);
        Mitra::firstOrCreate(['id_user' => $u->id], ['nama_perusahaan' => 'PT SIKARIR Demo', 'jenis_mitra' => 'Perusahaan', 'kota' => 'Jember', 'provinsi' => 'Jawa Timur', 'bidang_usaha' => 'Teknologi Informasi']);
    }
}
