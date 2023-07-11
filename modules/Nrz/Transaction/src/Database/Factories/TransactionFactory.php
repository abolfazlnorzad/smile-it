<?php

namespace Nrz\Transaction\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Nrz\Customer\Models\Customer;
use Nrz\Transaction\Enums\TransactionTypeEnum;
use Nrz\Transaction\Models\Transaction;

class TransactionFactory extends Factory
{
    protected $model = Transaction::class;
    public function definition(): array
    {
        return [
            'type'=>TransactionTypeEnum::TRANSACTION->value,
            'send_id'=>Customer::factory(),
            'receiver_id'=>Customer::factory(),
            'amount'=>fake()->randomFloat(0,100,999),
            'res_number'=>fake()->randomFloat(0,10000000000,99999999999),
            'description'=>fake()->text,
        ];
    }

    public function bankCommission()
    {
        return $this->state(function (array $attributes) {
            return [
                'type'=>TransactionTypeEnum::BANK_COMMISSION->value,
                'transaction_id'=>Transaction::factory()
            ];
        });
    }
}
