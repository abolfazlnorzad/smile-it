<?php

namespace Nrz\Transaction\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Nrz\Account\Http\Resources\AccountResource;

class TransactionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'amount'=>number_format($this->amount),
            'res_number'=>$this->res_number,
            'description'=>$this->description,
            'commission'=>$this->commission,
        ];
    }
}
