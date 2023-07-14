<?php

namespace Nrz\Account\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Nrz\Account\Models\Account;
use Nrz\Account\Models\History;
use Nrz\Transaction\Models\Transaction;

class HistoryFactory extends Factory
{
    protected $model=History::class;
    public function definition(): array
    {
        return [
            'transaction_id' => Transaction::factory(),
            'account_id' => Account::factory(),
            'amount' => mt_rand(400,777),
            'type'=>Arr::random(['deposit','withdraw']),
            'balance_after_transaction' => mt_rand(77,99999),
        ];
    }
}
