<?php

namespace App\Resources\Auth\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;

class AuthenticateSU
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = \JWTAuth::parseToken()->authenticate();
        if (!$user && $user['username'] == getenv('APP_SU_NAME')) {
            return response('Unauthorized.', 401);
        }

        return $next($request);
    }
}
