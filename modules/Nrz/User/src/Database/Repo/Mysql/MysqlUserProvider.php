<?php
namespace Nrz\User\Database\Repo\Mysql;
use Nrz\User\Contracts\UserProviderInterface;
use Nrz\User\Models\User;

class MysqlUserProvider implements UserProviderInterface
{

    public function findUserByEmail(string $email): \Nrz\User\Models\User
    {
       return User::query()->whereEmail($email)->firstOrFail();
    }

}
