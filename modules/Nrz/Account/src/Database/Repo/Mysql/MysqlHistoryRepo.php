<?php

namespace Nrz\Account\Database\Repo\Mysql;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Nrz\Account\Contracts\HistoryProviderInterface;
use Nrz\Account\Models\History;
use Nrz\Transaction\Models\Transaction;

class MysqlHistoryRepo implements HistoryProviderInterface
{

    public function createHistoryForTransaction(Transaction $transaction): void
    {
        try {
            DB::beginTransaction();

            History::query()->create([
                'transaction_id' => $transaction->id,
                'account_id' => $transaction->sender->id,
                'balance_after_transaction' => $transaction->sender->balance,
                'type' => 'withdraw',
                'amount' => $transaction->amount
            ]);

            History::query()->create([
                'transaction_id' => $transaction->id,
                'account_id' => $transaction->sender->id,
                'balance_after_transaction' => $transaction->sender->balance,
                'type' => 'withdraw',
                'amount' => $transaction->amount * config('commission.commission_percentage'),
                'description'=>'commission',
                'is_commission'=>true
            ]);

            History::query()->create([
                'transaction_id' => $transaction->id,
                'account_id' => $transaction->receiver->id,
                'balance_after_transaction' => $transaction->receiver->balance,
                'type' => 'deposit',
                'amount' => $transaction->amount
            ]);


            DB::commit();
        }catch (\Throwable $e){
            DB::rollBack();
            // todo handle error
            Log::error($e->getMessage());
        }
    }
}
