<?php

namespace Nrz\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Nrz\User\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->count(100)->create();
    }
}
