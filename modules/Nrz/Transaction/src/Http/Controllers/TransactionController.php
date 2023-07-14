<?php

namespace Nrz\Transaction\Http\Controllers;

use App\Http\Controllers\Controller;
use Nrz\Transaction\Http\Requests\TransactionRequest;
use Nrz\Transaction\Services\TransactionService;

class TransactionController extends Controller
{

    public function __construct(public TransactionService $service)
    {
    }

    public function store(TransactionRequest $request)
    {
        try {
           $resNumber =  $this->service->storeTransaction($request->validated());
        }catch (\Throwable $e){

        }
    }
}
