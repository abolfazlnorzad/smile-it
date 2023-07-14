<?php

namespace Nrz\Account\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nrz\Account\Database\Factories\HistoryFactory;
use Nrz\Transaction\Models\Transaction;

class History extends Model
{
    use HasUlids,HasFactory;

    protected static function newFactory()
    {
        return new HistoryFactory();
    }

    protected $guarded =[];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

}
