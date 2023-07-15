<?php

namespace Nrz\Transaction\Tests\Feature\Controllers;

use http\Client\Curl\User;
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
}
