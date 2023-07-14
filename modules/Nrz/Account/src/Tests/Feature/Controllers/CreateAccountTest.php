<?php

namespace Nrz\Account\Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Nrz\Account\Enums\AccountNameEnum;
use Nrz\Account\Models\Account;
use Nrz\Customer\Models\Customer;
use Nrz\Transaction\Models\Transaction;
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

    public function testNameFieldHasInArrayRule()
    {
        $user = User::factory()->create();
        $customer = Customer::factory()->create();
        $this->actingAs($user);
        // send request to create-account route
        $res = $this->postJson(route('account.create', [
            'name'=>'smileIt',
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
                        __('validation.exists', ['attribute' => 'name'])
                    ]
                ],
                "status" => 'error',
            ]
        );
    }

    public function testCustomerIdFieldHasRequiredRule()
    {

        $user = User::factory()->create();
        $customer = Customer::factory()->create();
        $this->actingAs($user);
        // send request to create-account route
        $res = $this->postJson(route('account.create', [
            'name'=>AccountNameEnum::GOLD->value,
            'balance' => 777,
            'bic' => 7777
        ]))
            ->assertStatus(422);

        // create new account
        $this->assertCount(0, Account::all());

        $res->assertJson(
            [
                "message" => [
                    'customer_id' => [
                        __('validation.required', ['attribute' => 'customer id'])
                    ]
                ],
                "status" => 'error',
            ]
        );
    }

    public function testCustomerIdFieldHasExistsRule()
    {

        $user = User::factory()->create();
        $customer = Customer::factory()->create();
        $this->actingAs($user);
        // send request to create-account route
        $res = $this->postJson(route('account.create', [
            'name'=>AccountNameEnum::GOLD->value,
            'customer_id'=>7,
            'balance' => 777,
            'bic' => 7777
        ]))
            ->assertStatus(422);

        // create new account
        $this->assertCount(0, Account::all());

        $res->assertJson(
            [
                "message" => [
                    'customer_id' => [
                        __('validation.exists', ['attribute' => 'customer id'])
                    ]
                ],
                "status" => 'error',
            ]
        );
    }

    public function testBalanceFieldHasRequiredRule()
    {

        $user = User::factory()->create();
        $customer = Customer::factory()->create();
        $this->actingAs($user);
        // send request to create-account route
        $res = $this->postJson(route('account.create', [
            'name'=>AccountNameEnum::GOLD->value,
            'customer_id'=>$customer->id,
            'bic' => 7777
        ]))
            ->assertStatus(422);

        // create new account
        $this->assertCount(0, Account::all());

        $res->assertJson(
            [
                "message" => [
                    'balance' => [
                        __('validation.required', ['attribute' => 'balance'])
                    ]
                ],
                "status" => 'error',
            ]
        );
    }

    public function testBalanceFieldHasNumericRule()
    {

        $user = User::factory()->create();
        $customer = Customer::factory()->create();
        $this->actingAs($user);
        // send request to create-account route
        $res = $this->postJson(route('account.create', [
            'name'=>AccountNameEnum::GOLD->value,
            'customer_id'=>$customer->id,
            'bic' => 7777,
            'balance'=>'smileIt'
        ]))
            ->assertStatus(422);

        // create new account
        $this->assertCount(0, Account::all());

        $res->assertJson(
            [
                "message" => [
                    'balance' => [
                        __('validation.numeric', ['attribute' => 'balance'])
                    ]
                ],
                "status" => 'error',
            ]
        );
    }

    public function testBalanceFieldHasMinRule()
    {

        $user = User::factory()->create();
        $customer = Customer::factory()->create();
        $this->actingAs($user);
        // send request to create-account route
        $res = $this->postJson(route('account.create', [
            'name'=>AccountNameEnum::GOLD->value,
            'customer_id'=>$customer->id,
            'bic' => 7777,
            'balance'=>5
        ]))
            ->assertStatus(422);

        // create new account
        $this->assertCount(0, Account::all());

        $res->assertJson(
            [
                "message" => [
                    'balance' => [
                        __('validation.between.numeric', ['attribute' => 'balance','min'=>7,'max' => 1000000000])
                    ]
                ],
                "status" => 'error',
            ]
        );
    }

    public function testBalanceFieldHasMaxRule()
    {

        $user = User::factory()->create();
        $customer = Customer::factory()->create();
        $this->actingAs($user);
        // send request to create-account route
        $res = $this->postJson(route('account.create', [
            'name'=>AccountNameEnum::GOLD->value,
            'customer_id'=>$customer->id,
            'bic' => 7777,
            'balance'=>10000000000
        ]))
            ->assertStatus(422);

        // create new account
        $this->assertCount(0, Account::all());

        $res->assertJson(
            [
                "message" => [
                    'balance' => [
                        __('validation.between.numeric', ['attribute' => 'balance','min'=>7,'max' => 1000000000])
                    ]
                ],
                "status" => 'error',
            ]
        );
    }

    public function testBicFieldHasRequiredRule()
    {

        $user = User::factory()->create();
        $customer = Customer::factory()->create();
        $this->actingAs($user);
        // send request to create-account route
        $res = $this->postJson(route('account.create', [
            'name'=>AccountNameEnum::GOLD->value,
            'customer_id'=>$customer->id,
            'balance' => 7777
        ]))
            ->assertStatus(422);

        // create new account
        $this->assertCount(0, Account::all());

        $res->assertJson(
            [
                "message" => [
                    'bic' => [
                        __('validation.required', ['attribute' => 'bic'])
                    ]
                ],
                "status" => 'error',
            ]
        );
    }
    public function testBicFieldHasNumericRule()
    {

        $user = User::factory()->create();
        $customer = Customer::factory()->create();
        $this->actingAs($user);
        // send request to create-account route
        $res = $this->postJson(route('account.create', [
            'name'=>AccountNameEnum::GOLD->value,
            'customer_id'=>$customer->id,
            'balance' => 7777,
            'bic'=>'smile'
        ]))
            ->assertStatus(422);

        // create new account
        $this->assertCount(0, Account::all());

        $res->assertJson(
            [
                "message" => [
                    'bic' => [
                        __('validation.numeric', ['attribute' => 'bic'])
                    ]
                ],
                "status" => 'error',
            ]
        );
    }

    public function testBicFieldHasMinRule()
    {

        $user = User::factory()->create();
        $customer = Customer::factory()->create();
        $this->actingAs($user);
        // send request to create-account route
        $res = $this->postJson(route('account.create', [
            'name'=>AccountNameEnum::GOLD->value,
            'customer_id'=>$customer->id,
            'balance' => 7777,
            'bic'=>777
        ]))
            ->assertStatus(422);

        // create new account
        $this->assertCount(0, Account::all());

        $res->assertJson(
            [
                "message" => [
                    'bic' => [
                        __('validation.between.numeric', ['attribute' => 'bic','min' => 1000,'max' => 9999])
                    ]
                ],
                "status" => 'error',
            ]
        );
    }

    public function testBicFieldHasMaxRule()
    {

        $user = User::factory()->create();
        $customer = Customer::factory()->create();
        $this->actingAs($user);
        // send request to create-account route
        $res = $this->postJson(route('account.create', [
            'name'=>AccountNameEnum::GOLD->value,
            'customer_id'=>$customer->id,
            'balance' => 7777,
            'bic'=>777777
        ]))
            ->assertStatus(422);

        // create new account
        $this->assertCount(0, Account::all());

        $res->assertJson(
            [
                "message" => [
                    'bic' => [
                        __('validation.between.numeric', ['attribute' => 'bic','min' => 1000,'max' => 9999])
                    ]
                ],
                "status" => 'error',
            ]
        );
    }

    public function testStaffCanSeeHistoryOfAccount()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $account = Account::factory()->create();
        $tr = Transaction::query()->create([
            'sender_id' => Account::factory()->create()->id,
            'receiver_id' => $account->id,
            'amount' => 7,
            'res_number' => mt_rand(),
        ]);
        $account->histories()->create([
            'amount'=>7,
            'balance_after_transaction' =>$account->balance,
            'type'=>'deposit',
            'transaction_id'=>$tr->id
        ]);
        $res = $this->getJson(route('account.show',$account->account_number))
        ->assertOk();
        $res->assertJson([
            "status"=>"success",
            'message'=>__('message.success'),
            'data'=>[
                'name'=>$account->name->value,
                'account_number'=>$account->account_number,
                'customer'=>[
                    'name'=>$account->customer->name,
                    'phone_number'=>$account->customer->phone_number,
                    'national_code'=>$account->customer->national_code,
                    'zip_code'=>$account->customer->zip_code,
                    'address'=>$account->customer->address,
                ],
                'balance'=>number_format(Account::find($account->id)->balance),
                'histories'=>[
                    [
                        'description'=>$account->histories()->first()->description,
                        'is_commission'=>$account->histories()->first()->is_commission,
                        'amount'=>$account->histories()->first()->amount,
                        'type'=>$account->histories()->first()->type,
                        'balance_after_transaction'=>number_format($account->histories()->first()->balance_after_transaction),
                    ]
                ]
            ]
        ]);
    }
}
