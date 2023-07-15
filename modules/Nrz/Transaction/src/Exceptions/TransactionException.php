<?php

namespace Nrz\Transaction\Exceptions;

use Exception;
use Illuminate\Contracts\Support\Renderable;
use Nrz\Base\Traits\ApiResponse;

class TransactionException extends Exception implements Renderable
{
    use ApiResponse;
    public function render()
    {
        return $this->errorResponse($this->getMessage() , $this->getCode());
    }
}
