<?php

namespace Database\Seeders;

use App\Models\Mitra;
use App\Models\User;
use Illuminate\Database\Seeder;

class MitraSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun demo Mitra
        $demoUser = User::updateOrCreate(
            ['email' => 'mitra@sikarir.test'],
            [
                'name' => 'Mitra Demo',
                'password' => 'password',
                'role' => 'mitra',
            ]
        );

        Mitra::firstOrCreate(
            ['id_user' => $demoUser->id],
            [
                'nama_perusahaan' => 'PT SIKARIR Demo',
                'jenis_mitra' => 'Perusahaan',
                'kota' => 'Jember',
                'provinsi' => 'Jawa Timur',
                'bidang_usaha' => 'Teknologi Informasi',
            ]
        );

        // 2. Ambil semua user dengan role 'mitra' yang belum memiliki profil mitra
        $unassignedMitraUsers = User::where('role', 'mitra')
            ->whereDoesntHave('mitra')
            ->get();

        foreach ($unassignedMitraUsers as $user) {
            Mitra::factory()->create([
                'id_user' => $user->id,
            ]);
        }
    }
}
