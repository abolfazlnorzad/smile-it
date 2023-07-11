<?php

namespace Nrz\Transaction\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nrz\Account\Models\Account;
use Nrz\Transaction\Database\Factories\TransactionFactory;
use Nrz\Transaction\Enums\TransactionTypeEnum;

class Transaction extends Model
{
    use HasFactory , HasUlids;

    protected static function newFactory()
    {
        return new TransactionFactory();
    }
    protected $guarded = [

    ];

    protected $casts =[
        "type"=>TransactionTypeEnum::class
    ];

    public function parent()
    {
        return $this->belongsTo(Transaction::class,"transaction_id");
    }

    public function bankCommission()
    {
         return $this->hasOne(Transaction::class,"transaction_id");
    }

    public function sender()
    {
        return $this->belongsTo(Account::class,"sender_id");
    }

    public function receiver()
    {
        return $this->belongsTo(Account::class,"receiver_id");
    }

}
