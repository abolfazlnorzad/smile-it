<?php

namespace Nrz\Customer\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'name'=>$this->name,
            'national_code'=>$this->national_code,
            'phone_number'=>$this->phone_number,
            'address'=>$this->address,
            'zip_code'=>$this->zip_code,
        ];
    }
}
