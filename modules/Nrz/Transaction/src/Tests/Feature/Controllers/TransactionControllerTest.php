<?php

namespace Nrz\Transaction\Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nrz\Account\Models\Account;
use Nrz\Account\Models\History;
use Nrz\Transaction\Models\Commission;
use Nrz\Transaction\Models\Transaction;
use Tests\TestCase;

class TransactionControllerTest extends TestCase
{
    use RefreshDatabase;
    public function testStaffCanStoreNewTransaction()
    {
        $user = \Nrz\User\Models\User::factory()->create();
        $this->actingAs($user);
        $amount = mt_rand(100, 555);
        $senderAccount = Account::factory()->state(['balance' => 10000])->create();
        $receiverAccount = Account::factory()->state(['balance' => 20000])->create();
        $bankCommission = $amount * config('commission.commission_percentage');
        $res = $this->postJson(route('transaction.store'), [
            'sender_id' => $senderAccount->id,
            'receiver_id' => $receiverAccount->id,
            'amount' => $amount,
            'description' => fake()->text,
        ])->assertOk();

        $this->assertCount(1, Transaction::all());
        $this->assertCount(1, Commission::all());
        $this->assertEquals(Transaction::first()->sender_id, $senderAccount->id);
        $this->assertEquals(Transaction::first()->receiver_id, $receiverAccount->id);
        $this->assertEquals(number_format(Commission::first()->amount , 2),number_format($bankCommission ,2));
        $this->assertEquals($senderAccount->balance - ($amount + $bankCommission), Account::query()->find($senderAccount->id)->balance);
        $this->assertEquals($receiverAccount->balance + $amount, Account::query()->find($receiverAccount->id)->balance);
        $this->assertCount(3,History::all());
        $hc = History::query()->where('amount' , $bankCommission)->get();
        $this->assertCount(1 , $hc);
        $resNumber = Transaction::first()->res_number;
        $res->assertJson(
            [
                "message" => __('message.success'),
                "status" => 'success',
                "data" => [
                    'result number'=>$resNumber
                ]
            ]
        );
    }

    public function testAmountFieldHasRequiredRule()
    {

        $user = \Nrz\User\Models\User::factory()->create();
        $this->actingAs($user);
        $amount = mt_rand(100, 555);
        $senderAccount = Account::factory()->state(['balance' => 10000])->create();
        $receiverAccount = Account::factory()->state(['balance' => 20000])->create();
        $bankCommission = $amount * config('commission.commission_percentage');
        $res = $this->postJson(route('transaction.store'), [
            'sender_id' => $senderAccount->id,
            'receiver_id' => $receiverAccount->id,

            'description' => fake()->text,
        ])->assertStatus(422);

        $this->assertCount(0, Transaction::all());
        $this->assertCount(0, Commission::all());
        $this->assertCount(0,History::all());
        $this->assertEquals($senderAccount->balance , Account::query()->find($senderAccount->id)->balance);
        $this->assertEquals($receiverAccount->balance , Account::query()->find($receiverAccount->id)->balance);
        $hc = History::query()->where('amount' , $bankCommission)->get();
        $this->assertCount(0 , $hc);
        $res->assertJson(
            [
                "message" => [
                    'amount' => [
                        __('validation.required', ['attribute' => 'amount'])
                    ]
                ],
                "status" => 'error',
            ]
        );
    }


    public function testAmountFieldHasNumericRule()
    {

        $user = \Nrz\User\Models\User::factory()->create();
        $this->actingAs($user);
        $amount = mt_rand(100, 555);
        $senderAccount = Account::factory()->state(['balance' => 10000])->create();
        $receiverAccount = Account::factory()->state(['balance' => 20000])->create();
        $bankCommission = $amount * config('commission.commission_percentage');
        $res = $this->postJson(route('transaction.store'), [
            'sender_id' => $senderAccount->id,
            'receiver_id' => $receiverAccount->id,
            'amount'=>'smile',
            'description' => fake()->text,
        ])->assertStatus(422);

        $this->assertCount(0, Transaction::all());
        $this->assertCount(0, Commission::all());
        $this->assertCount(0,History::all());
        $this->assertEquals($senderAccount->balance , Account::query()->find($senderAccount->id)->balance);
        $this->assertEquals($receiverAccount->balance , Account::query()->find($receiverAccount->id)->balance);
        $hc = History::query()->where('amount' , $bankCommission)->get();
        $this->assertCount(0 , $hc);
        $res->assertJson(
            [
                "message" => [
                    'amount' => [
                        __('validation.numeric', ['attribute' => 'amount'])
                    ]
                ],
                "status" => 'error',
            ]
        );
    }

    public function testAmountFieldHasCustomRule()
    {

        $user = \Nrz\User\Models\User::factory()->create();
        $this->actingAs($user);
        $amount = mt_rand(100, 555);
        $senderAccount = Account::factory()->state(['balance' => 7])->create();
        $receiverAccount = Account::factory()->state(['balance' => 20000])->create();
        $bankCommission = $amount * config('commission.commission_percentage');
        $res = $this->postJson(route('transaction.store'), [
            'sender_id' => $senderAccount->id,
            'receiver_id' => $receiverAccount->id,
            'amount'=>$amount,
            'description' => fake()->text,
        ])->assertStatus(422);

        $this->assertCount(0, Transaction::all());
        $this->assertCount(0, Commission::all());
        $this->assertCount(0,History::all());
        $this->assertEquals($senderAccount->balance , Account::query()->find($senderAccount->id)->balance);
        $this->assertEquals($receiverAccount->balance , Account::query()->find($receiverAccount->id)->balance);
        $hc = History::query()->where('amount' , $bankCommission)->get();
        $this->assertCount(0 , $hc);
        $res->assertJson(
            [
                "message" => [
                    'amount' => [
                        'The account balance is insufficient'
                    ]
                ],
                "status" => 'error',
            ]
        );
    }

    public function testAmountFieldHasMinRule()
    {

        $user = \Nrz\User\Models\User::factory()->create();
        $this->actingAs($user);
        $amount = mt_rand(100, 555);
        $senderAccount = Account::factory()->state(['balance' => 10000])->create();
        $receiverAccount = Account::factory()->state(['balance' => 20000])->create();
        $bankCommission = $amount * config('commission.commission_percentage');
        $res = $this->postJson(route('transaction.store'), [
            'sender_id' => $senderAccount->id,
            'receiver_id' => $receiverAccount->id,
            'amount'=>3,
            'description' => fake()->text,
        ])->assertStatus(422);

        $this->assertCount(0, Transaction::all());
        $this->assertCount(0, Commission::all());
        $this->assertCount(0,History::all());
        $this->assertEquals($senderAccount->balance , Account::query()->find($senderAccount->id)->balance);
        $this->assertEquals($receiverAccount->balance , Account::query()->find($receiverAccount->id)->balance);
        $hc = History::query()->where('amount' , $bankCommission)->get();
        $this->assertCount(0 , $hc);
        $res->assertJson(
            [
                "message" => [
                    'amount' => [
                        __('validation.min.numeric', ['attribute' => 'amount','min' => 5])
                    ]
                ],
                "status" => 'error',
            ]
        );
    }

    public function testSenderFieldHasRequiredRule()
    {

        $user = \Nrz\User\Models\User::factory()->create();
        $this->actingAs($user);
        $amount = mt_rand(100, 555);
        $senderAccount = Account::factory()->state(['balance' => 10000])->create();
        $receiverAccount = Account::factory()->state(['balance' => 20000])->create();
        $bankCommission = $amount * config('commission.commission_percentage');
        $res = $this->postJson(route('transaction.store'), [
            'receiver_id' => $receiverAccount->id,
            'amount'=>$amount,
            'description' => fake()->text,
        ])->assertStatus(404);

        $this->assertCount(0, Transaction::all());
        $this->assertCount(0, Commission::all());
        $this->assertCount(0,History::all());
        $this->assertEquals($senderAccount->balance , Account::query()->find($senderAccount->id)->balance);
        $this->assertEquals($receiverAccount->balance , Account::query()->find($receiverAccount->id)->balance);
        $hc = History::query()->where('amount' , $bankCommission)->get();
        $this->assertCount(0 , $hc);
        $res->assertJson(
            [
                "message" =>
                       'not found',
                "status" => 'error',
            ]
        );
    }

    public function testSenderFieldHasExistRule()
    {

        $user = \Nrz\User\Models\User::factory()->create();
        $this->actingAs($user);
        $amount = mt_rand(100, 555);
        $senderAccount = Account::factory()->state(['balance' => 10000])->create();
        $receiverAccount = Account::factory()->state(['balance' => 20000])->create();
        $bankCommission = $amount * config('commission.commission_percentage');
        $res = $this->postJson(route('transaction.store'), [
            'receiver_id' => $receiverAccount->id,
            'amount'=>$amount,
            'description' => fake()->text,
            'sender_id'=>7
        ])->assertStatus(404);

        $this->assertCount(0, Transaction::all());
        $this->assertCount(0, Commission::all());
        $this->assertCount(0,History::all());
        $this->assertEquals($senderAccount->balance , Account::query()->find($senderAccount->id)->balance);
        $this->assertEquals($receiverAccount->balance , Account::query()->find($receiverAccount->id)->balance);
        $hc = History::query()->where('amount' , $bankCommission)->get();
        $this->assertCount(0 , $hc);
        $res->assertJson(
            [
                "message" =>
                    'not found',

                "status" => 'error',
            ]
        );
    }

    public function testReceiverFieldHasRequiredRule()
    {

        $user = \Nrz\User\Models\User::factory()->create();
        $this->actingAs($user);
        $amount = mt_rand(100, 555);
        $senderAccount = Account::factory()->state(['balance' => 10000])->create();
        $receiverAccount = Account::factory()->state(['balance' => 20000])->create();
        $bankCommission = $amount * config('commission.commission_percentage');
        $res = $this->postJson(route('transaction.store'), [
            'sender_id' => $senderAccount->id,
            'amount'=>$amount,
            'description' => fake()->text,
        ])->assertStatus(422);

        $this->assertCount(0, Transaction::all());
        $this->assertCount(0, Commission::all());
        $this->assertCount(0,History::all());
        $this->assertEquals($senderAccount->balance , Account::query()->find($senderAccount->id)->balance);
        $this->assertEquals($receiverAccount->balance , Account::query()->find($receiverAccount->id)->balance);
        $hc = History::query()->where('amount' , $bankCommission)->get();
        $this->assertCount(0 , $hc);
        $res->assertJson(
            [
                "message" => [
                    'receiver_id' => [
                        __('validation.required', ['attribute' => 'receiver id'])
                    ]
                ],
                "status" => 'error',
            ]
        );
    }

    public function testReceiverFieldHasExistRule()
    {

        $user = \Nrz\User\Models\User::factory()->create();
        $this->actingAs($user);
        $amount = mt_rand(100, 555);
        $senderAccount = Account::factory()->state(['balance' => 10000])->create();
        $receiverAccount = Account::factory()->state(['balance' => 20000])->create();
        $bankCommission = $amount * config('commission.commission_percentage');
        $res = $this->postJson(route('transaction.store'), [
            'sender_id' => $senderAccount->id,
            'amount'=>$amount,
            'description' => fake()->text,
            'receiver_id'=>7
        ])->assertStatus(422);

        $this->assertCount(0, Transaction::all());
        $this->assertCount(0, Commission::all());
        $this->assertCount(0,History::all());
        $this->assertEquals($senderAccount->balance , Account::query()->find($senderAccount->id)->balance);
        $this->assertEquals($receiverAccount->balance , Account::query()->find($receiverAccount->id)->balance);
        $hc = History::query()->where('amount' , $bankCommission)->get();
        $this->assertCount(0 , $hc);
        $res->assertJson(
            [
                "message" => [
                    'receiver_id' => [
                        __('validation.exists', ['attribute' => 'receiver id'])
                    ]
                ],
                "status" => 'error',
            ]
        );
    }
}
