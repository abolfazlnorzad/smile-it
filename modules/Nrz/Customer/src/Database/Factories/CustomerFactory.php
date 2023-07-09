<?php

namespace Nrz\Customer\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Nrz\Customer\Models\Customer;

class CustomerFactory extends Factory
{
    protected $model = Customer::class;
    public function definition(): array
    {
        return [
            "name"=>fake()->lastName,
            "national_code"=>fake()->randomFloat(0,10000000000,99999999999),
            "address"=>fake()->address,
            "zip_code"=>fake()->postcode,
            "phone_number"=>fake()->e164PhoneNumber
        ];
    }
}
