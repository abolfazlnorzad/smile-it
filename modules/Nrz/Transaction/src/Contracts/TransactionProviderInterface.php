<?php

namespace Nrz\Transaction\Contracts;

use Nrz\Transaction\Models\Transaction;

interface TransactionProviderInterface
{
    public function createNewTransaction(array $data) :Transaction;


}
