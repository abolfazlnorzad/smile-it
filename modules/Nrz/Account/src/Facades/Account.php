<?php

namespace Nrz\Account\Facades;


use Illuminate\Support\Facades\Facade;
use Nrz\Transaction\Models\Transaction;

/**
 * @method static createAccount(array $data) :void
 * @method static updateAccountBalance(\Nrz\Account\Models\Account $account , int|float $newBalance)
 * @method static storeHistoryForTransaction(Transaction $transaction)
 */
class Account extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "accountService";
    }
}
