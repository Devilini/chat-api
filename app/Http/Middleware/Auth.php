<?php

namespace App\Http\Middleware;

use App\Models\Token;
use Closure;

class Auth
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
        if (! $request->expectsJson()) {
            return response('expects Json', 400);
        }

        $authTokenHeader = $request->header('Authorization', null);

        if ($authTokenHeader) {
            $token = Token::find($authTokenHeader);

            if (!$token) {
                return response('The token does not exist', 401);
            }

            if ($token->expires_at < now()) {
                return response('The token is outdated', 401);
            }
        }
        else {
            return response('The authorization token was not passed', 401);
        }

        return $next($request);
    }
}
