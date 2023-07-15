<?php

namespace Nrz\Transaction\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'amount'=>number_format($this->amount),
            'res_number'=>$this->res_number,
            'description'=>$this->description,
            'sender_account_number'=>$this->sender->account_number,
            'receiver_account_number'=>$this->receiver->account_number,
            'created_at'=>$this->created_at
        ];
    }
}
