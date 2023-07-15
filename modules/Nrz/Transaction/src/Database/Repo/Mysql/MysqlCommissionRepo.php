<?php

namespace Nrz\Transaction\Database\Repo\Mysql;

use Nrz\Transaction\Contracts\CommissionProviderInterface;
use Nrz\Transaction\Exceptions\TransactionException;
use Nrz\Transaction\Models\Commission;
use Nrz\Transaction\Models\Transaction;

class MysqlCommissionRepo implements CommissionProviderInterface
{

    public function CreateNewBankCommission(Transaction $transaction): Commission
    {
        try {
            return Commission::query()->create([
                'transaction_id'=>$transaction->id,
                'amount'=>$transaction->amount * config('commission.commission_percentage')
            ]);
        }catch (\Exception $exception){
            \Log::error($exception->getMessage());
            throw new TransactionException(__('message.internal-server-error') , 500);
        }
    }
}
