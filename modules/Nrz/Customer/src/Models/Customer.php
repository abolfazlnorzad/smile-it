<?php

namespace Nrz\Customer\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Nrz\Customer\Database\Factories\CustomerFactory;

class Customer extends Model
{
    use  HasFactory, Notifiable,HasUlids;
    protected $guarded = [

    ];

    protected static function newFactory()
    {
        return new CustomerFactory();
    }
}
