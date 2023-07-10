<?php

namespace Nrz\Account\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Nrz\Account\Enums\AccountNameEnum;
use Nrz\Base\Traits\ApiResponse;

class CreateAccountRequest extends FormRequest
{
    use ApiResponse;
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

    /**
     * function for customize validation error message
     * @param Validator $validator
     * @return void
     */
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->errorResponse($validator->errors(), 422));
    }
}
