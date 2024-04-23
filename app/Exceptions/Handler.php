<?php

namespace App\Exceptions;

use App\Traits\Responses;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use Responses;

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

    /**
     * Render an exception into an HTTP response.
     * @param  Request  $request
     * @param Throwable $exception
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof NotFoundHttpException) {
            info($exception->getMessage());
            return $this->returnError('Invalid URL', Response::HTTP_NOT_FOUND);
        }
        if ($exception instanceof ValidationException) {
            return $this->returnError($exception->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY, [
                'errors' => $exception->errors(),
            ]);
        }
        if ($exception instanceof AuthenticationException) {
            return $this->returnError($exception->getMessage(), Response::HTTP_FORBIDDEN);
        }
        if ($exception instanceof ModelNotFoundException) {
            return $this->returnError('Resource not found.', Response::HTTP_NOT_FOUND);
        }
        return $this->returnError($exception->getMessage());
    }
}
