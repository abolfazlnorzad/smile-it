<?php

namespace Nrz\Transaction\Tests\Feature\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nrz\Account\Models\Account;
use Nrz\Customer\Models\Customer;
use Nrz\Transaction\Models\Transaction;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use RefreshDatabase;

    public function testTransactionRelationShipWithSender()
    {
        $t = Transaction::factory()->create();
        $this->assertTrue(isset($t->sender_id));
        $this->assertTrue($t->sender instanceof Account);
    }

    public function testTransactionRelationShipWithReceiver()
    {
        $t = Transaction::factory()->create();
        $this->assertTrue(isset($t->receiver_id));
        $this->assertTrue($t->receiver instanceof Account);
    }

    public function testTransactionHasRelationShipWithParent()
    {
        $t = Transaction::factory()->bankCommission()->create();
        $this->assertTrue(isset($t->transaction_id));
        $this->assertTrue($t->parent instanceof Transaction);
    }

    public function testTransactionHasRelationShipWithBankCommission()
    {
        $t = Transaction::factory()->hasBankCommission()->create();
        $this->assertTrue($t->bankCommission instanceof Transaction);
    }
}
