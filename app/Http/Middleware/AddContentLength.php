<?php

namespace Gladiator\Http\Middleware;

use Closure;
use Illuminate\Support\Str;

class AddContentLength
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $response->header('Content-Length', Str::length($response->getContent()));

        return $response;
    }
}
