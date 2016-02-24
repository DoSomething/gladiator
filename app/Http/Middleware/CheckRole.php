<?php

namespace Gladiator\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $roles = array_slice(func_get_args(), 2);

        if (Auth::guest() || ! Auth::user()->hasRole($roles)) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                // @TODO: respond with a more custom unauthorized access page or whatevs.
                return redirect('/');
            }
        }

        return $next($request);
    }
}
