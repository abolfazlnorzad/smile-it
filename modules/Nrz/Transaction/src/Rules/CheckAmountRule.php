<?php

namespace Nrz\Transaction\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Nrz\Account\Models\Account;


class CheckAmountRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
       $senderAccount = Account::query()->findOrFail(request('sender_id'));
       if ($senderAccount->balance < (int) $value +(int) $value*config('commission.commission_percentage')){
           $fail('The account balance is insufficient');
       }
    }
}
