<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class RedisMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            Redis::ping();
            return $next($request);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Redis Connection Unsuccessful'], 401);
        }
    }
}