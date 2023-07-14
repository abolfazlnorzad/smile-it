<?php

namespace Nrz\Transaction\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Nrz\Transaction\Models\Commission;
use Nrz\Transaction\Models\Transaction;

class CommissionFactory extends Factory
{
    protected $model = Commission::class;
    public function definition(): array
    {
        $tr = Transaction::factory()->create();
        return [
            'transaction_id'=>$tr->id,
            'amount'=>$tr->amount * config('commission.commission_percentage'),
        ];
    }
}
