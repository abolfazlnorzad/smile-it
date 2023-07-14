<?php

namespace Nrz\Account\Contracts;

use Nrz\Account\Models\Account;

interface AccountProviderInterface
{
    public function createNewAccount(array $data) :Account;

    public function checkAccountNumberIsExist(string|int|float $number) :bool;

    public function updateAccountBalance(Account $account,float|int $newBalance);
}
