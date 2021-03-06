<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    public function convertExceptionToResponse(Exception $exception)
    {
        if ($exception instanceof TokenMismatchException || $exception->getPrevious() instanceof TokenMismatchException ) {
            if (request()->expectsJson()) {
                $errors = [__("messages.refreshPage")];
                return response()->json(['errors' => $errors], 500);
            } else {
                return redirect('/')
                    ->withErrors([__('messages.tryAgain')]);
            }
        }
        if (!config('app.debug')) {
            return response()->view('errors.500', ['exception' => $exception], 500);
        }
        return parent::convertExceptionToResponse($exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['errors' => [__('Unauthenticated')]], 401);
        }

        return redirect()->guest('login');
    }

    /**
     * Render the given HttpException.
     *
     * @param  \Symfony\Component\HttpKernel\Exception\HttpException  $e
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function renderHttpException(HttpException $e)
    {
        $status = $e->getStatusCode();

        if (request()->expectsJson()) {
            if (isset($e->retryAfter)) $replace = ['time' => $e->retryAfter];
            else $replace = [];
            $errors = [__("messages.error$status", $replace)];
            return response()->json(['errors' => $errors], $status);
        }

        view()->replaceNamespace('errors', [
            resource_path('views/errors'),
            __DIR__.'/views',
        ]);

        if (!config('app.debug') && view()->exists("errors::{$status}")) {
            return response()->view("errors::{$status}", ['exception' => $e], $status, $e->getHeaders());
        } else {
            return $this->convertExceptionToResponse($e);
        }
    }
}
