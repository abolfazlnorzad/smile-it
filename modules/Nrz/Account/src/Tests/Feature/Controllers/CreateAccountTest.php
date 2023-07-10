<?php

namespace Nrz\Account\Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Nrz\Account\Enums\AccountNameEnum;
use Nrz\Account\Models\Account;
use Nrz\Customer\Models\Customer;
use Nrz\User\Models\User;
use Tests\TestCase;

class CreateAccountTest extends TestCase
{
    use RefreshDatabase;

    public function testStaffCanCreateNewAccount()
    {
        $user = User::factory()->create();
        $customer = Customer::factory()->create();
        $this->actingAs($user);
        // send request to create-account route
        $res = $this->postJson(route('account.create', [
            'name' => Arr::random([AccountNameEnum::GENERAL->value, AccountNameEnum::GOLD->value, AccountNameEnum::SILVER->value]),
            'customer_id' => $customer->id,
            'balance' => 777,
            'bic' => 7777
        ]))
            ->assertOk();

        // create new account
        $this->assertCount(1, Account::all());
        $this->assertEquals(Account::first()->customer_id, $customer->id);
        $this->assertEquals(Account::first()->balance, 777);
        $res->assertJson(
            [
                "message" => __('messages.success'),
                "status" => 'success',
                "data" => null
            ]
        );
    }

    public function testStaffCanCreateNewAccountWhenHeIsNotLoggedIn()
    {
        $customer = Customer::factory()->create();
        $res = $this->postJson(route('account.create', [
            'name' => Arr::random([AccountNameEnum::GENERAL->value, AccountNameEnum::GOLD->value, AccountNameEnum::SILVER->value]),
            'customer_id' => $customer->id,
            'balance' => 777,
            'bic' => 7777
        ]))
            ->assertUnauthorized();

        // create new account
        $this->assertCount(0, Account::all());
        $res->assertJson(
            [
                "message" => __('message.authentication-exception'),
            ]
        );
    }

    public function testNameFieldHasRequiredRule()
    {
        $user = User::factory()->create();
        $customer = Customer::factory()->create();
        $this->actingAs($user);
        // send request to create-account route
        $res = $this->postJson(route('account.create', [
            'customer_id' => $customer->id,
            'balance' => 777,
            'bic' => 7777
        ]))
            ->assertStatus(422);

        // create new account
        $this->assertCount(0, Account::all());

        $res->assertJson(
            [
                "message" => [
                    'name' => [
                        __('validation.required', ['attribute' => 'name'])
                    ]
                ],
                "status" => 'error',
            ]
        );
    }
}
