<?php

namespace Nrz\Account\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Nrz\Account\Enums\AccountNameEnum;
use Nrz\Account\Models\Account;
use Nrz\Customer\Models\Customer;

class AccountFactory extends Factory
{
    protected $model = Account::class;
    public function definition(): array
    {
        return [
            'name'=>Arr::random([AccountNameEnum::General->value , AccountNameEnum::GOLD->value , AccountNameEnum::SILVER->value]),
            'account_number'=>fake()->randomFloat(0,100000,999999),
            'customer_id'=>Customer::factory(),
            'balance'=>fake()->randomFloat(0,1000,9999999999),
            'bic'=>fake()->randomFloat(0,1000,9999),
        ];
    }
}
