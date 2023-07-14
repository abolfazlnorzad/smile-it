<?php

namespace Nrz\Transaction\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckAmountRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

    }
}
