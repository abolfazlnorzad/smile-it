<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Nrz\Base\Traits\ApiResponse;
use Throwable;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\RelationNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    use ApiResponse;
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {

        if ($e instanceof ModelNotFoundException && request()->wantsJson()) {
            return $this->errorResponse(__('message.model-not-found'), 404);
        }

        if ($e instanceof ThrottleRequestsException && request()->wantsJson()) {
            return $this->errorResponse(__('messages.many-attempts'), 429);
        }

        if ($e instanceof AccessDeniedHttpException) {
            return $this->errorResponse(__("message.Access_Denied"), 403);
        }
        if ($e instanceof AuthorizationException) {
            return $this->errorResponse(__('message.unAuthorize'), 403);
        }

        if ($e instanceof NotFoundHttpException && request()->wantsJson()) {
            return $this->errorResponse(__('message.not-found-http'), 404);
        }

        if ($e instanceof AuthenticationException && request()->wantsJson()) {
            return $this->errorResponse(__('message.authentication-exception'), 401);
        }

        if ($e instanceof AuthenticationException) {
            return $this->errorResponse(__('message.authentication-exception'), 401);
        }
        if ($e instanceof ValidationException && request()->wantsJson()) {
            return  $this->errorResponse(__('message.validation-exception'),422);
        }

        if ($e instanceof MethodNotAllowedHttpException) {
            return $this->errorResponse(__('message.not-found-http'), 404);
        }

        if ($e instanceof \ParseError && request()->wantsJson()) {
            return $this->errorResponse(__('message.ParseError'), 500);
        }

        if ($e instanceof \Error) {
            Log::error($e->getMessage());
            return $this->errorResponse(__('message.internal-server-error'), 500);
        }

        if ($e instanceof QueryException) {
            Log::error($e->getMessage());
            return $this->errorResponse(__('message.internal-server-error'), 500);
        }

        if ($e instanceof RelationNotFoundException) {
            Log::error($e->getMessage());
            return $this->errorResponse(__('message.internal-server-error'), 500);
        }
        return parent::render($request, $e);

    }
}
