<?php

namespace Nrz\Account\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Nrz\Customer\Http\Resources\CustomerResource;

class AccountResource extends JsonResource
{
    public function toArray(Request $request): array
    {

        return [
            'name'=>$this->name,
            'account_number'=>$this->account_number,
            'customer'=>new CustomerResource($this->customer),
            'balance'=>number_format($this->balance),
            'bic'=>$this->bic,
        ];
    }
}
