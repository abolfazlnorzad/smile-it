<?php

namespace Nrz\Account\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Nrz\Account\Enums\AccountNameEnum;

class CreateAccountRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', Rule::in([AccountNameEnum::GENERAL->value, AccountNameEnum::SILVER->value, AccountNameEnum::GOLD->value])],
            'customer_id'=>['required',Rule::exists('customers','id')],
            'balance'=>['required','numeric','between:7,1000000000'],
            'bic'=>['required','max:7']
        ];
    }

    public function authorize(): bool
    {
        if (Auth::guard("sanctum")->check())
            return true;

        return false;
    }
}
