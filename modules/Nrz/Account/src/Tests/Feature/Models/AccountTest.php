<?php

namespace Nrz\Account\Tests\Feature\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nrz\Account\Models\Account;
use Nrz\Customer\Models\Customer;
use Nrz\User\Models\User;
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

    }
}
