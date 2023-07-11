<?php

namespace Nrz\Transaction\Database\Seeders;

use Illuminate\Database\Seeder;
use Nrz\Transaction\Models\Transaction;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        Transaction::factory()->count(100)
            ->bankCommission()
            ->create();
    }
}
