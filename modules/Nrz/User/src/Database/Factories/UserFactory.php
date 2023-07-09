<?php

namespace Nrz\User\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Nrz\User\Models\User;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            "name" => fake()->firstName,
            "email" => fake()->email(),
            "email_verified_at" => fake()->dateTime,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ];
    }
}
