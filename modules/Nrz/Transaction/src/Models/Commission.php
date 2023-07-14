<?php

namespace Nrz\Transaction\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nrz\Transaction\Database\Factories\CommissionFactory;
use Nrz\Transaction\Database\Factories\TransactionFactory;

class Commission extends Model
{
    use HasUlids,HasFactory;


    protected $guarded =[];
    protected static function newFactory()
    {
        return new CommissionFactory();
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }


}
