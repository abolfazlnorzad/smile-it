<?php

namespace Nrz\Account\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasUlids;
    protected $guarded =[];

}
