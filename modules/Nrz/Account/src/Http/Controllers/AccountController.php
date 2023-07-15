<?php

namespace Nrz\Account\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Exceptions\HttpResponseException;
use Nrz\Account\Exceptions\CreateAccountException;
use Nrz\Account\Http\Requests\CreateAccountRequest;
use Nrz\Account\Http\Resources\AccountResource;
use Nrz\Account\Http\Resources\HistoryResource;
use Nrz\Account\Models\Account;
use Nrz\Account\Services\AccountService;
use Nrz\Base\Http\Controllers\ApiController;

class AccountController extends ApiController
{

    public function create(CreateAccountRequest $request)
    {
        try {
            \Nrz\Account\Facades\Account::createAccount($request->validated());
            return $this->successResponse(null, 200, __("messages.success"));
        } catch (CreateAccountException $e) {
            return  $e->render();
        }

    }

    public function show(Account $account)
    {
        $account->load('histories');

        return $this->successResponse(new AccountResource($account) , 200,__('message.success'));
    }

    public function history(Account $account)
    {
        return $this->successResponse(
            HistoryResource::collection($account->histories)
            ,200,__('message.success'));
    }
}
