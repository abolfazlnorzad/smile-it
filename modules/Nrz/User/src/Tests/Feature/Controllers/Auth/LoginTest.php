<?php

namespace Nrz\User\Tests\Feature\Controllers\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nrz\User\Models\PersonalAccessToken;
use Nrz\User\Models\User;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    public function testUserCanLoginWithEmailAndPassword()
    {
        $user = User::factory()->create();
        $res = $this
            ->postJson(route("login"), [
                "email" => $user->email,
                "password" => "password"
            ])
            ->assertOk();

        $res->assertJsonStructure(
            [
                "message",
                "status",
                "data" => [
                    "token",
                    "loggedIn",
                ]
            ]
        );

        $this->assertCount(1 , PersonalAccessToken::all());
    }
}
// create user with user factory
// send email && password => request
// validation email & password

// check user is Exist

// check password

// generate token and response
