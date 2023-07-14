<?php

namespace Nrz\Account\Contracts;

use Nrz\Transaction\Models\Transaction;

interface HistoryProviderInterface
{
    public function createHistoryForTransaction(Transaction $transaction);
}
