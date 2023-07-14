<?php

namespace Nrz\Transaction\Contracts;

use Nrz\Transaction\Models\Commission;
use Nrz\Transaction\Models\Transaction;

interface CommissionProviderInterface
{
    public function CreateNewBankCommission(Transaction $transaction) :Commission;
}
