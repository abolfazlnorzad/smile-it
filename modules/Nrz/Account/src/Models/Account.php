<?php

namespace Nrz\Account\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nrz\Account\Database\Factories\AccountFactory;
use Nrz\Account\Enums\AccountNameEnum;

class Account extends Model
{
    use HasFactory ,HasUlids;


    protected static function newFactory()
    {
        return new AccountFactory();
    }
    protected $casts =["name"=>AccountNameEnum::class];

}
