<?php

namespace Nrz\User\Services\Auth;

use Illuminate\Support\Facades\Hash;
use Nrz\User\Contracts\UserProviderInterface;
use Nrz\User\Exceptions\WrongPasswordException;
use Nrz\User\Models\User;
use Nrz\User\Traits\CreateJWTToken;

class LoginService
{
    use CreateJWTToken;

    public function __construct(protected UserProviderInterface $provider)
    {
    }


    /**
     * @throws \Exception
     */
    public function login(string $email, string $password): string
    {
        // find user
        $user = $this->provider->findUserByEmail($email);

        // check password
        $this->compareUserPassword($user, $password);

        // create & return the token
        return $this->createJWTToken($user);

    }

    private function compareUserPassword(User $user, string $password)
    {
        $status = Hash::check($password, $user->getAuthPassword());
        if (! $status){
            throw new WrongPasswordException(message: __('validation.exists', ['attribute' => 'email']),code: 422);
        }

    }
}
