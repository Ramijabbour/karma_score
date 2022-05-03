<?php

namespace App\Exceptions;

use Illuminate\Http\Response;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Throwable;


class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (Throwable $exception) {
            \DB::rollBack();
            if ($exception instanceof AuthenticationException)
                return response()->json(['message' => 'User Unauthorized'],Response::HTTP_UNAUTHORIZED);
            elseif ($exception instanceof AccessDeniedHttpException)
                return response()->json(['message'=>$exception->getMessage()],Response::HTTP_FORBIDDEN);
            elseif ($exception instanceof HttpResponseException)
                return $exception->getResponse();
            elseif ($exception instanceof ValidationException) {
                return response()->json(['message' => $exception->validator->errors()->first()],Response::HTTP_BAD_REQUEST);
            } elseif ($exception instanceof NotFoundHttpException || $exception instanceof ModelNotFoundException || $exception instanceof ResourceNotFoundException || $exception instanceof RouteNotFoundException)
                return response()->json(['message' => $exception->getMessage()],Response::HTTP_NOT_FOUND);

            return response()->json(['message' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        });
    }
}
