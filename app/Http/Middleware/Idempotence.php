<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;

class Idempotence
{
    const EXPIRATION_MINUTES = 1440;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (in_array($request->method(), ['GET', 'PUT', 'DELETE'])) {
            return $next($request);
        }

        $requestId = $request->header("Idempotency-Key");
        if (!$requestId) {
            return $next($request);
        }

        if (Cache::has($requestId)) {
            return Cache::get($requestId);
        }

        $response = $next($request);
        $response->header("Idempotence-Key", $requestId);
        Cache::put($requestId, $response, self::EXPIRATION_MINUTES);

        return $response;
    }
}
