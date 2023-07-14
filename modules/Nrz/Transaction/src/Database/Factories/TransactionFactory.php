<?php

namespace Nrz\Transaction\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Nrz\Account\Models\Account;
use Nrz\Transaction\Enums\TransactionTypeEnum;
use Nrz\Transaction\Models\Transaction;

class TransactionFactory extends Factory
{
    protected $model = Transaction::class;
    public function definition(): array
    {
        return [
            'sender_id'=>Account::factory(),
            'receiver_id'=>Account::factory(),
            'amount'=>fake()->randomFloat(0,100,999),
            'res_number'=>fake()->randomFloat(0,10000000000,99999999999),
            'description'=>fake()->text,
        ];
    }
}
