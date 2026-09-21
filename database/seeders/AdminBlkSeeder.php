<?php

namespace Database\Seeders;

use App\Models\AdminBlk;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminBlkSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::updateOrCreate(['email' => 'admin@sikarir.test'], ['name' => 'Admin BLK', 'password' => 'password', 'role' => 'admin_blk']);
        AdminBlk::firstOrCreate(['id_user' => $user->id]);
    }
}
