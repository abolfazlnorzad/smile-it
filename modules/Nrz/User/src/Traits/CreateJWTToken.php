<?php
namespace Nrz\User\Traits;
trait CreateJWTToken
{
    /**
     * function for create JWT token
     *
     * @param $user
     * @return string
     */
    protected function createJWTToken($user) : string
    {
        // set expire_at in cookie
        $expiredAt = config('auth.jwt_cookie_lifetime');

        // create new token
        $token = $user->createToken('user-logged-in' , now()->addMinutes($expiredAt))->plainTextToken;

        // set token to cookie
        cookie()->queue(
            config('auth.jwt_cookie_name'),
            $token,
            $expiredAt,
            config('session.path'),
            config('session.domain'),
            config('session.secure'),
            config('session.http_only')
        );


        return $token;
    }
}
