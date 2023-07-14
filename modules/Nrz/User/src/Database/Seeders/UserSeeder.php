<?php

namespace Nrz\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Nrz\User\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->state(['email'=>'smile@it.com'])->create();
        User::factory()->count(100)->create();
    }
}
