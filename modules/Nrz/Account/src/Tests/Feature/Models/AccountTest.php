<?php

namespace Nrz\Account\Tests\Feature\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nrz\Account\Models\Account;
use Nrz\Customer\Models\Customer;
use Nrz\Transaction\Models\Transaction;
use Tests\TestCase;

class AccountTest extends TestCase
{
    use RefreshDatabase;

    public function testAccountRelationShipWithCustomer()
    {
        $account = Account::factory()->for(Customer::factory(), 'customer')->create();
        $this->assertTrue(isset($account->customer_id));
        $this->assertTrue($account->customer instanceof Customer);
    }

    public function testAccountRelationShipWithTransaction()
    {
       $tr = Transaction::factory()->create();
       $this->assertTrue($tr->sender instanceof Account);
       $this->assertTrue($tr->receiver instanceof Account);
       $this->assertTrue(isset($tr->sender_id));
       $this->assertTrue(isset($tr->receiver_id));
    }
}
