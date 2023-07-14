<?php

namespace Nrz\Account\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Nrz\Transaction\Http\Resources\TransactionResource;
use Nrz\Transaction\Models\Transaction;

class HistoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'amount'=>number_format($this->amount),
            'balance_after_transaction'=>number_format($this->balance_after_transaction),
            'type'=>$this->type,
            'description'=>$this->description,
            'is_commission'=>$this->is_commission,
        ];
    }
}
