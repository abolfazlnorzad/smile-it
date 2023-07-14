<?php

namespace Nrz\Transaction\Tests\Feature\Controllers;

use Nrz\Account\Models\Account;
use Nrz\Transaction\Models\Transaction;
use Tests\TestCase;

class TransactionControllerTest extends TestCase
{
    public function testStaffCanStoreNewTransaction()
    {
        $amount = mt_rand(100, 555);
        $senderAccount = Account::factory()->state(['balance' => 10000])->create();
        $receiverAccount = Account::factory()->state(['balance' => 20000])->create();
        $bankCommission = 2;
        $res = $this->postJson(route('transaction.store'), [
            'sender_account_number' => $senderAccount->account_number,
            'receiver_account_number' => $receiverAccount->account_number,
            'amount' => $amount,
            'description' => fake()->text,
        ])->assertOk();

        $this->assertCount(2, Transaction::all());
        $this->assertEquals(Transaction::oldest()->first()->amount, $amount);
        $this->assertEquals(Transaction::oldest()->first()->sender_id, $senderAccount->id);
        $this->assertEquals(Transaction::oldest()->first()->receiver_id, $receiverAccount->id);
        $this->assertEquals(Transaction::latest()->first()->transaction_id, Transaction::oldest()->first()->id);
        $this->assertEquals(Transaction::latest()->first()->amount, $bankCommission);
        $this->assertEquals($senderAccount->balance - ($amount + $bankCommission), Account::query()->find($senderAccount->id)->balance);
        $this->assertEquals($receiverAccount->balance + $amount, Account::query()->find($receiverAccount->id)->balance);

    }
}
