<?php

namespace Nrz\User\Http\Controllers\Auth;

use Illuminate\Http\Exceptions\HttpResponseException;
use Nrz\Base\Http\Controllers\ApiController;
use Nrz\User\Exceptions\WrongPasswordException;
use Nrz\User\Http\Requests\Auth\LoginRequest;
use Nrz\User\Services\Auth\LoginService;

class LoginController extends ApiController
{
    public function login(LoginRequest $loginRequest, LoginService $service)
    {
        try {
            $res = $service->login($loginRequest->email, $loginRequest->password);
            return $this->successResponse([
                "loggedIn" => true,
                "token" => $res
            ], 200, "you are logged in.");
        } catch (WrongPasswordException $e) {
            throw new HttpResponseException($this->errorResponse([
                "email"=>[$e->getMessage()]
            ], 422));

        } catch (\Exception $e) {
//            return $this->errorResponse($e->getMessage() , 422);
            throw new HttpResponseException($this->errorResponse($e->getMessage(), 422));
        }
    }
}
