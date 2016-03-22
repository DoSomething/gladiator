<?php

namespace Gladiator\Http\Middleware;

use Closure;
use Gladiator\Exceptions\UnauthorizedAccessException;

class AuthenticateApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if ($request->method() === 'POST') {
            if ($request->header('X-DS-Gladiator-API-Key') !== env('GLADIATOR_API_KEY')) {
                throw new UnauthorizedAccessException;
            }
        }

        return $next($request);
    }
}
