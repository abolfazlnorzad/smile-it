<?php

namespace Nrz\Transaction\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Nrz\Base\Traits\ApiResponse;

class TransactionRequest extends FormRequest
{
    use ApiResponse;
    public function rules(): array
    {
        return [
            'sender_account_number'=>['required',Rule::exists('accounts' , 'account_number')],
            'receiver_account_number'=>['required',Rule::exists('accounts' , 'account_number')],
            'amount'=>['required','numeric','min:5'],
            'description'=>['nullable','string','max:777']
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
