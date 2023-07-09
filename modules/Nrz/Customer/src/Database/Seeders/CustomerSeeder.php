<?php

namespace Nrz\Customer\Database\Seeders;

use Illuminate\Database\Seeder;
use Nrz\Customer\Models\Customer;

class CustomerSeeder extends Seeder
{

    public function run(): void
    {
        Customer::factory()->count(1000)->create();
    }
}
