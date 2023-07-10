<?php

namespace Nrz\Account\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $casts =["name"=>\AccountNameEnum::class];

}
