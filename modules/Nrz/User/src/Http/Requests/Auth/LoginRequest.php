<?php

namespace Nrz\User\Http\Requests\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Nrz\Base\Traits\ApiResponse;

class LoginRequest extends FormRequest
{
    use ApiResponse;
    public function rules(): array
    {
        return [
            'email' => ["required","string","email",Rule::exists("users","email")],
            'password' => ["required","string","min:8"]
        ];
    }

    public function authorize(): bool
    {
        if (Auth::guest())
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
