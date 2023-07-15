<?php

namespace Nrz\Account\Database\Seeders;

use Illuminate\Database\Seeder;
use Nrz\Account\Models\Account;

class AccountSeeder extends Seeder
{
    public function run(): void
    {
        Account::factory()
            ->count(1000)->create();
    }
}
