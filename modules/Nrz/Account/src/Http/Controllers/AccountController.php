<?php

namespace Nrz\Account\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Exceptions\HttpResponseException;
use Nrz\Account\Exceptions\CreateAccountException;
use Nrz\Account\Http\Requests\CreateAccountRequest;
use Nrz\Account\Http\Resources\AccountResource;
use Nrz\Account\Models\Account;
use Nrz\Account\Services\AccountService;
use Nrz\Base\Http\Controllers\ApiController;

class AccountController extends ApiController
{
    public function __construct(public AccountService $service)
    {
    }

    public function create(CreateAccountRequest $request)
    {
        try {
            $this->service->createAccount($request->validated());
            return $this->successResponse(null, 200, __("messages.success"));
        } catch (CreateAccountException $e) {
            return  $e->render();
        }

    }

    public function show(Account $account)
    {
        $account->load('histories');
        return new AccountResource($account);
    }
}
