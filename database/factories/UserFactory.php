<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),

            'email' => fake()->unique()->safeEmail(),

            'email_verified_at' => now(),

            'password' => static::$password ??= Hash::make('password'),
            'role' => fake()->randomElement(['admin_blk', 'mitra', 'peserta']),

            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the user is an Admin BLK.
     */
    public function adminBlk(): static
    {
        return $this->state(fn(array $attributes) => [
            'role' => 'admin_blk',
        ]);
    }

    /**
     * Indicate that the user is a Mitra.
     */
    public function mitra(): static
    {
        return $this->state(fn(array $attributes) => [
            'role' => 'mitra',
        ]);
    }

    /**
     * Indicate that the user is a Peserta.
     */
    public function peserta(): static
    {
        return $this->state(fn(array $attributes) => [
            'role' => 'peserta',
        ]);
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
