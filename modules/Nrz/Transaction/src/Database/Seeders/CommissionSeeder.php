<?php

namespace Nrz\Transaction\Database\Seeders;

use Illuminate\Database\Seeder;
use Nrz\Transaction\Models\Commission;

class CommissionSeeder extends Seeder
{
    public function run(): void
    {
        Commission::factory()->count(100)->create();
    }
}
