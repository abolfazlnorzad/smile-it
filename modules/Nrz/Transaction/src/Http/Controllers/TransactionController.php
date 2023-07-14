<?php

namespace Nrz\Transaction\Http\Controllers;

use App\Http\Controllers\Controller;
use Nrz\Base\Http\Controllers\ApiController;
use Nrz\Transaction\Exceptions\TransactionException;
use Nrz\Transaction\Http\Requests\TransactionRequest;
use Nrz\Transaction\Services\TransactionService;
use function Termwind\renderUsing;

class TransactionController extends ApiController
{

    public function __construct(public TransactionService $service)
    {
    }

    public function store(TransactionRequest $request)
    {

        try {
           $resNumber =  $this->service->storeTransaction($request->validated());
           return $this->successResponse([
               'result number'=>$resNumber
           ],200,__('message.success'));
        }catch (TransactionException $e){
            return $e->render();
        }catch (\Exception $exception){
            \Log::error($exception->getMessage());
            return $this->errorResponse(__('message.internal-server-error'),500);
        }
    }
}
