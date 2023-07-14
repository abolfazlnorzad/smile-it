<?php

namespace Nrz\Account\Services;


use Nrz\Account\Contracts\AccountProviderInterface;
use Nrz\Account\Contracts\HistoryProviderInterface;
use Nrz\Account\Exceptions\CreateAccountException;
use Nrz\Account\Models\Account;
use Nrz\Transaction\Models\Transaction;

class AccountService
{

    public function __construct(protected AccountProviderInterface $account,protected HistoryProviderInterface $historyProvider)
    {
    }


    /**
     * @throws CreateAccountException
     */
    public function createAccount(array $data): void
    {
        // generate new account number
        $data['account_number'] = $this->generateAccountNumber();

        // connect to db and store the account
        $this->account->createNewAccount($data);
    }


    private function generateAccountNumber(): float
    {
        do {
            $num = fake()->randomFloat(0, 1000000000, 9999999999);
        } while ($this->account->checkAccountNumberIsExist($num));
        return $num;
    }

    public function updateAccountBalance(Account $account , int|float $newBalance)
    {
        $this->account->updateAccountBalance($account , $newBalance);
    }

    public function storeHistoryForTransaction(Transaction $transaction)
    {
        $this->historyProvider->createHistoryForTransaction($transaction);
    }


}
