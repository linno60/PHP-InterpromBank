<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthenticatedApi
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
        try { if (JWTAuth::parseToken()->authenticate()) { return $next($request); };

        } catch (JWTException $e) { return response()->json(['success' => false, 'code' => 401, 'error' => $e->getMessage()]); }


    }
}
