<?php

namespace Nrz\User\Http\Controllers\Auth;

use Nrz\Base\Http\Controllers\ApiController;
use Nrz\User\Http\Requests\Auth\LoginRequest;
use Nrz\User\Services\Auth\LoginService;

class LoginController extends ApiController
{
    public function login(LoginRequest $loginRequest,LoginService $service)
    {
        try {
            $res = $service->login($loginRequest->email , $loginRequest->password);
            return $this->successResponse([
                "loggedIn"=>true,
                "token"=>$res
            ],200,"you are logged in.");
        }catch (\Exception $e){
            return $this->errorResponse($e->getMessage() , 422);
        }
    }
}
