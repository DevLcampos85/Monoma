<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpFoundation\Response;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(ResponseJson([], false, 'User not found'), Http(401));
            }
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(ResponseJson([], false, 'Token expired'), Http(401));
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(ResponseJson([], false, 'Token invalid'), Http(401));
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(ResponseJson([], false, 'Token absent'), Http(401));
        }
        return $next($request);
    }
}