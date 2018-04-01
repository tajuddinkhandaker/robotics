<?php

namespace Robotics\Exceptions;

use Log;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
        \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException::class,
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
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        // $vendor = config('app.name');
        // if($exception instanceof MethodNotAllowedHttpException)
        // {
        //     // MethodNotAllowedHttpException $e = $exception;
        //     // Log::critical('[' . $vendor . '][' . $e->getStatusCode() . '][' . $e->getHeaders() . '][' . $e->getMessage() . ']');
        //     //abort(503);
        // }
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        return parent::render($request, $exception);
    }
}
