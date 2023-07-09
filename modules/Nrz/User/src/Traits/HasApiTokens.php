<?php

namespace Nrz\User\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use Laravel\Sanctum\NewAccessToken;

trait HasApiTokens
{
    use \Laravel\Sanctum\HasApiTokens;


    public function createToken(string $name, $expiredAt ,  array $abilities = ['*']): NewAccessToken
    {

        $token = $this->tokens()->create([
            'name' => $name,
            'token' => hash('sha256', $plainTextToken = Str::random(64)),
            'ip_address' => Request::ip(),
            'user_agent' => Request::server("HTTP_USER_AGENT"),
            'abilities' => $abilities,
            'expired_at' => $expiredAt
        ]);
        return new NewAccessToken($token, $token->getKey().'|'.$plainTextToken);
    }

    /**
     * function for get current token by cookie
     * @return string|null
     */
    public function getCurrentAccessTokenByCookie(): ?string
    {
        $token = request()->cookie(
            config('auth.jwt_cookie_name')
        );

        return $token ? hash('sha256', Arr::last( explode('|', $token ) ) ) : null;
    }
}
