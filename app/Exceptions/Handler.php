<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof SpamException && $request->wantsJson()) {
            return $this->respondWithError($exception);
        } else if ($exception instanceof ValidationException && $request->expectsJson()) {
            return $this->respondWithError($exception);
        } else if ($exception instanceof ThrottleRequestsException || $exception instanceof ThreadIsLockedException) {
            return $this->respondWithError($exception);
        }

        return parent::render($request, $exception);
    }

    public function respondWithError($exception, int $code = 422)
    {
        return response()->json([
            'error' => [
                'message' => $exception->getMessage(),
                'code' => $code
            ]
        ], $code);
    }
}
