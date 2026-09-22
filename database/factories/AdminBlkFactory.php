<?php

namespace Database\Factories;

use App\Models\AdminBlk;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdminBlkFactory extends Factory
{
    protected $model = AdminBlk::class;

    public function definition(): array
    {
        return [
            'id_user' => User::factory(),
        ];
    }
}
