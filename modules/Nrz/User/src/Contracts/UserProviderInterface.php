<?php

namespace Nrz\User\Contracts;

use Nrz\User\Models\User;

interface UserProviderInterface
{
    public function findUserByEmail(string $email) :User;
}
