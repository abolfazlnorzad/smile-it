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

    public function testEmailHasRequiredRule()
    {
        $user = User::factory()->create();
        $res = $this
            ->postJson(route("login"), [
                "email" => null,
                "password" => "password"
            ]);
        $res->assertJson(
            [
                "message" => [
                    "email" => [
                        __('validation.required', ['attribute' => 'email'])
                    ]
                ],
                "status" => "error"

            ]
        );
    }

    /**
     * test password has required rule
     */
    public function testPasswordHasRequiredRule()
    {
        $user = User::factory()->create();
        $res = $this
            ->postJson(route("login"), [
                "email" => $user->email,
                "password" => null
            ]);
        $res->assertJson(
            [
                "message" => [
                    "password" => [
                        __('validation.required', ['attribute' => 'password'])
                    ]
                ],
                "status" => "error"

            ]
        );
    }

    /**
     * test email has email rule
     */
    public function testEmailHasEmailRule()
    {
        $user = User::factory()->create();
        $res = $this
            ->postJson(route("login"), [
                "email" => "smileIt",
                "password" => "password"
            ]);
        $res->assertJson(
            [
                "message" => [
                    "email" => [
                        __('validation.email', ['attribute' => 'email'])
                    ]
                ],
                "status" => "error"

            ]
        );
    }

    public function testEmailHasExistRule()
    {
        $res = $this
            ->postJson(route("login"), [
                "email" => "info@smilit.com",
                "password" => "password"
            ]);
        $res->assertJson(
            [
                "message" => [
                    "email" => [
                        __("validation.exists", ["attribute" => 'email'])
                    ]
                ],
                "status" => "error"

            ]
        );
    }

    /**
     * test password has min rule : 8
     */
    public function testPasswordHasMinRule()
    {
        $user = User::factory()->create();
        $res = $this
            ->postJson(route("login"), [
                "email" =>$user->email,
                "password" => "smile"
            ]);
        $res->assertJson(
            [
                "message" => [
                    "password" => [
                        __('validation.min.string', ['attribute' => 'password', 'min' => 8])
                    ]
                ],
                "status" => "error"

            ]
        );
    }



}
// create user with user factory
// send email && password => request
// validation email & password

// check user is Exist

// check password

// generate token and response

