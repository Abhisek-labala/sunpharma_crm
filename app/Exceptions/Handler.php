<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Illuminate\Session\TokenMismatchException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * Report or log an exception.
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     */
    // public function render($request, Throwable $exception)
    // {
    //     // CSRF token mismatch (419)
    //     if ($exception instanceof TokenMismatchException) {
    //         return response()->view('errors.419', [], 419);
    //     }

    //     // Page not found (404)
    //     if ($exception instanceof NotFoundHttpException) {
    //         return response()->view('errors.404', [], 404);
    //     }

    //     // Forbidden (403)
    //     if ($exception instanceof AccessDeniedHttpException) {
    //         return response()->view('errors.403', [], 403);
    //     }

    //     // Fallback for all other errors (500)
    //     return response()->view('errors.500', [], 500);
    // }
}
