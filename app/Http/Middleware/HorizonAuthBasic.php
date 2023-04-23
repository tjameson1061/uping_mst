<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;
use Illuminate\Http\Request;

class HorizonAuthBasic extends AuthenticateWithBasicAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @param  string|null              $guard
     * @return mixed
     */
//    public function handle($request, Closure $next, $guard = null)
//    {
//        return $this->auth->guard($guard)->basic('username') ?: $next($request);
//    }
}
