<?php

namespace Nrz\Account\Exceptions;

use Exception;
use Illuminate\Contracts\Support\Renderable;
use Nrz\Base\Traits\ApiResponse;

class CreateAccountException extends Exception implements Renderable
{
    use ApiResponse;

    public function render()
    {
        return $this->errorResponse($this->getMessage() , 500);
    }
}
