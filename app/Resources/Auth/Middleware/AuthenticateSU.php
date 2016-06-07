<?php

namespace App\Resources\Auth\Middleware;

use Closure;

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
        $token = \JWTAuth::getToken();
        $user = \JWTAuth::getJWTProvider()->decode($token)['user'];
        if (!$user || $user['username'] != getenv('APP_SU_NAME')) {
            return response('Unauthorized.', 401);
        }

        return $next($request);
    }
}
