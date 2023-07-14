<?php

namespace Nrz\Transaction\Database\Repo\Mysql;

use Nrz\Transaction\Contracts\CommissionProviderInterface;
use Nrz\Transaction\Models\Commission;
use Nrz\Transaction\Models\Transaction;

class MysqlCommissionRepo implements CommissionProviderInterface
{

    public function CreateNewBankCommission(Transaction $transaction): Commission
    {
        return Commission::query()->create([
           'transaction_id'=>$transaction->id,
           'amount'=>$transaction->amount * config('commission.commission_percentage')
        ]);
    }
}
