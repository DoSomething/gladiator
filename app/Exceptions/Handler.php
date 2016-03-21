<?php

namespace Gladiator\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Foundation\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Gladiator\Services\Northstar\Exceptions\NorthstarUserNotFoundException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {

        if ($request->ajax() || $request->wantsJson()) {
            return $this->json($request, $e);
        }

        if ($e instanceof ValidationException) {
            return redirect()->back()->withInput($request->input())->withErrors($e->validator->getMessages());
        }

        if ($e instanceof NorthstarUserNotFoundException) {
            return redirect()->back()->with('status', $e->getMessage());
        }

        return parent::render($request, $e);
    }

    /**
     * Render an exception into an HTTP JSON response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function json($request, Exception $e)
    {
        $code = 500;

        if ($e instanceof NorthstarUserNotFoundException) {
            $code = 404;
        }

        if ($this->isHttpException($e)) {
            $code = $e->getStatusCode();
        }

        $response = [
            'error' => [
                'code' => $code,
                'message' => $e->getMessage(),
            ],
        ];

        // Show more information if app is in debug mode.
        if (config('app.debug')) {
            $response['debug'] = [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];
        }

        return response()->json($response, $code);
    }
}
