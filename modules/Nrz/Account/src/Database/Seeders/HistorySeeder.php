<?php

namespace Nrz\Account\Database\Seeders;

use Illuminate\Database\Seeder;
use Nrz\Account\Models\Account;
use Nrz\Account\Models\History;

class HistorySeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            History::factory()->for(Account::factory() , 'account')
                ->create();
        }
    }
}
