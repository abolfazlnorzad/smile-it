<?php

namespace Nrz\Transaction\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nrz\Transaction\Enums\TransactionTypeEnum;

class Transaction extends Model
{
    use HasFactory , HasUlids;

    protected $guarded = [

    ];

    protected $casts =[
        "type"=>TransactionTypeEnum::class
    ];


}
