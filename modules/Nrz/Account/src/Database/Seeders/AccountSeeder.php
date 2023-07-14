<?php

namespace Nrz\Account\Database\Seeders;

use Illuminate\Database\Seeder;
use Nrz\Account\Database\Factories\AccountFactory;
use Nrz\Account\Models\Account;
use Nrz\Account\Models\History;

class AccountSeeder extends Seeder
{
    public function run(): void
    {
        Account::factory()
            ->count(1000)->create();
    }
}
