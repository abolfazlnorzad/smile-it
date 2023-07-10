<?php

namespace Nrz\Account\Services;


use Nrz\Account\Contracts\AccountProviderInterface;
use Nrz\Account\Exceptions\CreateAccountException;

class AccountService
{

    public function __construct(protected AccountProviderInterface $account)
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


}
