<?php

namespace Nrz\Transaction\Database\Repo\Mysql;

use Nrz\Transaction\Contracts\TransactionProviderInterface;
use Nrz\Transaction\Models\Transaction;

class MysqlTransactionRepo implements TransactionProviderInterface
{

    public function createNewTransaction(array $data): Transaction
    {
        return Transaction::query()->create([
            'amount' => $data['amount'],
            'sender_id' => $data['sender_id'],
            'receiver_id' => $data['receiver_id'],
            'description'=>$data['description'],
            'res_number' => mt_rand(100000000,999999999999),

        ]);
    }
}
