<?php

namespace Nrz\Customer\Tests\Feature\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nrz\Account\Models\Account;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    use RefreshDatabase;
    public function testCustomerRelationShipWithAccount()
    {
        $accountCount = rand(1,3);
        $customer = \Nrz\Customer\Models\Customer::factory()
            ->hasAccounts($accountCount)->create();
        $this->assertCount($accountCount , $customer->accounts);
        $this->assertTrue($customer->accounts->first() instanceof Account);
    }
}
