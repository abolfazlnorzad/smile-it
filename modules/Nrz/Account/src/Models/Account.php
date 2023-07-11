<?php

namespace Nrz\Account\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nrz\Account\Database\Factories\AccountFactory;
use Nrz\Account\Enums\AccountNameEnum;
use Nrz\Customer\Models\Customer;
use Nrz\Transaction\Models\Transaction;

class Account extends Model
{
    use HasFactory ,HasUlids;

    protected $guarded =[];


    protected static function newFactory()
    {
        return new AccountFactory();
    }
    protected $casts =["name"=>AccountNameEnum::class];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

}
